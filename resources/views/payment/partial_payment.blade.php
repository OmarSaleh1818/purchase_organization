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
                <h4 class="content-title mb-0 my-auto">مشتريات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافة طلب اصدار دفعة جزئي</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->

    <form method="post" action="{{ route('partial.payment.store') }}">
        @csrf
        <input type="hidden" name="id" value="{{ $purchases->id }}" >
        <input type="hidden" name="purchase_id" value="{{ $purchases->project_number }}" >

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                        <div class="form-group">
                            <label for="description"> ملاحظات هامة</label>
                            <textarea name="description"  class="form-control" placeholder="ادخل ملاحظات...">
                                {{ $purchases->description }}</textarea>
                        </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="row">
                @foreach($multi_payment as $key => $item)
                    <input type="hidden" name="multi_payment[{{ $key }}][payment_id]" value="{{ $item->payment_id }}">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>الدفعة{{ $key+1 }} </label><span style="color: red;">  *</span>
                            <input type="text" class="form-control" name="multi_payment[{{ $key }}][payment_price]" value="{{ $item->payment_price }}" placeholder="المبلغ...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>التاريخ المستحق للدفعة</label><span style="color: red;">  *</span>
                            <input type="date" class="form-control" name="multi_payment[{{ $key }}][payment_date]" value="{{ $item->payment_date }}" placeholder="التاريخ المستحق للدفعة...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        @if($item->paid == 0)
                            <a href="{{ route('batch.payment', $item->id) }}" class="btn btn-info">ارسل طلب الدفعة {{ $key+1 }}</a>
                        @elseif($item->paid == 1)
                            <input type="hidden" name="multi_payment[{{ $key }}][paid_payment][payment_price]" value="{{ $item->payment_price }}">
                            <input type="hidden" name="multi_payment[{{ $key }}][paid_payment][payment_date]" value="{{ $item->payment_date }}">
                            <button class="btn btn-danger" disabled>تم ارسال طلب الدفعة {{ $key+1 }}</button>
                            @php
                                $paidPayment = true;
                            @endphp
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>اسم الشركة</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="company_name" value="{{ $purchases->company_name }}" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>السعر الاجمالي</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="price" value="{{ $purchases->total_vat }}" readonly>
                </div>
            </div>
        </div>
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
                    <input type="text" class="form-control" name="gentlemen" value="{{ $purchases->gentlemen }}" placeholder="التاريخ...">
                    @error('gentlemen')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>اسم المورد/المقاول حسب السجل التجاري</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="supplier_name" required placeholder="اسم المورد/المقاول حسب السجل التجاري...">
                    @error('supplier_name')
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
                    <input type="text" class="form-control" name="financial_provision" value="{{ $purchases->financial_provision }}" placeholder="المخصص المالي...">
                    @error('financial_provision')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>الرقم</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="number" value="{{ $purchases->number }}" placeholder=" الرقم...">
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
            <div class="col-md-6">

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
