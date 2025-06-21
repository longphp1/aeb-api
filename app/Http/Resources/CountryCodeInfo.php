<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;


class CountryCodeInfo extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'emoji' => $this->emoji,
            'status' => $this->status,
            'statusName' => $this->status_name,
            'created_at' => $this->created_at != null ? Carbon::parse($this->created_at)->format('Y/m/d H:i') : null,
            'updated_at' => $this->updated_at != null ? Carbon::parse($this->updated_at)->format('Y/m/d H:i') : null,
            'company_id' => $this->company_id
        ];
    }


}
