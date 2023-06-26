<!-- Back-to-top -->
<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>
<!-- JQuery min js -->
<script src="{{URL::asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap Bundle js -->
<script src="{{URL::asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- Ionicons js -->
<script src="{{URL::asset('assets/plugins/ionicons/ionicons.js')}}"></script>
<!-- Moment js -->
<script src="{{URL::asset('assets/plugins/moment/moment.js')}}"></script>

<!-- Rating js-->
<script src="{{URL::asset('assets/plugins/rating/jquery.rating-stars.js')}}"></script>
<script src="{{URL::asset('assets/plugins/rating/jquery.barrating.js')}}"></script>

<!--Internal  Perfect-scrollbar js -->
<script src="{{URL::asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/perfect-scrollbar/p-scroll.js')}}"></script>
<!--Internal Sparkline js -->
<script src="{{URL::asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js')}}"></script>
<!-- Custom Scroll bar Js-->
<script src="{{URL::asset('assets/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<!-- right-sidebar js -->
<script src="{{URL::asset('assets/plugins/sidebar/sidebar-rtl.js')}}"></script>
<script src="{{URL::asset('assets/plugins/sidebar/sidebar-custom.js')}}"></script>
<!-- Eva-icons js -->
<script src="{{URL::asset('assets/js/eva-icons.min.js')}}"></script>
@yield('js')
<!-- Sticky js -->
<script src="{{URL::asset('assets/js/sticky.js')}}"></script>
<!-- custom js -->
<script src="{{URL::asset('assets/js/custom.js')}}"></script><!-- Left-menu js-->
<script src="{{URL::asset('assets/plugins/side-menu/sidemenu.js')}}"></script>
<script>
        var id = localStorage.getItem('id');
        var materialLink = document.getElementById('material-link');
        materialLink.href = materialLink.href + '/' + id;

        var purchaseLink = document.getElementById('purchase-link');
        purchaseLink.href = purchaseLink.href + '/' + id;

        var paymentLink = document.getElementById('payment-link');
        paymentLink.href = paymentLink.href + '/' + id;

        var commandLink = document.getElementById('command-link');
        commandLink.href = commandLink.href + '/' + id;

        var receiptLink = document.getElementById('receipt-link');
        receiptLink.href = receiptLink.href + '/' + id;

        var catchLink = document.getElementById('catch-link');
        catchLink.href = catchLink.href + '/' + id;

        var commandcatchLink = document.getElementById('commandcatch-link');
        commandcatchLink.href = commandcatchLink.href + '/' + id;
</script>
<script>
    var id = localStorage.getItem('id');
    var receipt = document.getElementById('receipt-order');
    receipt.href = receipt.href + '/' + id;

    var receiptCommand = document.getElementById('receipt-command');
    receiptCommand.href = receiptCommand.href + '/' + id;

    var receiptCatch = document.getElementById('receipt-catch');
    receiptCatch.href = receiptCatch.href + '/' + id;

    var commandCatch = document.getElementById('command-catch');
    commandCatch.href = commandCatch.href + '/' + id;

    var accountant = document.getElementById('accountant');
    accountant.href = accountant.href + '/' + id;

    var accountantReceipt = document.getElementById('accountant-receipt');
    accountantReceipt.href = accountantReceipt.href + '/' + id;

    var accountantCatch = document.getElementById('accountant-catch');
    accountantCatch.href = accountantCatch.href + '/' + id;

    var accountcommandCatch = document.getElementById('accountcommand-catch');
    accountcommandCatch.href = accountcommandCatch.href + '/' + id;

    var finance = document.getElementById('finance');
    finance.href = finance.href + '/' + id;

    var financeCommand = document.getElementById('finance-command');
    financeCommand.href = financeCommand.href + '/' + id;

    var financeReceipt = document.getElementById('finance-receipt');
    financeReceipt.href = financeReceipt.href + '/' + id;

    var financeCatch = document.getElementById('finance-catch');
    financeCatch.href = financeCatch.href + '/' + id;

    var financeCommandCatch = document.getElementById('finance-command-catch');
    financeCommandCatch.href = financeCommandCatch.href + '/' + id;
</script>
