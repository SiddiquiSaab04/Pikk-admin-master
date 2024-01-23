<?php

namespace Modules\Inventory\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Inventory\app\Http\Requests\AddonGroupRequest;
use Modules\Inventory\app\Services\AddonGroupService;

class AddonGroupController extends Controller
{
    private $addonGroupService;

    public function __construct(AddonGroupService $addonGroupService)
    {
        $this->addonGroupService = $addonGroupService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addonGroups = $this->addonGroupService->whereBranch();
        if(request()->wantsjson()) {
            return sendResponse('inventory::addonGroups.index', [
                "addonGroups" => $addonGroups,
                "title" => "Addon Groups List",
                "description" => "show all addon groups listing"
            ]);
        } else {
            return sendResponse(false, 'inventory::addonGroups.index', [
                "addonGroups" => $addonGroups,
                "title" => "Addon Groups List",
                "description" => "show all addon groups listing"
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = $this->addonGroupService->getBranches();
        return view('inventory::addonGroups.create', [
            "title" => "Create addon groups",
            "description" => "create a new addon group",
            'branches' => $branches
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddonGroupRequest $request): RedirectResponse
    {
        try {
            $data = $request->all();
            $created = $this->addonGroupService->createAddonGroup($data);
            return redirect()->route('addonGroup.index')->withToastSuccess("Addon group created successfully.");;
        } catch (Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $addonGroups = $this->addonGroupService->search($id);
        if(request()->wantsjson()) {
            return sendResponse('inventory::addonGroups.index', [
                "addonGroups" => $addonGroups,
                "title" => "Addon Groups List",
                "description" => "show all addon groups listing"
            ]);
        } else {
            return sendResponse(false, 'inventory::addonGroups.index', [
                "addonGroups" => $addonGroups,
                "title" => "Addon Groups List",
                "description" => "show all addon groups listing"
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $addonGroup = $this->addonGroupService->getById($id);
        $branches = $this->addonGroupService->getBranches();
        return view('inventory::addonGroups.edit', [
            "addonGroup" => $addonGroup,
            "title" => "Edit Addon Group",
            "description" => "edit a new addon group",
            "branches" => $branches,
            "selectedBranches" => $addonGroup ? $addonGroup->branches->map(fn ($branch) => $branch->branch_id)->values()->toArray() : [],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AddonGroupRequest $request, $id): RedirectResponse
    {
        try {
            $data = $request->all();
            $updated = $this->addonGroupService->updateAddonGroup($data, $id);
            return redirect()->route('addonGroup.index')->withToastSuccess("Addon group updated successfully.");
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
            $deleted = $this->addonGroupService->delete($id);
            return redirect()->route('addonGroup.index')->withToastSuccess("Addon group deleted successfully.");
        } catch (Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }
}
