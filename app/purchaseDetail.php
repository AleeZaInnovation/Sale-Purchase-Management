<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class purchaseDetail extends Model
{
    //

    public function supplier(){
        return $this->belongsTo(supplier::class,'supplier_id','id');
    }
    public function unit(){
        return $this->belongsTo(unit::class,'unit_id','id');
    }
    public function category(){
        return $this->belongsTo(category::class,'category_id','id');
    }
    public function product(){
        return $this->belongsTo(product::class,'product_id','id');
    }

    public function purchase(){
        return $this->belongsTo(purchase::class,'purchase_id','id');
    }
}
