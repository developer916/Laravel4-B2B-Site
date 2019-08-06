<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class UserCategoryImage extends Eloquent {

    protected $table = 'user_category';
    public function category() {
        return $this->belongsTo('Category', 'category_id');
    }
    public function member(){
        return $this->belongsTo('Members', 'user_id');
    }
}
