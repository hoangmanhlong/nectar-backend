<?php

namespace App\Models;

use Exception;
use Illuminate\Support\Facades\Hash;
use App\Models\EmailOrPasswordIncorrectException;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserAccount extends Authenticatable implements JWTSubject {

    use Notifiable;

    const ID = 'id';
    const EMAIL = 'email';
    const PASSWORD = 'password';
    const NEW_PASSWORD = 'new_password';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $table = 'user_account';

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

    static function login(string $email, string $password): Result
    {
        try {
            $user = self::where(self::EMAIL, $email)->first();

            if ($user && Hash::check($password, $user->password)) {
                return Result::success(null);
            }

            return Result::error(new EmailOrPasswordIncorrectException());

        } catch (Exception $e) {
            return Result::error($e);
        }
    }

    static function register(string $email, string $password): bool {
        try {
            $user = self::where(self::EMAIL, $email)->first();

            if(!$user) {
                self::create([
                    self::EMAIL => $email,
                    self::PASSWORD => Hash::make($password)
                ]);
                return true;
            }
        } catch(Exception $e) {

        }
        return false;
    }

    static function changePassword(string $email, string $password, string $newPassword): bool {
        try {
            $user = self::where(self::EMAIL, $email)->first();

            if($user && Hash::check($password, $user->password)) {
                $user->update([
                    self::PASSWORD => Hash::make($newPassword)
                ]);
                return true;
            }
        } catch(Exception $e) {

        }
        return false;
    }

}
