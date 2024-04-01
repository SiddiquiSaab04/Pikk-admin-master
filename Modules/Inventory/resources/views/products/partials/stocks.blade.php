<div id="stocks">
    <div class="col-sm-12 mb-4">
        <h4 class="p-4 text-center border-1">Stocks & Pricing</h4>
    </div>
    <input type="hidden" name="stock_checking" value="{{ $product->stock_checking ?? 1 }}">
    <input type="hidden" name="status" value="{{ $product->status ?? 1 }}">
    <div class="col-sm-4">
        <p class="mb-0">
            <label for="wholesale_price">Wholesale Price</label>
        </p>
        <input type="number" class="form-control" name="wholesale_price" id="name"
            value="{{ $product->wholesale_price ?? 0 }}">
        <span class="mt-1">
            <p class="mt-1">Enter wholesale price for the product</p>
        </span>
    </div>
    <div class="col-sm-4">
        <p class="mb-0">
            <label for="sale_price">Sale Price</label>
        </p>
        <input type="number" class="form-control" name="sale_price" id="name"
            value="{{ $product->sale_price ?? 0 }}">
        <span class="mt-1">
            <p class="mt-1">Enter sale price for the product</p>
        </span>
    </div>
    <div class="col-sm-4">
        <p class="mb-0">
            <label for="status">Status</label>
        </p>
        <div class="btn-group w-25">
            <button class="btn btn-success" type="button" value="1"
                onclick="event.preventDefault(); document.getElementById('status').value = this.value;">Enable</button>
            <button class="btn btn-danger" type="button" value="0"
                onclick="event.preventDefault(); document.getElementById('status').value = this.value;">Disable</button>
        </div>
        <span>
            <p class="mt-1">toggle product status to enable or disable </p>
        </span>
    </div>
</div>
<div class="col-sm-4">
    <p class="mb-0">
        <label for="status">New</label>
    </p>
    <div class="btn-group w-25">
        <button class="btn btn-success" type="button" value="1"
            onclick="event.preventDefault(); document.getElementById('is_new').value = this.value;">True</button>
        <button class="btn btn-danger" type="button" value="0"
            onclick="event.preventDefault(); document.getElementById('is_new').value = this.value;">False</button>
    </div>
    <span>
        <p class="mt-1">set if product as new or not </p>
    </span>
</div>
<div class="col-sm-4">
    <p class="mb-0">
        <label for="stock_checking">Stock Checking</label>
    </p>
    <div class="btn-group w-25">
        <button class="btn btn-success" type="button" value="1"
            onclick="event.preventDefault(); document.getElementById('stock_checking').value = this.value;">Yes</button>
        <button class="btn btn-danger" type="button" value="0"
            onclick="event.preventDefault(); document.getElementById('stock_checking').value = this.value;">No</button>
    </div>
    <span>
        <p class="mt-1">toggle stock checking to yes or no, product will not be tracked in stocks</p>
    </span>
</div>
</div>
