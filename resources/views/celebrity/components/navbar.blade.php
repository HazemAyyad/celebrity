<div class="top-bar">
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 d-md-none">
                <button class="mobile-menu-btn" id="menuToggle">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>

            <div class="col-10 d-md-none">
                <div class="input-group">
                    <input type="search" class="form-control" placeholder="عن ماذا تبحث ..." aria-label="Search">
                </div>
            </div>

            <div class="col-md-7 d-none d-md-block">
                <div class="input-group">
                    <input type="search" class="form-control" placeholder="عن ماذا تبحث ..." aria-label="Search">
                </div>
            </div>

            <div class="col-md-2 col-6">
                <div class="icons text-end">
                    <a href="#" class="notification-icon comment"><i class="fa-solid fa-comment-dots"></i><span class="notification-badge">3</span></a>
                    <a href="#" class="notification-icon bell"><i class="fa-solid fa-bell"></i><span class="notification-badge">5</span></a>
                    <a href="#" class="settings-icon gear"><i class="fa-solid fa-gear"></i><span class="notification-badge">1</span></a>
                </div>
            </div>


            <div class="col-md-3 col-6">
                <div class="dropdown text-end">
                    <button class="btn dropdown-toggle d-inline-flex align-items-center p-0" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ $celebrity->image ? asset('storage/' . $celebrity->image) : asset('assets/images/user.png') }}" class="user-icon me-2 rounded-circle" alt="User" width="40" height="40" />
                        مرحباً {{ $celebrity->name }}
                    </button>

                    <ul class="dropdown-menu text-end" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('celebrity.profile') }}">
                                <i class="fa-solid fa-user me-2"></i> الملف الشخصي
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('celebrity.logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger" type="submit">
                                    <i class="fa-solid fa-right-from-bracket me-2"></i> تسجيل الخروج
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
