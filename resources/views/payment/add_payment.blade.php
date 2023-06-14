@extends('layouts.master')
@section('title')
    اضافة طلب اصدار دفعة
@endsection
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">مشتريات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافة طلب اصدار دفعة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->

    <form method="post" action="{{ route('payment.store') }}">
        @csrf
        <input type="hidden" name="id" value="{{ $purchases->id }}" >
        <input type="hidden" name="purchase_id" value="{{ $purchases->order_purchase_number }}" >

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>رقم طلب الشراء</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="order_purchase_id" value="{{ $purchases->id }}" readonly>
                    @error('order_purchase_id')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>التاريخ</label><span style="color: red;">  *</span>
                    <input type="date" class="form-control" name="date" id="dateInput" placeholder="التاريخ...">
                    @error('date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>اسم المشروع</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="project_name" value="{{ $purchases->project_name }}" readonly>
                    @error('project_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>رقم المشروع</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="project_number" value="{{ $purchases->project_number }}" readonly>
                    @error('project_number')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>السادة</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="gentlemen" placeholder="التاريخ...">
                    @error('gentlemen')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>اسم المرد/المقاول حسب السجل التجاري</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="supplier_name" placeholder="اسم المرد/المقاول حسب السجل التجاري...">
                    @error('supplier_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>المبلغ</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="price" value="{{ $purchases->total_vat }}" placeholder="المبلغ...">
                    @error('price')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>التاريخ المستحق للدفعة</label><span style="color: red;">  *</span>
                    <input type="date" class="form-control" name="due_date" value="{{ $purchases->delivery_date }}" placeholder="التاريخ المستحق للدفعة...">
                    @error('due_date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($multi_purchase as $multi)
            <div class="col-md-6">
                <div class="form-group">
                    <label>البيان</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="purchase_name" value="{{ $multi->purchase_name }}" readonly>
                    @error('purchase_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>المخصص المالي</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="financial_provision" placeholder="المخصص المالي...">
                    @error('financial_provision')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>الرقم</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="number" placeholder=" الرقم...">
                    @error('number')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>البنك المسحوب عليه</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="bank_name" placeholder="البنك المسحوب عليه...">
                    @error('bank_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <input type="submit" class="btn btn-info" value="تأكيد الطلب">
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
