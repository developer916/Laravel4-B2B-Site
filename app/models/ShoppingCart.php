<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class ShoppingCart extends Eloquent {

    protected $table = 'shopping_cart';
    public function billingCountry() {
        return $this->belongsTo('Country', 'billing_country');
    }
    public function shoppingCountry() {
        return $this->belongsTo('Country', 'shipping_country');
    }
    public function member(){
        return $this->belongsTo('Members','buyer_id');
    }
    public function shoppingCartItems(){
        return $this->hasMany('ShoppingCartProduct','cart_id');
    }
}
