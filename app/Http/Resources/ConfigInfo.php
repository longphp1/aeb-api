<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;


class ConfigInfo extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'configName' => $this->config_name,
            'configKey' => $this->config_key,
            'configValue' => $this->config_value,
            'remark' => $this->remark,
            'created_at' => $this->created_at != null ? Carbon::parse($this->created_at)->format('Y/m/d H:i') : null,
            'create_by' => $this->create_by,
            'updated_at' => $this->updated_at != null ? Carbon::parse($this->updated_at)->format('Y/m/d H:i') : null,
            'update_by' => $this->update_by,
            'company_id' => $this->company_id
        ];
    }


}
