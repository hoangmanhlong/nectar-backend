<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AppResponse;
use App\Models\Area;
use App\Models\Zone;

class UserDataController extends Controller
{
    public function getLocation()
    {
        // Current user of request
        $user = auth()->user();

        if (!$user) {
            return AppResponse::unauthorized();
        }

        $userData = $user->userData;

        if (!$userData) {
            return AppResponse::success(
                status: AppResponse::ERROR_STATUS
            );
        }

        $zoneIdOfUserData = $userData->zone_id;
        $areaIdOfUserData = $userData->area_id;

        if (!$zoneIdOfUserData || !$areaIdOfUserData) {
            return AppResponse::success(
                status: AppResponse::ERROR_STATUS
            );
        }

        $zone = Zone::getZoneById(zoneId: $zoneIdOfUserData);
        $area = Area::getAreaById(areaId: $areaIdOfUserData);

        if (!$zone || !$area) {
            return AppResponse::success(
                status: AppResponse::ERROR_STATUS
            );
        }

        return AppResponse::success(
            status: AppResponse::SUCCESS_STATUS,
            data: [
                Zone::ID => $zone->id,
                Zone::NAME => $zone->name,
                'areas' => [[
                    Area::ID => $area->id,
                    Area::NAME => $area->name
                ]]
            ]
        );
    }
}
