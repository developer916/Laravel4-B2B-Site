<?php namespace Admin;

use Illuminate\Routing\Controllers\Controller;
use View, Input, Redirect, Session, Validator;
use SubCategory as SubCategoryModel, Category as CategoryModel;
class SubCategoryController  extends \BaseController
{

    public function __construct()
    {
        $this->beforeFilter(function () {
            if (!Session::has('admin_id')) {
                return Redirect::route('admin.auth.login');
            }
        });
    }

    public function index()
    {
        $param['pageNo'] = 22;
        $param['subcategory'] =SubCategoryModel::all();
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        return View::make('admin.subcategory.index')->with($param);
    }
    public function create(){
        $param['pageNo'] = 22;
        $param['category'] =CategoryModel::whereRaw(true)->orderBy('categoryname','asc')->get();
        return View::make('admin.subcategory.create')->with($param);
    }
    public function store(){
        $rules = [
            'category_id'  => 'required',
            'subcategoryname'  => 'required',
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else{
            if (Input::has('subcategory_id')) {
                $id = Input::get('subcategory_id');
                $subcategory = SubCategoryModel::find($id);
            }else{
                $subcategory = new SubCategoryModel;
            }
            $subcategory->category_id = Input::get('category_id');
            $subcategory->subcategoryname = Input::get('subcategoryname');
            $subcategory->save();
            $alert['msg'] = 'Sub Category has been saved successfully';
            $alert['type'] = 'success';
        }
        return Redirect::route('admin.subcategory')->with('alert', $alert);
    }
    public function edit($id){
        $param['pageNo'] = 22;
        $param['category'] =CategoryModel::whereRaw(true)->orderBy('categoryname','asc')->get();
        $param['subcategory'] = SubCategoryModel::find($id);
        return View::make('admin.subcategory.edit')->with($param);
    }
    public function delete($id){
        try {
            SubCategoryModel::find($id)->delete();
            $alert['msg'] = 'This sub category has been deleted successfully';
            $alert['type'] = 'success';
        } catch(\Exception $ex) {
            $alert['msg'] = 'This sub category focus has been already used';
            $alert['type'] = 'danger';
        }
        return Redirect::route('admin.subcategory')->with('alert', $alert);
    }

}