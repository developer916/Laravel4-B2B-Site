<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class RfqSpe extends Eloquent {

    protected $table = 'rfq_specification';

    public function rfq() {
        return $this->belongsTo('Rfq', 'rfq_id');
    }
    public function member(){
        return $this->belongsTo('Members','buyer_id');
    }
    public function specificationPicture(){
        return $this->hasMany('RfqSpePicture','specification_id');
    }
    public function quoteSpecification(){
        return $this->hasOne('QuoteSpe', 'specification_id');
    }
}
