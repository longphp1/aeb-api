<?php

namespace App\Models\Aeb\Import;

use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class ImportFinancialOverview extends Model
{
    protected $table = 'aeb_import_financial_overview';

    protected $guarded = [];

    use softDeletes;


    public static function init($params, $type = 'create')
    {
        $data = [
            'declaration_id' => $params['declaration_id'] ?? '',
            'total_invoice' => $params['total_invoice'] ?? '',
            'total_invoice_currency' => $params['total_invoice_currency'] ?? '',
            'nature_of_transact' => $params['nature_of_transact'] ?? '',
            'incoterm' => $params['incoterm'] ?? '',
            'place' => $params['place'] ?? '',
            'place_code' => $params['place_code'] ?? '',
            'incoterm_info' => $params['incoterm_info'] ?? '',
            'country' => $params['country'] ?? '',
            'calculate_values' => $params['calculate_values'] ?? '',
            'inclusion_mode' => $params['inclusion_mode'] ?? '',
            'transport' => $params['transport'] ?? '',
            'transport_abs_value' => $params['transport_abs_value'] ?? '',
            'transport_costs' => $params['transport_costs'] ?? '',
            'outside_eu' => $params['outside_eu'] ?? '',
            'eu_to_nl' => $params['eu_to_nl'] ?? '',
            'inside_nl' => $params['inside_nl'] ?? '',
            'insurance' => $params['insurance'] ?? '',
            'insurance_abs_value' => $params['insurance_abs_value'] ?? '',
            'insurance_costs' => $params['insurance_costs'] ?? '',
            'gross_weight' => $params['gross_weight'] ?? '',
            'net_weight' => $params['net_weight'] ?? '',
            'no_of_packages' => $params['no_of_packages'] ?? '',
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
