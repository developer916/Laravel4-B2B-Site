<?php namespace Admin;

use Illuminate\Routing\Controllers\Controller;
use Intervention\Image\Facades\Image;
use View, Input, Redirect, Session, Validator;
use Country as CountryModel;
class CountryController extends \BaseController
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
        $param['pageNo'] = 11;
        $param['country'] = CountryModel::whereRaw(true)->orderby('country_name','asc')->get();
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        return View::make('admin.country.index')->with($param);
    }
    public function create(){
        $param['pageNo'] = 11;
        return View::make('admin.country.create')->with($param);
    }
    public function store(){
        $rules = ['country_name'  => 'required',
                  'country_flag' => 'required|image|max:1024',
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else{
            $name = Input::get('country_name');
            $country_name = ucwords($name);
            $name = "flag"."_".str_replace(' ', '_', $country_name);
            if (Input::hasFile('country_flag')) {
                $image = Input::file('country_flag');
                $filename  = str_random(24) . '.' . $image->getClientOriginalExtension();
                $path = ABS_LOGO_PATH.$filename;
                Image::make($image->getRealPath())->resize(20, 20)->save($path);
            }
            if (Input::has('country_id')) {
                $id = Input::get('country_id');
                $country = CountryModel::find($id);
            }else{
                $country = new CountryModel;
            }
            $country->country_name = $country_name;
            $country->country_flag = $filename;
            $country->save();
            $alert['msg'] = 'Country has been saved successfully';
            $alert['type'] = 'success';
        }
        return Redirect::route('admin.country')->with('alert', $alert);
    }
    public function edit($id){
        $param['pageNo'] = 11;
        $param['country'] = CountryModel::find($id);
        return View::make('admin.country.edit')->with($param);
    }
    public function delete($id){
        try {
            CountryModel::find($id)->delete();
            $alert['msg'] = 'This country has been deleted successfully';
            $alert['type'] = 'success';
        } catch(\Exception $ex) {
            $alert['msg'] = 'This country has been already used';
            $alert['type'] = 'danger';
        }
        return Redirect::route('admin.country')->with('alert', $alert);
    }
}