<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class ShoppingCartDispute extends Eloquent
{


    protected $table = 'shopping_cart_dispute';

    public function ShoppingCart(){
        return $this->belongsTo('ShoppingCart', 'cart_id');
    }

    public function Product(){
        return $this->belongsTo('Product', 'cart_product_id');
    }

    public function sender(){
        return $this->belongsTo('Members','sender_id');
    }
    public function receiver(){
        return $this->belongsTo('Members','receiver_id');
    }


}