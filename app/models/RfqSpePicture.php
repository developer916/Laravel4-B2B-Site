<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class RfqSpePicture extends Eloquent {

    protected $table = 'rfq_specificationpicture';

    public function rfq() {
        return $this->belongsTo('Rfq', 'rfq_id');
    }
    public function member(){
        return $this->belongsTo('Members','buyer_id');
    }
    public function specification(){
        return $this->belongsTo('RfqSpe','specification_id');
    }
}
