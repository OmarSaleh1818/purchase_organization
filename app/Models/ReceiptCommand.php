<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptCommand extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function company() {

        return $this->belongsTo(Company::class, 'company_id','id');
    }

    public function subcompany() {

        return $this->belongsTo(SubCompany::class, 'subcompany_id','id');

    }

    public function subsubcompany() {

        return $this->belongsTo(SubSubCompany::class, 'subsubcompany_id','id');

    }

    public function bankName() {

        return $this->belongsTo(BankName::class, 'bank_id','id');

    }

    public function bankIban() {

        return $this->belongsTo(BankName::class, 'iban_id','id');

    }

}
