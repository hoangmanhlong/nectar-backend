<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;

class Area extends Model
{

    const TABLE_NAME = 'areas';

    const ID = 'id';

    const NAME = 'name';

    const ZONE_ID = 'zone_id';

    const AREA_ID = 'area_id';

    protected $table = self::TABLE_NAME;

    protected $fillable = [
        self::ID,
        self::NAME,
        self::ZONE_ID
    ];

    protected $hidden = [
        self::CREATED_AT,
        self::UPDATED_AT,
        self::ZONE_ID
    ];

    function zone()
    {
        return $this->belongsTo(Zone::class, Zone::ID, self::ZONE_ID);
    }

    static function isAreaExist(int $id): bool
    {
        try {
            return self::where(self::ID, $id)->exists();
        } catch (Exception) {
            return false;
        }
    }

    static function getAreaById(int $areaId) {
        try {
            return self::where(self::ID, $areaId)->first();
        } catch(Exception) {
            return null;
        }
    }
}
