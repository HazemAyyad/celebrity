@component('mail::message')
    # مرحباً

    رمز التحقق الخاص بك هو:

    ## {{ $otpCode }}

    يرجى إدخاله في التطبيق لإتمام التسجيل.

    شكراً,<br>
    {{ config('app.name') }}
@endcomponent
