<?php

namespace App\Http\Controllers;

use App\Facades\GenerateAddressFacade;
use App\Facades\NodeApi;
use App\Facades\NodeHelper;
use App\Facades\NodeRepositoryFacade;
use App\Models\Address;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller as BaseController;

class AddressController extends BaseController
{
    public function generate()
    {

        try {

            $address = GenerateAddressFacade::generateAddress();
            $data = [
                'address' => $address['address'],
                'hd_path' => $address['path'],

            ];

            $address = NodeRepositoryFacade::forceStoreRecord('Address', $data);


            return response($address, Response::HTTP_OK);

        } catch (\Exception $exception) {
            DB::rollBack();

            return response($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }


    }

    public function addressList()
    {
        try {

            return response(Address::all(), Response::HTTP_OK);

        } catch (\Exception $exception) {
            DB::rollBack();

            return response($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function addressDeposits($address)
    {

        try {
//            return NodeHelper::bcDecodeValue("e8d4a51000");
            $eth = NodeApi::eth_getTransactionByHash('0x634cc78ecf8a6d8dfabd5a3e4a184f0581af2b6aa903aecddef327ead5b2cb23');
//            $contract = NodeApi::eth_getTransactionByHash('0xb440620eceb29a7aaada624a7f374ea304774de1ad8a961e09cf4d2b30aa27e2');
//
            $data['eth'] = substr($eth['body']['result']['value'], 2);
            $data['eth_dec'] = NodeHelper::bcDecodeValue($data['eth']);
//
//            $data['contract'] = substr($contract['body']['result']['input'], 74);
//            $data['contract_dec'] = NodeHelper::bcDecodeValue($data['contract'], 18);
//
            return $data;




            $deposits = NodeRepositoryFacade::getRecords('Deposit', ['address' => $address]);

            return response($deposits, Response::HTTP_OK);

        } catch (\Exception $exception) {
            DB::rollBack();

            return response($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
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
