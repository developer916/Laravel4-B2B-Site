<?php namespace Admin;

use Illuminate\Routing\Controllers\Controller;
use View, Input, Redirect, Session, Validator;
use ShoppingCartDescription as ShoppingCartDescriptionModel;
class ShoppingCartDescriptionController  extends \BaseController
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
        $param['pageNo'] = 91;
        $param['descriptions'] = ShoppingCartDescriptionModel::all();
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        return View::make('admin.shoppingCartDescription.index')->with($param);
    }
    public function create(){
        $param['pageNo'] = 91;
        return View::make('admin.shoppingCartDescription.create')->with($param);
    }
    public function store(){
        $rules = [
            'title'  => 'required',
            'description'  => 'required'
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else {
            $descriptionID = Input::get('descriptionID');

            if($descriptionID !=""){
                $description = ShoppingCartDescriptionModel::find($descriptionID);
            }else{
                $description = new ShoppingCartDescriptionModel;
            }
            $description->title = Input::get('title');
            $description->description = Input::get('description');
            $description->save();
            if($descriptionID !=""){
                $alert['msg'] = 'Shopping cart description has been saved successfully';
                $alert['type'] = 'success';
            }else{
                $alert['msg'] = 'Shopping cart description has been update successfully';
                $alert['type'] = 'success';
            }
            return Redirect::route('admin.shoppingCart.description')->with('alert', $alert);
        }
    }
    public function edit($id){
        $param['pageNo'] = 91;
        $param['description'] = ShoppingCartDescriptionModel::find($id);
        return View::make('admin.shoppingCartDescription.create')->with($param);
    }
    public function delete($id){
        try {
            ShoppingCartDescriptionModel::find($id)->delete();
            $alert['msg'] = 'This shopping cart description  has been deleted successfully';
            $alert['type'] = 'success';
        } catch(\Exception $ex) {
            $alert['msg'] = 'This shopping cart description  focus has been already used';
            $alert['type'] = 'danger';
        }
        return Redirect::route('admin.shoppingCart.description')->with('alert', $alert);
    }
}