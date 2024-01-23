@extends('layouts.master')
@section('content')
@include('layouts.descriptions')

<div class="row">
  <div class="col-sm-12 my-2">
    <div class="row">
      <div class="px-3">
        <a href="{{ route('stock.index', request()->branch) }}">
          <button class="rounded-full btn-primary font-large padding-2">
            <i class="fa fa-refresh text-white"></i>
          </button>
        </a>
      </div>
      <div class="col-5">
        <div class="form-group top_search">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Search for..." id="search">
            <span class="input-group-btn">
              <button class="btn btn-primary text-white" onclick="event.preventDefault(); window.location = '/product/'+ (document.getElementById('search').value)">Go!</button>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-12 col-sm-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Manage Stocks </h2>
        <ul class="nav navbar-right panel_toolbox justify-content-end">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content" id="app">
        <stock-component :products="{{ $products}}" form-action="{{ route('stock.manage', ['branch' => request()->branch]) }}"/>
      </div>
    </div>
  </div>
</div>
@endsection
