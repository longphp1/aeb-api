<?php

namespace App\Http\Resources\Aeb;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ImportConfigContactInfo extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'initials' => $this->initials,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'name' => $this->name,
            'phone' => $this->phone,
            'fax' => $this->fax,
            'email' => $this->email,
            'company_name' => $this->company_name,
            'title' => $this->title,
            'signing_authority' => $this->signing_authority,
            'type' => $this->type,

            'created_at' => $this->created_at != null ? Carbon::parse($this->created_at)->format('Y/m/d H:i') : null,
            'create_by' => $this->create_by,
            'updated_at' => $this->updated_at != null ? Carbon::parse($this->updated_at)->format('Y/m/d H:i') : null,
            'company_id' => $this->company_id
        ];
    }
}
