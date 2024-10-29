<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model {

    const ID = 'id';

    const NAME ='name';
 
    protected $table = 'zones';

    protected $fillable = [
        'name'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    function areas() {
        return $this->hasMany(Area::class, Area::ZONE_ID, self::ID);
    }

    static function getZones() {
        try {
            return self::with('areas')->get();
        } catch(Exception) {
            return null;
        }
        
    }
}