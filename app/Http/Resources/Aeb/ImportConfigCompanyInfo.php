<?php

namespace App\Http\Resources\Aeb;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ImportConfigCompanyInfo extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'company_name' => $this->company_name,
            'company_code' => $this->company_code,
            'role_type' => $this->role_type,
            'trader_id' => $this->trader_id,
            'vat_id' => $this->vat_id,
            'ioss_vat' => $this->ioss_vat,
            'user_name' => $this->user_name,
            'street' => $this->street,
            'postal_code' => $this->postal_code,
            'city' => $this->city,
            'country' => $this->country,

            'created_at' => $this->created_at != null ? Carbon::parse($this->created_at)->format('Y/m/d H:i') : null,
            'create_by' => $this->create_by,
            'updated_at' => $this->updated_at != null ? Carbon::parse($this->updated_at)->format('Y/m/d H:i') : null,
            'company_id' => $this->company_id
        ];
    }
}
