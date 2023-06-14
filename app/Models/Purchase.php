<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function purchase() {

        return $this->hasOne(PurchaseOrder::class);

    }

    public function company() {

        return $this->belongsTo(Company::class, 'company_id','id');

    }

    public function subcompany() {

        return $this->belongsTo(SubCompany::class, 'subcompany_id','id');

    }

    public function subsubcompany() {

        return $this->belongsTo(SubSubCompany::class, 'subsubcompany_id','id');

    }

    public function multiPurchases() {

        return $this->hasMany(multiPurchase::class);
    }

    public function status() {

        return $this->hasOne(Status::class);
    }
}
