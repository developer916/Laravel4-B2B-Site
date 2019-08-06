<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Quote extends Eloquent {

    protected $table = 'seller_quote';

    public function sellerMember(){
        return $this->belongsTo('Members' , 'seller_id');
    }
    public function buyerMember(){
        return $this->belongsTo('Members' , 'buyer_id');
    }
    public function rfq() {
        return $this->belongsTo('Rfq', 'rfq_id');
    }
    public function quoteNote() {
        return $this->hasMany('QuoteNote', 'quote_id');
    }
    public function quotePic() {
        return $this->hasMany('QuotePicture', 'quote_id');
    }
    public function quoteSpe() {
        return $this->hasMany('QuoteSpe', 'quote_id');
    }
    public function quoteSample(){
        return $this->hasMany('QuoteSample', 'quote_id');
    }
    public function sampleBuyerCard(){
        return $this->hasMany('BuyerCard','quote_id');
    }
    public function Currency(){
        return $this->belongsTo('Currency','price_currency');
    }
    public function SampleCurrency(){
        return $this->belongsTo('Currency','sample_price_currency');
    }
}
