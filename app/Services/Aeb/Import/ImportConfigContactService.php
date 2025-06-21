<?php

namespace App\Services\Aeb\Import;

use App\Lib\Code;
use App\Models\Aeb\Import\ImportConfigContact;
use App\Services\Admin\BaseService;

class ImportConfigContactService extends BaseService
{

    protected $model;

    protected $filterRules = [
    ];

    protected $orderBy = [
        'id' => 'desc',
    ];

    public function __construct(ImportConfigContact $model)
    {
        $this->request = request();
        $this->formData = $this->request->all();
        $this->model = new ImportConfigContact();
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
        if (isset($this->formData['first_name']) && !empty($this->formData['first_name'])) {
            $query->where('first_name', $this->formData['first_name']);
        }
        if (isset($this->formData['name']) && !empty($this->formData['name'])) {
            $query->where('name', $this->formData['name']);
        }
        if (isset($this->formData['phone']) && !empty($this->formData['phone'])) {
            $query->where('phone', $this->formData['phone']);
        }
        if (isset($this->formData['email']) && !empty($this->formData['email'])) {
            $query->where('email', $this->formData['email']);
        }
        if (isset($this->formData['keywords']) && !empty($this->formData['keywords'])) {
            $query->where(function ($query) {
                $query->where('name', 'like', '%' . $this->formData['keywords'] . '%')
                    ->orWhere('email', 'like', '%' . $this->formData['keywords'] . '%')
                    ->orWhere('phone', 'like', '%' . $this->formData['keywords'] . '%')
                    ->orWhere('initials', 'like', '%' . $this->formData['keywords'] . '%');
            });
        }
    }

    public function getContactAll(){
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
