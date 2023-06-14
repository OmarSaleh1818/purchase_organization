<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptCatch extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function status() {

        return $this->hasOne(Status::class);
    }

}
