<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class RfqPicture extends Eloquent {

    protected $table = 'rfq_picture';

    public function rfq() {
        return $this->belongsTo('Rfq', 'rfq_id');
    }
    public function member(){
        return $this->belongsTo('Members','buyer_id');
    }

}
