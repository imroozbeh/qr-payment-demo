<?php

namespace App\Jobs;

use App\Facades\NodeHelper;
use App\Facades\NodeRepositoryFacade;
use Carbon\Carbon;

class CreateDepositJob extends Job
{
    /**
     * @var
     */
    private $currentBlockNumber;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($currentBlockNumber)
    {
        $this->currentBlockNumber = $currentBlockNumber;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $transactions = NodeHelper::getBlockTransactions($this->currentBlockNumber);

        $network = NodeRepositoryFacade::getRecord('Network', ['name' => 'ERC20']);

        foreach($transactions as $transaction) {
            $checkDepositExist = NodeRepositoryFacade::getRecord('Deposit', [
                'address' => $transaction['to'],
                'tx'      => $transaction['tx'],
            ]);
            if(! empty($checkDepositExist)) {
                break;
            }
            $address = NodeRepositoryFacade::getRecord('Address', [
                'address' => $transaction['to'],
                'address_type_id' => $network->address_type_id
            ]);
            if($address) {
                $currency = NodeRepositoryFacade::getCurrency($network, $transaction['contract']);

                if ($currency) {
                    $wallet = NodeRepositoryFacade::getRecord('Wallet', [
                        'user_id' => $address->user_id,
                        'currency_id' => $currency->id
                    ]);

                    $data = [
                        'type'               => 'blockchain',
                        'wallet_id'          => $wallet->id,
                        'network_id'         => $network->id,
                        'address'            => $transaction['to'],
                        'contract'           => $transaction['contract'],
                        'tx'                 => $transaction['tx'],
                        'block_number'       => $transaction['block'],
                        'status'             => null,
                        'amount'             => NodeHelper::bcDecodeValue($transaction['value'], $currency->pivot->decimal),
                        'confirmation_count' => 0,
                    ];

                    NodeRepositoryFacade::forceStoreRecord('Deposit', $data);

                    NodeRepositoryFacade::increaseWalletBalance($wallet, $network);
                }
            }
        }
    }
}
