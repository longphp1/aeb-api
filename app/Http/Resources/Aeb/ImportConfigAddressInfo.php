<?php

namespace App\Http\Resources\Aeb;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ImportConfigAddressInfo extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'street' => $this->street,
            'house_number' => $this->house_number,
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
