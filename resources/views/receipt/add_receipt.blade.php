@extends('layouts.master')
@section('title')
    اضافة سند صرف
@endsection
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">السندات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافة سند صرف اصدار دفعة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->

    <form method="post" action="{{ route('receipt.store') }}">
        @csrf
        <input type="hidden" name="id" value="{{ $payment->id }}" >
        <input type="hidden" class="form-control" name="payment_id" value="{{ $payment->id }}">
        <input type="hidden" class="form-control" name="company_name" value="{{ $payment->company_name }}" readonly>
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
                    <label>التاريخ</label><span style="color: red;">  *</span>
                    <input type="date" class="form-control" name="date" id="dateInput">
                    @error('date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>المستفيد</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="benefit" value="{{ $payment->supplier_name }}"placeholder="المستفيد...">
                    @error('benefit')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>المبلغ</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="price" value="{{ $payment->batch_payment }}" readonly>
                    @error('price')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>نوع العملة</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="currency_type" value="ريال سعودي" placeholder="نوع العملة...">
                    @error('currency_type')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>فقط</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="just" value="{{ $payment->price_name }}"
                           placeholder="فقط..." readonly>
                    @error('just')
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
                    <label>رقم الشيك</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="check_number" placeholder="رقم الشيك...">
                    @error('check_number')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <h5>اختيار رقم الايبان <span class="text-danger">*</span></h5>
                    <div class="controls">
                        <select name="iban_id" class="form-control">
                            <option value="" selected="" disabled="">اختيار الايبان</option>
                            @foreach($banks as $bank)
                                <option value="{{ $bank->id }}">{{ $bank->iban_number }}</option>
                            @endforeach
                        </select>
                        @error('iban_id')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
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
                    <label>البيان</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="purchase_name" value="{{ $payment->purchase_name }}">
                    @error('purchase_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>المخصص المالي</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="financial_provision" value="{{ $payment->financial_provision }}" readonly>
                    @error('financial_provision')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>الرقم</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="number" value="{{ $payment->number }}" readonly>
                    @error('number')
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
    <script>
        // Select the input field
        var input = document.getElementById('dateInput');

        // Create a new Date object for the current date
        var currentDate = new Date();

        // Format the date as YYYY-MM-DD for the input value
        var formattedDate = currentDate.toISOString().split('T')[0];

        // Set the initial value of the input field to the current date
        input.value = formattedDate;

        // Add an event listener to allow the user to change the date
        input.addEventListener('input', function(event) {
            var selectedDate = event.target.value;
            console.log(selectedDate); // Output the selected date
        });
    </script>
@endsection
