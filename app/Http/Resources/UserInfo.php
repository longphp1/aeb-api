<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserInfo  extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'username' => $this->username,
            'nickname' => $this->nickname,
            'gender' => $this->gender,
            'password' => $this->password,
            'deptId' => $this->dept_id,
            'deptName' => $this->dept->name??'',
            'avatar' => $this->avatar,
            'mobile' => $this->mobile,
            'status' => $this->status,
            'email' => $this->email,
            'last_login_at' => $this->last_login_at,
            'is_audited' => $this->is_audited,
            'forbid_login' => $this->forbid_login,
            'uuid' => $this->uuid,
            'createTime' => $this->created_at!=null?Carbon::parse($this->created_at)->format('Y/m/d H:i'):null,
            'create_by' => $this->create_by,
            'updateTime' => $this->updated_at!=null?Carbon::parse($this->updated_at)->format('Y/m/d H:i'):null,
            'update_by' => $this->update_by,
            'openid' => $this->openid,
            'company_id' => $this->company_id,
            'roles' => $this->roles??[],
            'perms' => $this->perms??[],
            'roleIds' => $this->roles_ids??[],
        ];
    }
}
