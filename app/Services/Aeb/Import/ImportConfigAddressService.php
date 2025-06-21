<?php

namespace App\Services\Aeb\Import;

use App\Lib\Code;
use App\Models\Aeb\Import\ImportConfigAddress;
use App\Services\Admin\BaseService;

class ImportConfigAddressService extends BaseService
{

    protected $model;

    protected $filterRules = [
    ];

    protected $orderBy = [
        'id' => 'desc',
    ];

    public function __construct(ImportConfigAddress $model)
    {
        $this->request = request();
        $this->formData = $this->request->all();
        $this->model = new ImportConfigAddress();
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
        $this->query->create($data);
        return Code::SUCCESS;
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
        if (isset($this->formData['street']) && !empty($this->formData['street'])) {
            $query->where('street', $this->formData['street']);
        }
        if (isset($this->formData['city']) && !empty($this->formData['city'])) {
            $query->where('city', $this->formData['city']);
        }
        if (isset($this->formData['country']) && !empty($this->formData['country'])) {
            $query->where('country', $this->formData['country']);
        }
    }

    public function getAddressAll(){
        $this->getFilter($this->query);
        return parent::all();
    }

    public function rules()
    {
        return [
            'initials' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'name' => 'required|string',
            'phone' => 'required|string',
            'fax' => 'required|string',
            'email' => 'required|string',
            'company_name' => 'required|string',
            'title' => 'required|string',
            'signing_authority' => 'required|string',
            'type' => 'required|string',
        ];
    }

}
