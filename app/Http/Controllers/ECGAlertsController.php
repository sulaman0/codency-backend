<?php

namespace App\Http\Controllers;

use App\AppHelper\AppHelper;
use App\Http\Requests\EcgCodes\NewEcgCodeAlertRequest;
use App\Http\Requests\EcgCodes\RespondEcgCodeRequest;
use App\Http\Resources\EcgCodes\EcgCodesCollection;
use App\Service\EcgAlertsService;
use App\Service\EcgCodesService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ECGAlertsController extends Controller
{
    protected EcgAlertsService $ecgAlertsService;

    /**
     * @param EcgAlertsService $ecgAlertsService
     */
    public function __construct(EcgAlertsService $ecgAlertsService)
    {
        $this->ecgAlertsService = $ecgAlertsService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Factory|Application|View|EcgCodesCollection|JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        if ($request->wantsJson()) {
            return $this->indexJson($request);
        } else {
            return view('reports.code_pressed');
        }
    }

    public function indexJson(Request $request): EcgCodesCollection|JsonResponse
    {
        try {
            return $this->ecgAlertsService->getAlerts($request);
        } catch (\Exception $exception) {
            return AppHelper::logErrorException($exception);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewEcgCodeAlertRequest $request): JsonResponse|bool
    {
        try {
            $this->ecgAlertsService->pressCode($request);
            return AppHelper::sendSuccessResponse(true, 'Alert Created');
        } catch (\Exception $exception) {
            return AppHelper::logErrorException($exception);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RespondEcgCodeRequest $request, string $id): JsonResponse
    {
        try {
            $this->ecgAlertsService->respondToCde($request, $id);
            return AppHelper::sendSuccessResponse(true, '');
        } catch (\Exception $exception) {
            return AppHelper::logErrorException($exception);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
