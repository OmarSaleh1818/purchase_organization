@extends('layouts.master')
@section('title')
    طباعة مواد
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
                <h4 class="content-title mb-0 my-auto">المشتريات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ طباعة المواد</span>
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
                            <h1 class="invoice-title">طلب مواد</h1>
                            <div class="billed-from">
                                <h3>{{ $purchases['company']['company_name'] }}</h3>

                            </div><!-- billed-from -->
                        </div><!-- invoice-header -->
                        <div class="row mg-t-20">
                            <div class="col-md">
                                <h5 class="invoice-info"><span>التاريخ :</span>
                                    <span>{{ $purchases->date }}</span></h5>
                                <br>
                                <br>
                                <h5 class="invoice-info"><span> الاستاذ :</span>
                                    <span>{{ $purchases->teacher_name }}</span></h5>
                                <br>
                                <br>
                                <h5 class="invoice-info"><span>المشروع :</span>
                                    <span>{{ $purchases['subsubcompany']['subsubcompany_name'] }}</span></h5>
                                <br>
                                <br>
                                <h5 class="invoice-info"><span>المخصص المالي :</span>
                                    <span>{{ $purchases->financial_provision }}</span></h5>
                                <br>
                            </div>
                            <div class="col-md">
                                <p ><span></span>
                                    <span></span></p>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <h5 class="invoice-info"><span>رقم المشروع :</span>
                                    <span>{{ $purchases->id }}</span></h5>
                                <br>
                                <br>
                                <h5 class="invoice-info"><span>رقم المخصص المالي : </span>
                                    <span>{{ $purchases->number }}</span></h5>
                                <br>
                            </div>
                        </div>
                        <div class="table-responsive mg-t-40">
                            <table class="table table-invoice border text-md-nowrap mb-0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th><h6>البيان</h6></th>
                                    <th><h6>الكمية</h6></th>
                                    <th><h6>الوحدة</h6></th>
                                    <th><h6>رقم الموديل</h6></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($multi_purchase as $key => $item)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td><h5>{{ $item->purchase_name }}</h5></td>
                                        <td><h5>{{ $item->quantity }}</h5></td>
                                        <td><h5>{{ $item->unit }}</h5></td>
                                        <td><h5>{{ $item->model_number }}</h5></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <br>
                        <hr class="mg-b-40">
                        <div class="row mg-t-20">
                            <div class="col-md">
                                <h5 class="invoice-info"><span>مقدم الطلب :</span>
                                    <span>{{ $purchases->applicant }}</span></h5>
                                <br>
                                <br>
                                <h5 class="invoice-info"><span>اعتماد الادارة : </span>
                                    <span>لم يعتمد</span></h5>
                                <br>
                            </div>
                            <div class="col-md">
                                <h5 class="invoice-info"><span>التوقيع :</span>
                                    <span></span></h5>
                            </div>
                        </div>
                        <br>
                        <strong class="invoice-info"><span>استلمت البضاعة كاملة و هي مطابقة للمواصفات المطلوبة</span></strong>
                            <br>
                        <br>
                        <br>
                        <div class="row mg-t-20">
                            <div class="col-md">
                                <h5 class="invoice-info"><span>توقيع المستلم :</span>
                                    <span></span></h5>

                            </div>
                            <div class="col-md">
                                <h5 class="invoice-info"><span>تاريخ اللاستلام :</span>
                                    <span></span></h5>
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
