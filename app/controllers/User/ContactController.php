<?php namespace User;

use Illuminate\Routing\Controllers\Controller;
use View, Input, Redirect, Session, Validator, DB, Mail,File, Request,Response,Lang;
use Members as MembersModel, EmailSend as EmailSendModel;
class ContactController extends \BaseController {
    public function index($id){
        if (!Session::has('user_id')) {
            return Redirect::route('user.auth.login');
        }else{
            $param['pageNo'] = 110;
            $listID = $id-100000;
            $param['member'] = MembersModel::find($listID);
            $param['user_id'] = $id;
            return View::make('user.contact.index')->with($param);
        }
    }
    public function contact(){
        $param['pageNo'] = 111;
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        return View::make('user.contact.contact')->with($param);
    }
    public function contactSend(){
        $rules = [
            'name'  => 'required ',
            'email'     => 'required |email',
            'message'    => 'required ',
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else{
            $name = Input::get('name');
            $email = Input::get('email');
            $messageContent = Input::get('message');
            $data = array(
                'name' =>$name,
                'email'    =>$email,
                'messageContent' =>$messageContent
            );
            Mail::send('emails.cotactAmdin', $data, function($message){
                $message->from('noreply@purchasetree.com', Lang::get('alert.Contact_Message'));
                $message->to("admin@purchasetree.com", 'Admin')->subject(Lang::get('alert.Contact_Message'));
            });
            $alert['msg'] = Lang::get('alert.Your_message_has_been_send_successfully');
            $alert['type'] = 'success';
        }
        return Redirect::route('user.contact.contact')->with('alert', $alert);
    }
    public function userMessage(){
        $rules = [
            'subject' =>'required',
            'content' =>'required'
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else {
            $id = Input::get('user_id');
            $receiver_id = $id - 100000;
            $sender_id = Session::get('user_id');
            $subject =Input::get('subject');
            $content =Input::get('content');

            $email_pattern = '/[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/';

            $content = preg_replace_callback($email_pattern, function($matches){
                return '##################';
            }, $content);
            $subject = preg_replace_callback($email_pattern, function ($matches){
                return '##################';
            }, $subject);
            $message = new EmailSendModel;
            $message->sender_id = $sender_id;
            $message->receiver_id = $receiver_id;
            $message->subject = $subject;
            $message->content = $content;
            $message->sender_red =1;
            $message->receiver_red =0;
            $message->parent = 0;
            $message->save();
//            $inserID =$message->id;
//            $messageContent = EmailSendModel::find($inserID);
//            $messageContent->parent = $inserID;
//            $messageContent->save();
            $recevier = MembersModel::find($receiver_id);
            $sender =  MembersModel::find($sender_id);
            $email = $recevier->email;


            $data =array(
                'username' =>$sender->username,
                'subject' =>$subject,
                'content' =>$content
            );
            Mail::send('emails.contact.sendMessage', $data, function($message) use ($email){
                $message->from('noreply@purchasetree.com', Lang::get('alert.Send_Message'));
                $message->to($email, Lang::get('alert.Send_Message'))->subject(Lang::get('alert.Send_Message'));
            });
            $alert['msg'] = Lang::get('missing.Message_has_been_send_successfully');
            $alert['type'] = 'success';
        }
        $storeContact = Input::get('storeContact');
        if($storeContact == 1){
            return Redirect::route('user.seller.store.contact',$id)->with('alert', $alert);
        }else{
            return Redirect::route('user.contact',$id)->with('alert', $alert);
        }

    }

}