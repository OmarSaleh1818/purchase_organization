@extends('layouts.master')
@section('title')
    طلب اصدار دفعة
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المشتريات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ طلب اصدار دفعة</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <!--div-->
        @if(Session()->has('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ Session()->get('status') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table key-buttons text-md-nowrap">
                            <thead>
                            <tr>
                                <th class="border-bottom-0">ID</th>
                                <th class="border-bottom-0">السادة</th>
                                <th class="border-bottom-0">رقم طلب الشراء</th>
                                <th class="border-bottom-0">تاريخ طلب الشراء</th>
                                <th class="border-bottom-0">الموضوع</th>
                                <th class="border-bottom-0">العنوان</th>
                                <th class="border-bottom-0">تاريخ التسليم</th>
                                <th class="border-bottom-0">الاجمالي بعد الضريبة</th>
                                <th class="border-bottom-0">طباعة</th>
                                <th class="border-bottom-0">التعديل</th>
                                <th class="border-bottom-0">حالة الطلب</th>
                                <th class="border-bottom-0"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($purchases as $key => $item)
                                @if($item->status_id == 7)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->gentlemen }}</td>
                                    <td>{{ $item->order_purchase_number }}</td>
                                    <td>{{ $item->order_purchase_date }}</td>
                                    <td>{{ $item->subject }}</td>
                                    <td>{{ $item->address }}</td>
                                    <td>{{ $item->delivery_date }}</td>
                                    <td>{{ $item->total_vat }}</td>
                                    <td>
                                        @if($item->status_id == 1)
                                            <a href="{{ route('print.orderpurchase', $item->id) }}" class="btn btn-secondary"
                                               title="طباعة"><i class="fa fa-print"></i></a>
                                        @else
                                            <a href="{{ route('print.manager.orderpurchase', $item->id) }}" class="btn btn-warning"
                                               title="طباعة"><i class="fa fa-print"></i></a>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('payment.purchase.edit', $item->id) }}" class="btn btn-info"
                                           title="عرض الطلب"><i class="las la-eye"></i></a>
                                    </td>
                                    <td>
                                        <a href="{{ route('add.partial.payment', $item->id) }}" class="btn btn-primary">طلب اصدار دفعة</a>
                                    </td>
                                    <td></td>
                                </tr>
                                @elseif($item->status_id == 4)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $item->gentlemen }}</td>
                                        <td>{{ $item->order_purchase_number }}</td>
                                        <td>{{ $item->order_purchase_date }}</td>
                                        <td>{{ $item->subject }}</td>
                                        <td>{{ $item->address }}</td>
                                        <td>{{ $item->delivery_date }}</td>
                                        <td>{{ $item->total_vat }}</td>
                                        <td>
                                            @if($item->status_id == 1)
                                                <a href="{{ route('print.orderpurchase', $item->id) }}" class="btn btn-warning"
                                                   title="طباعة"><i class="fa fa-print"></i></a>
                                            @else
                                                <a href="{{ route('print.manager.orderpurchase', $item->id) }}" class="btn btn-warning"
                                                   title="طباعة"><i class="fa fa-print"></i></a>
                                            @endif
                                        </td>
                                        <td>

                                        </td>
                                        <td>
                                            <a href="{{ route('add.partial.payment', $item->id) }}" class="btn btn-success">تم طلب اصدار الدفعة</a>
                                        </td>
                                        <td></td>
                                    </tr>
                                @elseif($item->status_id == 2)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $item->gentlemen }}</td>
                                        <td>{{ $item->order_purchase_number }}</td>
                                        <td>{{ $item->order_purchase_date }}</td>
                                        <td>{{ $item->subject }}</td>
                                        <td>{{ $item->address }}</td>
                                        <td>{{ $item->delivery_date }}</td>
                                        <td>{{ $item->total_vat }}</td>
                                        <td>
                                            @if($item->status_id == 1)
                                                <a href="{{ route('print.orderpurchase', $item->id) }}" class="btn btn-warning"
                                                   title="طباعة"><i class="fa fa-print"></i></a>
                                            @else
                                                <a href="{{ route('print.manager.orderpurchase', $item->id) }}" class="btn btn-warning"
                                                   title="طباعة"><i class="fa fa-print"></i></a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('payment.purchase.edit', $item->id) }}" class="btn btn-info"
                                               title="عرض الطلب"><i class="las la-eye"></i></a>
                                        </td>
                                        <td>
                                            <button class="btn btn-warning">تم رفض الطلب</button>
                                        </td>
                                        <td></td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
    <!--Internal  Datatable js -->
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>
@endsection
