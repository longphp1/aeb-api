<?php

namespace App\Models\Aeb\Import;

use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class ImportItemsDetail extends Model
{
    protected $table = 'aeb_import_declarations_items_detail';

    protected $guarded = [];

    use softDeletes;

    public static function init($params, $type = 'create')
    {
        $data = [
            'declaration_id' => $params['declaration_id'] ?? '',
            'item_id' => $params['item_id'] ?? '',
            'authorizations' => $params['authorizations'] ?? '',
            'additional_information' => $params['additional_information'] ?? '',
            'consignor' => $params['consignor'] ?? '',
            'buyer' => $params['buyer'] ?? '',
            'seller' => $params['seller'] ?? '',
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
