<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login PiKK</title>

    <!-- Bootstrap -->
    <link href="{{ asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- Animate.css -->
    <link href="{{ asset('vendors/animate.css/animate.min.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('css/custom.min.css') }}" rel="stylesheet">
</head>

<body class="container">
    <div id="bg-img">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                <div class="position-relative">
                    <form class="position-absolute intrepid translate-middle form" method="POST" action="{{ route('login') }}">
                        @csrf
                        <h2 class="text-gray login-admin-text">Login (Admin)</h2>
                        <div class="mb-2">
                            <label for="email" class="form-label text-gray">Email</label>
                            <input type="email" class="form-control form-input" name="email" placeholder="xyz@gmail.com" required>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="bottom-space">
                            <label for="password" class="form-label text-gray">Password</label>
                            <input type="password" class="form-control form-input" name="password" placeholder="Password" required>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <button type="submit" class="form-control form-input sign-in submit">Sign in</button>
                    </form>

                    <img src="{{ asset('/images/logo.png') }}" class="img-fluid logo" alt="Logo Image">
                    <img src="{{ asset('/images/lines.png') }}" class="img-fluid lines" alt="Lines Image">
                    <img src="{{ asset('/images/waves.png') }}" class="img-fluid waves-bottom" alt="Waves Image">
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 d-flex justify-content-end m-auto">
                <div class="rectangular-div">
                    <h1 class="sensa admin-text text-orange">Admin</h1>
                    <h1 class="brittany dashboard-text text-gray ">Dashboard</h1>
                    <ul class="rectangular-div-isting text-gray intrepid">
                        <li>It is a long established fact that a reader will be.</li>
                        <li>There are many variations of passages of Lorem Ipsum available.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')
</body>

</html>
