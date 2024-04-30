@extends('layouts.master')
@section('content')
@include('layouts.descriptions')
<div class="row">
    <div class="col-sm-12 my-2">
        <div class="row">
            <div class="px-3">
                <a href="{{ route('product.index', request()->branch) }}">
                    <button class="rounded-full btn-primary font-large padding-2">
                        <i class="fa fa-refresh text-white"></i>
                    </button>
                </a>
                @can('create_products')
                <a href="{{ route('product.create', request()->branch) }}">
                    <button class="rounded-full btn-success font-large padding-2">
                        <i class="fa fa-plus text-white"></i>
                    </button>
                </a>
                @endcan
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
                <h2>Manage Products </h2>
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
                            <th>Category</th>
                            <th>SKU</th>
                            <!-- <th>Wholesale Price</th> -->
                            <!-- <th>Sale Price</th> -->
                            <!-- <th>Status</th> -->
                            <!-- <th>Description</th> -->
                            <!-- <th>Created At</th> -->
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <th scope="">{{ $loop->iteration }}</th>
                            <td>{{ $product->name }}</td>
                            <td>
                                <span class="text-white p-2 rounded bg-{{ $colors[$product->category_id] }}">
                                    {{ $product->category->name }}
                                    <span>
                            </td>
                            <td>{{ $product->sku }}</td>
                            <!-- <td>{{ $product->wholesale_price }}</td> -->
                            <td>{{ $product->sale_price }}</td>
                            <!-- <td>{{ $product->status ? 'True' : 'False' }}</td> -->
                            <!-- <td>{{ $product->description }}</td> -->
                            <!-- <td>{{ $product->created_at }}</td> -->
                            <td role="presentation" class="dropdown">
                                <a id="drop5" href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                                    Options
                                    <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 44px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    <a class="dropdown-item" href="{{ route('product.edit', ['branch' => Auth::user()->branch_id, 'product' => $product->id]) }}">Edit</a>

                                    @can('delete_products')
                                    <a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('delete').submit()">Delete</a>
                                    <form id="delete" action="{{ route('product.destroy',  ['branch' => Auth::user()->branch_id, 'product' => $product->id]) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
