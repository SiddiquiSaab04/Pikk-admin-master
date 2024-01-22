@extends('layouts.master')
@section('content')
@include('layouts.descriptions')
<div id="stock">
  <stock-component>
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
          <div class="x_content">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Product Name</th>
                  <th>SKU</th>
                  <th>Available Stock</th>
                  <th>Default Quantity</th>
                  <th>Is Enabled</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($products as $product)
                <tr>
                  <th>{{ $loop->iteration }}</th>
                  <td>{{ $product->name }}</td>
                  <td>{{ $product->sku }}</td>
                  <td class="border">
                    <form action="{{ route('stock.change', ['branch' => request()->branch]) }}" method="post">
                      @csrf
                      <input type="hidden" name="product_id" value="{{ $product->id }}">
                      <div class="input-group input-group-sm">
                        <input type="number" min="0" name="available_stock" value="{{ $product->stock->available_stock ?? '' }}" class="form-control mr-2" placeholder="Enter a number" aria-label="Number input" required>
                        <div class="input-group-append">
                          <button type="submit" class="btn btn-success btn-sm">Change</button>
                        </div>
                      </div>
                    </form>
                  </td>
                  <td class="border">
                    <form action="{{ route('stock.default', ['branch' => request()->branch]) }}" method="post">
                      @csrf
                      <input type="hidden" name="product_id" value="{{ $product->id }}">
                      <div class="input-group input-group-sm">
                        <input type="number" min="0" name="default_quantity" value="{{ $product->stock->default_quantity ?? '' }}" class="form-control mr-2" placeholder="Enter a number" aria-label="Number input" required>
                        <div class="input-group-append">
                          <button type="submit" class="btn btn-primary btn-sm">Set</button>
                        </div>
                      </div>
                    </form>
                  </td>
                  <td>
                    <form action="{{ route('stock.status', ['branch' => request()->branch]) }}" method="post">
                      @csrf
                      <input type="hidden" name="product_id" value="{{ $product->id }}">
                      <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-success btn-sm {{ optional($product->stock)->is_enabled === 1 ? 'active' : '' }}">
                          <input type="radio" name="is_enabled" value="1" onchange="this.form.submit()"> Yes
                        </label>

                        <label class="btn btn-danger btn-sm {{ optional($product->stock)->is_enabled === 0 ? 'active' : '' }}">
                          <input type="radio" name="is_enabled" value="0" {{ optional($product->stock)->is_enabled === 0 ? 'checked' : '' }} onchange="this.form.submit()"> No
                        </label>
                      </div>
                    </form>
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
  </stock-component>
</div>
@endsection
