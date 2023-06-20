@extends('layouts.master')
@section('title')
    سند قبض
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
                <h4 class="content-title mb-0 my-auto">الخزنة</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ سند قبض </span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row raw-sm">
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
                    امر القبض
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table key-buttons text-md-nowrap">
                            <thead>
                            <tr>
                                <th class="border-bottom-0">ID</th>
                                <th class="border-bottom-0">التاريخ</th>
                                <th class="border-bottom-0">السادة</th>
                                <th class="border-bottom-0">المبلغ</th>
                                <th class="border-bottom-0">المبلغ كتابة</th>
                                <th class="border-bottom-0">المشروع</th>
                                <th class="border-bottom-0">المخصص المالي</th>
                                <th class="border-bottom-0">البيان</th>
                                <th class="border-bottom-0">طباعة</th>
                                <th class="border-bottom-0">حالة الطلب</th>
                                <th class="border-bottom-0"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($catch as $key => $item)
                                @if($item->status_id == 7)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $item->date }}</td>
                                        <td>{{ $item->gentlemen }}</td>
                                        <td>{{ $item->price }}</td>
                                        <td>{{ $item->just }}</td>
                                        <td>{{ $item['subsubcompany']['subsubcompany_name'] }}</td>
                                        <td>{{ $item->financial_provision }}</td>
                                        <td>{{ $item->purchase_name }}</td>
                                        <td>
                                            <a href="{{ route('print.catch', $item->id) }}" class="btn btn-warning"
                                               title="طباعة"><i class="fa fa-print"></i></a>
                                        </td>
                                        <td>
                                            @if($item->status_id == 7)
                                                <a href="{{ route('add.receipt.catch', $item->id) }}" class="btn btn-primary">اضافة سند قبض</a>
                                            @elseif($item->status_id == 3)
                                                <button class="btn btn-success">تم اضافة سند</button>
                                            @endif
                                        </td>
                                        <td></td>
                                    </tr>
                                @elseif($item->status_id == 3)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $item->date }}</td>
                                        <td>{{ $item->gentlemen }}</td>
                                        <td>{{ $item->price }}</td>
                                        <td>{{ $item->just }}</td>
                                        <td>{{ $item['subsubcompany']['subsubcompany_name'] }}</td>
                                        <td>{{ $item->financial_provision }}</td>
                                        <td>{{ $item->purchase_name }}</td>
                                        <td>
                                            <a href="{{ route('print.catch', $item->id) }}" class="btn btn-warning"
                                               title="طباعة"><i class="fa fa-print"></i></a>
                                        </td>
                                        <td>
                                            <button class="btn btn-success">تم اضافة سند</button>
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

        <!--div-->
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <a href="{{ route('add.safe.catch') }}" class="btn btn-primary">اضافة سند قبض </a>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example-delete" class="table text-md-nowrap">
                            <thead>
                            <tr>
                                <th class="border-bottom-0">ID</th>
                                <th class="border-bottom-0">التاريخ</th>
                                <th class="border-bottom-0">السادة</th>
                                <th class="border-bottom-0">المبلغ</th>
                                <th class="border-bottom-0">المبلغ كتابة</th>
                                <th class="border-bottom-0">المشروع</th>
                                <th class="border-bottom-0">المخصص المالي</th>
                                <th class="border-bottom-0">البيان</th>
                                <th class="border-bottom-0">طباعة</th>
                                <th class="border-bottom-0">حالة الطلب</th>
                                <th class="border-bottom-0"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($receipt_catch as $key => $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->date }}</td>
                                    <td>{{ $item->gentlemen }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->just }}</td>
                                    <td>{{ $item['subsubcompany']['subsubcompany_name'] }}</td>
                                    <td>{{ $item->financial_provision }}</td>
                                    <td>{{ $item->purchase_name }}</td>
                                    <td>
                                        <a href="{{ route('print.receipt.catch', $item->id) }}" class="btn btn-secondary"
                                           title="طباعة"><i class="fa fa-print"></i></a>
                                    </td>
                                    <td>
                                        @if($item->status_id == 1)
                                            <button class="btn btn-primary">تم ارسال سند قبض</button>
                                        @elseif($item->status_id == 5)
                                            <button class="btn btn-success">تم موافقة المحاسبة</button>
                                        @elseif($item->status_id == 6)
                                            <button class="btn btn-secondary">تم موافقة المالية</button>
                                        @elseif($item->status_id == 7)
                                            <button class="btn btn-danger">تم الاعتماد</button>
                                        @endif
                                    </td>
                                    <td></td>
                                </tr>
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
