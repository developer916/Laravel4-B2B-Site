<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class ProductAdditionalCategory extends Eloquent {

    protected $table = 'product_additional_category';
    public function product() {
        return $this->belongsTo('Product', 'product_id');
    }
    public function member() {
        return $this->belongsTo('Members', 'user_id');
    }
    public function additionalCategory() {
        return $this->belongsTo('AdditionalCategory', 'additional_category_id');
    }
    public function productAdditionalCategoryImage(){
        return $this->hasMany('ProductAdditionalImage', 'product_additional_category_id');
    }
}
