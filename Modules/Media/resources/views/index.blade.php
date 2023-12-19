@extends('layouts.master')
@section('content')
@include('layouts.descriptions')
<div class="row">
    <div class="col-sm-12 my-2">
        <div class="row">
            <div class="px-3">
                <a href="{{ route('media.index') }}">
                    <button class="rounded-full btn-primary font-large padding-2">
                        <i class="fa fa-refresh text-white"></i>
                    </button>
                </a>
                @can('create_medias')
                <a href="{{ route('media.create') }}">
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
                <form action="{{ route('media.show', 1) }}" method="get">

                </form>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Manage Medias </h2>
                <ul class="nav navbar-right panel_toolbox justify-content-end">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="row">
                @foreach($medias as $media)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <img src="{{ $media->url }}" class="card-img-top p-1" alt="Image">
                        <div class="card-body">
                            <h5 class="card-title">{{ $media->name }}</h5>
                            <div class="tools tools-bottom float-right">
                                <a href="{{ $media->url }}"><i class="fa fa-link"></i></a>
                                @can('update_medias')
                                <a href="{{ route('media.edit', $media->id) }}"><i class="fa fa-pencil"></i></a>
                                <a onclick="event.preventDefault(); document.getElementById('delete-{{ $media->id }}').submit()">
                                    <i class="fa fa-times"></i>
                                </a>
                                <form id="delete-{{ $media->id }}" action="{{ route('media.destroy', $media->id) }}" method="post">
                                    @csrf
                                    @method("DELETE")
                                </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection