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
                    <form action="{{ route('branch.update', $branch->id) }}" class="form" method="post">
                        @method("PUT")
                        @csrf
                        <input type="hidden" name="multi_kitchen" id="multi_kitchen" value="{{ $branch->multi_kitchen ?? 1 }}">
                        <input type="hidden" name="status" id="status" value="{{ $branch->status ?? 1 }}">
                        <div class="row">
                            <div class="input-group">
                                <input type="text" class="form-control" name="name" placeholder="Enter name" value="{{ $branch->name ?? '' }}" >
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </span>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-sm-4">
                                <p class="mb-0">
                                    <label for="address">Address</label>
                                </p>
                                <input type="text" class="form-control" name="address" value="{{ $branch->address ?? '' }}">
                                <span class="mt-1">
                                    <p class="mt-1">Address for the current branch</p>
                                </span>
                            </div>
                            <div class="col-sm-4">
                                <p class="mb-0">
                                    <label for="postcode">Postcode</label>
                                </p>
                                <input type="text" class="form-control" name="postcode" value="{{ $branch->postcode ?? '' }}">
                                <span class="mt-1">
                                    <p class="mt-1">Postcode for the current branch</p>
                                </span>
                            </div>
                            <div class="col-sm-4">
                                <p class="mb-0">
                                    <label for="phone">Phone</label>
                                </p>
                                <input type="text" class="form-control" name="phone" value="{{ $branch->phone ?? '' }}">
                                <span class="mt-1">
                                    <p class="mt-1">Phone for the current branch</p>
                                </span>
                            </div>
                            <div class="col-sm-4">
                                <p class="mb-0">
                                    <label for="preview_url">Multikitchen</label>
                                </p>
                                <div class="btn-group w-25">
                                    <button class="btn btn-success" type="button" value="1" onclick="event.preventDefault(); document.getElementById('multi_kitchen').value = this.value;">Yes</button>
                                    <button class="btn btn-danger" type="button" value="0" onclick="event.preventDefault(); document.getElementById('multi_kitchen').value = this.value;">No</button>
                                  </div>
                                <span>
                                    <p class="mt-1">set to true if branch has multiple kitchens</p>
                                </span>
                            </div>
                            <div class="col-sm-4">
                                <p class="mb-0">
                                    <label for="preview_url">Status</label>
                                </p>
                                <div class="btn-group w-25">
                                    <button class="btn btn-success" type="button" value="1" onclick="event.preventDefault(); document.getElementById('status').value = this.value;">Open</button>
                                    <button class="btn btn-danger" type="button" value="0" onclick="event.preventDefault(); document.getElementById('status').value = this.value;">Closed</button>
                                  </div>
                                <span>
                                    <p class="mt-1">set to true if branch is open</p>
                                </span>
                            </div>
                            <div class="col-sm-4">
                                <p class="mb-0">
                                    <label for="timings">Closing Reason</label>
                                </p>
                                <textarea type="text" class="form-control" name="closing_reason" rows="5">{{ $branch->closing_reason ?? '' }}</textarea>
                                <span class="mt-1">
                                    <p class="mt-1">closing reason for the branch</p>
                                </span>
                            </div>
                            <div class="col-sm-4">
                                <p class="mb-0">
                                    <label for="timings">Timings</label>
                                </p>
                                <textarea type="text" class="form-control" name="timings" rows="5">{{ $branch->timings ?? '' }}</textarea>
                                <span class="mt-1">
                                    <p class="mt-1">Enter timings for the branch</p>
                                </span>
                            </div>
                            <div class="col-sm-4">
                                <p class="mb-0">
                                    <label for="description">Description</label>
                                </p>
                                <textarea type="text" class="form-control" name="description" rows="5">{{ $branch->description ?? '' }}</textarea>
                                <span class="mt-1">
                                    <p class="mt-1">Enter description for the branch</p>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
