<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class EscrowDispute extends Eloquent {

    protected $table = 'escrow_dispute';

    public function escrowUser(){
        return $this->belongsTo('EscrowUser', 'escrow_user_id');
    }
}
