<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubSubCompany extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function company() {

        return $this->belongsTo(Company::class, 'company_id','id');
    }

    public function subcompany() {

        return $this->belongsTo(SubCompany::class, 'subcompany_id','id');
    }

}
