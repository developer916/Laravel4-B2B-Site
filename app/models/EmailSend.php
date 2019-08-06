<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class EmailSend extends Eloquent {

    protected $table = 'email';
    public function sender() {
        return $this->belongsTo('Members', 'sender_id');
    }
    public function recevier() {
        return $this->belongsTo('Members', 'receiver_id');
    }

}
