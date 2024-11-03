<?php

namespace App\Http\Controllers;

use App\Models\Exceptions\AccountAlreadyExistsException;
use App\Models\AppResponse;
use App\Models\Area;
use App\Models\Exceptions\RequestDataInvalidException;
use App\Models\Exceptions\UnknownErrorException;
use Illuminate\Http\Request;
use App\Models\UserAccount;
use App\Models\Zone;
use App\Models\AppUtils;
use App\Models\UserData;

class UserAccountController extends Controller
{

    private array $registerDataRule = [
        UserAccount::EMAIL => ['required', 'email', 'string'],
        UserAccount::PASSWORD => ['required', 'string'],
        UserData::USERNAME => ['required', 'string'],
        Zone::ZONE_ID => ['nullable', 'integer', 'regex:/^\d+$/', 'min:1'],
        Area::AREA_ID => ['nullable', 'integer','regex:/^\d+$/', 'min:1']
    ];

    function register(Request $request)
    {
        try {
            $params = $request->all();

            $validationResponse = AppUtils::validateParamsWithRule($params, $this->registerDataRule);
            if ($validationResponse) return $validationResponse;

            $email = $params[UserAccount::EMAIL];
            $password = $params[UserAccount::PASSWORD];
            $username = $params[UserData::USERNAME];
            $zoneId = $params[Zone::ZONE_ID];
            $areaId = $params[Area::AREA_ID];

            // If there is a zoneId and areaId, but it is not in the list of zones and areas then return 422
            if ($zoneId && $areaId && (!Zone::isZoneExist($zoneId) || !Area::isAreaExist($areaId))) {
                return AppResponse::invalidRuleParams();
            }

            // Create new user account
            $createUserAccountResult = UserAccount::register($email, $password);

            if ($createUserAccountResult) {
                // Create new user data
                $createUserDataResult = UserData::createUserData($email, $username, $zoneId, $areaId);
                if ($createUserDataResult) {
                    return AppResponse::success(
                        status: AppResponse::SUCCESS_STATUS,
                        message: __(key: 'messages.register_success')
                    );
                }
            }
        } catch (AccountAlreadyExistsException $accountAlreadyExistsException) {
            return AppResponse::success(
                status: AppResponse::ERROR_STATUS,
                message: $accountAlreadyExistsException->getMessage()
            );
        } catch (RequestDataInvalidException) {
            return AppResponse::invalidRuleParams();
        } catch (UnknownErrorException $unknownErrorException) {
            return AppResponse::unknownError($unknownErrorException->getMessage());
        }
    }
}
