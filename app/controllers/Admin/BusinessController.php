<?php namespace Admin;

use Illuminate\Routing\Controllers\Controller;
use View, Input, Redirect, Session, Validator;
use Business as BusinessModel;
class BusinessController  extends \BaseController
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
        $param['pageNo'] = 13;
        $param['business'] = BusinessModel::all();
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        return View::make('admin.business.index')->with($param);
    }
    public function create(){
        $param['pageNo'] = 13;
        return View::make('admin.business.create')->with($param);
    }
    public function store(){
        $rules = ['businesstype'  => 'required',
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else{
            if (Input::has('businesstype_id')) {
                $id = Input::get('businesstype_id');
                $business = BusinessModel::find($id);
            }else{
                $business = new BusinessModel;
            }
            $business->businesstype = Input::get('businesstype');
            $business->save();
            $alert['msg'] = 'Business Type has been saved successfully';
            $alert['type'] = 'success';
        }
        return Redirect::route('admin.business')->with('alert', $alert);
    }
    public function edit($id){
        $param['pageNo'] = 13;
        $param['business']=BusinessModel::find($id);
        return View::make('admin.business.edit')->with($param);
    }
    public function delete($id){
        try {
            BusinessModel::find($id)->delete();
            $alert['msg'] = 'This factory size has been deleted successfully';
            $alert['type'] = 'success';
        } catch(\Exception $ex) {
            $alert['msg'] = 'This factory size has been already used';
            $alert['type'] = 'danger';
        }
        return Redirect::route('admin.business')->with('alert', $alert);
    }
}