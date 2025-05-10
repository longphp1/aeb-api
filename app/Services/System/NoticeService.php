<?php

namespace App\Services\System;

use App\Models\System\Notice;
use App\Services\Admin\BaseService;

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

    public function getFilter(&$query){
        if(isset($this->formData['target_type'])){
            $query->where('target_type', $this->formData['target_type']);
        }
        if(isset($this->formData['publish_status'])){
            $query->where('publish_status', $this->formData['publish_status']);
        }
    }
    public function getList(){
        $this->getFilter($this->query);
        $this->setOrderBy();
        return parent::index();
    }

    public function getUnReadNotice(){
        return $this->query->where('publish_status', Notice::PUBLISHED)->where('read_status', Notice::UNREAD)->get();
    }

}
