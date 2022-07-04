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

            $deposits = NodeRepositoryFacade::getRecords('Deposit', ['address' => $address]);

            return response($deposits, Response::HTTP_OK);

        } catch (\Exception $exception) {
            DB::rollBack();

            return response($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

    }


}
