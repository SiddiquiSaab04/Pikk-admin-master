@extends('layouts.master')
@section('content')
@include('layouts.descriptions')
<div class="row">
    <div class="col-sm-12 my-2">
        <div class="row">
            <div class="px-3">
                <a href="{{ route('settings.index') }}">
                    <button class="rounded-full btn-primary font-large padding-2">
                        <i class="fa fa-refresh text-white"></i>
                    </button>
                </a>
                @can('manage_settings')
                <a href="{{ route('settings.create') }}">
                    <button class="rounded-full btn-success font-large padding-2">
                        <i class="fa fa-plus text-white"></i>
                    </button>
                </a>
                @endcan
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
                <form action="{{ route('settings.show', 1) }}" method="get">

                </form>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Manage Settings </h2>
                <ul class="nav navbar-right panel_toolbox justify-content-end">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="row">
            </div>
        </div>
    </div>
</div>
@endsection
