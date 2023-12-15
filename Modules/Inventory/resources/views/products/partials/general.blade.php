<div id="general">
    <div class="row">
        <div class="col-sm-12 mb-4">
            <h4 class="p-4 text-center border-1">General</h4>
        </div>
        <div class="col-sm-4">
            <p class="mb-0">
                <label for="name">Name</label>
            </p>
            <input type="text" class="form-control" name="name" id="name" value="{{ $product->name ?? '' }}">
            <span class="mt-1">
                <p class="mt-1">Enter name for the product</p>
            </span>
        </div>
        <div class="col-sm-4">
            <p class="mb-0">
                <label for="sku">SKU</label>
            </p>
            <input type="text" class="form-control" name="sku" id="sku" value="{{ $product->sku ?? '' }}">
            <span class="mt-1">
                <p class="mt-1">Enter unique sku for the product</p>
            </span>
        </div>
        <div class="col-sm-4">
            <p class="mb-0">
                <label for="barcode">Barcode</label>
            </p>
            <input type="text" class="form-control" name="barcode" id="barcode" value="{{ $product->barcode ?? '' }}">
            <span class="mt-1">
                <p class="mt-1">Enter unique barcode for the product</p>
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <p class="mb-0">
                <label for="sort_order">Sort Order</label>
            </p>
            <input type="text" class="form-control" name="sort_order" id="sort_order" value="{{ $product->sort_order ?? '' }}">
            <span class="mt-1">
                <p class="mt-1">Enter sorting number for the product</p>
            </span>
        </div>
        <div class="col-sm-4">
            <p class="mb-0">
                <label for="category">Category</label>
            </p>
            <select name="category_id" id="category_id" class="form-control">
                <option value="">-- select category --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <span class="mt-1">
                <p class="mt-1">Enter category for the product</p>
            </span>
        </div>
        <div class="col-sm-4">
            <p class="mb-0">
                <label for="description">Description</label>
            </p>
            <textarea type="text" class="form-control" name="description" rows="5">{{ $product->description ?? '' }}</textarea>
            <span class="mt-1">
                <p class="mt-1">Enter description for the product</p>
            </span>
        </div>
    </div>
</div>
