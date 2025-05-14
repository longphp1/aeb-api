<?php

namespace App\Services\System;

use App\Models\System\Notice;
use App\Models\System\UserNotice;
use App\Models\SysUser;
use App\Services\Admin\BaseService;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class NoticeService extends BaseService
{
    protected $model;

    protected $filterRules = [
        'title' => ['like', 'keyword'],
    ];

    protected $orderBy = [
        'updated_at' => 'asc',
    ];

    public function __construct()
    {
        $this->request = request();
        $this->formData = $this->request->all();
        $this->model = new Notice();
        $this->query = $this->model->newQuery();
        $this->setFilterRules();
    }

    public function getFilter(&$query)
    {
        if (isset($this->formData['target_type'])) {
            $query->where('target_type', $this->formData['target_type']);
        }
        if (isset($this->formData['publish_status'])) {
            $query->where('publish_status', $this->formData['publish_status']);
        }
        if (isset($this->formData['title'])) {
            $query->where('title', 'like', '%' . $this->formData['title'] . '%');
        }
        if (isset($this->formData['keywords'])) {
            $query->where(function ($query) {
                $query->where('title', 'like', '%' . $this->formData['keywords'] . '%')
                    ->orWhere('content', 'like', '%' . $this->formData['keywords'] . '%');
            });
        }
    }

    public function index()
    {
        $this->getFilter($this->query);
        $this->setOrderBy();
        return parent::index();
    }

    public function store($params)
    {
        validator($params, [
            'title' => 'required|string',
            'content' => 'required|string',
            'type' => 'required|integer',
            'level' => 'sometimes|nullable|string',
            'targetType' => 'sometimes|nullable|integer',
        ])->validate();
        $data = $this->model->init($params);
        $notice = $this->query->where('title', $data['title'])->first();
        if ($notice) {
            return $notice;
        }
        $notice = $this->query->create($data);
        $this->updateUserNotice($notice->id, $params);
        return $notice;
    }

    public function update($id, $params)
    {
        validator($params, [
            'title' => 'required|string',
            'content' => 'required|string',
            'type' => 'required|integer',
            'level' => 'sometimes|nullable|string',
            'targetType' => 'sometimes|nullable|integer',
        ])->validate();
        $data = $this->model->init($params, 'update');
        $notice = $this->query->findOrFail($id);
        if ($notice) {
            $this->updateUserNotice($id, $params);
            return $notice->update($data);
        }
        return false;
    }

    public function updateUserNotice($id, $params)
    {
        UserNotice::where('notice_id', $id)->delete();
        if ($params['targetType'] == Notice::TARGET_TYPE_ALL) {
            $userIdArr = SysUser::where('company_id', auth()->user()->company_id)->pluck('id')->toArray();
        } else {
            $userIdArr = $params['targetUserIds'];
        }
        foreach ($userIdArr as $userId) {
            $userNoticeList[] = [
                'notice_id' => $id,
                'user_id' => $userId,
                'created_at' => Carbon::now()->toDateTimeString(),
                'company_id' => auth()->user()->company_id,
            ];
        }
        UserNotice::insert($userNoticeList);
    }

    public function destroy($id)
    {
        $ids = _id($id);
        return $this->query->whereIn('id', $ids)->delete();
    }

    public function show($id)
    {
        return $this->query->find($id);
    }


    public function publish($id)
    {
        return $this->query->where('id', $id)->update(['publish_status' => Notice::PUBLISHED, 'publish_time' => Carbon::now()->toDateTimeString()]);
    }

    public function revoke($id)
    {
        return $this->query->where('id', $id)->update(['publish_status' => Notice::REVOKED, 'revoke_time' => Carbon::now()->toDateTimeString(), 'publish_time' => null]);
    }

}
