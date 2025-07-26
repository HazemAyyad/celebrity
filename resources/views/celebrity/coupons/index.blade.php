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
                    <th>الرقم</th>
                    <th>الاسم</th>
                    <th>قيمة الكوبون</th>
                    <th>وصف</th>
                    <th>الحالة</th>
                    <th>تاريخ الإضافة</th>
                    <th>تاريخ الانتهاء</th>
                    <th>المتبقي</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>15975</td>
                    <td>كورون أحمد</td>
                    <td>خصم %50 على رحلات الطيران</td>
                    <td>هنا توضع نص افتراضي</td>
                    <td><span class="badge-status badge-hali">حالي</span></td>
                    <td>20-05-2021</td>
                    <td>20-05-2021</td>
                    <td>5 أيام</td>
                </tr>
                <tr>
                    <td>15975</td>
                    <td>كورون أحمد</td>
                    <td>خصم %50 على رحلات الطيران</td>
                    <td>هنا توضع نص افتراضي</td>
                    <td><span class="badge-status badge-multghi">ملغي</span></td>
                    <td>20-05-2021</td>
                    <td>20-05-2021</td>
                    <td>5 أيام</td>
                </tr>
                <tr>
                    <td>15975</td>
                    <td>كورون أحمد</td>
                    <td>خصم %50 على رحلات الطيران</td>
                    <td>هنا توضع نص افتراضي</td>
                    <td><span class="badge-status badge-montahi">منتهي</span></td>
                    <td>20-05-2021</td>
                    <td>20-05-2021</td>
                    <td>5 أيام</td>
                </tr>
                <tr>
                    <td>15975</td>
                    <td>كورون أحمد</td>
                    <td>خصم %50 على رحلات الطيران</td>
                    <td>هنا توضع نص افتراضي</td>
                    <td><span class="badge-status badge-hali">حالي</span></td>
                    <td>20-05-2021</td>
                    <td>20-05-2021</td>
                    <td>5 أيام</td>
                </tr>
                <tr>
                    <td>15975</td>
                    <td>كورون أحمد</td>
                    <td>خصم %50 على رحلات الطيران</td>
                    <td>هنا توضع نص افتراضي</td>
                    <td><span class="badge-status badge-multghi">ملغي</span></td>
                    <td>20-05-2021</td>
                    <td>20-05-2021</td>
                    <td>5 أيام</td>
                </tr>
                <tr>
                    <td>15975</td>
                    <td>كورون أحمد</td>
                    <td>خصم %50 على رحلات الطيران</td>
                    <td>هنا توضع نص افتراضي</td>
                    <td><span class="badge-status badge-montahi">منتهي</span></td>
                    <td>20-05-2021</td>
                    <td>20-05-2021</td>
                    <td>5 أيام</td>
                </tr>
                <tr>
                    <td>15975</td>
                    <td>كورون أحمد</td>
                    <td>خصم %50 على رحلات الطيران</td>
                    <td>هنا توضع نص افتراضي</td>
                    <td><span class="badge-status badge-hali">حالي</span></td>
                    <td>20-05-2021</td>
                    <td>20-05-2021</td>
                    <td>5 أيام</td>
                </tr>
                <tr>
                    <td>15975</td>
                    <td>كورون أحمد</td>
                    <td>خصم %50 على رحلات الطيران</td>
                    <td>هنا توضع نص افتراضي</td>
                    <td><span class="badge-status badge-multghi">ملغي</span></td>
                    <td>20-05-2021</td>
                    <td>20-05-2021</td>
                    <td>5 أيام</td>
                </tr>
                <tr>
                    <td>15975</td>
                    <td>كورون أحمد</td>
                    <td>خصم %50 على رحلات الطيران</td>
                    <td>هنا توضع نص افتراضي</td>
                    <td><span class="badge-status badge-montahi">منتهي</span></td>
                    <td>20-05-2021</td>
                    <td>20-05-2021</td>
                    <td>5 أيام</td>
                </tr>
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
            $(document).ready(function () {
                $('#couponsTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route("celebrity.get-coupons") }}',
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                        { data: 'name', name: 'name' },
                        { data: 'value', name: 'value' },
                        { data: 'description', name: 'description' },
                        { data: 'status', name: 'status' },
                        { data: 'created_at', name: 'created_at' },
                        { data: 'expire_at', name: 'expire_at' },
                        { data: 'remaining_days', name: 'remaining_days', orderable: false, searchable: false }
                    ],
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
                    lengthChange: false,
                    scrollX: true
                });
            });

        });
    </script>
@endpush
