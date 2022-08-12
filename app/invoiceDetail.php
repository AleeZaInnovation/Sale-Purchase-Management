<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class invoiceDetail extends Model
{
    
    



    public function category(){
    return $this->belongsTo(category::class);
   }
   public function product(){
    return $this->belongsTo(product::class);
   }

   public function invoice(){
    return $this->belongsTo(invoice::class);
   }
}
