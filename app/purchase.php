<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class purchase extends Model
{

    public function supplierPayment(){
       return $this->belongsTo(supplierPayment::class, 'id','purchase_id');
    }
    public function purchaseDetails(){
        return $this->hasMany(purchaseDetail::class, 'purchase_id', 'id');
    }

}
