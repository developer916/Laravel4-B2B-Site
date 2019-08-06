<?php namespace Admin;

use Illuminate\Routing\Controllers\Controller;
use View, Input, Redirect, Session, Validator;
use ProductFocus as ProductFocusModel;
class ProductController  extends \BaseController
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
        $param['pageNo'] = 14;
        $param['product'] = ProductFocusModel::all();
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        return View::make('admin.product.index')->with($param);
    }
    public function create(){
        $param['pageNo'] = 14;
        return View::make('admin.product.create')->with($param);
    }
    public function edit($id){
        $param['pageNo'] = 14;
        $param['product']=ProductFocusModel::find($id);
        return View::make('admin.product.edit')->with($param);
    }
    public function delete($id){
        try {
            ProductFocusModel::find($id)->delete();
            $alert['msg'] = 'This product focus has been deleted successfully';
            $alert['type'] = 'success';
        } catch(\Exception $ex) {
            $alert['msg'] = 'This product focus has been already used';
            $alert['type'] = 'danger';
        }
        return Redirect::route('admin.product')->with('alert', $alert);
    }
    public function store(){
        $rules = ['productfocus'  => 'required',
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else{
            if (Input::has('productfocus_id')) {
                $id = Input::get('productfocus_id');
                $product = ProductFocusModel::find($id);
            }else{
                $product = new ProductFocusModel;
            }
            $product->productfocus = Input::get('productfocus');
            $product->save();
            $alert['msg'] = 'Product Focus has been saved successfully';
            $alert['type'] = 'success';
        }
        return Redirect::route('admin.product')->with('alert', $alert);
    }
}