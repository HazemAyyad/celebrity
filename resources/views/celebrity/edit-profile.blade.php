@extends('celebrity.layouts.app')

@section('title', 'الملف الشخصي')

@section('content')
    <div class="row mt-3 coupons">
        <div class="col-md-12 col-12 text-start">
            <h3 class="fw-bold">الملف الشخصي</h3>
        </div>

        <div class="container bg-white p-4 rounded shadow-sm my-3">
            <div class="form-section form-profile">

                <form method="POST" id="profileForm" action="{{ route('celebrity.save-profile',$celebrity->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">

                        <!-- صورة المستخدم -->
                        <div class="text-center mb-3">
                            <label class="avatar-wrapper" id="avatarLabel">
                                <img src="{{ asset('storage/' .$celebrity->image) }}" id="avatarPreview"
                                     class="avatar-preview" alt="الصورة الشخصية">
                                <div class="avatar-overlay">تغيير الصورة</div>
                                <input type="file" name="image" id="avatarInput" accept="image/*"
                                       onchange="loadAvatar(event)">
                            </label>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">اسم المستخدم</label>
                            <input type="text" name="name" class="form-control" value="{{ $celebrity->name }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control"  value="{{ $celebrity->email }}" required>
                        </div>


                        <div class="col-md-6">
                            <label class="form-label">رقم الجوال</label>
                            <input type="tel" name="phone" class="form-control" value="{{ $celebrity->phone }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">الدولة</label>
                            <select class="form-select select2"  name="country_id" id="country_id">
                                <option value="" >اختر الدولة </option>
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}" {{$celebrity->id==$country->id?'selected':''}} >
                                        {{$country->country_name .'-'.$country->city_name}}
                                    </option>

                                @endforeach

                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">العنوان الوطني</label>
                            <input type="text" name="address" value="{{$celebrity->address}}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">نوع الحساب</label>
                            <select class="form-select" name="account_type">
                                <option selected disabled>اختر نوع الحساب</option>
                                <option value="normal" {{$celebrity->account_type=='normal'?'selected':''}}>مستخدم</option>
                                <option value="influencer" {{$celebrity->account_type=='influencer'?'selected':''}}>حساب مشاهير</option>
                            </select>
                        </div>
                        @php
                            $socialLinks = json_decode($celebrity->social_links, true);
                        @endphp
                        <div class="col-md-6">
                            <label class="form-label">فيسبوك</label>
                            <input type="text" name="facebook" value="{{ $socialLinks['facebook'] ??null}}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">تويتر</label>
                            <input type="text" name="twitter" value="{{ $socialLinks['twitter'] ??null}}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">إنستغرام</label>
                            <input type="text" name="instagram" value="{{ $socialLinks['instagram'] ??null}}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">سناب شات</label>
                            <input type="text" name="snapchat" value="{{ $socialLinks['snapchat'] ??null}}" class="form-control">
                        </div>



                        <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-login">تعديل الملف الشخصي</button>
                        </div>
                    </div>
                </form>


            </div>
        </div>

    </div>
@endsection
@push('scripts')
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
        $(document).ready(function () {
            // تفعيل الفاليديشن
            $("#profileForm").validate({
                rules: {
                    name: "required",
                    email: {
                        required: true,
                        email: true
                    },
                    phone: "required",
                    account_type: "required",

                },
                messages: {
                    name: "الرجاء إدخال اسم المستخدم",
                    email: {
                        required: "الرجاء إدخال البريد الإلكتروني",
                        email: "البريد غير صحيح"
                    },
                    phone: "الرجاء إدخال رقم الجوال",
                    account_type: "اختر نوع الحساب",

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
                            $('.btn-login').text('جاري الحفظ...').attr('disabled', true);
                        },
                        success: function (response) {
                            if (response.status === 'success') {
                                toastr.success(response.message, 'تم بنجاح');
                            } else {
                                toastr.error(response.message || 'حدث خطأ غير متوقع', 'خطأ');
                            }
                        },
                        error: function (xhr) {
                            let message = "فشل الإرسال. حاول مرة أخرى.";

                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                // استخراج أول خطأ من الفاليديشن
                                let errors = xhr.responseJSON.errors;
                                let firstError = Object.values(errors)[0][0];
                                message = firstError;
                            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            }

                            toastr.error(message, 'خطأ');
                        },

                        complete: function () {
                            $('.btn-login').text('تعديل الملف الشخصي').attr('disabled', false);
                        }
                    });

                    return false;
                }
            });
        });
        $('#country_id').select2({
            placeholder: "اختر الدولة",
            allowClear: true,
            dir: "rtl", // لأن الصفحة بالعربية
            width: '100%' // ليأخذ عرض العنصر بالكامل
        });

    </script>
@endpush
