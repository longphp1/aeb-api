<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SysLogList extends ResourceCollection
{

    public function toArray($request)
    {
        return [
            'data' => [
                'list' => $this->collection->map(function ($data) {
                    return [
                        'id' => $data->id,
                        'module' => $data->module,
                        'request_method' => $data->request_method,
                        'request_params' => $data->request_params,
                        'response_content' => $data->response_content,
                        'content' => $data->content,
                        'request_uri' => $data->request_uri,
                        'method' => $data->method,
                        'ip' => $data->ip,
                        'executionTime' => $data->execution_time,
                        'browser' => $data->browser,
                        'os' => $data->os,
                        'createTime' => $data->created_at != null ? Carbon::parse($data->created_at)->format('Y/m/d H:i') : null,
                        'operator' => $data->createUser->username??'',
                        'create_by' => $data->create_by,
                        'updated_at' => $data->updated_at != null ? Carbon::parse($data->updated_at)->format('Y/m/d H:i') : null,
                        'company_id' => $data->company_id
                    ];
                }),
                'total' => $this->total(),
            ],
        ];
    }
}
