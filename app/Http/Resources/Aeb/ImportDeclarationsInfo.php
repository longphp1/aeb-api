<?php

namespace App\Http\Resources\Aeb;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ImportDeclarationsInfo extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'decl_type' => $this->decl_type,
            'declaration_type' => $this->declaration_type,
            'procedure_type' => $this->procedure_type,
            'manual_acc_date' => $this->manual_acc_date != null ? Carbon::parse($this->manual_acc_date)->format('Y/m/d H:i') : null,
            'commercial_reference' => $this->commercial_reference,
            'consignment_no' => $this->consignment_no,
            'container_no' => $this->container_no,
            'internal_reference' => $this->internal_reference,
            'lrn' => $this->lrn,
            'mrn' => $this->mrn,
            'deco' => $this->deco,
            'delivery_no' => $this->delivery_no,
            'invoice_no' => $this->invoice_no,
            'mode_border' => $this->mode_border,
            'number_of_items' => $this->number_of_items,
            'object_id' => $this->object_id,
            'release' => $this->release,
            'transition_id' => $this->transition_id,
            'version' => $this->version,
            'office_of_import' => $this->office_of_import,

            'declaration_date' => $this->declaration_date != null ? Carbon::parse($this->declaration_date)->format('Y/m/d H:i') : null,
            'created_at' => $this->created_at != null ? Carbon::parse($this->created_at)->format('Y/m/d H:i') : null,
            'create_by' => $this->create_by,
            'updated_at' => $this->updated_at != null ? Carbon::parse($this->updated_at)->format('Y/m/d H:i') : null,
            'company_id' => $this->company_id
        ];
    }
}
