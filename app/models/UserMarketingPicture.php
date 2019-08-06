<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class UserMarketingPicture extends Eloquent {

    protected $table = 'usermaketingpicture';
    public function member() {
        return $this->belongsTo('member', 'user_id');
    }
}