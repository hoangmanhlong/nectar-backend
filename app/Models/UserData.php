<?php

namespace App\Models;

use App\Models\Exceptions\RequestDataInvalidException;
use App\Models\Exceptions\UnknownErrorException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Lcobucci\JWT\Exception;

class UserData extends Model
{

    const TABLE_NAME = 'user_data';

    const ID = 'id';

    const USERNAME = 'username';

    const EMAIl = 'email';

    const ZONE_ID = 'zone_id';

    const AREA_ID = 'area_id';

    protected $table = self::TABLE_NAME;

    protected $fillable = [
        self::USERNAME,
        self::EMAIl,
        self::ZONE_ID,
        self::AREA_ID,
    ];

    /**
     * @throws UnknownErrorException|RequestDataInvalidException
     */
    public static function createUserData(
        string $email,
        string $username,
        int    $zoneId = null,
        int    $areaId = null
    ): true {
        DB::beginTransaction();
        try {
            if ((!$zoneId && !$areaId) || ($zoneId && $areaId)) {
                self::create([
                    self::EMAIl => $email,
                    self::USERNAME => $username,
                    self::ZONE_ID => $zoneId,
                    self::AREA_ID => $areaId,
                ]);
                DB::commit();
                return true;
            } else {
                throw new RequestDataInvalidException;
            }
        } catch (RequestDataInvalidException) {
            DB::rollBack();
            throw new RequestDataInvalidException;
        } catch (Exception) {
            DB::rollBack();
            throw new UnknownErrorException();
        }
    }

    public function useraccount()
    {
        return $this->hasOne(UserAccount::class, UserAccount::ID, self::ID);
    }

    public function favoriteProducts()
    {
        return $this->belongsToMany(
            related: Product::class,
            table: FavoriteProduct::TABLE_NAME,
            foreignPivotKey: self::ID,
            relatedPivotKey: FavoriteProduct::PRODUCT_ID
        );
    }

    public function basket() {
        return $this->hasOne(
            related: Basket::class,
            foreignKey: Basket::USER_ID,
            localKey: self::ID
        );
    }
}
