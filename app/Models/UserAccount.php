<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Models\EmailOrPasswordIncorrectException;

class UserAccount extends Model {

    const ID = 'id';
    const EMAIL = 'email';
    const PASSWORD = 'password';
    const NEW_PASSWORD = 'new_password';

    protected $table = 'user_account';

    protected $fillable = [
        self::ID,
        self::EMAIL,
        self::PASSWORD
    ];

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
