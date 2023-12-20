<?php

namespace App\Service\Misc;

use App\AppHelper\AppHelper;
use App\Models\EcgAlert\EcgAlertsModel;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;

class DashboardService
{

    private EcgAlertsModel $ecgAlertsModel;

    public function __construct(EcgAlertsModel $ecgAlertsModel)
    {
        $this->ecgAlertsModel = $ecgAlertsModel;
    }

    function dashboardRecord(Request $request)
    {
        return AppHelper::sendSuccessResponse(true, 'dashboard', [
            'em_codes' => [
                'receive' => $this->ecgAlertsModel->totalAlertReceives(),
                'accept' => $this->ecgAlertsModel->totalAccept(),
                'decline' => $this->ecgAlertsModel->totalDecline(),
                'announcement' => $this->ecgAlertsModel->totalPlayedToAmplifier(),
            ],
            'dail_codes' => $this->ecgAlertsModel->getAllAlertAdmin($request, 5),
            'emergency_calls_graph' => $this->emergencyCallsDashboardDataParser($this->ecgAlertsModel->emergencyCallsDashboardData()),
            'amplifier_calls_graph' => $this->emergencyCallsDashboardDataParser($this->ecgAlertsModel->amplifierCallsDashboardData()),
        ]);
    }

    #[ArrayShape(['xAxios' => "array", 'yAxios' => "array"])] function emergencyCallsDashboardDataParser($calls)
    {
        $xAxios = [];
        $yAxios = [];
        foreach ($calls as $call) {
            $xAxios[] = $call->date;
            $yAxios[] = $call->total_count;
        }

        return [
            'xAxios' => $xAxios,
            'yAxios' => $yAxios,
        ];
    }


}
