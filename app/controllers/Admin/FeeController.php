<?php namespace Admin;

use Illuminate\Routing\Controllers\Controller;
use View, Input, Redirect, Session, Validator;
use Fee as FeeModel;
class FeeController  extends \BaseController
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
        $param['pageNo'] = 17;
        $param['business'] = FeeModel::all();
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }

        return View::make('admin.fee.index')->with($param);
    }
    public function create(){
        $param['pageNo'] = 17;
        return View::make('admin.fee.create')->with($param);
    }
    public function store(){
        $rules = ['payment_fee'  => 'required',
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else{
            if (Input::has('fee_id')) {
                $id = Input::get('fee_id');
                $business = FeeModel::find($id);
            }else{
                $business = new FeeModel;
            }
            $business->fee = Input::get('payment_fee');
            $business->save();
            $alert['msg'] = 'Payment fee has been saved successfully';
            $alert['type'] = 'success';
        }
        return Redirect::route('admin.fee')->with('alert', $alert);
    }


    public function edit($id){
        $param['pageNo'] = 17;
        $param['business']=FeeModel::find($id);
        return View::make('admin.fee.edit')->with($param);
    }
    public function delete($id){
        try {
            FeeModel::find($id)->delete();
            $alert['msg'] = 'This payment fee has been deleted successfully';
            $alert['type'] = 'success';
        } catch(\Exception $ex) {
            $alert['msg'] = 'This payment fee has been already used';
            $alert['type'] = 'danger';
        }
        return Redirect::route('admin.fee')->with('alert', $alert);
    }
}