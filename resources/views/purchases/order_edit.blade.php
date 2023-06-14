@extends('layouts.master')
@section('title')
    تعديل طلب شراء
@endsection
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">مشتريات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل طلب شراء</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->

    <form method="post" action="{{ route('order.update',$purchases->id) }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>السادة</label>
                    <input type="text" class="form-control" name="gentlemen" value="{{ $purchases->gentlemen }}" placeholder="اسم السادة...">
                    @error('gentlemen')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>عناية الاستاذ</label>
                    <input type="text" class="form-control" name="professor_care" value="{{ $purchases->professor_care }}" placeholder="عناية الاستاذ...">
                    @error('professor_care')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>رقم طلب الشراء</label>
                    <input type="text" class="form-control" name="order_purchase_number" value="{{ $purchases->order_purchase_number }}" readonly>
                    @error('order_purchase_number')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>رقم طلب المواد</label>
                    <input type="text" class="form-control" name="order_material_number" value="{{ $purchases->order_material_number }}" readonly>
                    @error('order_material_number')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>تاريخ طلب الشراء</label>
                    <input type="date" class="form-control" name="order_purchase_date" value="{{ $purchases->order_purchase_date }}"
                           min="{{ Carbon\Carbon::now()->format('Y-m-d') }}" placeholder="التاريخ...">
                    @error('order_purchase_date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>اسم المشروع</label>
                    <input type="text" class="form-control" name="project_name" value="{{ $purchases->project_name }}" readonly >
                    @error('project_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>رقم المشروع</label>
                    <input type="text" class="form-control" name="project_number" value="{{ $purchases->project_number }}" readonly>
                    @error('project_number')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>العنوان</label>
                    <input type="text" class="form-control" name="address" value="{{ $purchases->address }}" placeholder="العنوان...">
                    @error('address')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>رقم التلفون</label>
                    <input type="text" class="form-control" name="phone_number" value="{{ $purchases->phone_number }}" placeholder="رقم التلفون...">
                    @error('phone_number')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>الايميل</label>
                    <input type="email" class="form-control" name="email" value="{{ $purchases->email }}" placeholder="الايميل...">
                    @error('email')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>الموضوع</label>
                    <input type="text" class="form-control" name="subject" value="{{ $purchases->subject }}" placeholder="الموضوع...">
                    @error('subject')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>التسلسل</label>
                    <input type="text" class="form-control" name="sequencing" value="{{ $purchases->sequencing }}" placeholder="التسلسل...">
                    @error('sequencing')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>البيان</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="purchase_name" value="{{ $purchases->purchase_name }}" readonly>
                    @error('purchase_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>الوحدة</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="unit" value="{{ $purchases->unit }}" readonly>
                    @error('unit')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>الكمية</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="quantity" value="{{ $purchases->quantity }}" placeholder="الكمية...">
                    @error('quantity')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>السعر</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="price" value="{{ $purchases->price }}" placeholder="السعر...">
                    @error('price')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>المجموع</label>
                    <input type="text" class="form-control" name="total" value="{{ $purchases->total }}" placeholder="المجموع...">
                    @error('total')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>الخصم</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="discount" value="{{ $purchases->discount }}" placeholder="الخصم...">
                    @error('discount')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>الاجمالي بعد الخصم</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="total_discount" value="{{ $purchases->total_discount }}" placeholder="الاجمالي بعد الخصم...">
                    @error('total_discount')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>الضريبة المضافة</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="added_vat" value="{{ $purchases->added_vat }}" placeholder="الضريبة المضافة...">
                    @error('added_vat')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>الاجمالي بعد الضريبة</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="total_vat" value="{{ $purchases->total_vat }}" placeholder="الاجمالي بعد الضريبة...">
                    @error('total_vat')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>موقع التسليم</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="delivery_location" value="{{ $purchases->delivery_location }}" placeholder="موقع التسليم...">
                    @error('delivery_location')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>تاريخ التسليم</label><span style="color: red;">  *</span>
                    <input type="date" class="form-control" name="delivery_date" value="{{ $purchases->delivery_date }}" placeholder="تاريخ التسليم...">
                    @error('delivery_date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>شروط السداد</label>
                    <input type="text" class="form-control" name="terms_payment" value="{{ $purchases->terms_payment }}" placeholder="شروط السداد...">
                    @error('terms_payment')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <input type="submit" class="btn btn-info" value="تأكيد">
        </div>
    </form>

    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
@endsection
