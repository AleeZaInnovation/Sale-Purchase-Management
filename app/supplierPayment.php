<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class supplierPayment extends Model
{
    public function supplier(){
        return $this->belongsTo(supplier::class, 'supplier_id', 'id');
    }
    public function purchase(){
        return $this->belongsTo(purchase::class, 'purchase_id','id');
    }
}
