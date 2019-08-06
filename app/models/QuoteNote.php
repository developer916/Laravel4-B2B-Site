<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class QuoteNote extends Eloquent {

    protected $table = 'seller_quote_note';

    public function sellerMember(){
        return $this->belongsTo('Members' , 'seller_id');
    }
    public function buyerMember(){
        return $this->belongsTo('Members' , 'buyer_id');
    }
    public function rfq() {
        return $this->belongsTo('Rfq', 'rfq_id');
    }
    public function quote() {
        return $this->belongsTo('Quote', 'quote_id');
    }
}
