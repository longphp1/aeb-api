<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;


class DictInfo extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'dictCode' => $this->dict_code,
            'status' => $this->status,
            'remark' => $this->remark,
            'created_at' => $this->created_at?->format('Y/m/d H:i'),
            'create_by' => $this->create_by,
            'updated_at' => $this->updated_at?->format('Y/m/d H:i'),
            'update_by' => $this->update_by,
            'company_id' => $this->company_id,
        ];
    }


}
