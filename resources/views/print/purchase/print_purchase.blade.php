@extends('layouts.master')
@section('title')
    طباعة طلب شراء
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
                <h4 class="content-title mb-0 my-auto">المشتريات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    طباعة طلب شراء</span>
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
                            <h1 class="invoice-title">طلب شراء</h1>
                            <div class="billed-from">
                                <h4>{{ $purchases->company_name }}</h4>
                            </div><!-- billed-from -->
                        </div><!-- invoice-header -->
                        <div class="row mg-t-20">
                            <div class="col-md">
                                <h5 class="invoice-info"><span>السادة :</span>
                                    <span>{{ $purchases->gentlemen }}</span></h5>
                                <br>
                                <h5 class="invoice-info"><span> عناية الاستاذ :</span>
                                    <span>{{ $purchases->professor_care }}</span></h5>
                                <br>
                                <h5 class="invoice-info"><span>العنوان :</span>
                                    <span>{{ $purchases->address }}</span></h5>
                                <br>
                                <h5 class="invoice-info"><span>رقم التلفون :</span>
                                    <span>{{ $purchases->phone_number }}</span></h5>
                                <br>
                                <h5 class="invoice-info"><span>الايميل :</span>
                                    <span>{{ $purchases->email }}</span></h5>
                                <br>
                                <h5 class="invoice-info"><span>الموضوع :</span>
                                    <span>{{ $purchases->subject }}</span></h5>
                                <br>
                            </div>
                            <div class="col-md">
                                <h5 class="invoice-info"><span>رقم طلب الشراء :</span>
                                    <span>{{ $purchases->id }}</span></h5>
                                <br>
                                <h5 class="invoice-info"><span>تاريخ طلب الشراء :</span>
                                    <span>{{ $purchases->order_purchase_date }}</span></h5>
                                <br>
                                <h5 class="invoice-info"><span>اسم المشروع :</span>
                                    <span>{{ $purchases->project_name }}</span></h5>
                                <br>
                                <h5 class="invoice-info"><span>رقم المشروع :</span>
                                    <span>{{ $purchases->project_number }}</span></h5>
                                <br>
                            </div>
                        </div>
                        <h5 style="text-align: center"><strong><ins> طلب شراء للبنود المدرجة ادناه</ins></strong></h5>
                        <div class="table-responsive mg-t-40">
                            <p style="text-align: center">نحيطكم علما بموافقتنا على عرض السعر المقدم من قبلكم رقم
                                <strong>{{ $purchases->order_material_id }}
                                </strong> بتاريخ <strong>{{ $purchases->order_purchase_date }}</strong> للبنود المدرجة ادناه
                            </p>
                            <table class="table table-invoice border text-md-nowrap mb-0">
                                <thead>
                                <tr>
                                    <th>التسلسل</th>
                                    <th>البيان</th>
                                    <th>الوحدة</th>
                                    <th>الكمية</th>
                                    <th>رقم الموديل</th>
                                    <th>السعر</th>
                                    <th>الاجمالي</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($multi_purchas as $key => $multi)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td><h5>{{ $multi->purchase_name }}</h5></td>
                                        <td><h5>{{ $multi->unit }}</h5></td>
                                        <td><h5>{{ $multi->quantity }}</h5></td>
                                        <td><h5>{{ $multi->model_number }}</h5></td>
                                        <td><h5>{{ $multi->price }}</h5></td>
                                        <td><h5>{{ $multi->total_price }}</h5></td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td class="valign-middle" colspan="4" rowspan="5">
                                        <div class="invoice-notes">


                                        </div><!-- invoice-notes -->
                                    </td>
                                    <td class="tx-right">المجموع</td>
                                    <td class="tx-left" colspan="4">{{ $purchases->total }}</td>
                                </tr>
                                <tr>
                                    <td class="tx-right">الخصم</td>
                                    <td class="tx-left" colspan="4">{{ $purchases->discount }}</td>
                                </tr>
                                <tr>
                                    <td class="tx-right">الاجمالي بعد الخصم</td>
                                    <td class="tx-left" colspan="4">{{ $purchases->total_discount }}</td>

                                </tr>
                                <tr>
                                    <td class="tx-right">الضريبة المضافة</td>
                                    <td class="tx-left" colspan="4">{{ $purchases->added_vat }}</td>

                                </tr>
                                <tr>
                                    <td class="tx-right tx-uppercase tx-bold tx-inverse">الاجمالي بعد الضريبة</td>
                                    <td class="tx-left" colspan="4">
                                        <h4 class="tx-bold">{{ $purchases->total_vat }}</h4>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr class="mg-b-40">
                        <div class="row mg-t-20">
                            <div class="col-md">
                                <h5 class="invoice-info"><span>موقع التسليم :</span>
                                    <span>{{ $purchases->delivery_location }}</span></h5>
                                <br>
                                <br>
                                <h5 class="invoice-info"><span>تاريخ التسليم :</span>
                                    <span>{{ $purchases->delivery_date }}</span></h5>
                                <br>
                                <br>
                                <h5 class="invoice-info"><span>اعتماد الادارة : </span>
                                    <span>لم يعتمد</span></h5>
                                <br>
                                <br>
                                <h5 class="invoice-info"><span>شروط السداد :</span>
                                    <span>{{ $purchases->terms_payment }}</span></h5>
                            </div>
                            <div class="row mg-t-20">

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
