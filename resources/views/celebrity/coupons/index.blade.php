@extends('celebrity.layouts.app')

@section('title', 'الملف الشخصي')

@section('content')
    <div class="row mt-3 coupons">
        <div class="col-md-6 col-6 text-start">
            <h3 class="fw-bold">كوبونات الخصم</h3>
        </div>
        <div class="col-md-6 col-6 text-end">
            <div class="dropdown text-end">
                <button class="btn dropdown-toggle" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    جميع الإحصائيات
                </button>
                <ul class="dropdown-menu text-end">
                    <li><a class="dropdown-item" href="#">إحصائيات اليوم</a></li>
                    <li><a class="dropdown-item" href="#">إحصائيات الأسبوع</a></li>
                    <li><a class="dropdown-item" href="#">إحصائيات الشهر</a></li>
                </ul>

            </div>
        </div>

        <div class="container bg-white p-4 rounded shadow-sm">
            <h5 class="mb-4 text-start">سجلات الكوبونات</h5>

            <table id="couponsTable" class="table table-striped"
                   style="width:100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                     <th>وصف</th>
                     <th>الكود</th>
                    <th>قيمة الكوبون</th>
                    <th>النوع</th>
                    <th>قيمة الفنادق</th>
                    <th>قيمة الطيران</th>
                    <th>قيمة الباقات</th>
                    <th>الحالة</th>
                    <th>تاريخ الإضافة</th>
                    <th>تاريخ الانتهاء</th>
                    <th>المتبقي</th>
                </tr>
                </thead>
                <tbody>
                @foreach($coupons as $coupon)
                    <tr>
                        <td># {{$coupon->id}}</td>
                        <td>{{$coupon->name??'-'}}</td>
                        <td>{{$coupon->descriptoion??'-'}}</td>
                        <td>{{$coupon->code}}</td>
                        <td>{{$coupon->value}}</td>
                        <td>{{ $coupon->type == 'percentage' ? 'نسبة مئوية' : 'مبلغ ثابت' }}</td>
                        <td>{{ $coupon->getDiscountLabel(\App\Enums\Couponable::Hotels) }}</td>
                        <td>{{ $coupon->getDiscountLabel(\App\Enums\Couponable::Flights) }}</td>
                        <td>{{ $coupon->getDiscountLabel(\App\Enums\Couponable::Packages) }}</td>
                        <td>
                            <span class="badge-status badge-{{$coupon->active==1?'montahi':'multghi'}}">{{$coupon->active==1?'فعال':'غير فعال'}}</span>
                        </td>
                        <td>{{ optional($coupon->created_at)->format('Y-m-d') }}</td>
                        <td>{{ optional($coupon->end_date)->format('Y-m-d') ?? '—' }}</td>

                        <td>{{ $coupon->remaining_time }}</td>
                    </tr>
                @endforeach


                </tbody>
            </table>
        </div>
    </div>

@endsection
@push('scripts')
    <script
        src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script
        src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#couponsTable').DataTable({
                language: {
                    search: "بحث:",
                    paginate: {
                        first: "الأول",
                        last: "الأخير",
                        next: "التالي",
                        previous: "السابق"
                    },
                    lengthMenu: "عرض _MENU_ سجلات",
                    info: "عرض _START_ إلى _END_ من أصل _TOTAL_ سجل",
                    infoEmpty: "لا توجد سجلات",
                    zeroRecords: "لم يتم العثور على نتائج",
                    emptyTable: "لا توجد بيانات متاحة في الجدول",
                },
                pagingType: "full_numbers",
                info: false,
                lengthChange: false,
                scrollX: true,
            });
        });
    </script>
@endpush
