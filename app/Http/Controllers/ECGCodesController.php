<?php

namespace App\Http\Controllers;

use App\AppHelper\AppHelper;
use App\Http\Requests\EcgCodes\NewEcgCodeAlertRequest;
use App\Http\Requests\EcgCodes\RespondEcgCodeRequest;
use App\Http\Resources\EcgCodes\EcgCodesCollection;
use App\Service\EcgCodesService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ECGCodesController extends Controller
{
    private EcgCodesService $ecgCodesService;

    /**
     * @param EcgCodesService $ecgCodesService
     */
    public function __construct(EcgCodesService $ecgCodesService)
    {
        $this->ecgCodesService = $ecgCodesService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Factory|Application|View|EcgCodesCollection|JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        if ($request->wantsJson()) {
            return $this->indexJson($request);
        } else {
            return view('ecg_codes.index');
        }
    }

    public function indexJson(Request $request): EcgCodesCollection|JsonResponse
    {
        try {
            return $this->ecgCodesService->getAlLCodes($request);
        } catch (\Exception $exception) {
            return AppHelper::logErrorException($exception);
        }
    }

    public function ecgCodesListForSearch(Request $request)
    {
        try {
            return $this->ecgCodesService->getAlLCodesForSearch($request);
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
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('ecg_codes.details');
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
    public function update(Request $request, string $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
