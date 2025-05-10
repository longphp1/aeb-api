<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UnReadNoticeList extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'isRead' => $this->is_read,
            'level' => $this->notice->level,
            'publishTime' => $this->notice->publish_time,
            'publisherName' => $this->notice->createUser->nickname ?? '',
            'title' => $this->notice->title,
            'type' => $this->notice->type,
            'company_id' => $this->company_id
        ];
    }
}
