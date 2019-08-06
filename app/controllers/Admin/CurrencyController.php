<?php namespace Admin;

use Illuminate\Routing\Controllers\Controller;
use Intervention\Image\Facades\Image;
use View, Input, Redirect, Session, Validator;
use Currency as CurrencyModel;
class CurrencyController extends \BaseController
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
        $param['pageNo'] = 15;
        $param['country'] = CurrencyModel::whereRaw(true)->orderby('currency_name', 'asc')->get();
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        return View::make('admin.currency.index')->with($param);
    }
    public function create(){
        $param['pageNo'] = 15;
        return View::make('admin.currency.create')->with($param);
    }
    public function store(){
        $rules = ['currency_name'  => 'required',
                 'currency_symbol' => 'required',
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else{
            if (Input::has('currency_id')) {
                $id = Input::get('currency_id');
                $currency = CurrencyModel::find($id);
            }else{
                $currency = new CurrencyModel;
            }
            $currency->currency_name = Input::get('currency_name');
            $currency->currency_symbol = Input::get('currency_symbol');
            $currency->save();
            $alert['msg'] = 'Currency has been saved successfully';
            $alert['type'] = 'success';
        }
        return Redirect::route('admin.currency')->with('alert', $alert);
    }
    public function edit($id){
        $param['pageNo'] = 15;
        $param['currency'] = CurrencyModel::find($id);
        return View::make('admin.currency.edit')->with($param);
    }
    public function delete($id){
        try {
            CurrencyModel::find($id)->delete();
            $alert['msg'] = 'This currency has been deleted successfully';
            $alert['type'] = 'success';
        } catch(\Exception $ex) {
            $alert['msg'] = 'This currency has been already used';
            $alert['type'] = 'danger';
        }
        return Redirect::route('admin.currency')->with('alert', $alert);
    }
}