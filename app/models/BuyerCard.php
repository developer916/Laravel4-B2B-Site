<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class BuyerCard extends Eloquent {

    protected $table = 'buyer_card';

    public function quote() {
        return $this->belongsTo('Quote', 'quote_id');
    }
}
