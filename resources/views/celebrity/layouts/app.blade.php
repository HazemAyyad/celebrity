<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'لوحة المشاهير')</title>
    <link rel="icon" href="{{ asset('assets/images/main-page-logo.png') }}" type="image/x-icon" />

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/media.css') }}" />
</head>
<body>

<!-- Preloader -->
<div id="preloader">
    <div class="loading-container">
        <img src="{{ asset('assets/images/main-page-logo.png') }}" alt="Logo" />
    </div>
</div>

<!-- Sidebar -->
@include('celebrity.components.sidebar')

<!-- Content -->
<div class="content">
    @include('celebrity.components.navbar')

    @yield('content')
</div>

<!-- Footer & Scripts -->
@include('celebrity.components.footer')

</body>
</html>
