<?php namespace Admin;

use Illuminate\Routing\Controllers\Controller;
use View, Input, Redirect, Session, Validator, DB, Mail,File, Request,Response;
use Adminuser as AdminuserModel;
class AuthController extends \BaseController {

    public function index() {
        if (Session::has('admin_id')) {
            return Redirect::route('admin.dashboard');
        } else {
            return Redirect::route('admin.auth.login');
        }
    }

    public function login() {
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
            return View::make('admin.auth.login')->with($param);
        } else {
            return View::make('admin.auth.login');
        }
    }

    public function doLogin() {
        $rules = ['username'  => 'required',
                  'password'  => 'required',
                //  'g-recaptcha-response' => 'required|captcha',
        ];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else {
            $name = Input::get('username');
            $password = Input::get('password');
//            $security = Input::get('security');
//            $securitySessionCode = session::get('securityCode');
//            if ($securitySessionCode != $security) {
//                $alert['msg'] = 'Invalid security code';
//                $alert['type'] = 'danger';
//                return Redirect::route('admin.auth.login')->with('alert', $alert);
//            } else {
                $user = AdminuserModel::whereRaw('AdminUserName = ? and AdminUserPassword = md5(?) and is_active = ?', array($name, $password, '1'))->get();
                if (count($user) != 0) {
                    Session::set('admin_id', 1);
                    Session::set('escrow_user_id',1);

                    return Redirect::route('admin.dashboard');
                } else {
                    $alert['msg'] = 'Invalid username and password';
                    $alert['type'] = 'danger';
                    return Redirect::route('admin.auth.login')->with('alert', $alert);
                }
//            }
        }
    }

    public function logout() {
        Session::forget('admin_id');
        return Redirect::route('admin.auth.login');
    }
    public function capcha(){
        if(Request::ajax()) {
            $width =      Input::get('width');
            $height =     Input::get('height');
            $characters = Input::get('characters');
            $strpattern = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789";
            $result = "";
            for( $i = 0 ; $i < $characters; $i ++ ){
                $rand = rand( 0, strlen($strpattern) - 1 );
                $result = $result.$strpattern[$rand];
            }
            session::put('securityCode' , $result);
            $data= $result;
                return Response::json($data);
        }
    }
}