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
        $ethLastProcessed = NodeApi::eth_blockNumber();
        $ethLastProcessedBlock = hexdec($ethLastProcessed['body']['result']) - 1;

        do {
            $lastBlock = NodeApi::eth_blockNumber();

            if($lastBlock['status'] == 200) {
                $lastBlockNumber = hexdec($lastBlock['body']['result']);

                if($lastBlockNumber > $ethLastProcessedBlock) {
                    for ($i = $ethLastProcessedBlock + 1; $i <= $lastBlockNumber; $i++) {
                        //var_dump('block_number: ' . $i);
                        dispatch(new CreateDepositJob($i));
                        var_dump($i);
                    }
                    $ethLastProcessedBlock = $lastBlockNumber;
                }
            }

        } while (true);

    }
}
