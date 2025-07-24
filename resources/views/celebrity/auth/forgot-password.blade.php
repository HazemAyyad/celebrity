<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>كلمة المرور</title>
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
        <img src="{{ asset('assets/images/Forgot password-bro 1.png') }}" width="90%" height="500px" alt="Login Image" />
    </div>

    <!-- النصف الثاني: الفورم -->
    <div class="col-md-6 col-12 d-flex align-items-center justify-content-center">
        <div class="form-box w-100 p-4 bg-white">

            <div class="logo mb-2 text-center">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" width="40%" height="120px" />
            </div>

            <!-- الفورم -->
            <div class="container my-5" style="max-width: 400px;">
                <h5 class="mb-4 text-center">نسيت كلمة المرور</h5>
                <p class="text-muted text-center">
                    أدخل البريد الالكتروني الخاص بك واضغط ارسال ليصلك رمز التحقق على بريدك
                </p>
                <form id="forgotForm" action="{{ route('celebrity.forgot-password.send-otp') }}"   method="POST">
                    @csrf
                    <div class="d-flex justify-content-between gap-2 mb-4">
                        <div class="col-md-12">
                            <label class="form-label">البريد اللاكتروني </label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-login w-100">تحقق الآن</button>
                    <div id="otpMessage" class="mt-3 text-center"></div>

                    <div class="text-center mt-4">
                        لم يصلك الرمز؟ <a href="#">إعادة الإرسال</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- WhatsApp Button -->
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
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>


<script>
    $(document).ready(function () {
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

<script>
    $(document).ready(function () {
         $("form").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                }
            },
            messages: {
                email: {
                    required: "يرجى إدخال البريد الإلكتروني",
                    email: "صيغة البريد غير صحيحة"
                }
            },
            errorElement: 'span',
            errorClass: 'text-danger',
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            },
            submitHandler: function (form) {
                event.preventDefault();

                var formData = new FormData(form);
                $.ajax({
                    url: $(form).attr("action"),
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    beforeSend: function () {
                        $('.btn-login').text('جاري الإرسال...').attr('disabled', true);
                        $('#otpMessage').html('');
                    },
                    success: function (response) {
                        $('#otpMessage').html('<div class="text-success">تم إرسال الرمز إلى بريدك بنجاح.</div>');
                        $('.btn-login').text('تحقق الآن').attr('disabled', false);

                        setTimeout(() => {
                             window.location.href =  response.redirect;

                        }, 1500);
                    },
                    error: function (xhr) {
                        let message = 'حدث خطأ ما، حاول مرة أخرى.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        $('#otpMessage').html('<div class="text-danger">' + message + '</div>');
                        $('.btn-login').text('تحقق الآن').attr('disabled', false);
                    },


                });
            }
        });
    });
</script>


 </body>
</html>
