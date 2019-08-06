<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class ProductPicture extends Eloquent {

    protected $table = 'productpicture';
    public function product() {
        return $this->belongsTo('Product', 'product_id');
    }
    public function member() {
        return $this->belongsTo('Members', 'user_id');
    }
}
