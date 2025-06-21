<?php

namespace App\Services\Aeb\Import;

use App\Lib\Code;
use App\Models\Aeb\Import\ImportItemsDetail;
use App\Services\Admin\BaseService;

class ImportItemsDetailService  extends BaseService
{
    protected $model;

    protected $filterRules = [
    ];

    protected $orderBy = [
        'id' => 'desc',
    ];

    public function __construct(ImportItemsDetail $model)
    {
        $this->request = request();
        $this->formData = $this->request->all();
        $this->model = new ImportItemsDetail();
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
        if (isset($this->formData['declaration_id']) && !empty($this->formData['declaration_id'])) {
            $query->where('declaration_id', $this->formData['declaration_id']);
        }
        if (isset($this->formData['item_id']) && !empty($this->formData['item_id'])) {
            $query->where('item_id', $this->formData['item_id']);
        }
    }

    public function rules()
    {
        return [
            'declaration_id' => 'required|string',
            'item_id' => 'required|string',
            'authorizations' => 'required|string',
            'additional_information' => 'required|string',
            'consignor' => 'required|string',
            'buyer' => 'required|string',
            'seller' => 'required|string',
        ];
    }

}
