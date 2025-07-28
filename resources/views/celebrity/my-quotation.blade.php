@extends('celebrity.layouts.app')

@section('title', 'عقدي مع الشركة')

@section('content')
    <div class="row mt-3 coupons">
        <div class="col-md-6 col-6 text-start">
            <h3 class="fw-bold">عقدي مع الشركة</h3>
        </div>
        <div class="col-md-6 col-6 text-end">
            <h5 class="fw-bold text-danger">
                <a class="fw-bold text-danger" href="https://api.whatsapp.com/send?phone=966920029449" target="_blank">
                    طلب دعم / مراجعة
                </a>

            </h5>
        </div>

        <div class="container bg-white p-4 rounded shadow-sm my-3">
            <section class="container py-5">
                <div class="ratio ratio-16x9 border">
                    <iframe src="{{ $celebrity->my_quotation ? asset('storage/' . $celebrity->my_quotation) : asset('assets/images/hotel-quotation-5000.pdf') }}" allowfullscreen></iframe>
                </div>
            </section>
        </div>
    </div>

@endsection
@push('scripts')

@endpush
