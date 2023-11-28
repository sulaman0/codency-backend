<?php

namespace App\Http\Controllers;

use App\AppHelper\AppHelper;
use App\Http\Requests\EcgCodes\NewEcgCodeAlertRequest;
use App\Http\Requests\EcgCodes\RespondEcgCodeRequest;
use App\Service\EcgAlertsService;
use App\Service\EcgCodesService;
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
    public function index()
    {
        //
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
            $this->ecgAlertsService->respondToCde($request);
            return AppHelper::sendSuccessResponse(true, 'Alert Created');
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
