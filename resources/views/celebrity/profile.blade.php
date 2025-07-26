@extends('celebrity.layouts.app')

@section('title', 'الملف الشخصي')

@section('content')
    <div class="row mt-3 coupons">
        <div class="col-md-12 col-12 text-start">
            <h3 class="fw-bold">الملف الشخصي</h3>
        </div>

        <div class="container bg-white p-4 rounded shadow-sm my-3">
            <div class="form-section form-profile">

                    <div class="row g-3">

                        <!-- صورة المستخدم (دائرية وقابلة للتغيير) -->
                        <div class="text-center mb-3">
                            <label class="avatar-wrapper" id="avatarLabel">
                                <img src="{{ asset('storage/' .$celebrity->image) }}" id="avatarPreview"
                                     class="avatar-preview" alt="الصورة الشخصية">
                            </label>
                        </div>


                        <div class="col-md-6">
                            <label class="form-label">اسم المستخدم</label>
                            <input type="text" class="form-control" value="{{ $celebrity->name }}" disabled>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control" value="{{ $celebrity->email }}" disabled>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">رقم الجوال</label>
                            <input type="tel" class="form-control" value="{{ $celebrity->phone }}" disabled>
                        </div>


                        <div class="col-md-6">
                            <label class="form-label">الدولة</label>
                            <select class="form-select" disabled>
                                <option selected disabled>اختر الدولة </option>
                                @foreach($countries as $country)
                                    <option value="normal" {{$country->id==$celebrity->country_id?'selected':''}}>
                                        {{$country->country_name .'-'.$country->city_name}}
                                    </option>

                                @endforeach

                            </select>
                         </div>

                        <div class="col-md-6">
                            <label class="form-label">العنوان الوطني</label>
                            <input type="text" class="form-control" value="{{ $celebrity->address }}" disabled>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">نوع الحساب</label>
                            <select class="form-select" disabled>
                                <option selected disabled>اختر نوع الحساب</option>
                                <option value="normal" {{$celebrity->account_type=='normal'?'selected':''}}>مستخدم</option>
                                <option value="influencer" {{$celebrity->account_type=='influencer'?'selected':''}}>حساب مشاهير</option>
                            </select>
                        </div>

                        @php
                            $socialLinks = json_decode($celebrity->social_links, true);
                        @endphp

                        <div class="col-md-12">
                            <label class="form-label">حسابات السوشيال ميديا</label>
                            <div class="social-icons">
                                @if (!empty($socialLinks['youtube']))
                                    <a href="{{ $socialLinks['youtube'] }}" target="_blank" class="icon youtube">
                                        <i class="fab fa-youtube"></i>
                                    </a>
                                @endif
                                @if (!empty($socialLinks['twitter']))
                                    <a href="{{ $socialLinks['twitter'] }}" target="_blank" class="icon twitter">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                @endif
                                @if (!empty($socialLinks['instagram']))
                                    <a href="{{ $socialLinks['instagram'] }}" target="_blank" class="icon instagram">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                @endif
                                @if (!empty($socialLinks['facebook']))
                                    <a href="{{ $socialLinks['facebook'] }}" target="_blank" class="icon facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                @endif
                                @if (!empty($socialLinks['whatsapp']))
                                    <a href="https://wa.me/{{ $socialLinks['whatsapp'] }}" target="_blank" class="icon whatsapp">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                @endif
                                @if (!empty($socialLinks['snapchat']))
                                    <a href="{{ $socialLinks['snapchat'] }}" target="_blank" class="icon snapchat">
                                        <i class="fab fa-snapchat"></i>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="col-12 mt-3 w-100 text-end">
                            <a href="{{route('celebrity.edit-profile')}}"
                                    class="btn btn-login ">تعديل الملف الشخصي</a>
                        </div>
                    </div>

            </div>
        </div>

    </div>
@endsection
@push('scripts')

@endpush
