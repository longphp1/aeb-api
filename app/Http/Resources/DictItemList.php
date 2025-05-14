<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DictItemList extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => [
                'list' => $this->collection->map(function ($data) {
                    return [
                        'id' => $data->id,
                        'dictCode' => $data->dict_code,
                        'dict_code' => $data->dict_code,
                        'value' => $data->value,
                        'label' => $data->label,
                        'tagType' => $data->tag_type,
                        'tag_type' => $data->tag_type,
                        'status' => $data->status,
                        'remark' => $data->remark,
                        'sort' => $data->sort,
                        'created_at' => $data->created_at?->format('Y/m/d H:i'),
                        'create_by' => $data->create_by,
                        'updated_at' => $data->updated_at?->format('Y/m/d H:i'),
                        'update_by' => $data->update_by,
                        'company_id' => $data->company_id,
                    ];
                }),
                'total' => $this->total(),
            ],
        ];
    }
}
