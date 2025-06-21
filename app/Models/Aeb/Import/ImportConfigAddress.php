<?php

namespace App\Models\Aeb\Import;

use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class ImportConfigAddress extends Model
{
    protected $table = 'aeb_import_config_address';

    protected $guarded = [];

    use softDeletes;

    public static function init($params, $type = 'add')
    {
        $data = [
            'street' => $params['street'],
            'house_number' => $params['house_number'],
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
