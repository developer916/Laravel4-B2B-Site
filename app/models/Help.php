<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Help extends Eloquent {

    protected $table = 'help';
    public function category() {
        return $this->belongsTo('HelpCategory', 'category_id');
    }
    public function subCategory() {
        return $this->belongsTo('HelpSubCategory', 'subcategory_id');
    }
}
