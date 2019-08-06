<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class HelpSubCategory extends Eloquent {

    protected $table = 'helpsubcategory';
    public function category() {
        return $this->belongsTo('HelpCategory', 'category_id');
    }
}
