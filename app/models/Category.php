<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Category extends Eloquent {

    protected $table = 'categories';
    public function subCategories() {
        return $this->hasMany('SubCategory', 'category_id');
    }
    public function categoryImage(){
        return $this->hasMany('SubCategory', 'category_id');
    }
}
