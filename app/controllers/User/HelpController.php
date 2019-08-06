<?php namespace User;

use Illuminate\Routing\Controllers\Controller;
use View, Input, Redirect, Session, Validator, DB, Mail,File, Request,Response;
use Help as HelpModel, HelpCategory as HelpCategoryModel, HelpSubCategory as HelpSubCategoryModel;
class HelpController extends \BaseController {
    public function index(){
        $param['pageNo'] =10;
        $param['helpCategory'] = HelpCategoryModel::whereRaw(true)->orderBy('categoryname','asc')->get();
        $param['helps'] = HelpModel::all();
        $param['id'] ='';
        return View::make('user.help.index')->with($param);
    }
    public function getTitle(){
        if(Request::ajax()){
            $list = HelpModel::all();
            $j =0;
            $source = array();
            foreach($list as $listes){
                $source[$j] = $listes->title;
                $j++;
            }
            $data = array();
            $data['result'] ="success";
            $data['source'] = $source;
           return Response::json($data);
        }
    }
    public function search(){
        $param['pageNo'] = 10;
        $slug = Input::get('searchTitle');
        $param['helpCategory'] = HelpCategoryModel::whereRaw(true)->orderBy('categoryname','asc')->get();
        $param['helps'] = HelpModel::where('title','LIKE','%'.$slug.'%')->get();
        $param['slug'] = $slug;
        $param['id'] ='';
        return View::make('user.help.search')->with($param);
    }
    public function faq_list($id){
        $param['pageNo'] = 10;
        $listID = $id-100000;
        $param['helpCategory'] = HelpCategoryModel::whereRaw(true)->orderBy('categoryname','asc')->get();
        $param['helps'] = HelpModel::whereRaw('subcategory_id=?', array($listID))->get();
        $param['id'] = $listID;
        return View::make('user.help.list')->with($param);
    }
    public function faq_item($id){
        $param['pageNo'] = 10;
        $listID = $id-100000;
        $param['helpCategory'] = HelpCategoryModel::whereRaw(true)->orderBy('categoryname','asc')->get();
        $list = HelpModel::whereRaw('id=?', array($listID))->get();
        $param['helps']=$list;
        $param['id'] = $list[0]->subcategory_id;
        return View::make('user.help.item')->with($param);
    }
}