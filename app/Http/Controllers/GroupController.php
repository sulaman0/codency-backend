<?php

namespace App\Http\Controllers;

use App\AppHelper\AppHelper;
use App\Http\Requests\Group\CreateGroupRequest;
use App\Http\Requests\Staff\CreateStaffRequest;
use App\Models\User;
use App\Models\Users\GroupsModel;
use App\Service\GroupsService;
use App\Service\LocationsService;
use App\Service\UsersService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    private GroupsService $groupsService;
    private User $user;
    private GroupsModel $groupsModel;

    /**
     * @param GroupsService $groupsService
     * @param LocationsService $locationsService
     * @param User $user
     */
    public function __construct(
        GroupsService $groupsService,
        User          $user,
        GroupsModel   $groupsModel,
    )
    {
        $this->groupsService = $groupsService;
        $this->user = $user;
        $this->groupsModel = $groupsModel;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('groups.index', [
            'staffs' => $this->user->getAllUsersForSearch(null, true)
        ]);
    }

    public function tableRecord(Request $request): string
    {
        try {
            return $this->groupsService->getAllGroups($request);
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
    public function store(CreateGroupRequest $request): JsonResponse
    {
        try {
            return $this->groupsService->createGroup($request);
        } catch (\Exception $exception) {
            return AppHelper::logErrorException($exception);
        }
    }

    public function show($id)
    {
        $group = $this->groupsModel->findById($id);
        return AppHelper::sendSuccessResponse(
            true,
            'found',
            [
                'group' => $group,
                'user' => $group->usersArray(true)
            ]
        );
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
