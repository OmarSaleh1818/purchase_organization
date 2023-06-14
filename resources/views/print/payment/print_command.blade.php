@extends('layouts.master')
@section('title')
    طباعة امر دفع
@endsection
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
                <h4 class="content-title mb-0 my-auto">المحاسبة</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/طباعة امر دفع</span>
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
                            <h1 class="invoice-title"></h1>
                            <div class="billed-from">
                                <h3 style="margin-right: 250px; margin-top: 40px">{{ $payment['company']['company_name'] }}</h3>

                            </div><!-- billed-from -->
                        </div><!-- invoice-header -->
                        <h1 class="invoice-title" style="text-align: center">امر دفع نقدي / بنكي</h1>
                        <br>
                        <div class="row mg-t-20">
                            <div class="col-md mr-5">
                                <h5 class="invoice-info"><span>التاريخ :</span>
                                    <span style="margin-right: 50px">{{ $payment->date }}</span></h5>
                                <br>
                                <br>
                                <h5 class="invoice-info"><span> المشروع :</span>
                                    <span style="margin-right: 50px">{{ $payment->project_name }}</span></h5>
                                <br>

                                <br>

                            </div>
                            <div class="col-md">
                                <h5 class="invoice-info"><span> الرقم :</span>
                                    <span style="margin-right: 50px"> {{ $payment->id }}</span></h5>
                                <br>
                                <br>
                                <h5 class="invoice-info"><span>رقم :</span>
                                    <span style="margin-right: 50px">{{ $payment->project_number }}</span></h5>
                                <br>
                                <br>

                            </div>
                        </div>
                        <h4 class="invoice-info mr-5"><span>المستفيد :</span>
                            <span style="margin-right: 80px;border-style: double">{{ $payment->benefit_name }} </span></h4>
                        <div class="row mg-t-20">
                            <div class="col-md mr-5">
                                <br>
                                <br>
                                <h4 class="invoice-info"><span> المبلغ :</span>
                                    <span style="margin-right: 50px; border-style: double">{{ $payment->price }}</span></h4>
                                <br><br>
                            </div>
                            <div class="col-md">
                                <p ><span></span>
                                    <span></span></p>
                                <br>
                                <h4 class="invoice-info"><span>نوع العملة :</span>
                                    <span style="margin-right: 50px; border-style: double">{{ $payment->currency_type }}</span></h4>
                            </div>
                        </div>
                        <br>

                        <h4 class="invoice-info mr-5"><span>المبلغ كتابة :</span>
                            <span style="margin-right: 80px;border-style: double">{{ $payment->just }} </span></h4>
                        <br>
                        <br>
                        <div class="row mg-t-20">
                            <div class="col-md mr-5">
                                <br>
                                <h4 class="invoice-info"><span>البنك المسحوب عليه  :</span>
                                    <span style="border-style: double">{{ $payment->bank_name }}</span></h4>
                                <br><br>
                            </div>
                            <div class="col-md">
                                <p ><span></span>
                                    <span></span></p>
                                <h4 class="invoice-info"><span>رقم الشيك :</span>
                                    <span style="border-style: double">{{ $payment->check_number }}</span></h4>
                            </div>
                        </div>
                        <br>
                        <h4 class="invoice-info mr-5"><span>رقم الايبان :</span>
                            <span style="margin-right: 80px;border-style: double">{{ $payment->iban_number }} </span></h4>
                        <br>
                        <div class="row mg-t-20">
                            <div class="col-md mr-5">
                                <br>
                                <h3 class="invoice-info"><span>المخصص المالي :</span>
                                    <span style="margin-right: 50px; border-style: double">{{ $payment->financial_provision }}</span></h3>
                                <br><br>
                            </div>
                            <div class="col-md">
                                <p ><span></span>
                                    <span></span></p>
                                <h4 class="invoice-info"><span>رقم :</span>
                                    <span style="margin-right: 50px; border-style: double">{{ $payment->number_financial }}</span></h4>
                            </div>
                        </div>
                        <br>
                        <h4 class="invoice-info mr-5"><span>البيان :</span>
                            <span style="margin-right: 100px;border-style: double">{{ $payment->purchase_name }} </span></h4>
                        <br>
                        <br>
                        <div class="row mg-t-20">
                            <div class="col-md mr-5">
                                <h4 class="invoice-info"><span>اعداد :</span>
                                    <span></span></h4>
                                <br>
                                <br>
                                <br>
                                <h4 class="invoice-info"><span>اعتماد الادارة :</span>
                                    <span style="margin-right: 50px">
                                        @if($payment->status_id == 1)
                                            لم يتم الاعتماد
                                        @else
                                            تم الاعتماد
                                        @endif
                                    </span></h4>
                            </div>
                            <div class="col-md">
                                <h4 class="invoice-info"><span>مراجعة :</span>
                                    <span></span></h4>
                                <br>
                                <br>
                                <br>
                                <br>
                            </div>
                        </div>
                        <br>
                        <br>

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
