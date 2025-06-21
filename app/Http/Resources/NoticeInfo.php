<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;


class NoticeInfo extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'type' => $this->type,
            'level' => $this->level,
            'targetType' => $this->target_type,
            'target_user_ids' => $this->target_user_ids,
            'targetUserIds' => array_map('intval', array_filter(explode(',', $this->target_user_ids), 'is_numeric')),
            'publisherId' => $this->publisher_id,
            'publisherName' => $this->publisher->username,
            'publishStatus' => $this->publish_status,
            'publishTime' => $this->publish_time != null ? Carbon::parse($this->publish_time)->format('Y/m/d H:i') : null,
            'revokeTime' => $this->revoke_time != null ? Carbon::parse($this->revoke_time)->format('Y/m/d H:i') : null,
            'createdTime' => $this->created_at != null ? Carbon::parse($this->created_at)->format('Y/m/d H:i') : null,
            'create_by' => $this->create_by,
            'updatedTime' => $this->updated_at != null ? Carbon::parse($this->updated_at)->format('Y/m/d H:i') : null,
            'update_by' => $this->update_by,
            'company_id' => $this->company_id
        ];
    }


}
