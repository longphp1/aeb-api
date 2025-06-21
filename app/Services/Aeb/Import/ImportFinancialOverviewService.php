<?php

namespace App\Services\Aeb\Import;

use App\Lib\Code;
use App\Models\Aeb\Import\ImportDeclarations;
use App\Models\Aeb\Import\ImportFinancialOverview;
use App\Services\Admin\BaseService;

class ImportFinancialOverviewService extends BaseService
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
        $this->model = new ImportFinancialOverview();
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
            'declaration_id' => 'required|integer',
            'total_invoice' => 'required|string',
            'total_invoice_currency' => 'required|string',
            'nature_of_transact' => 'required|string',
            'incoterm' => 'required|string',
            'place' => 'required|string',
            'place_code' => 'required|string',
            'incoterm_info' => 'required|string',
            'country' => 'required|string',
            'calculate_values' => 'required|string',
            'inclusion_mode' => 'required|string',
            'transport' => 'required|string',
            'transport_abs_value' => 'required|string',
            'transport_costs' => 'required|string',
            'outside_eu' => 'required|string',
            'eu_to_nl' => 'required|string',
            'inside_nl' => 'required|string',
            'insurance' => 'required|string',
            'insurance_abs_value' => 'required|string',
            'insurance_costs' => 'required|string',
            'gross_weight' => 'required|string',
            'net_weight' => 'required|string',
            'no_of_packages' => 'required|string',
            'company_id' => 'required|string',
        ];
    }
}
