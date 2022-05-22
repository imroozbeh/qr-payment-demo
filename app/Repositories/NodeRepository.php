<?php

namespace App\Repositories;

use App\Models\Deposit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Milyoonex\Repositories\BaseRepository;

class NodeRepository extends BaseRepository
{
    public function getCurrency($network, $contract)
    {
        $network = $network->load(['currencies' => function ($query) use ($contract) {
            $query->where('currency_network.contract', $contract);
        }]);
        return $network->currencies->first();
    }

    public function increaseWalletBalance($wallet, $network)
    {
        var_dump('increase, wallet: ' . $wallet->id . ' || increase, network:' . $network->name);
        DB::beginTransaction();

        $deposits = $wallet->deposits()->where('deposited_at', null)->where('status', '=', '1')->get();

        $sum = '0';

        foreach ($deposits as $deposit) {
            $sum = addAmount($sum, $deposit->amount);
        }

        if ($sum >= $wallet->currency->min_deposit) {
            $wallet->update([
                'balance' => addAmount($wallet->balance, $sum)
            ]);

            foreach ($deposits as $deposit) {
                $deposit->update([
                    'deposited_at' => Carbon::now()->toDateTimeString()
                ]);
            }
        }

        DB::commit();
    }

    public function getNotConfirmedDeposits()
    {
        return Deposit::where('confirmed_at', null)->where(function ($query) {
            $query->where('status', null)->orWhere('status', '1');
        })->get();
    }
}
