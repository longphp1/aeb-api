<?php

namespace App\Models\Aeb\Import;

use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class ImportCustomsOffice extends Model
{
    protected $table = 'aeb_import_customs_office';

    protected $guarded = [];

    use softDeletes;

    public static function init($params, $type = 'add')
    {
        $data = [
            'code' => $params['code'],
            'domestic_code' => $params['domestic_code'],
            'country' => $params['country'],
            'to_country' => $params['to_country'] ?? '',
            'geo_info_code' => $params['geo_info_code'] ?: '',
            'data_source' => $params['data_source'] ?: '',
            'from_data_service' => $params['from_data_service'] ?? 0,
            'start_on' => $params['start_on'] ?? null,
            'end_on' => $params['end_on'] ?? null,
            'export_customs_office' => $params['export_customs_office'] ?? 0,
            'office_of_exit' => $params['office_of_exit'] ?? 0,
            'air_exit_office' => $params['air_exit_office'] ?? 0,
            'customs_office_of_entry' => $params['customs_office_of_entry'] ?? 0,
            'border_customs_office' => $params['border_customs_office'] ?? 0,
            'supervising_customs_office' => $params['supervising_customs_office'] ?? 0,
            'transit_customs_office' => $params['transit_customs_office'] ?? 0,
            'office_of_departure' => $params['office_of_departure'] ?? 0,
            'office_of_destination' => $params['office_of_destination'] ?? 0,
            'exit_office_inland' => $params['exit_office_inland'] ?? 0,
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
