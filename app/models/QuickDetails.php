<?php

use Illuminate\Database\Eloquent\Model as Eloquent;
use QuickDetailsCategory as QuickDetailsCategoryyModel;
class QuickDetails extends Eloquent
{

    protected $table = 'quick_details';
    public function category() {
        return $this->belongsTo('QuickDetailsCategory', 'category_id');
    }
    public static function getAll($id){
        return QuickDetails::whereRaw('category_id =?', array($id))->get();
    }
    public static function getCategory($id){
        return QuickDetailsCategoryyModel::find($id);
    }
}