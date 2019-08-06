<?php namespace Admin;

use Illuminate\Routing\Controllers\Controller;
use View, Input, Redirect, Session, Validator;
use FactorySize as FactorySizeModel;
class FactorySizeController  extends \BaseController
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
        $param['pageNo'] = 12;
        $param['country'] = FactorySizeModel::all();
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        return View::make('admin.factorysize.index')->with($param);
    }
    public function create(){
        $param['pageNo'] = 12;
        return View::make('admin.factorysize.create')->with($param);
    }
    public function store(){
        $rules = ['factorysize'  => 'required',
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else{
            if (Input::has('factorysize_id')) {
                $id = Input::get('factorysize_id');
                $factorysize = FactorySizeModel::find($id);
            }else{
                $factorysize = new FactorySizeModel;
            }
            $factorysize->factorysize = Input::get('factorysize');
            $factorysize->save();
            $alert['msg'] = 'Factory size has been saved successfully';
            $alert['type'] = 'success';
        }
        return Redirect::route('admin.factorysize')->with('alert', $alert);
    }
    public function edit($id){
        $param['pageNo'] = 12;
        $param['factorysize']=FactorySizeModel::find($id);
        return View::make('admin.factorysize.edit')->with($param);
    }
    public function delete($id){
        try {
            FactorySizeModel::find($id)->delete();
            $alert['msg'] = 'This factory size has been deleted successfully';
            $alert['type'] = 'success';
        } catch(\Exception $ex) {
            $alert['msg'] = 'This factory size has been already used';
            $alert['type'] = 'danger';
        }
        return Redirect::route('admin.factorysize')->with('alert', $alert);
    }
}