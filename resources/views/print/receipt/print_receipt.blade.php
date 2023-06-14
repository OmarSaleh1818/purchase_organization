@extends('layouts.master')
@section('title')
    طباعة سند صرف
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
                <h4 class="content-title mb-0 my-auto">الخزنة</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/طباعة سند صرف</span>
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
                            <h1 class="invoice-title">سند صرف نقدي / بنكي</h1>
                            <div class="billed-from">
                                <h3>{{ $receipt->company_name }}</h3>

                            </div><!-- billed-from -->
                        </div><!-- invoice-header -->
                        <br>
                        <div class="row mg-t-20">
                            <div class="col-md mr-5">
                                <h5 class="invoice-info"><span>التاريخ :</span>
                                    <span style="margin-right: 50px">{{ $receipt->date }}</span></h5>
                                <br>
                                <br>
                                <h5 class="invoice-info"><span> المشروع :</span>
                                    <span style="margin-right: 50px">{{ $receipt->project_name }}</span></h5>
                                <br>

                                <br>

                            </div>
                            <div class="col-md">
                                <h5 class="invoice-info"><span> الرقم :</span>
                                    <span style="margin-right: 50px"> {{ $receipt->id }}</span></h5>
                                <br>
                                <br>
                                <h5 class="invoice-info"><span>رقم :</span>
                                    <span style="margin-right: 50px">{{ $receipt->project_number }}</span></h5>
                                <br>
                                <br>

                            </div>
                        </div>
                        <div class="row mg-t-20">
                            <div class="col-md mr-5">
                                <h4 class="invoice-info"><span>المستفيد :</span>
                                    <span style="margin-right: 50px; border-style: double">{{ $receipt->benefit }}</span>
                                </h4>
                                <br>
                                <br>
                                <h4 class="invoice-info"><span> المبلغ :</span>
                                    <span style="margin-right: 50px; border-style: double">{{ $receipt->price }}</span></h4>
                                <br>
                                <br>
                                <br>
                                <h4 class="invoice-info"><span>المبلغ كتابة :</span>
                                    <span style="border-style: double">{{ $receipt->just }} </span></h4>
                                <br>
                                <br>
                                <br>
                                <h4 class="invoice-info"><span>البنك المسحوب عليه  :</span>
                                    <span style="margin-right: 50px; border-style: double">{{ $receipt->bank_name }}</span></h4>
                                <br>
                                <br>
                                <br>
                                <br>
                                <h3 class="invoice-info"><span>رقم الايبان :</span>
                                    <span style="border-style: double">{{ $receipt->iban_number }}</span></h3>
                                <br>
                                <br>
                                <br>
                                <br>
                                <h3 class="invoice-info"><span>المخصص المالي :</span>
                                    <span style="margin-right: 50px; border-style: double">{{ $receipt->financial_provision }}</span></h3>
                                <br><br>
                                <br><br>
                                <h3 class="invoice-info"><span>البيان :</span>
                                    <span style="margin-right: 50px; border-style: double">{{ $receipt->purchase_name }}</span></h3>
                                <br><br>
                            </div>
                            <div class="col-md">
                                <p ><span></span>
                                    <span></span></p>
                                <br>
                                <br>
                                <br>
                                <h4 class="invoice-info"><span>نوع العملة :</span>
                                    <span style="margin-right: 50px; border-style: double">{{ $receipt->currency_type }}</span></h4>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <h4 class="invoice-info"><span>رقم الشيك :</span>
                                    <span style="border-style: double">{{ $receipt->check_number }}</span></h4>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <h4 class="invoice-info"><span>رقم :</span>
                                    <span style="margin-right: 50px; border-style: double">{{ $receipt->number }}</span></h4>
                                <br>
                            </div>
                        </div>
                        <br>
                        <div class="row mg-t-20">
                            <div class="col-md mr-5">
                                <h4 class="invoice-info"><span>اعداد :</span>
                                    <span></span></h4>
                                <br>
                                <br>
                                <h4 class="invoice-info"><span>اعتماد الادارة :</span>
                                    <span style="margin-right: 50px">
                                        @if($receipt->status_id == 7)
                                            تم الاعتماد
                                        @else
                                            لم يتم الاعتماد
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
                        <div class="row mg-t-20">
                            <div class="col-md mr-5">
                                <h4 class="invoice-info"><span>اسم المستلم :</span>
                                    <span></span></h4>
                                <br>
                                <h4 class="invoice-info"><span>تاريخ الاستلام :</span>
                                    <span style="margin-right: 50px"></span></h4>
                                <br>
                                <h4 class="invoice-info"><span>توقيع المستلم :</span>
                                    <span style="margin-right: 50px"></span></h4>
                            </div>
                            <div class="col-md">
                                <br>
                                <br>
                                <br>
                                <br>
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
