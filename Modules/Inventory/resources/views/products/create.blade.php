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
                    <small>General Information</small>
                </span>
            </a>
        </li>
        <li>
            <a href="#stocks">
                <span class="step_no">2</span>
                <span class="step_descr">
                    Stocks & Pricing<br />
                    <small>Stock Management</small>
                </span>
            </a>
        </li>
        <li>
            <a href="#addons">
                <span class="step_no">3</span>
                <span class="step_descr">
                    Addons<br />
                    <small>Addon Information</small>
                </span>
            </a>
        </li>
        <li>
            <a href="#gallery">
                <span class="step_no">4</span>
                <span class="step_descr">
                    Gallery<br />
                    <small>Gallery Management</small>
                </span>
            </a>
        </li>
    </ul>
    <div id="app">
        <form action="{{ route('product.store') }}" class="form-horizontal form-label-left my-5 px-3" method="post" id="form-wizard">
            @csrf
            @include('inventory::products.partials.general')
            @include('inventory::products.partials.stocks')
            @include('inventory::products.partials.addons')
            @include('inventory::products.partials.gallery')
        </form>
    </div>
</div>
@endsection
