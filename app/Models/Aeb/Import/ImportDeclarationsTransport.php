<?php

namespace App\Models\Aeb\Import;

use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class ImportDeclarationsTransport extends Model
{
    protected $table = 'aeb_import_declarations_transport';

    protected $guarded = [];


    use softDeletes;

    public static function init($params, $type = 'add')
    {
        $data = [
            'declaration_id' => $params['declaration_id'] ?? '',
            'nat_means_border' => $params['nat_means_border'] ?? '',
            'mode_border' => $params['mode_border'] ?? '',
            'mode_arrival' => $params['mode_arrival'] ?? '',
            'means_type_arrival' => $params['means_type_arrival'] ?? '',
            'means_arrival_id' => $params['means_arrival_id'] ?? '',
            'ctry_of_dispatch' => $params['ctry_of_dispatch'] ?? '',
            'ctry_of_destination' => $params['ctry_of_destination'] ?? '',
            'office_of_entry' => $params['office_of_entry'] ?? '',
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
