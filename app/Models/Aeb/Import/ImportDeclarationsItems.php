<?php

namespace App\Models\Aeb\Import;

use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class ImportDeclarationsItems extends Model
{
    protected $table = 'aeb_import_declarations_items';

    protected $guarded = [];

    use softDeletes;

    public static function init($params, $type = 'add')
    {
        $data = [
            'declaration_id' => $params['declaration_id'] ?? '',
            'no' => $params['no'] ?? '',
            'commercial_reference' => $params['commercial_reference'] ?? '',
            'material_id' => $params['material_id'] ?? '',
            'quantity' => $params['quantity'] ?? '',
            'goods_description' => $params['goods_description'] ?? '',
            'internal_remark' => $params['internal_remark'] ?? '',
            'commodity_code' => $params['commodity_code'] ?? '',
            'chemical_cus_code' => $params['chemical_cus_code'] ?? '',
            'statistical_quantity' => $params['statistical_quantity'] ?? '',
            'tariff_quantities' => $params['tariff_quantities'] ?? '',
            'taric' => $params['taric'] ?? '',
            'nat_add_codes' => $params['nat_add_codes'] ?? '',
            'preference_request' => $params['preference_request'] ?? '',
            'quota_number' => $params['quota_number'] ?? '',
            'evaluation_method' => $params['evaluation_method'] ?? '',
            'ctry_of_origin' => $params['ctry_of_origin'] ?? '',
            'preferential_origin' => $params['preferential_origin'] ?? '',
            'procedure' => $params['procedure'] ?? '',
            'nat_procedure' => $params['nat_procedure'] ?? '',
            'net_price' => $params['net_price'] ?? '',
            'stat_value' => $params['stat_value'] ?? '',
            'gross_weight' => $params['gross_weight'] ?? '',
            'net_weight' => $params['net_weight'] ?? '',
            'no_of_packages' => $params['no_of_packages'] ?? '',
            'packages' => $params['packages'] ?? '',
            'ctry_of_dispatch' => $params['ctry_of_dispatch'] ?? '',
            'ctry_of_destination' => $params['ctry_of_destination'] ?? '',
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
