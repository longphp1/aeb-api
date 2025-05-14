<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;


class MenuInfo extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'parentId' => $this->parent_id,
            'name' => $this->name,
            'type' => $this->type,
            'routeName' => $this->route_name,
            'routePath' => $this->route_path,
            'component' => $this->component,
            'perm' => $this->perm,
            'alwaysShow' => $this->always_show,
            'keepAlive' => $this->keep_alive,
            'visible' => $this->visible,
            'sort' => $this->sort,
            'icon' => $this->icon,
            'redirect' => $this->redirect,
            'params' => $this->params,
            'created_at' => $this->created_at?->format('Y/m/d H:i'),
            'updated_at' => $this->updated_at?->format('Y/m/d H:i'),
            'company_id' => $this->company_id,
        ];
    }


}
