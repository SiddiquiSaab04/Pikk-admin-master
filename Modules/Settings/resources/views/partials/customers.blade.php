<div id="customers">
    <div class="row">
        <div class="col-sm-12 mb-4">
            <h4 class="p-4 text-center border-1">Customers</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <p class="mb-0">
                <label for="login">Allow Login</label>
            </p>
            <div id="login" class="btn-group" data-toggle="buttons">
                <label class="btn btn-success" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                  <input type="radio" name="login" value="1" class="join-btn" data-parsley-multiple="login" data-parsley-id="12"> &nbsp; True &nbsp;
                </label>
                <label class="btn btn-danger" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                  <input type="radio" name="login" value="0" class="join-btn" data-parsley-multiple="login"> False
                </label>
              </div>
            <span class="mt-1">
                <p class="mt-1">Allow Customers to Login</p>
            </span>
        </div>
        <div class="col-sm-4">
            <p class="mb-0">
                <label for="login_type">Authentication Type</label>
            </p>
            <div id="login_type" class="btn-group" data-toggle="buttons">
                <label class="btn btn-success" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                  <input type="radio" name="login_type" value="otp" class="join-btn" data-parsley-multiple="login_type" data-parsley-id="12"> &nbsp; OTP Login &nbsp;
                </label>
                <label class="btn btn-danger" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                  <input type="radio" name="login_type" value="credentials" class="join-btn" data-parsley-multiple="login_type"> Credentials
                </label>
              </div>
            <span class="mt-1">
                <p class="mt-1">Select Authentication Type</p>
            </span>
        </div>
        <div class="col-sm-4">
            <p class="mb-0">
                <label for="credentials_type">Credentials Type</label>
            </p>
            <div id="credentials_type" class="btn-group" data-toggle="buttons">
                <label class="btn btn-success" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                  <input type="radio" name="credentials_type" value="phone" class="join-btn" data-parsley-multiple="credentials_type" data-parsley-id="12"> &nbsp; Phone &nbsp;
                </label>
                <label class="btn btn-danger" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                  <input type="radio" name="credentials_type" value="email" class="join-btn" data-parsley-multiple="credentials_type"> Email
                </label>
              </div>
            <span class="mt-1">
                <p class="mt-1">Select Which Field Should Be Used To Authenticate Customers</p>
            </span>
        </div>
        <div class="col-sm-4">
            <p class="mb-0">
                <label for="email_verification">Email Verification</label>
            </p>
            <div id="email_verification" class="btn-group" data-toggle="buttons">
                <label class="btn btn-success" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                  <input type="radio" name="email_verification" value="1" class="join-btn" data-parsley-multiple="email_verification" data-parsley-id="12"> &nbsp; True &nbsp;
                </label>
                <label class="btn btn-danger" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                  <input type="radio" name="email_verification" value="0" class="join-btn" data-parsley-multiple="email_verification"> False
                </label>
              </div>
            <span class="mt-1">
                <p class="mt-1">Allow Email Verification for Customers</p>
            </span>
        </div>
        <div class="col-sm-4">
            <p class="mb-0">
                <label for="phone_verification">Phone Verification</label>
            </p>
            <div id="phone_verification" class="btn-group" data-toggle="buttons">
                <label class="btn btn-success" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                  <input type="radio" name="phone_verification" value="1" class="join-btn" data-parsley-multiple="phone_verification" data-parsley-id="12"> &nbsp; True &nbsp;
                </label>
                <label class="btn btn-danger" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                  <input type="radio" name="phone_verification" value="0" class="join-btn" data-parsley-multiple="phone_verification"> False
                </label>
              </div>
            <span class="mt-1">
                <p class="mt-1">Allow Phone Verification for Customers</p>
            </span>
        </div>
    </div>
</div>
