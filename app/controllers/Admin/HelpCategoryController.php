<?php namespace Admin;

use Illuminate\Routing\Controllers\Controller;
use Illuminate\Validation\Factory;
use View, Input, Redirect, Session, Validator, DB,Request,Response;
use HelpCategory as HelpCategoryModel;
class HelpCategoryController  extends \BaseController
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
        $param['pageNo'] = 61;
        $param['category'] = HelpCategoryModel::all();
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        return View::make('admin.helpCategory.index')->with($param);
    }
    public function create(){
        $param['pageNo'] = 61;
        return View::make('admin.helpCategory.create')->with($param);
    }
    public function store(){
        $rules = ['categoryname'  => 'required',
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else{
            if (Input::has('category_id')) {
                $id = Input::get('category_id');
                $product = HelpCategoryModel::find($id);
            }else{
                $product = new HelpCategoryModel;
            }
            $product->categoryname = Input::get('categoryname');
            $product->save();
            $alert['msg'] = 'Help Category has been saved successfully';
            $alert['type'] = 'success';
        }
        return Redirect::route('admin.helpCategory')->with('alert', $alert);
    }
    public function edit($id){
        $param['pageNo'] = 61;
        $param['category']=HelpCategoryModel::find($id);
        return View::make('admin.helpCategory.edit')->with($param);
    }
    public function delete($id){
        try {
            HelpCategoryModel::find($id)->delete();
            $alert['msg'] = 'This help category has been deleted successfully';
            $alert['type'] = 'success';
        } catch(\Exception $ex) {
            $alert['msg'] = 'This help category focus has been already used';
            $alert['type'] = 'danger';
        }
        return Redirect::route('admin.helpCategory')->with('alert', $alert);
    }
}