<?php

namespace Modules\Branch\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Branch\app\Services\BranchService;

class BranchController extends Controller
{
    private $branchService;

    public function __construct(BranchService $branchService)
    {
        $this->branchService = $branchService;
    }
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $branches = $this->branchService->getWhere(['id' => Auth::user()->branch_id]);
    //     if(request()->wantsjson()) {
    //         return sendResponse(true, null,
    //             $branches,
    //             null,
    //             200
    //         );
    //     } else {
    //         return sendResponse(false, 'branch::index', [
    //             "branches" => $branches,
    //             "title" => "Branches List",
    //             "description" => "show all branches listing"
    //         ]);
    //     }
    // }


    public function index()
{
    $branches = $this->branchService->getAll(); // Assuming getAll() fetches all branches
    if(request()->wantsjson()) {
        return sendResponse(true, null,
            $branches,
            null,
            200
        );
    } else {
        return view('branch::index', [
            "branches" => $branches,
            "title" => "Branches List",
            "description" => "Show all branches listing"
        ]);
    }
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('branch::create', [
            "title" => "Create Branch",
            "description" => "create a new branch"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $data = $request->all();
            $created = $this->branchService->create($data);
            return redirect()->route('branch.index')->withToastSuccess("Branch created successfully.");
        } catch (Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     */
    // public function show($id)
    // {
    //     $branches = $this->branchService->search($id);
    //     if(request()->wantsjson()) {
    //         return sendResponse('branch::index', [
    //             "branches" => $branches,
    //             "title" => "Branches List",
    //             "description" => "show all branches listing"
    //         ]);
    //     } else {
    //         return sendResponse(false, 'branch::index', [
    //             "branches" => $branches,
    //             "title" => "Branches List",
    //             "description" => "show all branches listing"
    //         ]);
    //     }
    // }


    public function show($id)
{
    $branches = $this->branchService->search($id);
    return view('branch::index', [
        "branches" => $branches,
        "title" => "Branches List",
        "description" => "Show all branches listing"
    ]);
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $branch = $this->branchService->getById($id);
        return view('branch::edit', [
            "branch" => $branch,
            "title" => "Edit Branch",
            "description" => "edit a branch"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        try {
            $data = $request->all();
            $updated = $this->branchService->update($data, $id);
            return redirect()->route('branch.index')->withToastSuccess("Branch updated successfully.");
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
            $deleted = $this->branchService->delete($id);
            return redirect()->route('branch.index')->withToastSuccess("Branch deleted successfully.");
        } catch (Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }
}
