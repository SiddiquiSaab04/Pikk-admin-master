<?php

namespace Modules\User\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Modules\User\app\Services\UserService;
use Modules\User\app\Http\Requests\UserRequest;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->userService->getUsers();
        $users->load('branch');

        if (request()->wantsjson()) {
            return sendResponse('user::index', [
                "users" => $users,
                "title" => "User List",
                "description" => "show all system users list"
            ]);
        } else {
            return sendResponse(false, 'user::index', [
                "users" => $users,
                "title" => "User List",
                "description" => "show all system users list"
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = $this->userService->getAllRoles();
        $branches = $this->userService->getAllBranches();

        return sendResponse(false, 'user::create', [
            "roles" => $roles,
            "branches" => $branches,
            "title" => "Create User",
            "description" => "create a new system user"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request): RedirectResponse
    {
        try {
            $created = $this->userService->create($request->all());
            $this->userService->updateRole($request['role'], $created);

            return redirect()->route('user.index')->withToastSuccess("User created successfully.");
        } catch (Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }
    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $users = $this->userService->search($id);
        if (request()->wantsjson()) {
            return sendResponse('user::index', [
                "users" => $users,
                "title" => "User List",
                "description" => "show all system users list"
            ]);
        } else {
            return sendResponse(false, 'user::index', [
                "users" => $users,
                "title" => "User List",
                "description" => "show all system users list"
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = $this->userService->getById($id);
        $roles = $this->userService->getAllRoles();
        $branches = $this->userService->getAllBranches();
        return view('user::edit', [
            "user" => $user,
            "roles" => $roles,
            "branches" => $branches,
            "title" => "Edit User",
            "description" => "edit a new system user"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, $id): RedirectResponse
    {
        try {
            $updated = $this->userService->getById($id);
            $this->userService->update($request->all(), $id);
            $this->userService->updateRole($request['role'], $updated);

            return redirect()->route('user.index')->withToastSuccess("User updated successfully.");
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
            $this->userService->delete($id);
            return redirect()->route('user.index')->withToastSuccess("User deleted successfully.");
        } catch (Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    public function getUserById($id)
    {
        $user = $this->userService->getById($id);
        $user->getRoleNames()->first();
        return sendResponse(true, null, $user, null, 200);
    }
}
