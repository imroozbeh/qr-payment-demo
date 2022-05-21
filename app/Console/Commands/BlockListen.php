<?php

namespace App\Console\Commands;

use App\Facades\NodeApi;
use App\Facades\NodeRepositoryFacade;
use App\Jobs\ConfirmDepositJob;
use App\Jobs\CreateDepositJob;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class BlockListen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'block:listen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get not analysed blocks from blockchain and analysis.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // pending 0x685f84e54dfd5086082bd98c09b8fc3bd7f14bfedf492c96a0c609ee37b7d1b9
        // failed 0x05c7797d3ddc82b59a4364aed6382f59f23fa25c19f4aed5b29458d12fc68cfd
        // success 0xa23b6df60b00ca897cf464ee1c8a5f1f7e070db04bcf292400fc985bfda4c967
        //$receipt = NodeApi::eth_getTransactionReceipt('0x685f84e54dfd5086082bd98c09b8fc3bd7f14bfedf492c96a0c609ee37b7d1b9');
        //dd($receipt);

        $lastProcessedBlock = Cache::rememberForever('lastProcessedBlock', function () {
            return 0;
        });

        // 12272161 cache

        var_dump($lastProcessedBlock);

        do {
            $lastBlock = NodeApi::eth_blockNumber();

            if($lastBlock['status'] == 200) {
                //$lastBlockNumber = hexdec($lastBlock['body']['result']);
                $lastBlockNumber = 12272162;

                //dd($lastBlockNumber);

                if($lastBlockNumber > $lastProcessedBlock) {
                    for ($i = $lastProcessedBlock + 1; $i <= $lastBlockNumber; $i++) {
                        dispatch(new CreateDepositJob($i));
                        dispatch(new ConfirmDepositJob($i));
                        Cache::put('lastProcessedBlock', $i);
                    }
                    $lastProcessedBlock = $lastBlockNumber;
                }
            }

        } while (true);
    }
}
