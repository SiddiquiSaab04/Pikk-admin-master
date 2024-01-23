@extends('layouts.master')
@section('content')
    @include('layouts.descriptions')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{ $title }}</h2>
                    <ul class="nav navbar-right panel_toolbox justify-content-end">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content my-4 px-2">
                    <form action="{{ route('addonGroup.update', ['branch' => Auth::user()->branch_id, 'addon_group' => $addonGroup->id]) }}" class="" method="post">
                        @csrf
                        @method("PUT")
                        <input type="hidden" name="multiselect" id="multiselect" value="{{ $addonGroup->multiselect }}">
                        <input type="hidden" name="status" id="status" value="{{ $addonGroup->status }}">
                        <div class="row">
                            <div class="input-group">
                                <input type="text" class="form-control" name="name" placeholder="Enter name" value="{{ $addonGroup->name }}">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </span>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-sm-4">
                                <p class="mb-0">
                                    <label for="description">Description</label>
                                </p>
                                <textarea type="text" class="form-control" name="description" rows="5">{{ $addonGroup->description }}</textarea>
                                <span class="mt-1">
                                    <p class="mt-1">Enter description for the addonGroup</p>
                                </span>
                            </div>
                            <div class="col-sm-4">
                                <p class="mb-0">
                                    <label for="preview_url">Multiselect</label>
                                </p>
                                <div class="btn-group w-25">
                                    <button class="btn btn-success" type="button" value="1" onclick="event.preventDefault(); document.getElementById('multiselect').value = this.value;">Yes</button>
                                    <button class="btn btn-danger" type="button" value="0" onclick="event.preventDefault(); document.getElementById('multiselect').value = this.value;">No</button>
                                  </div>
                                <span>
                                    <p class="mt-1">control if more than one addons in this group can be selected</p>
                                </span>
                            </div>
                            <div class="col-sm-4">
                                <p class="mb-0">
                                    <label for="preview_url">Status</label>
                                </p>
                                <div class="btn-group w-25">
                                    <button class="btn btn-success" type="button" value="1" onclick="event.preventDefault(); document.getElementById('status').value = this.value;">Yes</button>
                                    <button class="btn btn-danger" type="button" value="0" onclick="event.preventDefault(); document.getElementById('status').value = this.value;">No</button>
                                </div>
                                <span>
                                    <p class="mt-1">Enable or disable specific addon group</p>
                                </span>
                            </div>
                            @if (Auth::user()->branch_id == null)
                                <div class="col-sm-4">
                                    <p class="mb-0">
                                        <label for="branches">Branches</label>
                                    </p>
                                    <select class="form-control select2_multiple" multiple="multiple" name="branch_id[]" id="branch_id"
                                        >
                                        <option disabled>Choose Branch</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}" @if (in_array($branch->id, $selectedBranches)) selected @endif>
                                                {{ ucfirst(trans($branch->name)) }}</option>
                                        @endforeach
                                    </select>
                                    <span class="mt-1">
                                        <p class="mt-1">Enter branches for the addon group</p>
                                    </span>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
