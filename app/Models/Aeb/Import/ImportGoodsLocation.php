<?php

namespace App\Models\Aeb\Import;

use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class ImportGoodsLocation extends Model
{
    protected $table = 'aeb_import_goods_location';

    protected $guarded = [];
    use softDeletes;

    public static function init($params, $type = 'create')
    {
        $data = [
            'declaration_id' => $params['declaration_id'] ?? '',
            'type' => $params['type'] ?? '',
            'qualifier' => $params['qualifier'] ?? '',
            'agreed_loc_code' => $params['agreed_loc_code'] ?? '',
            'add_identifier' => $params['add_identifier'] ?? '',
            'customs_office' => $params['customs_office'] ?? '',
            'un_locode' => $params['un_locode'] ?? '',
            'address_id' => $params['address_id'] ?? '',
            'gnss' => $params['gnss'] ?? '',
            'economic_operator_id' => $params['economic_operator_id'] ?? '',
            'company_id' => auth()->user()->company_id ?? 0,
        ];

        if ($type == 'create') {
            $data['created_at'] = Carbon::now()->toDateTimeString();
            $data['created_by'] = auth()->user()->id ?? 0;
        } else {
            $data['updated_at'] = Carbon::now()->toDateTimeString();
        }
        return $data;
    }


}
