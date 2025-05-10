<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserList extends ResourceCollection
{

    public function toArray($request)
    {
        return [
            'data' => [
                'list' => $this->collection->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'username' => $user->username,
                        'nickname' => $user->nickname,
                        'gender' => $user->gender,
                        'password' => $user->password,
                        'dept_id' => $user->dept_id,
                        'dept_name' => $user->dept->name??'',
                        'avatar' => $user->avatar,
                        'mobile' => $user->mobile,
                        'status' => $user->status,
                        'email' => $user->email,
                        'last_login_at' => $user->last_login_at,
                        'is_audited' => $user->is_audited,
                        'forbid_login' => $user->forbid_login,
                        'uuid' => $user->uuid,
                        'created_at' => $user->created_at!=null?Carbon::parse($user->created_at)->format('Y/m/d H:i'):null,
                        'create_by' => $user->create_by,
                        'create_user' => $user->createdBy->username??null,
                        'updated_at' => $user->updated_at!=null?Carbon::parse($user->updated_at)->format('Y/m/d H:i'):null,
                        'update_by' => $user->update_by,
                        'update_user' => $user->updatedBy->username??null,
                        'openid' => $user->openid,
                        'company_id' => $user->company_id
                    ];
                }),
                'total'=>$this->total(),
            ],
        ];
    }
}
