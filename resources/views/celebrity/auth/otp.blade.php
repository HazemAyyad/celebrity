<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>كلمة المرور</title>
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}" type="image/x-icon" />

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/media.css') }}" />

    <style>
        .otp-input {
            width: 50px;
            font-size: 2rem;
            text-align: center;
        }
    </style>
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
        <img src="{{ asset('assets/images/confirmation-code.png') }}" width="90%" height="500px" alt="Login Image" />
    </div>

    <!-- النصف الثاني: الفورم -->
    <div class="col-md-6 col-12 d-flex align-items-center justify-content-center">
        <div class="form-box w-100 p-4 bg-white">
            <div class="logo mb-2 text-center">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" width="40%" height="120px" />
            </div>

            <!-- الفورم -->
            <div class="container my-5" style="max-width: 400px;">
                <h5 class="mb-4 text-center">كود تأكيد إنشاء حساب</h5>
                <p class="text-muted text-center">أدخل رمز التحقق المكون من 5 خانات الذي تم إرساله إلى بريدك الإلكتروني.</p>
                @if(app()->isLocal() && !empty($otp))
                    <div class="alert alert-info text-center">
                        <strong>كود التطوير:</strong> {{ $otp }}
                    </div>
                @endif

                <form id="otpForm" method="POST" action="{{ route('celebrity.verify-otp') }}">
                    @csrf
                    <input type="hidden" name="celebrity_id" value="{{ request('user') }}">

                    <div class="d-flex justify-content-between gap-2 mb-4">
                        <input type="text" maxlength="1" name="otp[]" class="form-control otp-input" required autocomplete="off" inputmode="numeric" pattern="[0-9]*">
                        <input type="text" maxlength="1" name="otp[]" class="form-control otp-input" required autocomplete="off" inputmode="numeric" pattern="[0-9]*">
                        <input type="text" maxlength="1" name="otp[]" class="form-control otp-input" required autocomplete="off" inputmode="numeric" pattern="[0-9]*">
                        <input type="text" maxlength="1" name="otp[]" class="form-control otp-input" required autocomplete="off" inputmode="numeric" pattern="[0-9]*">
                        <input type="text" maxlength="1" name="otp[]" class="form-control otp-input" required autocomplete="off" inputmode="numeric" pattern="[0-9]*">
                    </div>
                    <input type="hidden" name="user_id" value="{{ request('user') }}">
                    <button type="submit" class="btn btn-login w-100">تحقق الآن</button>
                </form>
                <div id="otpMessage" class="mt-3 text-center"></div>
                <form   method="POST" style="display: inline;">
                    @csrf
                    <input type="hidden" name="celebrity_id" value="{{ $celebrity->id }}">
                    <input type="hidden" name="type" value="email"> {{-- أو "phone" حسب السياق --}}
                    <button type="button" id="resendOtpBtn" class="btn btn-link">إعادة إرسال رمز التحقق</button>
                </form>
                    <div id="resendMessage" class="mt-2 text-center"></div>
            </div>
        </div>
    </div>
</div>

<!-- WhatsApp -->
<div class="whatsapp-float d-flex">
    <a href="https://wa.me/+966920029449" target="_blank">
        <img src="{{ asset('assets/images/whatsapp.png') }}" alt="WhatsApp" />
    </a>
</div>

<!-- JS -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>

<script>
    $(document).ready(function () {
        // تنقل تلقائي للخانة التالية عند كتابة رقم
        $('.otp-input').on('input', function () {
            const $this = $(this);
            if ($this.val().length === 1) {
                $this.next('.otp-input').focus();
            }
        });

        // دعم اللصق (paste) لتعبئة كل الخانات مرة واحدة
        $('.otp-input').on('paste', function (e) {
            e.preventDefault();
            const pasteData = e.originalEvent.clipboardData.getData('text').trim();
            if (pasteData.length === 5 && /^[0-9]+$/.test(pasteData)) {
                const inputs = $('.otp-input');
                for (let i = 0; i < 5; i++) {
                    $(inputs[i]).val(pasteData[i]);
                }
                $(inputs[4]).focus();
            }
        });

        // إرسال الفورم عبر AJAX
        $('#otpForm').submit(function (e) {
            e.preventDefault();

            let otpValues = [];
            $('.otp-input').each(function () {
                otpValues.push($(this).val());
            });

            if (otpValues.some(val => val === "")) {
                $('#otpMessage').html('<div class="text-danger">يرجى تعبئة جميع خانات الرمز.</div>');
                return;
            }

            let formData = $(this).serialize();

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                beforeSend: function () {
                    $('.btn-login').text('جاري التحقق...').attr('disabled', true);
                    $('#otpMessage').html('');
                },
                success: function (response) {
                    if (response.status === 'success') {
                        $('#otpMessage').html('<div class="text-success">تم التحقق بنجاح! جاري التحويل...</div>');
                        setTimeout(() => {
                            window.location.href = response.redirect_url ?? '/celebrity/dashboard';
                        }, 1500);
                    } else {
                        $('#otpMessage').html('<div class="text-danger">' + (response.message || 'رمز التحقق غير صحيح') + '</div>');
                        $('.btn-login').text('تحقق الآن').attr('disabled', false);
                    }
                },
                error: function () {
                    $('#otpMessage').html('<div class="text-danger">حدث خطأ في التحقق، حاول مرة أخرى.</div>');
                    $('.btn-login').text('تحقق الآن').attr('disabled', false);
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#resendOtpBtn').click(function () {
            let celebrityId = $('input[name="celebrity_id"]').val();

            $.ajax({
                url: "{{ route('celebrity.resendOtp') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    celebrity_id: celebrityId
                },
                beforeSend: function () {
                    $('#resendOtpBtn').attr('disabled', true).text('جاري الإرسال...');
                    $('#resendMessage').html('');
                },
                success: function (response) {
                    if (response.status === 'success') {
                        // عرض رسالة النجاح
                        $('#resendMessage').html('<div class="text-success">' + response.message + '</div>');

                        // لو في بيئة التطوير حدث كود الـ OTP المعروض (div.alert)
                        @if(app()->isLocal())
                        // تحديث الكود داخل الـ alert
                        $('.alert.alert-info strong').text('كود التطوير:');
                        $('.alert.alert-info').html('<strong>كود التطوير:</strong> ' + response.new_otp);
                        @endif

                        // اخفاء رسالة الإرسال بعد 3 ثواني
                        setTimeout(function () {
                            $('#resendMessage').fadeOut('slow', function () {
                                $(this).html('').show();
                            });
                        }, 3000);
                    } else {
                        $('#resendMessage').html('<div class="text-danger">' + (response.message || 'حدث خطأ') + '</div>');
                    }
                    $('#resendOtpBtn').attr('disabled', false).text('إعادة إرسال رمز التحقق');
                },
                error: function (xhr) {
                    let errMsg = 'حدث خطأ، حاول مرة أخرى.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errMsg = xhr.responseJSON.message;
                    }
                    $('#resendMessage').html('<div class="text-danger">' + errMsg + '</div>');
                    $('#resendOtpBtn').attr('disabled', false).text('إعادة إرسال رمز التحقق');
                }
            });
        });
    });

</script>

</body>
</html>
