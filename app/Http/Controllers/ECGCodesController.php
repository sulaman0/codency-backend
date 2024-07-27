<?php

namespace App\Http\Controllers;

use App\AppHelper\AppHelper;
use App\Http\Requests\EcgCodes\CreateNewEcgCodeRequest;
use App\Http\Requests\EcgCodes\EditEcgCodeRequest;
use App\Http\Resources\EcgCodes\EcgCodesCollection;
use App\Models\EcgCodes\EcgCodesModel;
use App\Models\User;
use App\Models\Users\GroupsModel;
use App\Service\EcgCodesService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\NoReturn;

class ECGCodesController extends Controller
{
    private EcgCodesService $ecgCodesService;
    private User $user;
    private EcgCodesModel $ecgCodesModel;
    private GroupsModel $groupsModel;

    /**
     * @param EcgCodesService $ecgCodesService
     */
    public function __construct(EcgCodesService $ecgCodesService,
                                User            $user, EcgCodesModel $ecgCodesModel, GroupsModel $groupsModel)
    {
        $this->ecgCodesService = $ecgCodesService;
        $this->user = $user;
        $this->ecgCodesModel = $ecgCodesModel;
        $this->groupsModel = $groupsModel;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request):
    Factory|Application|View|EcgCodesCollection|JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        if ($request->wantsJson()) {
            return $this->indexJson($request);
        } else {
            return view('ecg_codes.index', []);
        }
    }

    public function tableRecord(Request $request)
    {
        try {
            return $this->ecgCodesService->getAlLCodes($request, false);
        } catch (\Exception $exception) {
            return "Error: " . $exception->getMessage();
        }
    }

    public function receiverTableList(Request $request, $id): string
    {
        try {
            return $this->ecgCodesService->receiverTable($id);
        } catch (\Exception $exception) {
            return "Error: " . $exception->getMessage();
        }
    }

    public function senderTableList(Request $request, $id): string
    {
        try {
            return $this->ecgCodesService->senderTable($id);
        } catch (\Exception $exception) {
            return "Error: " . $exception->getMessage();
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
    public function create(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return \view('ecg_codes.create', [
            'groups' => $this->groupsModel->getAllGroupsSearch()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateNewEcgCodeRequest $request): JsonResponse|bool
    {
        try {
            return $this->ecgCodesService->createEcgCode($request);
        } catch (\Exception $exception) {
            return AppHelper::logErrorException($exception);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        /** @var $ecgCode EcgCodesModel */
        $ecgCode = $this->ecgCodesModel->findById($id);
        return view('ecg_codes.details', [
            'codesToUsers' => $ecgCode->assignedToUsers(),
            'alertsToUsers' => $ecgCode->alertAssignedToUsers(),
            'ecgCode' => $ecgCode,
            'lastCall' => $ecgCode->lastCallAt($ecgCode->id),
            'totalCodePressed' => $ecgCode->totalCodePressed($ecgCode->id),
            'lastAudio' => $ecgCode->lastAudio()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        /** @var $ecgCode EcgCodesModel */
        $ecgCode = $this->ecgCodesModel->findById($id);
        return \view('ecg_codes.edit', [
                'groups' => $this->groupsModel->getAllGroupsSearch(),
                'codesToUsers' => $ecgCode->assignedToUsersIds(),
                'alertsToUsers' => $ecgCode->alertAssignedToUsersIds(),
                'ecgCode' => $ecgCode,
            ]
        );
    }


    /**
     * Update the specified resource in storage.
     */
    #[NoReturn] public function updateEcgCode(EditEcgCodeRequest $request, string $id)
    {
        try {
            return $this->ecgCodesService->updateEcgCode($request, $id);
        } catch (\Exception $exception) {
            return AppHelper::logErrorException($exception);
        }
    }
}
