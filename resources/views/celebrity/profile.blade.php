@extends('celebrity.layouts.app')

@section('title', 'الملف الشخصي')

@section('content')
    <div class="row mt-3 coupons">
        <div class="col-md-12 col-12 text-start">
            <h3 class="fw-bold">الملف الشخصي</h3>
        </div>

        <div class="container bg-white p-4 rounded shadow-sm my-3">
            <div class="form-section form-profile">
                <form method="POST" action="#">

                    <div class="row g-3">

                        <!-- صورة المستخدم (دائرية وقابلة للتغيير) -->
                        <div class="text-center mb-3">
                            <label class="avatar-wrapper" id="avatarLabel">
                                <img src="./images/Ellipse 7182.png" id="avatarPreview"
                                     class="avatar-preview" alt="الصورة الشخصية">
                                <div class="avatar-overlay">تغيير الصورة</div>
                                <input type="file" id="avatarInput" accept="image/*"
                                       onchange="loadAvatar(event)">
                            </label>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">اسم المستخدم</label>
                            <input type="text" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">رقم الجوال</label>
                            <input type="tel" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">الدولة</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">العنوان الوطني</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">نوع الحساب</label>
                            <select class="form-select">
                                <option selected disabled>اختر نوع الحساب</option>
                                <option value="user">مستخدم</option>
                                <option value="partner">شريك</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">حسابات السوشيال ميديا</label>
                            <div class="social-icons">
                                <a href="#" class="icon youtube"><i
                                        class="fab fa-youtube"></i></a>
                                <a href="#" class="icon twitter"><i
                                        class="fab fa-twitter"></i></a>
                                <a href="#" class="icon instagram"><i
                                        class="fab fa-instagram"></i></a>
                                <a href="#" class="icon facebook"><i
                                        class="fab fa-facebook-f"></i></a>
                                <a href="#" class="icon whatsapp"><i
                                        class="fab fa-whatsapp"></i></a>
                            </div>

                        </div>
                        <div class="col-12 mt-3 w-100 text-end">
                            <button type="submit "
                                    class="btn btn-login ">تعديل الملف الشخصي</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
@push('scripts')
    <script>
        // Bar Chart
        const ctx1 = document.getElementById("bookingsChart").getContext("2d");

        new Chart(ctx1, {
            type: "bar",
            data: {
                labels: [
                    "شهر 12", "شهر 11", "شهر 10", "شهر 9", "شهر 8", "شهر 7",
                    "شهر 6", "شهر 5", "شهر 4", "شهر 3", "شهر 2", "شهر 1"
                ],
                datasets: [
                    {
                        label: "حجوزات فنادق",
                        backgroundColor: "#008066",
                        data: [80, 90, 70, 85, 75, 100, 95, 90, 80, 60, 55, 70],
                        barThickness: 14
                    },
                    {
                        label: "حجوزات طيران",
                        backgroundColor: "#757575",
                        data: [60, 70, 60, 65, 55, 85, 80, 75, 70, 50, 45, 60],
                        barThickness: 14
                    },
                    {
                        label: "حجوزات خدمات",
                        backgroundColor: "#c19617",
                        data: [40, 50, 45, 55, 50, 70, 65, 60, 50, 40, 35, 45],
                        barThickness: 14
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: "top",
                        labels: {
                            usePointStyle: true,
                            font: { family: "Tahoma" }
                        }
                    },
                    tooltip: {
                        rtl: true,
                        bodyAlign: "right",
                        titleAlign: "right"
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: true,
                            color: "#e0e0e0",
                            borderWidth: 1
                        },
                        ticks: {
                            font: { family: "Tahoma" },
                            color: "#000"
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 20,
                            font: { family: "Tahoma" },
                            color: "#000"
                        },
                        grid: {
                            color: "#f0f0f0"
                        }
                    }
                }
            }
        });

    </script>

    <script>
        // Line Chart
        const ctx2 = document.getElementById("profitChart").getContext("2d");

        const gradient = ctx2.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(0, 128, 102, 0.2)');
        gradient.addColorStop(1, 'rgba(0, 128, 102, 0)');

        new Chart(ctx2, {
            type: "line",
            data: {
                labels: [
                    "شهر 12", "شهر 11", "شهر 10", "شهر 9", "شهر 8", "شهر 7",
                    "شهر 6", "شهر 5", "شهر 4", "شهر 3", "شهر 2", "شهر 1"
                ],
                datasets: [{
                    label: "الأرباح",
                    data: [60, 65, 70, 40, 95, 55, 50, 40, 75, 85, 80, 82],
                    fill: true,
                    backgroundColor: gradient,
                    borderColor: "#008066",
                    tension: 0.4,
                    pointRadius: function(ctx) {
                        return ctx.dataIndex === 8 ? 6 : 0;
                    },
                    pointBackgroundColor: "#fff",
                    pointBorderColor: "#008066",
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        rtl: true,
                        bodyAlign: "right",
                        titleAlign: "right"
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { family: "Tahoma" },
                            color: "#000"
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: "#f0f0f0"
                        },
                        ticks: {
                            font: { family: "Tahoma" },
                            color: "#000"
                        }
                    }
                }
            }
        });

    </script>
    <script>
        $(document).ready(function(){
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
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const menuToggle = document.getElementById("menuToggle");
            const sidebar = document.getElementById("sidebar");
            const closeBtn = document.getElementById("closeSidebar");

            menuToggle.addEventListener("click", function () {
                sidebar.classList.add("open");
                menuToggle.classList.add("d-none"); // إخفاء الزر عند الفتح
            });

            closeBtn.addEventListener("click", function () {
                sidebar.classList.remove("open");
                menuToggle.classList.remove("d-none"); // إظهاره عند الإغلاق
            });

            // إغلاق عند الضغط خارج القائمة
            document.addEventListener("click", function (e) {
                if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                    sidebar.classList.remove("open");
                    menuToggle.classList.remove("d-none"); // إظهار الزر
                }
            });
        });
    </script>
@endpush
