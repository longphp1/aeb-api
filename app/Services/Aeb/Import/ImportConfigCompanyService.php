<?php

namespace App\Services\Aeb\Import;

use App\Lib\Code;
use App\Lib\ImportDeclarationEnum;
use App\Models\Aeb\Import\ImportConfigCompany;
use App\Services\Admin\BaseService;

class ImportConfigCompanyService extends BaseService
{

    protected $model;

    protected $filterRules = [
    ];

    protected $orderBy = [
        'id' => 'desc',
    ];

    public function __construct(ImportConfigCompany $model)
    {
        $this->request = request();
        $this->formData = $this->request->all();
        $this->model = new ImportConfigCompany();
        $this->query = $this->model->newQuery();
    }

    public function index()
    {
        $this->getFilter($this->query);
        return parent::index();
    }

    public function show($id)
    {
        return $this->model::findOrFail($id);
    }

    public function store($params)
    {

        validator($params, $this->rules());
        $data = $this->model::init($params);
        return $this->query->create($data);
    }

    public function update($id, $params)
    {
        validator($params, $this->rules());
        $data = $this->model::init($params);
        $this->model::findOrFail($id)->update($data);
        return Code::SUCCESS;
    }

    public function destroy($id)
    {
        $ids = _id($id);
        $this->query->whereIn('id', $ids)->delete();
    }

    public function getFilter(&$query)
    {
        if (isset($this->formData['company_name']) && !empty($this->formData['company_name'])) {
            $query->where('company_name', $this->formData['company_name']);
        }
        if (isset($this->formData['company_code']) && !empty($this->formData['company_code'])) {
            $query->where('company_code', $this->formData['company_code']);
        }
        if (isset($this->formData['user_name']) && !empty($this->formData['user_name'])) {
            $query->where('user_name', $this->formData['user_name']);
        }
        if (isset($this->formData['postal_code']) && !empty($this->formData['postal_code'])) {
            $query->where('postal_code', $this->formData['postal_code']);
        }
        if (isset($this->formData['keywords']) && !empty($this->formData['keywords'])) {
            $query->where(function ($query) {
                $query->where('company_name', 'like', '%' . $this->formData['keywords'] . '%')
                    ->orWhere('company_code', 'like', '%' . $this->formData['keywords'] . '%')
                    ->orWhere('user_name', 'like', '%' . $this->formData['keywords'] . '%')
                    ->orWhere('postal_code', 'like', '%' . $this->formData['keywords'] . '%');
            });
        }
    }

    public function getCompanyAll(){
        $this->getFilter($this->query);
        return parent::all();
    }

    public function rules()
    {
        return [
            'company_name' => 'required|string',
            'company_code' => 'required|string',
            'role_type' => 'required|string',
            'trader_id' => 'required|string',
            'vat_id' => 'required|string',
            'ioss_vat' => 'required|string',
            'user_name' => 'required|string',
            'street' => 'required|string',
            'postal_code' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
        ];
    }

}
