<div id="gallery">
    <div>
        <gallery-component :images="{{ $images }}" :product="{{ $product ?? json_encode([])}}"></gallery-component>
    </div>
</div>
