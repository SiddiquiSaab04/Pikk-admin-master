<?php

namespace Modules\Role\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Modules\Role\app\Http\Requests\RoleRequest;
use Modules\Role\app\Services\RoleService;

class RoleController extends Controller
{
    private $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = $this->roleService->getAll();

        if (request()->wantsjson()) {
            return sendResponse('role::index', [
                "roles" => $roles,
                "title" => "Role List",
                "description" => "show all system role list"
            ]);
        } else {
            return sendResponse(false, 'role::index', [
                "roles" => $roles,
                "title" => "Role List",
                "description" => "show all system role list"
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return sendResponse(false, 'role::create', [
            "title" => "Create Role",
            "description" => "create a new system role"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request): RedirectResponse
    {
        try {
            $this->roleService->create($request->all());
            return redirect()->route('role.index')->withToastSuccess("Role created successfully.");
        } catch (Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $role = $this->roleService->search($id);
        if (request()->wantsjson()) {
            return sendResponse('role::index', [
                "roles" => $role,
                "title" => "Role List",
                "description" => "show all system roles list"
            ]);
        } else {
            return sendResponse(false, 'role::index', [
                "roles" => $role,
                "title" => "Role List",
                "description" => "show all system roles list"
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $role = $this->roleService->getById($id);
        return view('role::edit', [
            "role" => $role,
            "title" => "Edit Role",
            "description" => "edit a new system role"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, $id): RedirectResponse
    {
        try {
            $this->roleService->update($request->all(), $id);
            return redirect()->route('role.index')->withToastSuccess("Role updated successfully.");
        } catch (Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->roleService->delete($id);
            return redirect()->route('role.index')->withToastSuccess("Role deleted successfully.");
        } catch (Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }
}
