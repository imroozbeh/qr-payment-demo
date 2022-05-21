<?php

namespace App\Jobs;

use App\Facades\NodeApi;
use App\Facades\NodeRepositoryFacade;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ConfirmDepositJob extends Job
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
        $deposits = NodeRepositoryFacade::getRecords('Deposit', ['confirmed_at' => null, 'status' => null]);

        DB::beginTransaction();

        foreach ($deposits as $deposit) {
            $network = $deposit->wallet->currency->networks()->where('name', 'ERC20')->first();

            if ($network && $network->deposit_status) {

                $confirmation = $this->currentBlockNumber - $deposit->block_number;

                if ($confirmation >= $network->deposit_confirmation) {
                    $receipt = NodeApi::eth_getTransactionReceipt($deposit->tx);

                    if (hexdec($receipt['body']['result']['status']) == 1) {
                        $deposit->update([
                            'confirmation_count' => $confirmation,
                            'status' => 1
                        ]);
                    } else {
                        $deposit->update([
                            'confirmation_count' => $confirmation,
                            'status' => 0
                        ]);
                    }
                }
                else {
                    $deposit->update([
                        'confirmation_count' => $confirmation
                    ]);
                }
            }

        }

        DB::commit();
    }
}
