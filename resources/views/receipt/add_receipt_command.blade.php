@extends('layouts.master')
@section('title')
    اضافة امر سند صرف
@endsection
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">السندات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافة امر سند صرف</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->

    <form method="post" action="{{ route('receipt.command.store') }}">
        @csrf
        <input type="hidden" name="id" value="{{ $payments->id }}" >
        <input type="hidden" class="form-control" name="paymentorder_id" value="{{ $payments->id }}">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <h5> اسم الشركة <span class="text-danger">*</span></h5>
                    <div class="controls">
                        <select name="company_id" class="form-control">
                            <option value="" selected="" disabled="">اختيار اسم الشركة</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}" {{ $company->id == $payments->company_id
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
                    <h5> المركز الرئيسي<span class="text-danger">*</span></h5>
                    <div class="controls">
                        <select name="subcompany_id" class="form-control">
                            <option value="" selected="" disabled=""> اسم المركز الرئيسي</option>
                            @foreach($subcompanies as $subcompany)
                                <option value="{{ $subcompany->id }}" {{ $subcompany->id == $payments->subcompany_id
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
                                <option value="{{ $subsub->id }}" {{$subsub->id == $payments->subsubcompany_id ? 'selected' : '' }}>
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
                    <label>التاريخ</label><span style="color: red;">  *</span>
                    <input type="date" class="form-control" name="date" value="{{ $payments->date }}">
                    @error('date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>المستفيد</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="benefit_name"  value="{{ $payments->benefit_name }}">
                    @error('benefit_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>المبلغ</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="price"  value="{{ $payments->price }}">
                    @error('price')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>نوع العملة</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="currency_type"  value="{{ $payments->currency_type }}">
                    @error('currency_type')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>فقط</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="just" value="{{ $payments->just }}" readonly>
                    @error('just')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <h5>البنك  <span class="text-danger">*</span></h5>
                    <div class="controls">
                        <select name="bank_id" class="form-control">
                            <option value="" selected="" disabled="">اختيار اسم البنك </option>
                            @foreach($banks as $bank)
                                <option value="{{ $bank->id }}" {{$bank->id == $payments->bank_id ? 'selected' : '' }}>
                                    {{ $bank->bank_name }}</option>
                            @endforeach
                        </select>
                        @error('bank_id')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>رقم الشيك</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="check_number" value="{{ $payments->check_number }}">
                    @error('check_number')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <h5>رقم الايبان <span class="text-danger">*</span></h5>
                    <div class="controls">
                        <select name="iban_id" class="form-control">
                            <option value="" selected="" disabled="">اختيار رقم الايبان </option>
                            @foreach($banks as $bank)
                                <option value="{{ $bank->id }}" {{$bank->id == $payments->iban_id ? 'selected' : '' }}>
                                    {{ $bank->iban_number }}</option>
                            @endforeach
                        </select>
                        @error('iban_id')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>رقم المشروع</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="project_number" value="{{ $payments->project_number }}">
                    @error('project_number')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>البيان</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="purchase_name" value="{{ $payments->purchase_name }}">
                    @error('purchase_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>المخصص المالي</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="financial_provision" value="{{ $payments->financial_provision }}">
                    @error('financial_provision')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-6">
                <div class="form-group">
                    <label>الرقم</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="number_financial" value="{{ $payments->number_financial }}">
                    @error('number_financial')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <input type="submit" class="btn btn-info" value="ارسال السند">
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
