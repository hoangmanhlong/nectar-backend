<?php

namespace App\Models;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Exceptions\AccountAlreadyExistsException;
use App\Models\Exceptions\UnknownErrorException;

class UserAccount extends Authenticatable implements JWTSubject
{

    use Notifiable;

    const TABLE_NAME = 'user_account';

    const ID = 'id';
    const EMAIL = 'email';
    const PASSWORD = 'password';
    const NEW_PASSWORD = 'new_password';

    protected $table = self::TABLE_NAME;

    protected $fillable = [
        self::EMAIL,
        self::PASSWORD
    ];

    protected $hidden = [
        self::ID,
        self::PASSWORD,
        self::CREATED_AT,
        self::UPDATED_AT
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @throws AccountAlreadyExistsException
     * @throws UnknownErrorException
     */
    static function register(string $email, string $password): true
    {
        DB::beginTransaction();
        try {
            $user = self::where(self::EMAIL, $email)->first();

            if (!$user) {
                self::create([
                    self::EMAIL => $email,
                    self::PASSWORD => Hash::make($password),
                ]);
                DB::commit();
                return true;
            } else {
                throw new AccountAlreadyExistsException;
            }
        } catch (AccountAlreadyExistsException) {
            DB::rollBack();
            throw new AccountAlreadyExistsException;
        } catch (Exception) {
            DB::rollBack();
            throw new UnknownErrorException;
        }
    }

    static function changePassword(string $email, string $password, string $newPassword): bool
    {
        try {
            $user = self::where(self::EMAIL, $email)->first();

            if ($user && Hash::check($password, $user->password)) {
                $user->update([
                    self::PASSWORD => Hash::make($newPassword)
                ]);
                return true;
            }
        } catch (Exception $e) {
        }
        return false;
    }

    function userData()
    {
        return $this->belongsTo(UserData::class, UserData::ID, self::ID);
    }
}
