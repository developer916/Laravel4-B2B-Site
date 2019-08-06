<?php namespace Admin;

use Illuminate\Routing\Controllers\Controller;
use Intervention\Image\Facades\Image;
use View, Input, Redirect, Session, Validator,Response;
use QuickDetails as QuickDetailsModel,Category as CategoryModel,QuickDetailsCategory as QuickDetailsCategoryModel;
class QuickController  extends \BaseController
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
        $param['pageNo'] = 44;
        $param['quick'] = QuickDetailsModel::whereRaw(true)->orderBy('quick_details_name','asc')->get();
        $param['quickCategory'] = QuickDetailsCategoryModel::whereRaw(true)->orderBy('categoryname','asc')->get();
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        return View::make('admin.details.index')->with($param);
    }

    public function create(){
        $param['pageNo'] = 44;
        $param['categories'] = CategoryModel::whereRaw(true)->orderBy('categoryname','asc')->get();
        $param['quickCategory'] = QuickDetailsCategoryModel::whereRaw(true)->orderBy('categoryname','asc')->get();
        return View::make('admin.details.create')->with($param);
    }
    public function categoryStore(){
        $rules = ['categoryName' => 'required',
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $category_id = Input::get('quick_category_id');
            if($category_id != ""){
                $quickCategory = QuickDetailsCategoryModel::find($category_id);
            }else{
                $quickCategory = new QuickDetailsCategoryModel;
            }
            $quickCategory->categoryname = Input::get('categoryName');
            $quickCategory->save();
            $alert['msg'] = 'Quick detail category has been saved successfully';
            $alert['type'] = 'success';
            return Redirect::back();
        }
    }
    public function store()
    {
        $rules = ['category' => 'required',
            'quick_details' => 'required',
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $quick_id = Input::get('quick_id');
            if($quick_id != ""){
                $quick = QuickDetailsModel::find($quick_id);
            }else{
                $quick = new QuickDetailsModel;
            }
            $quick->category_id = Input::get('category');
            $quick->quick_details_name = Input::get('quick_details');
            $quick->save();
            $alert['msg'] = 'Quick detail has been saved successfully';
            $alert['type'] = 'success';
            return Redirect::route('admin.quick')->with('alert', $alert);
        }
    }
    public function edit($id){
        $param['pageNo'] = 11;
        $param['categories'] = CategoryModel::whereRaw(true)->orderBy('categoryname','asc')->get();
        $param['quickCategory'] = QuickDetailsCategoryModel::whereRaw(true)->orderBy('categoryname','asc')->get();
        $param['quick'] = QuickDetailsModel::find($id);
        return View::make('admin.details.edit')->with($param);
    }
    public function delete($id){
        try {

            QuickDetailsModel::find($id)->delete();
            $alert['msg'] = 'This quick detail has been deleted successfully';
            $alert['type'] = 'success';
        } catch(\Exception $ex) {
            $alert['msg'] = 'This quick detail has been already used';
            $alert['type'] = 'danger';
        }
        return Redirect::route('admin.quick')->with('alert', $alert);
    }
    public function CategoryDelete($id){
        try {
            QuickDetailsModel::whereRaw('category_id = ?', array($id))->delete();
            QuickDetailsCategoryModel::find($id)->delete();
        } catch(\Exception $ex) {
        }
        return Redirect::back();
    }
    public function categoryEdit(){
        $id = Input::get('id');
        $category = QuickDetailsCategoryModel::find($id);
        return Response::json(['result' =>'success', 'id' =>$id, 'categoryName' =>$category->categoryname ]);
    }
}