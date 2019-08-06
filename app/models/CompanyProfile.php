<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class CompanyProfile extends Eloquent {

    protected $table = 'companyprofiles';

    public function member() {
        return $this->belongsTo('Members', 'user_id');
    }

}
