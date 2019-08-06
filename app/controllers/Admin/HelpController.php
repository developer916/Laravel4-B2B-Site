<?php namespace Admin;

use Illuminate\Routing\Controllers\Controller;
use Illuminate\Validation\Factory;
use View, Input, Redirect, Session, Validator, DB,Request,Response;
use HelpCategory as HelpCategoryModel, Help as HelpModel, HelpSubCategory as HelpSubCategoryModel;
class HelpController  extends \BaseController
{

    public function __construct()
    {
        $this->beforeFilter(function () {
            if (!Session::has('admin_id')) {
                return Redirect::route('admin.auth.login');
            }
        });
    }
    public function index(){
        $param['pageNo'] = 63;
        $param['help'] = HelpModel::all();
        return View::make('admin.help.index')->with($param);
    }
    public function create(){
        $param['pageNo'] = 63;
        $param['category'] = HelpCategoryModel::whereRaw(true)->orderBy('categoryname','asc')->get();
        $param['subCategory'] = HelpSubCategoryModel::whereRaw(true)->orderBy('subcategoryname','asc')->get();
        return View::make('admin.help.create')->with($param);
    }
    public function getSubCategory(){
        if(Request::ajax()){
            $categoryID = Input::get('categoryID');
            $subcategory = HelpSubCategoryModel::whereRaw('category_id = ?', array($categoryID))->get();
            $data = array('result'=> 'success', 'subcategory' => $subcategory);
        }
        return Response::json($data);
    }
    public function store(){

        $rules = [
            'category'  => 'required ',
            'subcategory'  => 'required ',
            'title' => 'required ',
            'subcontent' => 'required ',
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else{
            if (Input::has('createID')) {
                $id = Input::get('createID');
                $help = HelpModel::find($id);

            }else{
                $help = new HelpModel;
            }
            $help->category_id = Input::get('category');
            $help->subcategory_id = Input::get('subcategory');
            $help->title = Input::get('title');
            $help->content = Input::get('subcontent');
            $help->save();
            $alert['msg'] = 'Product has been saved successfully';
            $alert['type'] = 'success';

        }
        return Redirect::route('admin.helpCreating')->with('alert', $alert);
    }
    public function edit($id){
        $param['pageNo'] = 63;
        $param['help'] = HelpModel::find($id);
        $param['category'] = HelpCategoryModel::whereRaw(true)->orderBy('categoryname','asc')->get();
        $param['subcategory'] = HelpSubCategoryModel::whereRaw('category_id = ?', array($param['help']->category_id))->get();

        return View::make('admin.help.edit')->with($param);
    }
    public function delete($id){
        try {
            HelpModel::find($id)->delete();
            $alert['msg'] = 'This help has been deleted successfully';
            $alert['type'] = 'success';
        } catch(\Exception $ex) {
            $alert['msg'] = 'This help has been already used';
            $alert['type'] = 'danger';
        }
        return Redirect::route('admin.helpCreating')->with('alert', $alert);
    }
}