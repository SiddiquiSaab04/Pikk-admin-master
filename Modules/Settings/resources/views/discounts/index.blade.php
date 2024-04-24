@extends('layouts.master')
@section('content')
@include('layouts.descriptions')
<div class="row">
  <div class="col-sm-12 my-2">
    <div class="row">
      <div class="px-3">
        <a href="{{ route('discounts.index',request()->branch) }}">
          <button class="rounded-full btn-primary font-large padding-2">
            <i class="fa fa-refresh text-white"></i>
          </button>
        </a>
        @can('create_discount')
        <a href="{{ route('discounts.create', request()->branch) }}">
          <button class="rounded-full btn-success font-large padding-2">
            <i class="fa fa-plus text-white"></i>
          </button>
        </a>
        @endcan
      </div>
    </div>
  </div>
  <div class="col-md-12 col-sm-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Manage Discounts </h2>
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
              <th>Key</th>
              <th>Discounts</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($settings as $setting)
            <tr>
              <th scope="">{{ $loop->iteration }}</th>
              <td>{{ $setting['key'] }}</td>
              <td>
                @php
                $settingValues = json_decode($setting['value']);
                @endphp
                Cashback: {{ $settingValues->cashback }}, Status: {{ $settingValues->status == 1 ? 'Active' : 'Inactive'  }}
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        {{ $settings->links() }}
      </div>
    </div>
  </div>
</div>

@endsection
