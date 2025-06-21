<?php

namespace App\Http\Resources\Aeb;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ImportCustomsOfficeInfo extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'domestic_code' => $this->domestic_code,
            'country' => $this->country,
            'to_country' => $this->to_country,
            'geo_info_code' => $this->geo_info_code,
            'data_source' => $this->data_source,
            'form_data_service' => $this->form_data_service,
            'start_on' => $this->start_on != null ? Carbon::parse($this->start_on)->format('Y/m/d H:i') : null,
            'end_on' => $this->end_on != null ? Carbon::parse($this->end_on)->format('Y/m/d H:i') : null,
            'export_customs_office' => $this->export_customs_office,
            'office_of_exit' => $this->office_of_exit,
            'air_exit_office' => $this->air_exit_office,
            'customs_office_of_entry' => $this->customs_office_of_entry,
            'border_customs_office' => $this->border_customs_office,
            'supervising_customs_office' => $this->supervising_customs_office,
            'transit_customs_office' => $this->transit_customs_office,
            'office_of_departure' => $this->office_of_departure,
            'office_of_destination' => $this->office_of_destination,
            'exit_office_inland' => $this->exit_office_inland,
            'office_address_id' => $this->office_address_id,
            'created_at' => $this->created_at != null ? Carbon::parse($this->created_at)->format('Y/m/d H:i') : null,
            'create_by' => $this->create_by,
            'updated_at' => $this->updated_at != null ? Carbon::parse($this->updated_at)->format('Y/m/d H:i') : null,
            'company_id' => $this->company_id
        ];
    }

}
