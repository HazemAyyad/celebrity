<div class="sidebar" id="sidebar">
    <button class="close-sidebar d-md-none" id="closeSidebar">
        <i class="fa-solid fa-xmark"></i>
    </button>

    <div class="logo">
        <img src="{{ asset('assets/images/logo.png') }}" width="50%" height="65px" alt="Logo" />
    </div>

    <a href="{{ route('celebrity.dashboard') }}"
       class="{{ request()->routeIs('celebrity.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-house-chimney-window mx-2"></i>الرئيسية</a>
    <a href="{{ route('celebrity.coupons.index') }}"
       class="{{ request()->routeIs('celebrity.coupons.index') ? 'active' : '' }}"><i class="fa-solid fa-gift mx-2"></i> كوبونات الخصم</a>
    <a href="#"><i class="fa-solid fa-receipt mx-2"></i> عقدي مع الشركة</a>
    <a href="#"><i class="fa-solid fa-gifts mx-2"></i> الميزات و الهدايا</a>
    <a href="{{ route('celebrity.edit-profile') }}"
       class="{{ request()->routeIs('celebrity.edit-profile') ? 'active' : '' }}">
        <i class="fa-solid fa-circle-user mx-2"></i> الملف الشخصي
    </a>
</div>
