<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;


class DictItemInfo extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'dictCode' => $this->dict_code,
            'dict_code' => $this->dict_code,
            'value' => $this->value,
            'label' => $this->label,
            'tagType' => $this->tag_type,
            'tag_type' => $this->tag_type,
            'status' => $this->status,
            'remark' => $this->remark,
            'sort' => $this->sort,
            'created_at' => $this->created_at?->format('Y/m/d H:i'),
            'create_by' => $this->create_by,
            'updated_at' => $this->updated_at?->format('Y/m/d H:i'),
            'update_by' => $this->update_by,
            'company_id' => $this->company_id,
        ];
    }


}
