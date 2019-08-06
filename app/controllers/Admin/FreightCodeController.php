<?php namespace Admin;

use Illuminate\Routing\Controllers\Controller;
use View, Input, Redirect, Session, Validator;
use FreightCode  as FreightCodeModel;
class FreightCodeController  extends \BaseController
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
        $param['pageNo'] = 18;
        $param['freights'] = FreightCodeModel::all();
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }

        return View::make('admin.freight.index')->with($param);
    }

    public function create(){
        $param['pageNo'] = 18;
        return View::make('admin.freight.create')->with($param);
    }
    public function store(){
        $rules = ['freight_code'  => 'required',
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else{
            if (Input::has('freight_code_id')) {
                $id = Input::get('freight_code_id');
                $business = FreightCodeModel::find($id);
            }else{
                $business = new FreightCodeModel;
            }
            $business->code = Input::get('freight_code');
            $business->save();
            $alert['msg'] = 'Payment freight code  has been saved successfully';
            $alert['type'] = 'success';
        }
        return Redirect::route('admin.freight')->with('alert', $alert);
    }
    public function edit($id){
        $param['pageNo'] = 18;
        $param['freight']=FreightCodeModel::find($id);
        return View::make('admin.freight.edit')->with($param);
    }
    public function delete($id){
        try {
            FreightCodeModel::find($id)->delete();
            $alert['msg'] = 'This freight code has been deleted successfully';
            $alert['type'] = 'success';
        } catch(\Exception $ex) {
            $alert['msg'] = 'This freight code has been already used';
            $alert['type'] = 'danger';
        }
        return Redirect::route('admin.freight')->with('alert', $alert);
    }
}