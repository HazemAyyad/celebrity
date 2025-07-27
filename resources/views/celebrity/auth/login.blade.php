<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>تسجيل الدخول</title>
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}" type="image/x-icon" />

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/media.css') }}" />
</head>

<body>
<!-- Start Preloader HTML -->
<div id="preloader">
    <div class="loading-container">
        <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" />
    </div>
</div>
<!-- End Preloader HTML -->

<div class="container-fluid login-container d-flex">
    <!-- النصف الأول: اللوجو والصورة -->
    <div class="col-md-6 mt-5 text-center d-none d-md-block">
        <div class="logo mb-2">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" width="40%" height="120px" />
        </div>
        <img src="{{ asset('assets/images/login.png') }}" width="90%" height="400px" alt="Login Image" />
    </div>

    <!-- النصف الثاني: الفورم -->
    <div class="col-md-6 col-12 d-flex align-items-center justify-content-center">
        <div class="form-box w-100 p-4 bg-white">
            <h4 class="mb-4">مرحبا بك في</h4>
            <h6 class="head-6 mb-4">الذهبية العالمية للسياحة و السفر</h6>

            <!-- أزرار السوشال ميديا -->
{{--            <a href="#" class="btn border-gray social-btn">--}}
{{--                <img src="{{ asset('assets/images/google.png') }}" class="mx-2" alt="Google" />--}}
{{--                التسجيل بواسطة جوجل--}}
{{--            </a>--}}
{{--            <a href="#" class="btn border-gray social-btn">--}}
{{--                <img src="{{ asset('assets/images/facebook.png') }}" class="mx-2" alt="Facebook" />--}}
{{--                التسجيل بواسطة فيسبوك--}}
{{--            </a>--}}

{{--            <div class="d-flex align-items-center text-muted my-1">--}}
{{--                <hr class="flex-grow-1 border-top border-secondary" />--}}
{{--                <span class="px-3">أو</span>--}}
{{--                <hr class="flex-grow-1 border-top border-secondary" />--}}
{{--            </div>--}}

            <!-- الفورم -->
            <form id="loginForm" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">البريد الإلكتروني</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="example@example.com" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">كلمة المرور</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label" for="remember">تذكر كلمة المرور</label>
                    </div>
                    <a href="{{route('celebrity.forgot-password')}}" class="text-decoration-none small">نسيت كلمة المرور؟</a>
                </div>
                <button type="submit" class="btn btn-login w-100" id="loginBtn">تسجيل الدخول</button>
                <div id="loginError" class="text-danger text-center mt-2"></div>

            </form>

            <div class="text-center mt-4">
                ليس لديك حساب؟ <a href="{{route('celebrity.register')}}">سجل الآن</a>
            </div>
        </div>
    </div>
</div>

<!-- WhatsApp Floating Button -->
<div class="whatsapp-float d-flex">
    <a href="https://wa.me/+966920029449" target="_blank">
        <img src="{{ asset('assets/images/whatsapp.png') }}" alt="WhatsApp" />
    </a>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>

<script>
    $(document).ready(function () {
        // Check if URL has a hash and scroll to that section
        if (window.location.hash) {
            var hash = window.location.hash;
            if ($(hash).length) {
                $("html, body").animate({
                    scrollTop: $(hash).offset().top
                }, 800);
            }
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
    $(document).ready(function () {
        $('#loginForm').validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true
                }
            },
            messages: {
                email: {
                    required: "يرجى إدخال البريد الإلكتروني",
                    email: "صيغة البريد الإلكتروني غير صحيحة"
                },
                password: {
                    required: "يرجى إدخال كلمة المرور"
                }
            },
            errorClass: 'is-invalid', // Bootstrap 5 uses this
            validClass: 'is-valid',
            errorElement: 'div',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                error.insertAfter(element); // مباشرة بعد الـ input
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass(errorClass).removeClass(validClass);
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass(errorClass).addClass(validClass);
            },
            submitHandler: function (form) {
                $('#loginBtn').attr('disabled', true).text('جاري التحقق...');
                $('#loginError').html('');

                $.ajax({
                    url: "{{ route('celebrity.login') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        email: $('#email').val(),
                        password: $('#password').val(),
                        remember: $('#remember').is(':checked') ? 1 : 0
                    },
                    success: function (response) {
                        if (response.status === 'success' || response.status === 'otp_required') {
                            window.location.href = response.redirect;
                        } else {
                            $('#loginError').html(response.message || 'حدث خطأ');
                            $('#loginBtn').attr('disabled', false).text('تسجيل الدخول');
                        }
                    },
                    error: function (xhr) {
                        let msg = 'حدث خطأ أثناء محاولة تسجيل الدخول';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        $('#loginError').html(msg);
                        $('#loginBtn').attr('disabled', false).text('تسجيل الدخول');
                    }
                });
            }
        });
    });
</script>

</body>
</html>
