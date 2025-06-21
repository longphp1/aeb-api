<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SysLogInfo extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'module' => $this->module,
            'request_method' => $this->request_method,
            'request_params' => $this->request_params,
            'response_content' => $this->response_content,
            'content' => $this->content,
            'request_uri' => $this->request_uri,
            'method' => $this->method,
            'ip' => $this->ip,
            'executionTime' => $this->execution_time,
            'browser' => $this->browser,
            'os' => $this->os,
            'createTime' => $this->created_at != null ? Carbon::parse($this->created_at)->format('Y/m/d H:i') : null,
            'operator' => $this->createUser->username ?? '',
            'create_by' => $this->create_by,
            'updated_at' => $this->updated_at != null ? Carbon::parse($this->updated_at)->format('Y/m/d H:i') : null,
            'company_id' => $this->company_id
        ];
    }
}
