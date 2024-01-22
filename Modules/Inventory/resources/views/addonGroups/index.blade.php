@extends('layouts.master')
@section('content')
@include('layouts.descriptions')
<div class="row">
    <div class="col-sm-12 my-2">
        <div class="row">
            <div class="px-3">
                <a href="{{ route('addonGroup.index', request()->branch) }}">
                    <button class="rounded-full btn-primary font-large padding-2">
                        <i class="fa fa-refresh text-white"></i>
                    </button>
                </a>
                @can('create_addon_groups')
                <a href="{{ route('addonGroup.create', request()->branch) }}">
                    <button class="rounded-full btn-success font-large padding-2">
                        <i class="fa fa-plus text-white"></i>
                    </button>
                </a>
                @endcan
            </div>
            <div class="col-5">
                <div class="form-group top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for..." id="search">
                        <span class="input-group-btn">
                            <button class="btn btn-primary text-white" onclick="event.preventDefault(); window.location = '/addon-groups/'+ (document.getElementById('search').value)">Go!</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Manage Addon Groups </h2>
                <ul class="nav navbar-right panel_toolbox justify-content-end">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Multiselect</th>
                            <th>Status</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($addonGroups as $addonGroup)
                        <tr>
                            <th scope="">{{ $loop->iteration }}</th>
                            <td>{{ $addonGroup->name }}</td>
                            <td>{{ $addonGroup->multiselect ? 'true' : 'false' }}</td>
                            <td>{{ $addonGroup->status ? 'true' : 'false' }}</td>
                            <td>{{ $addonGroup->description }}</td>
                            <td>{{ $addonGroup->created_at }}</td>
                            <td role="presentation" class="dropdown">
                                <a id="drop5" href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                                    Options
                                    <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 44px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    @can('update_addon_groups')
                                    <a class="dropdown-item" href="{{ route('addonGroup.edit', ['addon_group' => $addonGroup->id]) }}">Edit</a>
                                    @endcan
                                    @can('delete_addon_groups')
                                    <a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('delete').submit()">Delete</a>
                                    <form id="delete" action="{{ route('addonGroup.destroy', ['addon_group' => $addonGroup->id]) }}" method="post">
                                        @csrf
                                        @method("DELETE")
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $addonGroups->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
