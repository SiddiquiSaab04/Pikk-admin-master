<div id="payment">
    <div class="row">
        <div class="col-sm-12 mb-4">
            <h4 class="p-4 text-center border-1">Payment</h4>
        </div>
    </div>
    <div class="px-3">
        <payment-component
            :setting={{ isset($settings['payments']) ? json_encode($settings['payments']) : json_encode([]) }}
            :gateway="{{ isset($settings['gateway']) ? json_encode($settings['gateway']) : json_encode([]) }}"
        >
        </payment-component>
    </div>
</div>
