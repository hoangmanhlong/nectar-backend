<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Zone extends Model {

    const TABLE_NAME = 'zones';

    const ID = 'id';

    const NAME ='name';

    const ZONE_ID = 'zone_id';

    protected $table = self::TABLE_NAME;

    protected $fillable = [
        self::ID,
        self::NAME,
    ];

    protected $hidden = [
        self::CREATED_AT,
        self::UPDATED_AT
    ];

    function areas(): HasMany
    {
        return $this->hasMany(Area::class, Area::ZONE_ID, self::ID);
    }

    static function getZones(): ?Collection
    {
        try {
            return self::with('areas')->get();
        } catch(Exception) {
            return null;
        }
    }

    static function isZoneExist(int $id): bool {
        try {
            return self::where(self::ID, $id)->exists();
        } catch (Exception) {
            return false;
        }
    }

    static function getZoneById(int $zoneId) {
        try {
            return self::where(self::ID, $zoneId)->first();
        } catch(Exception) {
            return null;
        }
    }
}
