<?php

namespace App\Services\System;

use App\Models\System\SysLog;
use App\Services\Admin\BaseService;
use Illuminate\Support\Carbon;

class SysLogService extends BaseService
{
    protected $model;

    protected $filterRules = [
    ];

    protected $orderBy = [
    ];

    public function __construct()
    {
        $this->request = request();
        $this->formData = $this->request->all();
        $this->model = new SysLog();
        $this->query = $this->model->newQuery();
        $this->setFilterRules();
    }

    public function index($params = [])
    {
        $this->getFilter($this->query);
        return parent::index();
    }

    public function getFilter($query)
    {
        if (isset($this->formData['keywords'])) {
            $query->where(function ($query) {
                $query->where('content', 'like', '%' . $this->formData['keywords'] . '%')
                    ->orWhere('request_uri', 'like', '%' . $this->formData['keywords'] . '%');
            });
        }
        if (isset($this->formData['createTime']) && is_array($this->formData['createTime'])) {
            $query->whereBetween('created_at', [
                Carbon::parse($this->formData['createTime'][0])->startOfDay(),
                Carbon::parse($this->formData['createTime'][1])->endOfDay()
            ]);
        }
    }
}
