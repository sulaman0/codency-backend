<?php

namespace App\Http\Controllers;

use App\AppHelper\AppHelper;
use App\Http\Requests\Staff\CreateStaffRequest;
use App\Models\EcgCodes\EcgCodesModel;
use App\Models\User;
use App\Models\Users\GroupsModel;
use App\Service\LocationsService;
use App\Service\UsersService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    private UsersService $usersService;
    private LocationsService $locationsService;
    private User $user;
    private GroupsModel $groupsModel;
    private EcgCodesModel $ecgCodesModel;

    /**
     * @param UsersService $usersService
     * @param LocationsService $locationsService
     */
    public function __construct(
        UsersService     $usersService,
        LocationsService $locationsService, User $user,
        GroupsModel      $groupsModel,
        EcgCodesModel    $ecgCodesModel,
    )
    {
        $this->usersService = $usersService;
        $this->locationsService = $locationsService;
        $this->user = $user;
        $this->groupsModel = $groupsModel;
        $this->ecgCodesModel = $ecgCodesModel;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('staff.index', [
            'locations' => $this->locationsService->getAllLocations(),
            'groups' => $this->groupsModel->getAllGroupsSearch(),
            'selectedGroup' => $request->get('group', ''),
            'selectedEcgCode' => $request->get('ecg_code', ''),
            'ecgCodes' => $this->ecgCodesModel->getAllCodesForSearchNoPagination()
        ]);
    }

    public function tableRecord(Request $request)
    {
        try {
            return $this->usersService->getAllUsers($request);
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
    public function store(CreateStaffRequest $request)
    {
        try {
            return $this->usersService->createStaff($request);
        } catch (\Exception $exception) {
            return AppHelper::logErrorException($exception);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        try {
            $user = $this->user->findOrFail($id);
            if ($request->json == 1) {
                return AppHelper::sendSuccessResponse(true, 'found', [
                    'group' => $user->groupArray(true),
                    'locations' => $user->locations(),
                    'user' => $user,
                ]);
            } else {
                return view('staff.details', [
                    'user' => $user,
                ]);
            }
        } catch (\Exception $exception) {
            return AppHelper::logErrorException($exception);
        }
    }


    public function codeInteraction(Request $request, $id): string
    {
        try {
            return $this->usersService->codeInteractionTable($id);
        } catch (\Exception $exception) {
            return "Error: " . $exception->getMessage();
        }
    }

    public function locationAssigned(Request $request, $id = null)
    {
        try {
            $loggedInUser = $id ?: AppHelper::getUserFromRequest($request)->id;
            return $this->usersService->locationAssignTable($loggedInUser, $request->wantsJson());
        } catch (\Exception $exception) {
            return "Error: " . $exception->getMessage();
        }
    }

    public function locationAssign($userId, $id): JsonResponse
    {
        try {
            return $this->usersService->assignLocation($userId, $id);
        } catch (\Exception $exception) {
            return AppHelper::logErrorException($exception);
        }
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
