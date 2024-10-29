<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Zone;

class ZoneController extends Controller {

    function getZones() {
        return response()->json(Zone::getZones());
    }
}