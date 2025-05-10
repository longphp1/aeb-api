<?php

namespace App\Http\Resources;

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
            'dept_id' => $this->dept_id,
            'avatar' => $this->avatar,
            'mobile' => $this->mobile,
            'status' => $this->status,
            'email' => $this->email,
            'last_login_at' => $this->last_login_at,
            'is_audited' => $this->is_audited,
            'forbid_login' => $this->forbid_login,
            'uuid' => $this->uuid,
            'created_at' => $this->created_at,
            'create_by' => $this->create_by,
            'updated_at' => $this->updated_at,
            'update_by' => $this->update_by,
            'openid' => $this->openid,
            'company_id' => $this->company_id,
            'roles' => $this->roles??[],
            'perms' => $this->perms??[],
            'roles_ids' => $this->roles_ids??[],
        ];
    }
}
