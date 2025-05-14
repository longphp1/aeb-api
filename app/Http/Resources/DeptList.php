<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DeptList extends ResourceCollection
{

    public function toArray($request)
    {
        return [
            'data' => [
                'list' => $this->collection->map(function ($data) {
                    return [
                        'id' => $data->id,
                        'name' => $data->name,
                        'code' => $data->code,
                        'sort' => $data->sort,
                        'status' => $data->status,
                        'data_scope' => $data->data_scope,
                        'created_at' => $data->created_at != null ? Carbon::parse($data->created_at)->format('Y/m/d H:i') : null,
                        'create_by' => $data->create_by,
                        'updated_at' => $data->updated_at != null ? Carbon::parse($data->updated_at)->format('Y/m/d H:i') : null,
                        'update_by' => $data->update_by,
                        'company_id' => $data->company_id
                    ];
                }),
                'total' => $this->total(),
            ],
        ];
    }
}
