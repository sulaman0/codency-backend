<?php

namespace App\Http\Controllers;

use App\AppHelper\AppHelper;
use App\Http\Requests\Location\CreateLocationRequest;
use App\Models\Locations\LocationModel;
use App\Service\LocationsService;
use Illuminate\Contracts\View\Factory as FactoryAlias;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class LocationController extends Controller
{

    private LocationsService $locationsService;
    private LocationModel $locationModel;

    public function __construct(LocationsService $locationsService, LocationModel $locationModel)
    {
        $this->locationsService = $locationsService;
        $this->locationModel = $locationModel;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): FactoryAlias|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('location.index');
    }

    public function tableRecord(Request $request)
    {
        try {
            return $this->locationsService->getAllLocationAdmin($request);
        } catch (\Exception $exception) {
            return "Error: " . $exception->getMessage();
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
    public function store(CreateLocationRequest $request): \Illuminate\Http\JsonResponse|bool
    {
        try {
            return $this->locationsService->createLocation($request);
        } catch (\Exception $exception) {
            return AppHelper::logErrorException($exception);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return AppHelper::sendSuccessResponse(true, 'found', $this->locationModel->findById($id));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
