<?php namespace Admin;

use Illuminate\Routing\Controllers\Controller;
use View, Input, Redirect, Session, Validator;
use ShoppingCartConditionPrivacy as ShoppingCartConditionPrivacyModel;
class ShoppingCartPrivacyController  extends \BaseController
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
        $param['pageNo'] = 94;
        $param['descriptions'] = ShoppingCartConditionPrivacyModel::whereRaw('flag = ?', array('privacy'))->get();
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        return View::make('admin.shoppingCartPrivacy.index')->with($param);
    }
    public function create(){
        $param['pageNo'] = 94;
        return View::make('admin.shoppingCartPrivacy.create')->with($param);
    }
    public function store(){
        $rules = [
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
                $description = ShoppingCartConditionPrivacyModel::find($descriptionID);
            }else{
                $description = new ShoppingCartConditionPrivacyModel;
            }
            $description->description = Input::get('description');
            $description->flag="privacy";
            $description->save();
            if($descriptionID !=""){
                $alert['msg'] = 'Shopping cart privacy has been saved successfully';
                $alert['type'] = 'success';
            }else{
                $alert['msg'] = 'Shopping cart privacy has been update successfully';
                $alert['type'] = 'success';
            }
            return Redirect::route('admin.shoppingCart.privacy')->with('alert', $alert);
        }
    }

    public function edit($id){
        $param['pageNo'] = 94;
        $param['description'] = ShoppingCartConditionPrivacyModel::find($id);
        return View::make('admin.shoppingCartPrivacy.create')->with($param);
    }

    public function delete($id){
        try {
            ShoppingCartConditionPrivacyModel::find($id)->delete();
            $alert['msg'] = 'This shopping cart privacy  has been deleted successfully';
            $alert['type'] = 'success';
        } catch(\Exception $ex) {
            $alert['msg'] = 'This shopping cart privacy  focus has been already used';
            $alert['type'] = 'danger';
        }
        return Redirect::route('admin.shoppingCart.privacy')->with('alert', $alert);
    }

}