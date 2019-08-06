<?php namespace Admin;

use Illuminate\Routing\Controllers\Controller;
use View, Input, Redirect, Session, Validator;
use Conditions as ConditionsModel;
class TermsController  extends \BaseController
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
        $param['pageNo'] = 19;
        $param['conditions'] = ConditionsModel::whereRaw(true)->orderby('id','asc')->get();
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        return View::make('admin.conditions.index')->with($param);
    }

    public function create(){
        $param['pageNo'] = 19;
        return View::make('admin.conditions.create')->with($param);
    }

    public function store(){
        $rules = [
            'realContent' => 'required',
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else{
            if (Input::has('conditions_id')) {
                $id = Input::get('conditions_id');
                $conditions = ConditionsModel::find($id);
            }else{
                $conditions = new ConditionsModel;
            }
            $conditions->title = Input::get('title');
            $conditions->description = Input::get('realContent');
            $conditions->save();
            $alert['msg'] = 'Terms and conditions  has been saved successfully';
            $alert['type'] = 'success';
        }
        return Redirect::route('admin.terms_conditions')->with('alert', $alert);
    }
    public function edit($id){
        $param['pageNo'] = 19;
        $param['condition']= ConditionsModel::find($id);
        return View::make('admin.conditions.edit')->with($param);
    }
    public function delete($id){
        try {
            ConditionsModel::find($id)->delete();
            $alert['msg'] = 'Terms & condition  has been deleted successfully';
            $alert['type'] = 'success';
        } catch(\Exception $ex) {
            $alert['msg'] = ' Terms & condition has been already used';
            $alert['type'] = 'danger';
        }
        return Redirect::route('admin.terms_conditions')->with('alert', $alert);
    }
}