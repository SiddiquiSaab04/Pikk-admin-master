<div id="addons">
    <input type="hidden" name="product_addon" id="product_addon">
    <div class="row">
        <div class="col-sm-12 mb-4">
            <h4 class="p-4 text-center border-1">Addons </h4>
        </div>
        <div class="col-sm-4">
            <p class="mb-0">
                <label for="addon_group_id">Modifier Groups</label>
            </p>
            <select name="addon_group_id" class="form-control">
                <option value="">-- select addons --</option>
                @foreach ($addons as $addon)
                <option value="{{ $addon->id }}" @if (!empty($product->id) && $addon->id == $product->addon_group_id) selected @endif>
                    {{ $addon->name }}
                </option>
                @endforeach
            </select>
            <span class="mt-1">
                <p class="mt-1">
                    Set this field to save product as a modifier
                </p>
            </span>
        </div>
    </div>
    <div class="col-sm-12 mb-4">
        <h4 class="p-4 text-center border-1">Addons Products</h4>
    </div>
    <div>
        <addon-component :addons="{{ $addons }}" :product="{{ $product }}">

        </addon-component>
    </div>
</div>
