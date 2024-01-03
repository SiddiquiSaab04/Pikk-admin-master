@extends('layouts.master')

@section('content')
@include('layouts.descriptions')
  <div class="row" id="app">
    <div class="col-4">
        <tile-component :path="'orders-count'"></tile-component>
    </div>
    <div class="col-4">
        <tile-component :path="'orders-revenue'"></tile-component>
    </div>
    <div class="col-4">
        <tile-component :path="'orders-profit'"></tile-component>
    </div>
  </div>
@endsection
