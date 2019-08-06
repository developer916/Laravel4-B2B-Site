<?php namespace Admin;

use Illuminate\Routing\Controllers\Controller;
use View, Input, Redirect, Session, Validator;
use Unit as UnitModel;
class UnitController  extends \BaseController
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
        $param['pageNo'] = 16;
        $param['unit'] = UnitModel::all();
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        return View::make('admin.unit.index')->with($param);
    }
    public function create(){
        $param['pageNo'] = 16;
        return View::make('admin.unit.create')->with($param);
    }
    public function store(){
        $rules = ['unitname'  => 'required',
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else {
            if (Input::has('unit_id')) {
                $id = Input::get('unit_id');
                $unit = UnitModel::find($id);
            } else {
                $unit = new UnitModel;
            }
            $unit->unitname = Input::get('unitname');
            $unit->save();
            $alert['msg'] = 'Unit has been saved successfully';
            $alert['type'] = 'success';
        }
        return Redirect::route('admin.unit')->with('alert', $alert);
    }
    public function edit($id){
        $param['pageNo'] = 16;
        $param['unit']=UnitModel::find($id);
        return View::make('admin.unit.edit')->with($param);
    }
    public function delete($id){
        try {
            UnitModel::find($id)->delete();
            $alert['msg'] = 'This unit has been deleted successfully';
            $alert['type'] = 'success';
        } catch(\Exception $ex) {
            $alert['msg'] = 'This unit focus has been already used';
            $alert['type'] = 'danger';
        }
        return Redirect::route('admin.unit')->with('alert', $alert);
    }
}