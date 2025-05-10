<?php

namespace App\Services\System;

use App\Models\System\UserNotice;
use App\Services\Admin\BaseService;

class UserNoticeService extends BaseService
{

    protected $model;

    protected $filterRules = [
    ];

    protected $orderBy = [
        'id' => 'desc',
    ];

    public function __construct()
    {
        $this->request = request();
        $this->formData = $this->request->all();
        $this->model = new UserNotice();
        $this->query = $this->model->newQuery();
        $this->setFilterRules();
    }

    public function getUnReadNotice()
    {
        $this->query->where(['user_id' => auth()->user()->id, 'is_read' => UserNotice::UNREAD]);
        $data= parent::all();
        return ['list' => $data,'total'=>count($data)];
    }
}
