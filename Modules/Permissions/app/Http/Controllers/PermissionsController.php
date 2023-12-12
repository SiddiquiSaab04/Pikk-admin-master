<?php

namespace Modules\Permissions\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Permissions\app\Http\Requests\PermissionsRequest;
use Modules\Permissions\app\Services\PermissionsService;
use Modules\Role\app\Services\RoleService;
use Modules\User\app\Services\UserService;

class PermissionsController extends Controller
{
    private $permissionsService;

    public function __construct(PermissionsService $permissionsService)
    {
        $this->permissionsService = $permissionsService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = $this->permissionsService->getAll();

        if (request()->wantsjson()) {
            return sendResponse('permissions::index', [
                "permissions" => $permissions,
                "title" => "Permissions List",
                "description" => "show all system permissions list"
            ]);
        } else {
            return sendResponse(false, 'permissions::index', [
                "permissions" => $permissions,
                "title" => "Permissions List",
                "description" => "show all system permissions list"
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = $this->permissionsService->getAllRoles();
        return sendResponse(false, 'permissions::create', [
            "roles" => $roles,
            "title" => "Create Permission",
            "description" => "create a new system permission"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionsRequest $request): RedirectResponse
    {
        $created = $this->permissionsService->create($request->all());
        $this->permissionsService->updateRole($request['role'], $created);

        return redirect()->route('permissions.index')->withToastSuccess("Permission created successfully.");
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $permission = $this->permissionsService->search($id);
        if (request()->wantsjson()) {
            return sendResponse('permissions::index', [
                "permissions" => $permission,
                "title" => "Permissions List",
                "description" => "show all system permissions list"
            ]);
        } else {
            return sendResponse(false, 'permissions::index', [
                "permissions" => $permission,
                "title" => "Permissions List",
                "description" => "show all system permissions list"
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $permission = $this->permissionsService->getById($id);
        $roles = $this->permissionsService->getAllRoles();

        return view('permissions::edit', [
            "permission" => $permission,
            "roles" => $roles,
            "title" => "Edit Permission",
            "description" => "edit a new system permission"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionsRequest $request, $id): RedirectResponse
    {
        $updated = $this->permissionsService->getById($id);
        $this->permissionsService->update($request->all(), $id);
        $this->permissionsService->updateRole($request['role'], $updated);

        return redirect()->route('permissions.index')->withToastSuccess("Permission updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->permissionsService->delete($id);
        return redirect()->route('permissions.index')->withToastSuccess("Permission deleted successfully.");
    }
}
