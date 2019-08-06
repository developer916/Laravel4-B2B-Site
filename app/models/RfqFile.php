<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class RfqFile extends Eloquent {

    protected $table = 'rfq_file';

    public function rfq() {
        return $this->belongsTo('Rfq', 'rfq_id');
    }
    public function member(){
        return $this->belongsTo('Members','buyer_id');
    }

}
