<?php

namespace App\Models\Aeb\Import;

use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class ImportConfigCompany extends Model
{
    protected $table = 'aeb_import_config_company';

    protected $guarded = [];

    use softDeletes;


    public static function init($params, $type = 'add')
    {
        $data = [
            'company_name' => $params['company_name'],
            'company_code' => $params['company_code'],
            'role_type' => $params['role_type'],
            'trader_id' => $params['trader_id'],
            'vat_id' => $params['vat_id'],
            'ioss_vat' => $params['ioss_vat'],
            'user_name' => $params['user_name'],
            'street' => $params['street'],
            'postal_code' => $params['postal_code'],
            'city' => $params['city'],
            'country' => $params['country'],
            'company_id' => auth()->user()->company_id ?? 0,
        ];
        if ($type == 'add') {
            $data['created_at'] = Carbon::now()->toDateTimeString();
            $data['created_by'] = auth()->user()->id ?? 0;
        } else {
            $data['updated_at'] = Carbon::now()->toDateTimeString();
        }
        return $data;
    }

}
