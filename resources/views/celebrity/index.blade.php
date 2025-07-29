@extends('celebrity.layouts.app')

@section('title', 'لوحة المشاهير')

@section('content')
    <div class="row mt-3">
        <div class="col-md-6 col-6 text-start">
            <h3 class="fw-bold">إحصائياتي</h3>
        </div>
        <div class="col-md-6 col-6 text-end">
            <div class="dropdown text-end">
                <button class="btn dropdown-toggle" type="button" id="userDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    جميع الإحصائيات
                </button>
                <ul class="dropdown-menu text-end" aria-labelledby="userDropdown">
                    <li></li>
                </ul>
            </div>
        </div>

        <div class="row">

            {{-- بطاقة حجوزات الطيران --}}
            <div class="col-md-3 col-6 my-4">
                <div class="stats-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex align-items-center gap-1">
                <span class="growth-icon">
                    <i class="fa-solid {{ $flightGrowth >= 0 ? 'fa-arrow-trend-up text-success' : 'fa-arrow-trend-down text-danger' }}"></i>
                </span>
                            <span class="percentage">{{ number_format($flightGrowth, 1) }}%</span>
                        </div>
                        <div class="dots">•••</div>
                    </div>
                    <div class="mt-4 text-start">
                        <h6 class="mb-2">حجوزات الطيران</h6>
                        <div class="amount">+ {{ number_format($flightTotalAllTime) }} رس</div>
                        <small class="text-muted d-block">هذا الشهر: {{ number_format($flightTotalThisMonth) }} رس</small>
                        <small class="text-muted d-block">الشهر الماضي: {{ number_format($flightTotalLastMonth) }} رس</small>

                        {{-- أرباح المشهور --}}
                        <hr class="my-2">
                        <small class="text-success d-block fw-bold">ربحك هذا الشهر: {{ number_format($flightProfitThisMonth, 2) }} رس</small>
                        <small class="text-muted d-block">الشهر الماضي: {{ number_format($flightProfitLastMonth, 2) }} رس</small>
                        <small class="text-muted d-block">الإجمالي: {{ number_format($flightProfitAllTime, 2) }} رس</small>
                    </div>
                    <div class="ribbon"></div>
                </div>
            </div>

            {{-- بطاقة حجوزات الفنادق --}}
            <div class="col-md-3 col-6 my-4">
                <div class="stats-card yellow">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex align-items-center gap-1">
                <span class="growth-icon">
                    <i class="fa-solid {{ $hotelGrowth >= 0 ? 'fa-arrow-trend-up text-success' : 'fa-arrow-trend-down text-danger' }}"></i>
                </span>
                            <span class="percentage">{{ number_format($hotelGrowth, 1) }}%</span>
                        </div>
                        <div class="dots">•••</div>
                    </div>
                    <div class="mt-4 text-start">
                        <h6 class="mb-2">حجوزات الفنادق</h6>
                        <div class="amount">+ {{ number_format($hotelTotalAllTime) }} رس</div>
                        <small class="text-muted d-block">هذا الشهر: {{ number_format($hotelTotalThisMonth) }} رس</small>
                        <small class="text-muted d-block">الشهر الماضي: {{ number_format($hotelTotalLastMonth) }} رس</small>

                        {{-- أرباح المشهور --}}
                        <hr class="my-2">
                        <small class="text-success d-block fw-bold">ربحك هذا الشهر: {{ number_format($hotelProfitThisMonth, 2) }} رس</small>
                        <small class="text-muted d-block">الشهر الماضي: {{ number_format($hotelProfitLastMonth, 2) }} رس</small>
                        <small class="text-muted d-block">الإجمالي: {{ number_format($hotelProfitAllTime, 2) }} رس</small>
                    </div>
                    <div class="ribbon"></div>
                </div>
            </div>

            {{-- نسبة أرباح المشهور --}}
            <div class="col-md-3 col-6 my-4">
                <div class="stats-card purple">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex align-items-center gap-1">
                            <span class="growth-icon"><i class="fa-solid fa-percent text-primary"></i></span>
                            <span class="percentage">%</span>
                        </div>
                        <div class="dots">•••</div>
                    </div>
                    <div class="mt-4 text-start">
                        <h6 class="mb-2">نسبة أرباح المشهور</h6>
                        <div class="amount">طيران: {{ $flightProfitRatio }}%</div>
                        <div class="amount">فنادق: {{ $hotelProfitRatio }}%</div>
                    </div>
                    <div class="ribbon"></div>
                </div>
            </div>
            {{-- إجمالي أرباح المشهور --}}
            <div class="col-md-3 col-6 my-4">
                <div class="stats-card green">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex align-items-center gap-1">
                            <span class="growth-icon"><i class="fa-solid fa-sack-dollar text-success"></i></span>
                            <span class="percentage">+{{ number_format($totalProfitAllTime, 0) }} رس</span>
                        </div>
                        <div class="dots">•••</div>
                    </div>
                    <div class="mt-4 text-start">
                        <h6 class="mb-2">إجمالي أرباحك</h6>
                        <div class="amount">+ {{ number_format($totalProfitAllTime) }} رس</div>

                        <small class="text-muted d-block">هذا الشهر: {{ number_format($totalProfitThisMonth, 0) }} رس</small>
                        <small class="text-muted d-block">الشهر الماضي: {{ number_format($totalProfitLastMonth, 0) }} رس</small>
                    </div>
                    <div class="ribbon"></div>
                </div>
            </div>


        </div>

        <div class="container mt-5" dir="rtl">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">إجمالي الحجوزات</h5>
                <select class="form-select w-auto" style="min-width: 120px;">
                    <option selected>سنة 2025</option>
                    <option>2024</option>
                    <option>2023</option>
                </select>
            </div>

            <div style="height: 360px;">
                <canvas id="bookingsChart"></canvas>
            </div>
        </div>

        <div class="container mt-5" dir="rtl">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">إجمالي الأرباح</h5>
                <select class="form-select w-auto" style="min-width: 120px;">
                    <option selected>سنة 2025</option>
                    <option>2024</option>
                    <option>2023</option>
                </select>
            </div>

            <div style="height: 300px;">
                <canvas id="profitChart"></canvas>
            </div>
        </div>

    </div>
