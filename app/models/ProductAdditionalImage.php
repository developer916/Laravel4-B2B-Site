<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class ProductAdditionalImage extends Eloquent {

    protected $table = 'product_additional_image';
    public function product() {
        return $this->belongsTo('Product', 'product_id');
    }
    public function member() {
        return $this->belongsTo('Members', 'user_id');
    }
    public function additionalCategory() {
        return $this->belongsTo('AdditionalCategory', 'additional_category_id');
    }
    public function productAdditionalCategory() {
        return $this->belongsTo('ProductAdditionalCategory', 'product_additional_category_id');
    }
}
