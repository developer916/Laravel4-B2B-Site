<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Members extends Eloquent {

    protected $table = 'member';
    public function country() {
        return $this->belongsTo('Country', 'country_id');
    }
    public function maketing(){
        return $this->hasMany('UserMarketingPicture', 'user_id');
    }
    public function companyProfile(){
        return $this->hasOne('CompanyProfile', 'user_id');
    }
}
