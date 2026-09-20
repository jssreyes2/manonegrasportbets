<!-- jQuery -->
<script type="text/javascript" src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

<!-- Setup CSRF Token -->
<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>

<!-- jQuery UI -->
<script type="text/javascript" src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>

<!-- jQuery Validate -->
<script type="text/javascript" src="{{ asset('js/jquery.validate.js') }}"></script>

<!-- Bootstrap -->
<script type="text/javascript" src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Toastr -->
<script type="text/javascript" src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

<!-- Custom Scripts -->
<script type="text/javascript" src="{{ asset('js/scripts/auth.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/scripts/banner.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/scripts/app.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/scripts/freelancers.js') }}"></script>
