<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Product extends Eloquent {

    protected $table = 'product';
    public function category() {
        return $this->belongsTo('Category', 'category_id');
    }
    public function subCategory() {
        return $this->belongsTo('SubCategory', 'subcategory_id');
    }
    public function member() {
        return $this->belongsTo('Members', 'user_id');
    }
    public function productpicture()
    {
        return $this->hasMany('ProductPicture', 'product_id');
    }
    public function minOrderUnit(){
        return $this->belongsTo('Unit', 'min_order_unit');
    }
    public function supplyAbilityUnit(){
        return $this->belongsTo('Unit', 'supply_ability_unit');
    }
    public function productCurrencyPrice1(){
        return $this->belongsTo('Currency', 'price1_currency');
    }
    public function productCurrencyPrice2(){
        return $this->belongsTo('Currency', 'price2_currency');
    }
    public function productCurrencyPrice3(){
        return $this->belongsTo('Currency', 'price3_currency');
    }
    public function productQuickDetails(){
        return $this->hasMany('ProductQuickDetail','product_id');
    }
    public function productShipping()
    {
        return $this->hasOne('ProductShipping', 'product_id');
    }

}
