
    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <!-- Toastr script -->
    <script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>
    <!-- sweetalert script -->
    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>
    @yield('js-plugin')
    <script type="text/javascript">
    toastr.options = {
      "closeButton": false,
      "debug": false,
      "progressBar": true,
      "preventDuplicates": true,
      "positionClass": "toast-top-right",
      "showDuration": "400",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }
    </script>
    @yield('js-custom')

</body>

</html>
