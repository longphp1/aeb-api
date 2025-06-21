<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MyNoticeInfo extends JsonResource
{

    public function toArray($request)
    {
        $notice = $this->notice ?? (object)[
            'level' => '',
            'publish_time' => null,
            'publisher' => (object)['username' => ''],
            'title' => '',
            'type' => '',
            'id' => ''
        ];

        // 统一处理时间格式化
        $formatTime = function ($timestamp) {
            return $timestamp ? Carbon::parse($timestamp)->format('Y/m/d H:i') : null;
        };
        return [
            'id' => $this->id,
            'isRead' => $this->is_read,
            'level' => $notice->level,
            'publishTime' => $formatTime($notice->publish_time),
            'publisherName' => $notice->publisher->username,
            'title' => $notice->title,
            'type' => $notice->type,
            'notice_id' => $notice->id,
            'createTime' => $formatTime($this->created_at),
            'updateTime' => $formatTime($this->updated_at),
            'company_id' => $this->company_id
        ];
    }
}
