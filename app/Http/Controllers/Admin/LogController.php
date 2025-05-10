<?php

namespace App\Http\Controllers\Admin;

use App\Services\ApiResponseService;

class LogController
{

    public function getVisitStats()
    {
        return ApiResponseService::success([
            "pvGrowthRate" => 18,
            "todayPvCount" => 2052,
            "todayUvCount" => 214,
            "totalPvCount" => 130768,
            "totalUvCount" => 8535,
            "uvGrowthRate" => 16.83,
        ]);
    }

    public function getVisitTrend()
    {
        return ApiResponseService::success([
            "dates" => [
                "2024-08-01",
                "2024-08-02",
                "2024-08-03",
                "2024-08-04",
                "2024-08-05",
                "2024-08-06"
            ],
            "pvList" => [
                120,
                132,
                101,
                134,
                90,
                230
            ],
            "ipList" => [
                120,
                132,
                101,
                134,
                90,
                230
            ]
        ]);
    }
}
