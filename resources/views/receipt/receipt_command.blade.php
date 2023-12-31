@extends('layouts.master')
@section('title')
    امر سند صرف
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
                <h4 class="content-title mb-0 my-auto">السندات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ امر سند صرف</span>
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
                    اضافة امر سند صرف
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table key-buttons text-md-nowrap">
                            <thead>
                            <tr>
                                <th class="border-bottom-0">ID</th>
                                <th class="border-bottom-0">المستفيد</th>
                                <th class="border-bottom-0">المبلغ</th>
                                <th class="border-bottom-0">المبلغ كتابة</th>
                                <th class="border-bottom-0">البنك المسحوب عليه</th>
                                <th class="border-bottom-0">المشروع</th>
                                <th class="border-bottom-0">البيان</th>
                                <th class="border-bottom-0">المخصص المالي</th>
                                <th class="border-bottom-0">طباعة</th>
                                <th class="border-bottom-0">حالة الطلب</th>
                                <th class="border-bottom-0"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($commands as $key => $item)
                                @if($item->status_id == 7)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->benefit_name }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->just }}</td>
                                    <td>{{ $item['bankName']['bank_name'] }}</td>
                                    <td>{{ $item['subsubcompany']['subsubcompany_name'] }}</td>
                                    <td>{{ $item->purchase_name }}</td>
                                    <td>{{ $item->financial_provision }}</td>
                                    <td>
                                        <a href="{{ route('print.command', $item->id) }}" class="btn btn-secondary"
                                           title="طباعة"><i class="fa fa-print"></i></a>
                                    </td>
                                    <td>
                                        <a href="{{ route('add.receipt.command', $item->id) }}" class="btn btn-primary">اضافة سند صرف</a>
                                    </td>
                                    <td></td>
                                </tr>
                                @elseif($item->status_id == 3)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $item->benefit_name }}</td>
                                        <td>{{ $item->price }}</td>
                                        <td>{{ $item->just }}</td>
                                        <td>{{ $item['bankName']['bank_name'] }}</td>
                                        <td>{{ $item['subsubcompany']['subsubcompany_name'] }}</td>
                                        <td>{{ $item->purchase_name }}</td>
                                        <td>{{ $item->financial_provision }}</td>
                                        <td>
                                            <a href="{{ route('print.command', $item->id) }}" class="btn btn-warning"
                                               title="طباعة"><i class="fa fa-print"></i></a>
                                        </td>
                                        <td>
                                            <button class="btn btn-success">تم اضافة سند صرف </button>
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

    <div class="row">
        <!--div-->
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    سندات امر
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example-delete" class="table text-md-nowrap">
                            <thead>
                            <tr>
                                <th class="border-bottom-0">ID</th>
                                <th class="border-bottom-0">المستفيد</th>
                                <th class="border-bottom-0">المبلغ</th>
                                <th class="border-bottom-0">المبلغ كتابة</th>
                                <th class="border-bottom-0">البنك المسحوب عليه</th>
                                <th class="border-bottom-0">المشروع</th>
                                <th class="border-bottom-0">المخصص المالي</th>
                                <th class="border-bottom-0">البيان</th>
                                <th class="border-bottom-0">طباعة</th>
                                <th class="border-bottom-0">حالة الطلب</th>
                                <th class="border-bottom-0"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($command as $key => $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->benefit_name }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->just }}</td>
                                    <td>{{ $item['bankName']['bank_name'] }}</td>
                                    <td>{{ $item['subsubcompany']['subsubcompany_name'] }}</td>
                                    <td>{{ $item->financial_provision }}</td>
                                    <td>{{ $item->purchase_name }}</td>
                                    <td>
                                        <a href="{{ route('print.receipt.command', $item->id) }}" class="btn btn-secondary"
                                           title="طباعة"><i class="fa fa-print"></i></a>
                                    </td>
                                    <td>
                                        <button class="btn btn-success"> تم اضافة سند صرف</button>
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
