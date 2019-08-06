<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Rfq extends Eloquent {

    protected $table = 'rfq';

    public function member(){
        return $this->belongsTo('Members' , 'buyer_id');
    }

    public function rfqImage() {
        return $this->hasMany('RfqPicture', 'rfq_id');
    }

    public function rfqFile(){
        return $this->hasMany('RfqFile', 'rfq_id');
    }
    public function rfqSpecifications(){
        return $this->hasMany('RfqSpe', 'rfq_id');
    }
    public function rfqSpecificationpicture(){
        return $this->hasMany('RfqSpePicture', 'specification_id');
    }

    public function unit(){
        return $this->belongsTo('Unit','rfq_unit');
    }
    public function quote(){
        return $this->belongsTo('Quote','rfq_id');
    }
}
