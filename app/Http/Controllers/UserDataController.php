<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AppResponse;
use App\Models\AppUtils;
use App\Models\Area;
use App\Models\UserData;
use App\Models\Zone;
use Exception;

class UserDataController extends Controller
{
    public function getLocation()
    {

        $userData = AppUtils::getUserData();

        if (!$userData) {
            return AppResponse::success(
                status: AppResponse::ERROR_STATUS
            );
        }

        $address = $this->getAddress($userData);

        if ($address === null || empty($address)) {
            return AppResponse::success(
                status: AppResponse::ERROR_STATUS
            );
        }

        $data = $this->getFormattedAddressResponseData($address);

        return AppResponse::success(
            status: AppResponse::SUCCESS_STATUS,
            data: $data
        );
    }

    public function getAddress(UserData $userData): ?array {
        try {
            $zoneId = $userData->zone_id;
            $areaId = $userData->area_id;

            if (!$zoneId && !$areaId) return [];

            $zone = $userData->zone;
            $area = $userData->area;
            if ($zone && $area) return [UserData::ZONE => $zone, UserData::AREA => $area];
            else throw new Exception;
        } catch(Exception) {
            return null;
        }
    }

    private function getFormattedAddressResponseData(array $address) {
        return [
                Zone::ID => $address[UserData::ZONE]->id,
                Zone::NAME => $address[UserData::ZONE]->name,
                'areas' => [[
                    Area::ID => $address[UserData::AREA]->id,
                    Area::NAME => $address[UserData::AREA]->name
                ]]
        ];
    }

    public function getProfile() {
        try {
            $userData = AppUtils::getUserData();

            if(!$userData) throw new Exception;

            $address = $this->getAddress($userData);

            if ($address !== null && !empty($address)) {
                $userData->address = $this->getFormattedAddressResponseData($address);
            }

            return AppResponse::success(
                status: AppResponse::SUCCESS_STATUS,
                data: $userData
            );
        } catch(Exception) {
            return AppResponse::success(
                status: AppResponse::SUCCESS_STATUS,
                data: AppUtils::getUserData()
            );
        }
    }
}
