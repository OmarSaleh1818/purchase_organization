@extends('layouts.master')
@section('title')
    تعديل اسم المشروع
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
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
                <h4 class="content-title mb-0 my-auto">الشركات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل مشروع الشركة</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    <!-- row -->
    <div class="row">
        <!--div-->

        <!--/div-->
        <div class="col-xl-6">
            <div class="card mg-b-20">
                <div class="card-header pb-0">

                </div>

                <div class="card-body">
                    <form method="post" action="{{ route('subsubcompany.update', $subsubcompany->id) }}">
                        @csrf

                        <div class="form-group">
                            <h5>اختيار اسم الشركة <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <select name="company_id" class="form-control" >
                                    <option value="" selected="" disabled="">اختيار اسم الشركة</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ $company->id == $subsubcompany->company_id
                                         ? 'selected' : ''}}>{{ $company->company_name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <span class="text-danger"> {{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <h5>اختيار اسم المركز الرئيسي <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <select name="subcompany_id" class="form-control" >
                                    <option value="" selected="" disabled="">اختيار اسم المركز الرئيسي</option>
                                    @foreach($subcompanies as $subcompany)
                                        <option value="{{ $subcompany->id }}" {{ $subcompany->id == $subsubcompany->subcompany_id
                                         ? 'selected' : ''}}>{{ $subcompany->subcompany_name }}</option>
                                    @endforeach

                                </select>
                                @error('subcompany_id')
                                <span class="text-danger"> {{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label>اسم المشروع</label><span style="color: red;">  *</span>
                            <input type="text" class="form-control" name="subsubcompany_name" value="{{ $subsubcompany->subsubcompany_name }}" placeholder="اسم المشروع...">
                            @error('subsubcompany_name')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-between">
                            <input type="submit" class="btn btn-info" value="تعديل اسم المشروع">
                        </div>
                        <br>
                    </form>
                </div>
            </div>
        </div>
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

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection
