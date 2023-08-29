<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{ asset('adminassets/plugins/global/plugins.bundle.css') }}" rel="stylesheet">
    <link href="{{ asset('adminassets/css/style.bundle.css') }}" rel="stylesheet">
    <link href="{{ asset('adminassets/plugins/global/plugins.bundle.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

</head>
<body id="kt_body" class="bg-dark">
<div class="d-flex flex-column flex-root">
    <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url({{ asset('assets/media/illustrations/sketchy-1/14-dark.png') }}">
        <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
            <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" action="" method="post">

                    <div class="fv-row mb-10">
                        <label class="form-label fs-6 fw-bolder text-dark">Email</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" name="email" autocomplete="off" placeholder="Email" />
                    </div>
                    <div class="fv-row mb-10">
                        <div class="d-flex flex-stack mb-2">
                            <label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
                        </div>
                        <input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="off" placeholder="Password" />
                    </div>
                    <div class="text-center">
                        <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                            <span class="indicator-label">Continue</span>
                            <span class="indicator-progress">Please wait...
								<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>var baseHost = '/admin/';</script>
<script src="{{ asset('adminassets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{ asset('adminassets/js/scripts.bundle.js')}}"></script>
<script src="{{ asset('adminassets/js/custom/authentication/sign-in/general.js')}}"></script>
</body>
</html>
