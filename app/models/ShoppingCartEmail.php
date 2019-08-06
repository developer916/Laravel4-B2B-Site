<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class ShoppingCartEmail extends Eloquent
{

    protected $table = 'shopping_cart_email';

    public function sender(){
        return $this->belongsTo('Members' , 'sender_id');
    }
    public function receiver(){
        return $this->belongsTo('Members' , 'receiver_id');
    }
}