<!DOCTYPE html>
<html lang="en">
<head>
    @include('head')

    @yield('css')
</head>

<body>

@include('header')

@if (Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
@endif
@if(Session::has('error'))
    <div class="alert alert-danger">
        {{ Session::get('error') }}
    </div>
@endif
@if(session('message'))
        <div class="toast align-items-center toast-message border-0" role="alert" aria-live="assertive" aria-atomic="true" id="messageToast">
            <div class="d-flex">
                <div class="toast-body py-3 fs-6 d-flex align-items-center">
                    <i class="fa-solid fa-circle-check mx-2 fs-5"></i>
                    <span>{{ session('message') }}</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
@endif

@yield('content')

@include('footer')

</body>
</html>
