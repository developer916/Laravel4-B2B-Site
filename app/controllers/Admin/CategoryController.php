<?php namespace Admin;

use Illuminate\Routing\Controllers\Controller;
use View, Input, Redirect, Session, Validator;
use Category as CategoryModel;
class CategoryController  extends \BaseController
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
        $param['pageNo'] = 21;
        $param['category'] = CategoryModel::all();
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        return View::make('admin.category.index')->with($param);
    }
    public function create(){
        $param['pageNo'] = 21;
        return View::make('admin.category.create')->with($param);
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
                $product = CategoryModel::find($id);
            }else{
                $product = new CategoryModel;
            }
            $product->categoryname = Input::get('categoryname');
            $product->save();
            $alert['msg'] = 'Category has been saved successfully';
            $alert['type'] = 'success';
        }
        return Redirect::route('admin.category')->with('alert', $alert);
    }
    public function edit($id){
        $param['pageNo'] = 21;
        $param['category']=CategoryModel::find($id);
        return View::make('admin.category.edit')->with($param);
    }
    public function delete($id){
        try {
            CategoryModel::find($id)->delete();
            $alert['msg'] = 'This category has been deleted successfully';
            $alert['type'] = 'success';
        } catch(\Exception $ex) {
            $alert['msg'] = 'This category focus has been already used';
            $alert['type'] = 'danger';
        }
        return Redirect::route('admin.category')->with('alert', $alert);
    }
}