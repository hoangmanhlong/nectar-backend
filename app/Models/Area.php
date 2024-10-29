<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model {

    const TABLE_NAME = 'areas';

    const ID = 'id';

    const NAME = 'name';

    const ZONE_ID = 'zone_id';
 
    protected $table = self::TABLE_NAME;

    protected $fillable = [
        self::ID,
        self::NAME,
        self::ZONE_ID
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        self::ZONE_ID
    ];

    function zone() {
        return $this->belongsTo(Zone::class, Zone::ID, self::ZONE_ID);
    }
}