<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MyNoticeList extends ResourceCollection
{

    public function toArray($request)
    {
        return [
            'data' => [
                'list' => $this->collection->map(function ($data) {
                    return [
                        'id' => $data->id,
                        'isRead' => $data->is_read,
                        'level' => $data->notice->level ?? "",
                        'publishTime' => $data->notice->publish_time != null ? Carbon::parse($data->notice->publish_time)->format('Y/m/d H:i') : null,
                        'publisherName' => $data->notice->publisher->username ?? '',
                        'title' => $data->notice->title ?? '',
                        'type' => $data->notice->type ?? '',
                        'createTime' => $data->created_at != null ? Carbon::parse($data->created_at)->format('Y/m/d H:i') : null,
                        'updateTime' => $data->updated_at != null ? Carbon::parse($data->updated_at)->format('Y/m/d H:i') : null,
                        'company_id' => $data->company_id
                    ];
                }),
                'total' => $this->total(),
            ],
        ];
    }
}
