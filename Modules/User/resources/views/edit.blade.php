@extends('layouts.master')
@section('content')
@include('layouts.descriptions')
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <a href="{{ route('user.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
                    </svg>
                </a>
                <ul class="nav navbar-right panel_toolbox justify-content-end">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br />
                <form class="form-horizontal form-label-left" method="post" action="{{ route('user.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group row ">
                        <label class="control-label col-md-3 col-sm-3 ">Name</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $user->name }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 ">Email</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="email" name="email" class="form-control" placeholder="abc@xyz.com" value="{{ $user->email }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 ">Role</label>
                        <div class="col-md-9 col-sm-9 ">
                            <select class="form-control" name="role" required>
                                <option disabled>Choose Role</option>
                                @foreach($roles as $role)
                                <option value="{{$role->name}}" {{ $user->getRoleNames()->first() == $role->name ? 'selected' : ''}}>{{ucfirst(trans($role->name))}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 ">Role</label>
                        <div class="col-md-9 col-sm-9 ">
                            <select class="form-control" name="branch_id" required>
                                <option disabled>Choose Role</option>
                                @foreach($branches as $branch)
                                <option value="{{$branch->id}}" {{$branch->id == $user->branch_id  ? 'selected' : ''}}>{{ucfirst(trans($branch->name))}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 ">Status</label>
                        <div class="col-md-9 col-sm-9 ">
                            <select class="form-control" name="status" required>
                                <option selected disabled>Choose status</option>
                                <option value="1" {{$user->status == 1  ? 'selected' : ''}}>Active</option>
                                <option value="0" {{$user->status == 0  ? 'selected' : ''}}>In-active</option>
                            </select>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9  offset-md-3">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection