<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    public function purchase() {

        return $this->hasMany(Purchase::class);
    }

    public function purchaseOrder() {

        return $this->hasMany(PurchaseOrder::class);
    }

    public function payment() {

        return $this->hasMany(Payment::class);
    }

    public function paymentOrder() {

        return $this->hasMany(PaymentOrder::class);
    }

}
