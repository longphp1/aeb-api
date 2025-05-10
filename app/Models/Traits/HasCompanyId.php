<?php



namespace App\Models\Traits;

use App\Models\SysUser;
use App\Models\Scope\CompanyScope;
use App\Models\User;

trait HasCompanyId
{
    public static function getCompanyId()
    {
        $user = auth()->user();
        if ($user instanceof SysUser) {
            return $user->company_id;
        }
        if ($user instanceof User) {
            return $user->company_id;
        }

        $companyID = self::getCompanyIdFromReqPath();
        if ($companyID) {
            return $companyID;
        }

        if (CompanyScope::getUuidFromInput()) {
            return CompanyScope::getUuidFromInput();
        }

        return CompanyScope::getUuidFromHeader();
    }

    public static function getCompanyIdFromReqPath()
    {
        $arr = explode('/', request()->path());

        end($arr);
        $uuid = current($arr);

        return self::getValidCompanyId($uuid);
    }

    public static function getValidCompanyId(string $uuid): ?int
    {
        if (strlen($uuid) !== 36) {
            return null;
        }

        $company = SysUser::where('uuid', $uuid)->select('company_id')->first();

        return $company ? $company->company_id : null;
    }
}
