<?php

namespace Modules\User\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\User\app\Services\UserService;
use Exception;

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

        if (request()->wantsjson()) {
            return sendResponse('user::index', [
                "users" => $users,
                "title" => "User List",
                "description" => "System users list"
            ]);
        } else {
            return sendResponse(false, 'user::index', [
                "users" => $users,
                "title" => "User List",
                "description" => "System users list"
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return sendResponse(false, 'user::create', [
            "title" => "Create User",
            "description" => "Create system user"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required",
                "email"  => "required|email",
                "password" => "required",
                "role" => "required",
                "status" => "required"
            ]);

            if ($validator->fails()) {
                return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
            }

            $user = $this->userService->createUser($request->all());
            if ($user["status"] == 1) {
                return redirect('user')->withToastSuccess($user["success_message"]);
            } else {
                throw new Exception($user["error_message"]);
            }

            return redirect('user');
        } catch (Exception $e) {
            session()->flash("alert-error", $e->getMessage());
            return redirect()->back();
        }
    }
    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::find($id);
        $user['role'] = $user->getRoleNames();

        return sendResponse(false, 'user::edit', [
            "user" => $user,
            "title" => "Edit user",
            "description" => "Edit system user"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required",
                "email"  => "required|email",
                "role" => "required",
                "status" => "required"
            ]);

            if ($validator->fails()) {
                return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
            }

            $user = $this->userService->updateUser($request->all(), $id);
            if ($user["status"] == 1) {
                return redirect('user')->withToastSuccess($user["success_message"]);
            } else {
                throw new Exception($user["error_message"]);
            }

            return redirect('user');
        } catch (Exception $e) {
            session()->flash("alert-error", $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
