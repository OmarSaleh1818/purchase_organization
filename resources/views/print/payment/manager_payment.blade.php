@extends('layouts.master')
@section('css')
    <style>
        @media print {
            #print_Button {
                display: none;
            }
        }
    </style>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المدير العام</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/طباعة طلبات اصدار دفعة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-md-12 col-xl-12">
            <div class=" main-content-body-invoice" id="print">
                <div class="card card-invoice">
                    <div class="card-body">
                        <div class="invoice-header">
                            <h1 class="invoice-title">طلب اصدار دفعة</h1>
                            <div class="billed-from">
                                <h3>{{ $payment->company_name }}</h3>

                            </div><!-- billed-from -->
                        </div><!-- invoice-header -->
                        <div class="row mg-t-20">
                            <div class="col-md mr-5">
                                <h5 class="invoice-info"><span>التاريخ :</span>
                                    <span>{{ $payment->date }}</span></h5>
                                <br>
                                <h5 class="invoice-info"><span> الرقم :</span>
                                    <span>{{ $payment->number_order }}</span></h5>
                                <br>
                                <h5 class="invoice-info"><span>اسم المشروع :</span>
                                    <span>{{ $payment->project_name }}</span></h5>
                                <br>
                                <h5 class="invoice-info"><span>رقم المشروع :</span>
                                    <span>{{ $payment->project_number }}</span></h5>
                                <br>
                                <br>
                                <h2 class="invoice-info"><span>السادة :</span>
                                    <span>{{ $payment->gentlemen }} المحترمين</span></h2>
                                <br>
                            </div>
                            <div class="col-md">
                                <p ><span></span>
                                    <span></span></p>
                                <br>
                                <br>
                                <br>
                                <br>
                            </div>
                        </div>
                        <h4 style="text-align: center"> نأمل اصدار دفعة حسب البيانات ادناه :</h4>
                        <br>
                        <br>
                        <div class="row mg-t-20">
                            <div class="col-md mr-5">
                                <h4 class="invoice-row"><span>اسم المورد / المقاول حسب السجل التجاري :</span>
                                    <span>{{ $payment->supplier_name }}</span>
                                </h4>
                                <br>
                                <br>
                                <h4 class="invoice-info"><span> المبلغ :</span>
                                    <span>{{ $payment->batch_payment }} ريال سعودي   </span></h4>
                                <br>
                                <br>
                                <h4 class="invoice-info"><span>المبلغ كتابة :</span>
                                    <span>{{ $payment->price_name }} ريال سعودي</span></h4>
                                <br>
                                <br>
                                <h4 class="invoice-info"><span>التاريخ المستحق للدفعة  :</span>
                                    <span>{{ $payment->due_date }}</span></h4>
                                <br>
                                <br>
                                <h3 class="invoice-info"><span>البيان :</span>
                                    <span>{{ $payment->	purchase_name }}</span></h3>
                                <br>
                                <br>
                                <h3 class="invoice-info"><span>اعده :</span>
                                    <span></span></h3>
                                <br><br>
                                <h3 class="invoice-info"><span>راجعه :</span>
                                    <span></span></h3>
                                <br><br>
                                <h3 class="invoice-info"><span>مدير المشتريات والعقود :</span>
                                    <span></span></h3>
                                <br>
                            </div>
                            <div class="col-md">
                                <p ><span></span>
                                    <span></span></p>
                                <br>
                                <br>
                                <br>
                                <br>
                            </div>
                        </div>
                        <br>
                        <div class="row mg-t-20">
                            <div class="col-md mr-5">
                                <h5 class="invoice-info"><span>المخصص المالي :</span>
                                    <span>{{ $payment->financial_provision }}</span></h5>
                                <br>
                                <br>
                                <h5 class="invoice-info"><span>البنك المسحوب عليه : </span>
                                    <span>{{ $payment->bank_name }}</span></h5>
                                <br>
                                <br>
                                <h5 class="invoice-info"><span>اعده :</span>
                                    <span></span></h5>
                                <br>
                                <br>
                                <h5 class="invoice-info"><span>الادارة المالية :</span>
                                    <span></span></h5>
                            </div>
                            <div class="col-md">
                                <h5 class="invoice-info"><span>الرقم :</span>
                                    <span>{{ $payment->number }}</span></h5>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <h5 class="invoice-info"><span>راجعه :</span>
                                    <span></span></h5>
                            </div>
                        </div>
                        <br>
                        <div class="row mg-t-20">
                            <div class="col-md mr-5">
                                <h5 class="invoice-info"><span>موافقة الادارة :</span>
                                    <span>تم الاعتماد</span></h5>
                                <br>
                                <br>
                            </div>
                            <div class="col-md">

                            </div>
                        </div>

                        <button class="btn btn-danger  float-left mt-3 mr-2" id="print_Button" onclick="printDiv()"> <i
                                class="mdi mdi-printer ml-1"></i>طباعة</button>
                    </div>
                </div>
            </div>
        </div><!-- COL-END -->
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Chart.bundle js -->
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>


    <script type="text/javascript">
        function printDiv() {
            var printContents = document.getElementById('print').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>
@endsection
