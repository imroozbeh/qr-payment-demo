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
            ]);
            if($address) {

                    $data = [
                        'address'            => $transaction['to'],
                        'contract'           => $transaction['contract'],
                        'tx'                 => $transaction['tx'],
                        'block_number'       => $transaction['block'],
                        'amount'             => NodeHelper::bcDecodeValue($transaction['value']),
                        'deposited_at'       => Carbon::now()
                    ];

                    NodeRepositoryFacade::forceStoreRecord('Deposit', $data);

            }
        }
    }

    private function bchexdec($hex)
    {
        $remainingDigits = substr($hex, 0, -1);
        $lastDigitToDecimal = \hexdec(substr($hex, -1));

        if (strlen($remainingDigits) === 0) {
            return $lastDigitToDecimal;
        }

        return addAmount(mulAmount(16, $this->bchexdec($remainingDigits)), $lastDigitToDecimal, 0);
    }
}
