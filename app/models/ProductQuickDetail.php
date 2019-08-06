<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class ProductQuickDetail extends Eloquent {

    protected $table = 'product_quick_details';
    public function product() {
        return $this->belongsTo('Product', 'product_id');
    }
    public function member() {
        return $this->belongsTo('Members', 'user_id');
    }
}
