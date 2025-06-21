<?php

namespace App\Models\Aeb\Import;

use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class ImportDeclarationsDetail extends Model
{
    protected $table = 'aeb_import_declarations_detail';

    protected $guarded = [];

    use softDeletes;


    public static function init($params, $type = 'add')
    {
        $data = [
            'declarations_id' => $params['declarations_id'] ?? '',
            'document_language' => $params['document_language'] ?? '',
            'warehouse_type' => $params['warehouse_type'] ?? '',
            'warehouse_id' => $params['warehouse_id'] ?? '',
            'supervising_office' => $params['supervising_office'] ?? '',
            'method_of_payment' => $params['method_of_payment'] ?? '',
            'vat_payment_mode' => $params['vat_payment_mode'] ?? '',
            'guarantees' => $params['guarantees'] ?? '',
            'additional_information' => $params['additional_information'] ?? '',
            'transport_equipment' => $params['transport_equipment'] ?? '',
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
