<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    public function supplier(){
        return $this->belongsTo(supplier::class);
    }
    public function unit(){
        return $this->belongsTo(unit::class);
    }
    public function category(){
        return $this->belongsTo(category::class);
    }

    public function invoiceDetails(){
        return $this->hasMany(invoiceDetail::class);
    }

    public function purchase(){
        return $this->hasMany(purchase::class);
    }
}
