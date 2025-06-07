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
                    // 使用空对象模式避免重复的空值检查
                    $notice = $data->notice ?? (object)[
                        'level' => '',
                        'publish_time' => null,
                        'publisher' => (object)['username' => ''],
                        'title' => '',
                        'type' => ''
                    ];

                    // 统一处理时间格式化
                    $formatTime = function ($timestamp) {
                        return $timestamp ? Carbon::parse($timestamp)->format('Y/m/d H:i') : null;
                    };

                    return [
                        'id' => $data->id,
                        'isRead' => $data->is_read,
                        'level' => $notice->level,
                        'publishTime' => $formatTime($notice->publish_time),
                        'publisherName' => $notice->publisher->username,
                        'title' => $notice->title,
                        'type' => $notice->type,
                        'createTime' => $formatTime($data->created_at),
                        'updateTime' => $formatTime($data->updated_at),
                        'company_id' => $data->company_id
                    ];
                }),
                'total' => $this->total(),
            ],
        ];
    }
}
