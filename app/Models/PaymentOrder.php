<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentOrder extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function status() {

        return $this->hasOne(Status::class);
    }

    public function company() {

        return $this->belongsTo(Company::class, 'company_id','id');
    }

}
