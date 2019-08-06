<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class EscrowUser extends Eloquent {

    protected $table = 'escrow_users';
    public function member(){
        return $this->belongsTo('Members' , 'purchasetree_id');
    }
}
