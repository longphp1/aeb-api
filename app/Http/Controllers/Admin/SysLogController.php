<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\SysLogInfo;
use App\Lib\Code;
use App\Services\System\SysLogService;
use Illuminate\Http\Request;

class SysLogController extends Controller
{
    public $service;

    public function __construct(SysLogService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return SysLogInfo::collection($this->service->index($request->all()))->additional(Code::SUCCESS);
    }
}
