@extends('layouts.master')
@section('title')
    الادارة المالية
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
                <h4 class="content-title mb-0 my-auto">الادارة المالية</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ طلب اصدار دفعة</span>
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
                                <th class="border-bottom-0">اسم المشروع</th>
                                <th class="border-bottom-0">السادة</th>
                                <th class="border-bottom-0">البيان</th>
                                <th class="border-bottom-0">اسم المورد</th>
                                <th class="border-bottom-0">مبلغ الدفعة</th>
                                <th class="border-bottom-0">التاريخ المستحق للدفعة</th>
                                <th class="border-bottom-0">طباعة</th>
                                <th class="border-bottom-0">عرض الطلب</th>
                                <th class="border-bottom-0">حالة الطلب</th>
                                <th class="border-bottom-0"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($payments as $key => $item)
                                @if($item->status_id == 5)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item['subsubcompany']['subsubcompany_name'] }}</td>
                                    <td>{{ $item->gentlemen }}</td>
                                    <td>{{ $item->purchase_name }}</td>
                                    <td>{{ $item->supplier_name }}</td>
                                    <td>{{ $item->batch_payment }}</td>
                                    <td>{{ $item->due_date }}</td>
                                    <td>
                                        <a href="{{ route('print.manager.payment', $item->id) }}" class="btn btn-warning"
                                           title="طباعة"><i class="fa fa-print"></i></a>
                                    </td>
                                    <td>
                                        <a href="{{ route('finance.edit', $item->id) }}" class="btn btn-info"
                                           title="تعديل الطلب "><i class="las la-pen"></i></a>
                                    </td>
                                    <td>
                                        <a href="{{ route('finance.sure', $item->id) }}" class="btn btn-primary">تاكيد الطلب</a>
                                    </td>
                                    <td></td>
                                </tr>
                                @elseif($item->status_id == 6)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $item['subsubcompany']['subsubcompany_name'] }}</td>
                                        <td>{{ $item->gentlemen }}</td>
                                        <td>{{ $item->purchase_name }}</td>
                                        <td>{{ $item->supplier_name }}</td>
                                        <td>{{ $item->batch_payment }}</td>
                                        <td>{{ $item->due_date }}</td>
                                        <td>
                                            <a href="{{ route('print.manager.payment', $item->id) }}" class="btn btn-warning"
                                               title="طباعة"><i class="fa fa-print"></i></a>
                                        </td>
                                        <td>
                                            <a href="{{ route('finance.edit', $item->id) }}" class="btn btn-info"
                                               title="تعديل الطلب "><i class="las la-pen"></i></a>
                                        </td>
                                        <td>
                                            <button class="btn btn-success">تم تاكيد الطلب</button>
                                        </td>
                                        <td></td>
                                    </tr>
                                @elseif($item->status_id == 7)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $item['subsubcompany']['subsubcompany_name'] }}</td>
                                        <td>{{ $item->gentlemen }}</td>
                                        <td>{{ $item->purchase_name }}</td>
                                        <td>{{ $item->supplier_name }}</td>
                                        <td>{{ $item->batch_payment }}</td>
                                        <td>{{ $item->due_date }}</td>
                                        <td>
                                            <a href="{{ route('print.manager.payment', $item->id) }}" class="btn btn-warning"
                                               title="طباعة"><i class="fa fa-print"></i></a>
                                        </td>
                                        <td>
                                            <a href="{{ route('finance.edit', $item->id) }}" class="btn btn-info"
                                               title="تعديل الطلب "><i class="las la-pen"></i></a>
                                        </td>
                                        <td>
                                            <button class="btn btn-secondary">تم موافقة المدير</button>
                                        </td>
                                        <td></td>
                                    </tr>
                                @elseif($item->status_id == 3)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $item['subsubcompany']['subsubcompany_name'] }}</td>
                                        <td>{{ $item->gentlemen }}</td>
                                        <td>{{ $item->purchase_name }}</td>
                                        <td>{{ $item->supplier_name }}</td>
                                        <td>{{ $item->batch_payment }}</td>
                                        <td>{{ $item->due_date }}</td>
                                        <td>
                                            <a href="{{ route('print.manager.payment', $item->id) }}" class="btn btn-warning"
                                               title="طباعة"><i class="fa fa-print"></i></a>
                                        </td>
                                        <td>
                                            <a href="{{ route('finance.edit', $item->id) }}" class="btn btn-info"
                                               title="عرض الطلب "><i class="las la-eye"></i></a>
                                        </td>
                                        <td>
                                            <button class="btn btn-dark">تم الدفع</button>
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
