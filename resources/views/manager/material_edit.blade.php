@extends('layouts.master')
@section('title')
    تعديل طلب مواد
@endsection
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المدير العام</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل طلب مواد</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->

    <form method="post" action="{{ route('material.update', $purchases->id) }}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <h5>اختيار اسم الشركة <span class="text-danger">*</span></h5>
                    <div class="controls">
                        <select name="company_id" class="form-control">
                            <option value="" selected="" disabled="">اختيار اسم الشركة</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}" {{ $company->id == $purchases->company_id
                                         ? 'selected' : ''}}>{{ $company->company_name }}</option>
                            @endforeach
                        </select>
                        @error('company_id')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <h5>اختيار اسم الفرع <span class="text-danger">*</span></h5>
                    <div class="controls">
                        <select name="subcompany_id" class="form-control">
                            <option value="" selected="" disabled="">اختيار اسم الفرع</option>
                            @foreach($subcompanies as $subcompany)
                                <option value="{{ $subcompany->id }}" {{ $subcompany->id == $purchases->subcompany_id
                                         ? 'selected' : ''}}>{{ $subcompany->subcompany_name }}</option>
                            @endforeach
                        </select>
                        @error('subcompany_id')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <h5>اسم المشروع <span class="text-danger">*</span></h5>
                    <div class="controls">
                        <select name="subsubcompany_id" class="form-control">
                            <option value="" selected="" disabled="">اختيار اسم المشروع</option>
                            @foreach($subsubcompanies as $subsub)
                                <option value="{{ $subsub->id }}" {{$subsub->id == $purchases->subsubcompany_id ? 'selected' : '' }}>
                                    {{ $subsub->subsubcompany_name }}</option>
                            @endforeach
                        </select>
                        @error('subsubcompany_id')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>الاستاذ</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="teacher_name" value="{{$purchases->teacher_name}}" placeholder="اسم الاستاذ...">
                    @error('teacher_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>المخصص المالي</label>
                    <input type="text" class="form-control" name="financial_provision" value="{{ $purchases->financial_provision }}" placeholder="المخصص المالي...">
                    @error('financial_provision')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>الرقم</label>
                    <input type="text" class="form-control" name="number" value="{{ $purchases->number }}" placeholder="الرقم...">
                    @error('financial_provision')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>التاريخ</label>
                    <input type="date" class="form-control" name="date" value="{{ $purchases->date }}">
                    @error('date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <hr>
        @foreach($multi_purchase as $multi)
            <input type="hidden" name="multi[]" value="{{$multi->id }}">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>البيان</label>
                        <input type="text" class="form-control" name="purchase_name[]"
                               value="{{ $multi->purchase_name }}" placeholder="البيان...">
                        @error('purchase_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>الكمية</label>
                        <input type="text" class="form-control" name="quantity[]"
                               value="{{ $multi->quantity }}" placeholder="الكمية...">
                        @error('quantity')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>الوحدة</label>
                        <input type="text" class="form-control" name="unit[]"
                               value="{{ $multi->unit }}" placeholder="الوحدة...">
                        @error('unit')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>رقم الموديل</label>
                        <input type="text" class="form-control" name="model_number[]"
                               value="{{ $multi->model_number }}" placeholder="رقم الموديل ...">
                        @error('model_number')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <hr>
        @endforeach

        <div class="d-flex justify-content-between">
            <input type="submit" class="btn btn-info" value="حفظ">
        </div>
        <br>
    </form>

    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
@endsection
