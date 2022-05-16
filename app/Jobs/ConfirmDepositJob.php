<?php

namespace App\Jobs;

class ConfirmDepositJob extends Job
{
    /**
     * @var
     */
    private $blockNumber;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($blockNumber)
    {
        $this->blockNumber = $blockNumber;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
    }
}
