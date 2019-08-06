<?php namespace Admin;

use Illuminate\Routing\Controllers\Controller;
use Intervention\Image\Facades\Image;
use View, Input, Redirect, Session, Validator;
use Email  as EmailModel;
class EmailController extends \BaseController
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
        $param['pageNo'] = 51;
        $param['email'] = EmailModel::all();
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        return View::make('admin.emailTemplate.index')->with($param);
    }
    public function create(){
        $param['pageNo'] = 51;
        return View::make('admin.emailTemplate.create')->with($param);
    }
    public function store(){
        $rules = ['title'  => 'required',
                'realContent' => 'required',
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else{
            if (Input::has('email_id')) {
                $id = Input::get('email_id');
                $email = EmailModel::find($id);
            }else{
                $email = new EmailModel;
            }
            $email->title = Input::get('title');
            $email->content = Input::get('realContent');
            $email->save();
            $alert['msg'] = 'Email template has been saved successfully';
            $alert['type'] = 'success';
        }
        return Redirect::route('admin.email')->with('alert', $alert);
    }
    public function edit($id){
        $param['pageNo'] = 51;
        $param['email']= EmailModel::find($id);
        return View::make('admin.emailTemplate.edit')->with($param);
    }
}