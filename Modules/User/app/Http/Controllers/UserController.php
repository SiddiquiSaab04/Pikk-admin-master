<?php

namespace Modules\User\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
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
        $users = $this->userService->getAll();

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
        $roles = $this->userService->getAllRole();
        return sendResponse(false, 'user::create', [
            "roles" => $roles,
            "title" => "Create User",
            "description" => "create a new system user"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request): RedirectResponse
    {
        $created = $this->userService->create($request->all());
        $this->userService->getRole($created, $request['role']);

        return redirect()->route('user.index')->withToastSuccess("User created successfully.");
    }
    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $user = $this->userService->search($id);
        if (request()->wantsjson()) {
            return sendResponse('user::index', [
                "users" => $user,
                "title" => "User List",
                "description" => "show all system users list"
            ]);
        } else {
            return sendResponse(false, 'user::index', [
                "users" => $user,
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
        $roles = $this->userService->getAllRole();
        return view('user::edit', [
            "user" => $user,
            "roles" => $roles,
            "title" => "Edit User",
            "description" => "edit a new system user"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, $id): RedirectResponse
    {
        $updated = $this->userService->getById($id);
        $this->userService->update($request->all(), $id);
        $this->userService->getRole($updated, $request['role']);

        return redirect()->route('user.index')->withToastSuccess("User updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->userService->delete($id);
        return redirect()->route('user.index')->withToastSuccess("User deleted successfully.");
    }
}
