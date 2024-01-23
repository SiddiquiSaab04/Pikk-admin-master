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
                    <form action="{{ route('category.update', ['branch' => Auth::user()->branch_id, 'category' => $category->id]) }}" class="" method="post">
                        @csrf
                        @method("PUT")
                        <input type="hidden" name="display" id="display" value="{{ $category->display }}">
                        <div class="row">
                            <div class="input-group">
                                <input type="text" class="form-control" name="name" placeholder="Enter name" value="{{ $category->name }}">
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
                                <textarea type="text" class="form-control" name="description" rows="5">{{ $category->description }}</textarea>
                                <span class="mt-1">
                                    <p class="mt-1">Enter description for the category</p>
                                </span>
                            </div>
                            <div class="col-sm-4">
                                <p class="mb-0">
                                    <label for="preview_url">Preview URL</label>
                                </p>
                                <input type="text" class="form-control" name="preview_url" value="{{ $category->preview_url }}">
                                <span class="mt-1">
                                    <p class="mt-1">The image url provided here will be shown at the frontend</p>
                                </span>
                            </div>
                            <div class="col-sm-4">
                                <p class="mb-0">
                                    <label for="preview_url">Category Display</label>
                                </p>
                                <div class="btn-group w-25">
                                    <button class="btn btn-success" type="button" value="1" onclick="event.preventDefault(); document.getElementById('display').value = this.value;">Yes</button>
                                    <button class="btn btn-danger" type="button" value="0" onclick="event.preventDefault(); document.getElementById('display').value = this.value;">No</button>
                                  </div>
                                <span>
                                    <p class="mt-1">control if category is shown to the frontend</p>
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
                                        <p class="mt-1">Enter branches for the category</p>
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
