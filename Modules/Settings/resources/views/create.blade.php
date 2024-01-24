@extends('layouts.master')
@section('content')
@include('layouts.descriptions')
<div id="wizard" class="form_wizard wizard_horizontal bg-white py-5">
    <ul class="wizard_steps">
        <li>
            <a href="#general">
                <span class="step_no">1</span>
                <span class="step_descr">
                    General<br />
                    <small>General Settings</small>
                </span>
            </a>
        </li>
        <li>
            <a href="#customers">
                <span class="step_no">2</span>
                <span class="step_descr">
                Customers<br />
                    <small>Customers Settings</small>
                </span>
            </a>
        </li>
        <li>
            <a href="#payment">
                <span class="step_no">3</span>
                <span class="step_descr">
                    Payment<br />
                    <small>Payment Settings</small>
                </span>
            </a>
        </li>
        <li>
            <a href="#services">
                <span class="step_no">4</span>
                <span class="step_descr">
                    Services<br />
                    <small>Services Settings</small>
                </span>
            </a>
        </li>
        <li>
            <a href="#notifications">
                <span class="step_no">5</span>
                <span class="step_descr">
                    Notifications<br />
                    <small>Notifications Settings</small>
                </span>
            </a>
        </li>
    </ul>
    <div id="app">
        <form action="{{ route('settings.store') }}" class="form-horizontal form-label-left my-5 px-3" method="post" id="form-wizard">
            @csrf
            @include('settings::partials.general')
            @include('settings::partials.customers')
            @include('settings::partials.payment')
            @include('settings::partials.services')
            @include('settings::partials.notifications')
        </form>
    </div>
</div>
@endsection
