@extends('layouts.master')
@section('content')
@include('layouts.descriptions')
<div class="row">
    <div class="col-sm-12 my-2">
        <div class="row">
            <div class="px-3">
                <a href="{{ route('permissions.index') }}">
                    <button class="rounded-full btn-primary font-large padding-2">
                        <i class="fa fa-refresh text-white"></i>
                    </button>
                </a>
                <a href="{{ route('permissions.create') }}">
                    <button class="rounded-full btn-success font-large padding-2">
                        <i class="fa fa-plus text-white"></i>
                    </button>
                </a>
            </div>
            <div class="col-sm-5">
                <div class="form-group top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for..." id="search">
                        <span class="input-group-btn">
                            <button class="btn btn-primary text-white" onclick="event.preventDefault(); window.location = +(document.getElementById('search').value)">Go!</button>
                        </span>
                    </div>
                </div>
                <form action="{{ route('permissions.show', 1) }}" method="get">

                </form>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Manage Permissions </h2>
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
                            <th>Role</th>
                            <th>Guard Name</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permissions as $permission)
                        <tr>
                            <th scope="">{{ $loop->iteration }}</th>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->getRoleNames()->first() }}</td>
                            <td>{{ $permission->guard_name }}</td>
                            <td>{{ $permission->created_at }}</td>
                            <td role="presentation" class="dropdown">
                                <a id="drop5" href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                                    Options
                                    <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 44px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    <a class="dropdown-item" href="{{ route('permissions.edit', $permission->id) }}">Edit</a>
                                    <a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('delete').submit()">Delete</a>
                                    <form id="delete" action="{{ route('permissions.destroy', $permission->id) }}" method="post">
                                        @csrf
                                        @method("DELETE")
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $permissions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection