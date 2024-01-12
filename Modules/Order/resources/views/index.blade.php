@extends('layouts.master')
@section('content')
    @include('layouts.descriptions')
    <div class="row">
        <div class="col-sm-12 my-2">
            <div class="row">
                <div class="px-3">
                    <a href="{{ route('order.index', request()->branch) }}">
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
                                <button class="btn btn-primary text-white"
                                    onclick="event.preventDefault(); window.location = '/order/'+ (document.getElementById('search').value)">Go!</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Manage Orders </h2>
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
                                <th>Code</th>
                                <th>Customer Name</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Wallet</th>
                                <th>Discount Type</th>
                                <th>Sub Total</th>
                                <th>Discount</th>
                                <th>Total</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <th scope="">{{ $loop->iteration }}</th>
                                    <td>{{ $order->code }}</td>
                                    <td>{{ $order->customer_id }}</td>
                                    <td>{{ $order->type }}</td>
                                    <td>
                                        <span class="text-white rounded p-2 @if ($order->status == 'ongoing') bg-warning
                                            @elseif($order->status == 'ready')
                                                bg-info
                                            @else
                                                bg-success
                                            @endif">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td>{{ $order->payment }}</td>
                                    <td>{{ $order->wallet }}</td>
                                    <td>{{ $order->discount_type }}</td>
                                    <td>{{ $order->sub_total }}</td>
                                    <td>{{ $order->discount }}</td>
                                    <td>{{ $order->total }}</td>
                                    <td>{{ $order->created_at }}</td>
                                    <td role="presentation" class="dropdown">
                                        <a id="drop5" href="#" class="dropdown-toggle" data-toggle="dropdown"
                                            aria-haspopup="true" role="button" aria-expanded="false">
                                            Options
                                            <span class="caret"></span>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                                            x-placement="bottom-start"
                                            style="position: absolute; transform: translate3d(0px, 44px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <a class="dropdown-item"
                                                href="{{ route('order.receipt', ['id' => $order->id, 'branch' => request()->branch]) }}">Receipt</a>
                                            <a class="dropdown-item"
                                                href="{{ route('order.invoice', [request()->branch, $order->id]) }}">Invoice</a>
                                            <a class="dropdown-item"
                                                onclick="event.preventDefault(); document.getElementById('delete').submit()">Delete</a>
                                            <form id="delete"
                                                action="{{ route('order.destroy', [request()->branch, $order->id]) }}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
