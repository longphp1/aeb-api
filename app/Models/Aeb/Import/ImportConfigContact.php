<?php

namespace App\Models\Aeb\Import;

use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class ImportConfigContact extends Model
{
    protected $table = 'aeb_import_config_contact';

    protected $guarded = [];
    use softDeletes;


    public static function init($params, $type = 'add')
    {
        $data = [
            'initials' => $params['initials'],
            'first_name' => $params['first_name'],
            'last_name' => $params['last_name'],
            'name' => $params['name'],
            'phone' => $params['phone'],
            'fax' => $params['fax'],
            'email' => $params['email'],
            'company_name' => $params['company_name'],
            'title' => $params['title'],
            'signing_authority' => $params['signing_authority'],
            'type' => $params['type'],
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
