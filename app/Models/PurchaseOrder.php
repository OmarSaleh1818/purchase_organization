<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_purchase_id');
    }

    public function status() {

        return $this->hasOne(Status::class);
    }


}
