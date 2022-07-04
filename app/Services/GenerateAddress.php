<?php

namespace App\Services;

use App\Models\Address;
use HdWallet\Src\Services\AddressGenerator\AddressGenerator;

class GenerateAddress
{
    public function generateAddress()
    {
        $address = [];
        $hdPath = $this->getNewHdPath();
        if(! empty($hdPath) && $hdPath != '') {
            $address = AddressGenerator::getNewAddress('erc', $hdPath);
        }
        return $address;
    }

    private function getNewHdPath(): string
    {
        $lastAddress = Address::latest()->first();

        if(is_null($lastAddress)) {
            $newHdPath = '0/0';
        } else {
            $lastHdPath = array_map('intval', explode('/', $lastAddress->hd_path));

            if($lastHdPath[1] == 2147483647 && $lastHdPath[0] != 2147483647) {
                $lastHdPath[0] = $lastHdPath[0] + 1;
                $lastHdPath[1] = 0;
            } elseif($lastHdPath[1] == 2147483647 && $lastHdPath[0] == 2147483647) {
                $lastHdPath[0] = null;
                $lastHdPath[1] = null;
            } else {
                $lastHdPath[1] = $lastHdPath[1] + 1;
            }
            if(! is_null($lastHdPath[0]) && ! is_null($lastHdPath[1])) {
                $newHdPath = $lastHdPath[0] . '/' . $lastHdPath[1];
            } else {
                $newHdPath = '';
            }
        }
        return $newHdPath;
    }
}
