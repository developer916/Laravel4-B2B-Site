<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class ProductShipping extends Eloquent {

    protected $table = 'product_shipping';

    public function product() {
        return $this->belongsTo('Product', 'product_id');
    }
    public function member() {
        return $this->belongsTo('Members', 'user_id');
    }
    public function flatRate1(){
        return $this->belongsTo('Currency', 'add1');
    }
    public function flatRate2(){
        return $this->belongsTo('Currency', 'add2');
    }
    public function flatRate3(){
        return $this->belongsTo('Currency', 'add3');
    }
}
