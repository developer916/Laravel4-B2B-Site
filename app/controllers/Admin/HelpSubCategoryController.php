<?php namespace Admin;

use Illuminate\Routing\Controllers\Controller;
use View, Input, Redirect, Session, Validator;
use HelpSubCategory as HelpSubCategoryModel, HelpCategory as HelpCategoryModel;
class HelpSubCategoryController  extends \BaseController
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
        $param['pageNo'] = 62;
        $param['subcategory'] =HelpSubCategoryModel::all();
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        return View::make('admin.helpSubcategory.index')->with($param);
    }
    public function create(){
        $param['pageNo'] = 62;
        $param['category'] =HelpCategoryModel::whereRaw(true)->orderBy('categoryname','asc')->get();
        return View::make('admin.helpSubcategory.create')->with($param);
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
                $subcategory = HelpSubCategoryModel::find($id);
            }else{
                $subcategory = new HelpSubCategoryModel;
            }
            $subcategory->category_id = Input::get('category_id');
            $subcategory->subcategoryname = Input::get('subcategoryname');
            $subcategory->save();
            $alert['msg'] = 'Help Sub Category has been saved successfully';
            $alert['type'] = 'success';
        }
        return Redirect::route('admin.helpSubCategory')->with('alert', $alert);
    }
    public function edit($id){
        $param['pageNo'] = 62;
        $param['category'] =HelpCategoryModel::whereRaw(true)->orderBy('categoryname','asc')->get();
        $param['subcategory'] = HelpSubCategoryModel::find($id);
        return View::make('admin.helpSubCategory.edit')->with($param);
    }
    public function delete($id){
        try {
            HelpSubCategoryModel::find($id)->delete();
            $alert['msg'] = 'This help sub category has been deleted successfully';
            $alert['type'] = 'success';
        } catch(\Exception $ex) {
            $alert['msg'] = 'This help sub category focus has been already used';
            $alert['type'] = 'danger';
        }
        return Redirect::route('admin.helpSubCategory')->with('alert', $alert);
    }
}