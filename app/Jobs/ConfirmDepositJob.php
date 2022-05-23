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
        //var_dump('current_block: ' . $this->currentBlockNumber);

        $deposits = NodeRepositoryFacade::getNotConfirmedDeposits();

        DB::beginTransaction();

        foreach ($deposits as $deposit) {
            $network = $deposit->wallet->currency->networks()->where('name', 'ERC20')->first();

            if ($network && $network->deposit_status) {

                $confirmation = $this->currentBlockNumber - $deposit->block_number;

                if ($confirmation >= $network->deposit_confirmation) {
                    // status update
                    if ($deposit->status == null) {
                        //var_dump('call api: eth_getTransactionReceipt()' . ' || ' . Carbon::now()->toDateTimeString());
                        $receipt = NodeApi::eth_getTransactionReceipt($deposit->tx);

                        if (hexdec($receipt['body']['result']['status']) == 1) {
                            $deposit->update([
                                'confirmation_count' => $confirmation,
                                'status' => 1
                            ]);
                            // deposit cycle
                            NodeRepositoryFacade::increaseWalletBalance($deposit->wallet, $network);
                        } else {
                            $deposit->update([
                                'confirmation_count' => $confirmation,
                                'status' => 0
                            ]);
                        }
                    } else {
                        $deposit->update([
                            'confirmation_count' => $confirmation
                        ]);
                    }
                    // confirmed_at update
                    if ($confirmation >= $network->withdrawal_confirmation) {
                        var_dump('confirmed_at: ' . $deposit->id);
                        $deposit->update([
                            'confirmed_at' => $deposit->confirmation_count >= $network->withdrawal_confirmation ? Carbon::now()->toDateTimeString() : null
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
