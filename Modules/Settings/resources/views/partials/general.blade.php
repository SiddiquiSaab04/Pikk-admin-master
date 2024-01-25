<div id="general">
    <div class="row">
        <div class="col-sm-12 mb-4">
            <h4 class="p-4 text-center border-1">General</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <p class="mb-0">
                <label for="name">App Name</label>
            </p>
            <input type="text" class="form-control" name="APP_NAME" id="name" value="{{ $settings['APP_NAME'] ?? '' }}">
            <span class="mt-1">
                <p class="mt-1">Enter Application name</p>
            </span>
        </div>
        <div class="col-sm-4">
            <p class="mb-0">
                <label for="env">App Environment</label>
            </p>
            <input type="text" class="form-control" name="APP_ENV" id="env" value="{{ $settings['APP_ENV'] ?? '' }}">
            <span class="mt-1">
                <p class="mt-1">Set Application Environment</p>
            </span>
        </div>
        <div class="col-sm-4">
            <p class="mb-0">
                <label for="timezone">Time Zone</label>
            </p>
            <select class="form-control" name="TIMEZONE" id="timezone">
                <option value={{ null }}>Choose Timeone</option>
                @foreach(config('timezones') as $key => $value )
                    <option value="{{ $value }}" @if($value == $settings['TIMEZONE']) selected @endif>{{ $key }}</option>
                @endforeach
            </select>
            <span class="mt-1">
                <p class="mt-1">Set Application Time zone</p>
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <p class="mb-0">
                <label for="logo">App Logo</label>
            </p>
            <div class="form-group has-feedback position-relative">
                <input type="text" name="logo" class="form-control" id="inputSuccess5" value="{{ $settings['logo'] ?? '' }}">
                <span class="fa fa-image text-lg form-control-feedback right" aria-hidden="true"></span>
            </div>
            <span class="mt-1">
                <p class="mt-1">Enter Application Logo</p>
            </span>
        </div>
        <div class="col-sm-4">
            <p class="mb-0">
                <label for="favicon">Fav Icon</label>
            </p>
            <div class="form-group has-feedback position-relative">
                <input type="text" name="favicon" class="form-control" id="inputSuccess5" value="{{ $settings['favicon'] ?? '' }}">
                <span class="fa fa-image text-lg form-control-feedback right" aria-hidden="true"></span>
            </div>
            <span class="mt-1">
                <p class="mt-1">Set Application Favicon</p>
            </span>
        </div>
        <div class="col-sm-4">
            <p class="mb-0">
                <label for="platforms">Allowed Platforms</label>
            </p>
            <select class="form-control select2_multiple" multiple="multiple" name="platform[]" id="platform">
                <option disabled>Choose Platforms</option>
                <option value="app" @if(in_array('app', $settings['platform'])) selected @endif>App</option>
                <option value="kiosk" @if(in_array('kiosk', $settings['platform'])) selected @endif>Kiosk</option>
                <option value="pos" @if(in_array('pos', $settings['platform'])) selected @endif>POS</option>
                <option value="web" @if(in_array('web', $settings['platform'])) selected @endif>Web</option>
            </select>
            <span class="mt-1">
                <p class="mt-1">Set Allowed Platforms for Orders</p>
            </span>
        </div>
    </div>
</div>
