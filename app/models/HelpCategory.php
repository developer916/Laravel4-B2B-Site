<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class HelpCategory extends Eloquent {

    protected $table = 'helpcategory';
    public function subCategories() {
        return $this->hasMany('HelpSubCategory', 'category_id');
    }
}