@endsection
@push('scripts')
    <script>
        const ctx1 = document.getElementById("bookingsChart").getContext("2d");

        new Chart(ctx1, {
            type: "bar",
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [
                    {
                        label: "حجوزات فنادق",
                        backgroundColor: "#008066",
                        data: {!! json_encode($hotelsData) !!},
                        barThickness: 14
                    },
                    {
                        label: "حجوزات طيران",
                        backgroundColor: "#757575",
                        data: {!! json_encode($flightsData) !!},
                        barThickness: 14
                    },
                    {{--{--}}
                    {{--    label: "حجوزات خدمات",--}}
                    {{--    backgroundColor: "#c19617",--}}
                    {{--    data: {!! json_encode($servicesData) !!},--}}
                    {{--    barThickness: 14--}}
                    {{--}--}}
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
        const hotelsData = @json($monthlyHotelProfits);
        const flightsData = @json($monthlyFlightProfits);
        const totalData = @json($monthlyProfits);
        const labelData = @json($monthlyLabels);
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
                labels: labelData,
                datasets: [
                    {
                        label: "إجمالي الأرباح",
                        data: totalData,
                        fill: true,
                        backgroundColor: 'rgba(0, 128, 102, 0.2)',
                        borderColor: "#008066",
                        tension: 0.4
                    },
                    {
                        label: "أرباح الفنادق",
                        data: hotelsData,
                        fill: false,
                        borderColor: "#0080ff",
                        backgroundColor: 'rgba(0, 128, 255, 0.2)',
                        tension: 0.4
                    },
                    {
                        label: "أرباح الطيران",
                        data: flightsData,
                        fill: false,
                        borderColor: "#ffa500",
                        backgroundColor: 'rgba(255, 165, 0, 0.2)',
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            font: { family: "Tahoma" },
                            color: "#000"
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
                        grid: { display: false },
                        ticks: {
                            font: { family: "Tahoma" },
                            color: "#000"
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: "#f0f0f0" },
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
