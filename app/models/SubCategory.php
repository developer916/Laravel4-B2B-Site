<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class SubCategory extends Eloquent {

    protected $table = 'subcategory';
    public function category() {
        return $this->belongsTo('Category', 'category_id');
    }
}
