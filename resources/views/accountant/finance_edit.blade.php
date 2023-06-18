@extends('layouts.master')
@section('title')
    تعديل طلب اصدار دفعة
@endsection
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الادارة المالية</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل طلب اصدار دفعة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->

    <form method="post" action="{{ route('finance.update', $payment->id) }}">
        @csrf
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <h5> اسم الشركة <span class="text-danger">*</span></h5>
                    <div class="controls">
                        <select name="company_id" class="form-control" readonly>
                            <option value="" selected="" disabled="">اختيار اسم الشركة</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}" {{ $company->id == $payment->company_id
                                         ? 'selected' : ''}}>{{ $company->company_name }}</option>
                            @endforeach
                        </select>
                        @error('company_id')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <h5> المركز الرئيسي <span class="text-danger">*</span></h5>
                    <div class="controls">
                        <select name="subcompany_id" class="form-control" readonly>
                            <option value="" selected="" disabled="">اختيار اسم الفرع</option>
                            @foreach($subcompanies as $subcompany)
                                <option value="{{ $subcompany->id }}" {{ $subcompany->id == $payment->subcompany_id
                                         ? 'selected' : ''}}>{{ $subcompany->subcompany_name }}</option>
                            @endforeach
                        </select>
                        @error('subcompany_id')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <h5>اسم المشروع <span class="text-danger">*</span></h5>
                    <div class="controls">
                        <select name="subsubcompany_id" class="form-control" readonly>
                            <option value="" selected="" disabled="">اختيار اسم المشروع</option>
                            @foreach($subsubcompanies as $subsub)
                                <option value="{{ $subsub->id }}" {{$subsub->id == $payment->subsubcompany_id ? 'selected' : '' }}>
                                    {{ $subsub->subsubcompany_name }}</option>
                            @endforeach
                        </select>
                        @error('subsubcompany_id')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>رقم طلب الشراء</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="order_purchase_id" value="{{ $payment->order_purchase_id }}" readonly>
                    @error('order_purchase_id')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>التاريخ</label><span style="color: red;">  *</span>
                    <input type="date" class="form-control" name="date" value="{{ $payment->date }}">
                    @error('date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>رقم المشروع</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="project_number" value="{{ $payment->project_number }}" readonly>
                    @error('project_number')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>السادة</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="gentlemen" value="{{ $payment->gentlemen }}">
                    @error('gentlemen')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>اسم المرد/المقاول حسب السجل التجاري</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="supplier_name" value="{{ $payment->supplier_name }}">
                    @error('supplier_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label> مبلغ الدفعة </label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="batch_payment" value="{{ $payment->batch_payment }}">
                    @error('price')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>التاريخ المستحق للدفعة</label><span style="color: red;">  *</span>
                    <input type="date" class="form-control" name="due_date" value="{{ $payment->due_date }}">
                    @error('due_date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>البيان</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="purchase_name" value="{{ $payment->purchase_name }}" readonly>
                    @error('purchase_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <h5>البنك المسحوب عليه <span class="text-danger">*</span></h5>
                    <div class="controls">
                        <select name="bank_id" class="form-control">
                            <option value="" selected="" disabled="">اختيار اسم البنك </option>
                            @foreach($banks as $bank)
                                <option value="{{ $bank->id }}" {{$bank->id == $payment->bank_id ? 'selected' : '' }}>
                                    {{ $bank->bank_name }}</option>
                            @endforeach
                        </select>
                        @error('bank_id')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>المخصص المالي</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="financial_provision" value="{{ $payment->financial_provision }}">
                    @error('financial_provision')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>الرقم</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="number" value="{{ $payment->number }}">
                    @error('number')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
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
