<?php

namespace App\Models\Aeb\Import;

use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class ImportDeclarations extends Model
{
    protected $table = 'aeb_import_declarations';

    protected $guarded = [];

    use softDeletes;


    public static function init($params, $type = 'create')
    {
        $data = [
            'decl_type' => $params['decl_type'] ?? '',
            'declaration_type' => $params['declaration_type'] ?? '',
            'declaration_date' => $params['declaration_date'] ?? '',
            'procedure_type' => $params['procedure_type'] ?? '',
            'manual_acc_date' => $params['manual_acc_date'] ?? '',
            'commercial_reference' => $params['commercial_reference'] ?? '',
            'consignment_no' => $params['consignment_no'] ?? '',
            'container_no' => $params['container_no'] ?? '',
            'internal_reference' => $params['internal_reference'] ?? '',
            'lrn' => $params['lrn'] ?? '',
            'mrn' => $params['mrn'] ?? '',
            'deco' => $params['deco'] ?? '',
            'delivery_no' => $params['delivery_no'] ?? '',
            'invoice_no' => $params['invoice_no'] ?? '',
            'mode_border' => $params['mode_border'] ?? '',
            'number_of_items' => $params['number_of_items'] ?? '',
            'object_id' => $params['object_id'] ?? '',
            'release' => $params['release'] ?? '',
            'transition_id' => $params['transition_id'] ?? '',
            'version' => $params['version'] ?? '',
            'office_of_import' => $params['office_of_import'] ?? '',
            'declarant_id' => $params['declarant_id'] ?? '',
            'importer_id' => $params['importer_id'] ?? '',
            'consignee_id' => $params['consignee_id'] ?? '',
            'consignor_id' => $params['consignor_id'] ?? '',
            'representative_id' => $params['representative_id'] ?? '',
            'payer_id' => $params['payer_id'] ?? '',
            'guarantor_import_id' => $params['guarantor_import_id'] ?? '',
            'vat_payer_id' => $params['vat_payer_id'] ?? '',
            'buyer_id' => $params['buyer_id'] ?? '',
            'seller_id' => $params['seller_id'] ?? '',
            'receiving_point_id' => $params['receiving_point_id'] ?? '',
            'company_id' => auth()->user()->company_id ?? 0,
        ];

        if ($type == 'create') {
            $data['created_at'] = Carbon::now()->toDateTimeString();
            $data['created_by'] = auth()->user()->id?? 0;
        } else {
            $data['updated_at'] = Carbon::now()->toDateTimeString();
        }
        return $data;
    }
}
