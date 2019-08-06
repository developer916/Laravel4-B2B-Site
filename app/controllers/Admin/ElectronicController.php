<?php namespace Admin;

use Illuminate\Routing\Controllers\Controller;
use Intervention\Image\Facades\Image;
use View, Input, Redirect, Session, Validator;
use EscrowMessageTemplate  as EscrowMessageTemplateModel;
class ElectronicController extends \BaseController
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
        $param['pageNo'] = 75;
        $param['electronic'] = EscrowMessageTemplateModel::whereRaw('type=?',array('electronic'))->get();
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        return View::make('admin.escrow.electronic.index')->with($param);
    }
    public function store(){
        $rules = ['realContent'  => 'required',
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else{
            $realContent = Input::get('realContent');
            $electronic_id = Input::get('electronic_id');
            if(Input::has('electronic_id')){
                $electronic = EscrowMessageTemplateModel::find($electronic_id);
            }else{
                $electronic = new EscrowMessageTemplateModel;
            }

            $electronic->title = '';
            $electronic->content = $realContent;
            $electronic->type = 'electronic';
            $electronic->save();
            $alert['type'] = "success";
            $alert['msg'] = "Electronic has been saved successfully.";
            return Redirect::route('admin.escrow.electronic')->with('alert', $alert);
        }
    }
    public function emailIndex(){
        $param['pageNo'] = 76;
        $param['email'] = EscrowMessageTemplateModel::whereRaw('type=?',array('email'))->get();
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        return View::make('admin.escrow.email.index')->with($param);
    }

    public function emailCreate(){
        $param['pageNo'] = 76;
        return View::make('admin.escrow.email.create')->with($param);
    }

    public function emailStore(){
        $rules = [
            'title'  => 'required',
            'content'  => 'required',
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else{
            if(Input::has('email_id')){
                $id = Input::get('email_id');
                $email = EscrowMessageTemplateModel::find($id);
            }else{
                $email = new EscrowMessageTemplateModel;
            }

            $email->title = Input::get('title');
            $email->content = Input::get('content');
            $email->type = "email";
            $email->save();
            $alert['type'] = "success";
            $alert['msg'] = "Email has been saved successfully.";
            return Redirect::route('admin.escrow.email')->with('alert', $alert);
        }
    }
    public function emailEdit($id){
        $param['pageNo'] = 76;
        $param['email'] = EscrowMessageTemplateModel::find($id);
        return View::make('admin.escrow.email.edit')->with($param);
    }
    public function emailDelete($id){
        try {
            EscrowMessageTemplateModel::find($id)->delete();
            $alert['msg'] = 'This message template has been deleted successfully';
            $alert['type'] = 'success';
        } catch(\Exception $ex) {
            $alert['msg'] = 'This message  has been already used';
            $alert['type'] = 'danger';
        }
        return Redirect::route('admin.escrow.email')->with('alert', $alert);
    }
}