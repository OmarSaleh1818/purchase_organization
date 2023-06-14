<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class multiPurchase extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function purchases() {

        return $this->belongsTo(Purchase::class, 'purchase_id', 'id');

    }
}
