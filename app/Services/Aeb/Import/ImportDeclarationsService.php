<?php

namespace App\Services\Aeb\Import;

use App\Lib\Code;
use App\Lib\ImportDeclarationEnum;
use App\Models\Aeb\Import\ImportDeclarations;
use App\Services\Admin\BaseService;

class ImportDeclarationsService extends BaseService
{

    protected $model;

    protected $filterRules = [
    ];

    protected $orderBy = [
        'id' => 'desc',
    ];

    public function __construct(ImportDeclarations $model)
    {
        $this->request = request();
        $this->formData = $this->request->all();
        $this->model = new ImportDeclarations();
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
        if (isset($this->formData['decl_type']) && !empty($this->formData['decl_type'])) {
            $query->where('decl_type', $this->formData['decl_type']);
        }
        if (isset($this->formData['declaration']) && !empty($this->formData['declaration'])) {
            $query->where('declaration', $this->formData['declaration']);
        }
        if (isset($this->formData['declaration_type']) && !empty($this->formData['declaration_type'])) {
            $query->where('declaration_type', $this->formData['declaration_type']);
        }
        if (isset($this->formData['status']) && !empty($this->formData['status'])) {
            $query->where('status', $this->formData['status']);
        }
    }

    public function rules()
    {
        return [
            'decl_type' => 'required|string',
            'declaration_type' => 'required|string',
            'declaration_date' => 'required|string',
            'procedure_type' => 'required|string',
            'manual_acc_date' => 'required|string',
            'commercial_reference' => 'required|string',
            'consignment_no' => 'required|string',
            'container_no' => 'required|string',
            'internal_reference' => 'required|string',
            'lrn' => 'required|string',
            'mrn' => 'required|string',
            'deco' => 'required|string',
            'delivery_no' => 'required|string',
            'invoice_no' => 'required|string',
            'mode_border' => 'required|string',
            'number_of_items' => 'required|string',
            'object_id' => 'required|string',
            'release' => 'required|string',
            'transition_id' => 'required|string',
            'version' => 'required|string',
            'office_of_import' => 'required|string',
        ];
    }

    public function getImportDeclarationsEnum()
    {
        return [
            'decl_type' => ImportDeclarationEnum::$declType,
            'declaration_type' => ImportDeclarationEnum::$declarationType,
            'procedure_type' => ImportDeclarationEnum::$procedureType,
            'mode_border' => ImportDeclarationEnum::$transportModeBorder,
            'representation' => ImportDeclarationEnum::$representation,
            'goods_location_type' => ImportDeclarationEnum::$goodsLocationType,
            'goods_location_qualifier' => ImportDeclarationEnum::$goodsLocationQualifier,
            'transport_means_type_arrival' => ImportDeclarationEnum::$transportMeansTypeArrival
        ];
    }

}
