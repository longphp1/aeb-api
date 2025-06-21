<?php

namespace App\Services\Aeb\Import;

use App\Lib\Code;
use App\Models\Aeb\Import\ImportCustomsOffice;
use App\Services\Admin\BaseService;

class ImportCustomsOfficeService extends BaseService
{

    protected $model;

    protected $filterRules = [
    ];

    protected $orderBy = [
        'id' => 'desc',
    ];

    public function __construct(ImportCustomsOffice $model)
    {
        $this->request = request();
        $this->formData = $this->request->all();
        $this->model = new ImportCustomsOffice();
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
        if (isset($this->formData['code']) && !empty($this->formData['code'])) {
            $query->where('code', $this->formData['code']);
        }
        if (isset($this->formData['domestic_code']) && !empty($this->formData['domestic_code'])) {
            $query->where('domestic_code', $this->formData['domestic_code']);
        }
        if (isset($this->formData['country']) && !empty($this->formData['country'])) {
            $query->where('country', $this->formData['country']);
        }
        if (isset($this->formData['to_country']) && !empty($this->formData['to_country'])) {
            $query->where('to_country', $this->formData['to_country']);
        }
        if (isset($this->formData['keywords']) && !empty($this->formData['keywords'])) {
            $query->where(function ($query) {
                $query->where('code', 'like', '%' . $this->formData['keywords'] . '%')
                    ->orWhere('domestic_code', 'like', '%' . $this->formData['keywords'] . '%')
                    ->orWhere('country', 'like', '%' . $this->formData['keywords'] . '%')
                    ->orWhere('to_country', 'like', '%' . $this->formData['keywords'] . '%');
            });
        }
    }

    public function getCustomsOfficeAll()
    {
        $this->getFilter($this->query);
        $this->query->select('id', 'code', 'domestic_code', 'country', 'to_country');
        return parent::all();
    }

    public function rules()
    {
        return [
            'code' => 'required|string',
            'domestic_code' => 'required|string',
            'country' => 'required|string',
            'to_country' => 'required|string',
            'geo_info_code' => 'sometimes|null|string',
            'data_source' => 'sometimes|null|string',
            'start_on' => 'sometimes|null|string',
            'end_on' => 'sometimes|null||string',
        ];
    }

}
