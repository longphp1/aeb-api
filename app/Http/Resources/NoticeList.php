<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NoticeList extends ResourceCollection
{

    public function toArray($request)
    {
        return [
            'data' => [
                'list' => $this->collection->map(function ($data) {
                    return [
                        'id' => $data->id,
                        'title' => $data->title,
                        'content' => $data->content,
                        'type' => $data->type,
                        'level' => $data->level,
                        'targetType' => $data->target_type,
                        'target_user_ids' => $data->target_user_ids,
                        'publisher_id' => $data->publisher_id,
                        'publisherName' => $data->publisher->username??'',
                        'publishStatus' => $data->publish_status,
                        'publishTime' => $data->publish_time != null ? Carbon::parse($data->publish_time)->format('Y/m/d H:i') : null,
                        'revokeTime' => $data->revoke_time != null ? Carbon::parse($data->revoke_time)->format('Y/m/d H:i') : null,
                        'createTime' => $data->created_at != null ? Carbon::parse($data->created_at)->format('Y/m/d H:i') : null,
                        'create_by' => $data->create_by,
                        'updateTime' => $data->updated_at != null ? Carbon::parse($data->updated_at)->format('Y/m/d H:i') : null,
                        'update_by' => $data->update_by,
                        'company_id' => $data->company_id
                    ];
                }),
                'total' => $this->total(),
            ],
        ];
    }
}
