<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class EscrowEscrow extends Eloquent {

    protected $table = 'escrow_escrow';

    public function sellerMember(){
        return $this->belongsTo('EscrowUser', 'seller_id');
    }
    public function buyerMember(){
        return $this->belongsTo('EscrowUser', 'buyer_id');
    }

}
