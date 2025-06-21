<?php

namespace App\Models\Aeb\Import;

use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class ImportFinancialOverviewValue extends Model
{
    protected $table = 'aeb_import_financial_overview_value';

    protected $guarded = [];

    use softDeletes;


    public static function init($params, $type = 'create')
    {
        $data = [
            'declaration_id' => $params['declaration_id'] ?? '',
            'financial_id' => $params['financial_id'] ?? '',
            'customs_value' => $params['customs_value'] ?? '',
            'customs_value_currency' => $params['customs_value_currency'] ?? '',
            'statistical_value' => $params['statistical_value'] ?? '',
            'statistical_value_currency' => $params['statistical_value_currency'] ?? '',
            'vat_value' => $params['vat_value'] ?? '',
            'vat_value_currency' => $params['vat_value_currency'] ?? '',
            'customs_duties' => $params['customs_duties'] ?? '',
            'customs_duties_currency' => $params['customs_duties_currency'] ?? '',
            'excise_duties' => $params['excise_duties'] ?? '',
            'excise_duties_currency' => $params['excise_duties_currency'] ?? '',
            'vat' => $params['vat'] ?? '',
            'vat_currency' => $params['vat_currency'] ?? '',
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
