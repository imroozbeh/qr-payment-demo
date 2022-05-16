<?php

namespace App\Console\Commands;

use App\Facades\NodeApi;
use App\Jobs\ConfirmDepositJob;
use App\Jobs\CreateDepositJob;
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
        $lastListenedBlock = Cache::rememberForever('lastListenedBlock', function () {
            return 0;
        });

        do {
            $currentBlock = NodeApi::eth_blockNumber();
            if($currentBlock['status'] == 200) {
                $currentBlockNumber = hexdec($currentBlock['body']['result']);
            }

            if($currentBlockNumber > $lastListenedBlock) {
                for ($i = $lastListenedBlock + 1; $i <= $currentBlockNumber; $i++) {
                    dispatch(new CreateDepositJob($i));
                    dispatch(new ConfirmDepositJob($i));
                    Cache::put('lastListenedBlock', $i);
                }
                $lastListenedBlock = $currentBlockNumber;
            }
        } while (true);
    }
}
