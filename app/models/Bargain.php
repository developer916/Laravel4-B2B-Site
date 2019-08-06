<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Bargain extends Eloquent {

    protected $table = 'bargain';
    public function product(){
        return $this->belongsTo('Product', 'product_id');
    }
}
