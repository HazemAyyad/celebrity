<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>تسجيل الدخول</title>
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}" type="image/x-icon" />

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/media.css') }}" />
    <style>
        .is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.875em;
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

<div class="register-container">
    <div class="container">
        <div class="form-section">
            <form method="POST" action="{{ route('celebrity.register') }}" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">

                    <!-- صورة المستخدم -->
                    <div class="text-center mb-3">
                        <label class="avatar-wrapper" id="avatarLabel">
                            <img src="{{ asset('assets/images/Ellipse 7182.png') }}" id="avatarPreview"
                                 class="avatar-preview" alt="الصورة الشخصية">
                            <div class="avatar-overlay">تغيير الصورة</div>
                            <input type="file" name="image" id="avatarInput" accept="image/*"
                                   onchange="loadAvatar(event)">
                        </label>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">اسم المستخدم</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">كلمة المرور</label>
                        <input type="password" name="password" class="form-control" required minlength="6">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">تأكيد كلمة المرور</label>
                        <input type="password" name="password_confirmation" class="form-control" required equalTo="[name='password']">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">رقم الجوال</label>
                        <input type="tel" name="phone" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">الدولة</label>
                        <select class="form-select select2"  name="country_id" id="country_id">
                            <option value="" >اختر الدولة </option>
                            @foreach($countries as $country)
                                <option value="{{$country->id}}" >
                                    {{$country->country_name .'-'.$country->city_name}}
                                </option>

                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">العنوان الوطني</label>
                        <input type="text" name="address" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">نوع الحساب</label>
                        <select class="form-select" name="account_type">
                            <option selected disabled>اختر نوع الحساب</option>
                            <option value="normal">مستخدم</option>
                            <option value="influencer">حساب مشاهير</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">فيسبوك</label>
                        <input type="text" name="facebook" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">تويتر</label>
                        <input type="text" name="twitter" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">إنستغرام</label>
                        <input type="text" name="instagram" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">سناب شات</label>
                        <input type="text" name="snapchat" class="form-control">
                    </div>

                    <div class="col-12">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="is_partner" id="partnerCheck">
                            <label class="form-check-label" for="partnerCheck">
                                التسجيل كشريك
                            </label>
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <button type="submit" class="btn btn-login">إنشاء حساب</button>
                    </div>
                </div>
            </form>
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
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- معاينة الصورة -->
<script>
    function loadAvatar(event) {
        const input = event.target;
        const preview = document.getElementById('avatarPreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<script>
    $('#country_id').select2({
        placeholder: "اختر الدولة",
        allowClear: true,
        theme: "bootstrap-5",

        dir: "rtl", // لأن الصفحة بالعربية
        width: '100%' // ليأخذ عرض العنصر بالكامل
    });

    $(document).ready(function () {
        // تفعيل الفاليديشن
        $("form").validate({
            rules: {
                name: "required",
                email: {
                    required: true,
                    email: true
                },
                phone: "required",
                account_type: "required",
                password: {
                    required: true,
                    minlength: 6
                },
                password_confirmation: {
                    required: true,
                    equalTo: "[name='password']"
                }
            },
            messages: {
                name: "الرجاء إدخال اسم المستخدم",
                email: {
                    required: "الرجاء إدخال البريد الإلكتروني",
                    email: "البريد غير صحيح"
                },
                phone: "الرجاء إدخال رقم الجوال",
                account_type: "اختر نوع الحساب",
                password: {
                    required: "يرجى إدخال كلمة المرور",
                    minlength: "كلمة المرور يجب أن تكون 6 أحرف على الأقل"
                },
                password_confirmation: {
                    required: "يرجى تأكيد كلمة المرور",
                    equalTo: "كلمة المرور غير متطابقة"
                }
            },
            messages: {
                name: "الرجاء إدخال اسم المستخدم",
                email: {
                    required: "الرجاء إدخال البريد الإلكتروني",
                    email: "البريد غير صحيح"
                },
                phone: "الرجاء إدخال رقم الجوال",
                account_type: "اختر نوع الحساب"
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
            submitHandler: function (form, event) {
                event.preventDefault();

                var formData = new FormData(form);

                $.ajax({
                    url: $(form).attr("action"),
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    beforeSend: function () {
                        $('.btn-login').text('جاري الإرسال...').attr('disabled', true);
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            window.location.href = `/celebrity/otp?user=${response.user_id}`;
                        } else {
                            alert("حدث خطأ: " + response.message);
                        }
                    },
                    error: function (xhr) {
                        alert("فشل الإرسال. حاول مرة أخرى.");
                    },
                    complete: function () {
                        $('.btn-login').text('إنشاء حساب').attr('disabled', false);
                    }
                });

                return false;
            }
        });
    });
</script>

</body>
</html>
