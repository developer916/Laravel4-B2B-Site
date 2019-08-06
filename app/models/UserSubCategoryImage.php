<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class UserSubCategoryImage extends Eloquent {

    protected $table = 'user_sub_category';
    public function category() {
        return $this->belongsTo('Category', 'category_id');
    }
    public function subcategory() {
        return $this->belongsTo('SubCategory', 'subcategory_id');
    }
    public function member(){
        return $this->belongsTo('Members', 'user_id');
    }
}
