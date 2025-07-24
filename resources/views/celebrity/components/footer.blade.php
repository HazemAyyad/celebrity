<!-- WhatsApp Floating Button -->
<div class="whatsapp-float d-flex">
    <a href="https://wa.me/+966920029449" target="_blank">
        <img src="{{ asset('assets/images/whatsapp.png') }}" alt="WhatsApp" />
    </a>
</div>

<!-- Scripts -->
{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>--}}
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>

{{-- Scripts for Charts and Sidebar toggle (انقلهم هنا) --}}
@stack('scripts')
