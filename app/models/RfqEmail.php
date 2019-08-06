<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class RfqEmail extends Eloquent {
    protected $table = 'rfq_email';
    public function sender(){
        return $this->belongsTo('Members' , 'sender_id');
    }
    public function receiver(){
        return $this->belongsTo('Members' , 'receiver_id');
    }
    public function rfq(){
        return $this->belongsTo('Rfq','rfq_id');
    }
}