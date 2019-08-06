<?php namespace Admin;

use Illuminate\Routing\Controllers\Controller;
use View, Input, Redirect, Session, Validator, DB, Mail,File, Request,Response,Lang,URL;
use Members as MembersModel, Country as CountryModel,CompanyProfile as CompanyProfileModel, EmailSend as EmailSendModel,
    Rfq as RfqModel, RfqPicture as RfqPictureModel,RfqFile as RfqFileModel,RfqSpe as RfqSpeModel, RfqEmail as RfqEmailModel,
    RfqSpePicture as RfqSpePictureModel,Currency as CurrencyModel,Unit as UnitModel, Quote as QuoteModel, QuoteNote as QuoteNoteModel, QuotePicture as QuotePictureModel,
    QuoteSpe as QuoteSpeModel, QuoteSample as QuoteSampleModel, Fee as FeeModel, BuyerCard as BuyerCardModel, Email as EmailModel;
class SampleRFQController   extends \BaseController{

    public function __construct()
    {
        $this->beforeFilter(function () {
            if (!Session::has('admin_id')) {
                return Redirect::route('admin.auth.login');
            }
        });
    }
    public function index(){
        $param['pageNo'] = 43;
        $param['sampleRFQs'] = QuoteModel::whereIn('status', array(4,5))->orderBy('updated_at','desc')->get();
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        return View::make('admin.sampleRFQ.index')->with($param);
    }
    public function message(){
        if(Request::ajax()){
            $rules = [
                'usertype'  => 'required',
                'message'  => 'required',
            ];
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return Response::json(['result' =>'failed', 'error' =>$validator->getMessageBag()->toArray()]);
            }else{
                $QuoteID = Input::get('quote_id');
                $QuoteList = QuoteModel::find($QuoteID);
                $userType = Input::get('usertype');
                if($userType == "seller"){
                    $member = MembersModel::find($QuoteList->seller_id);
                }else{
                    $member = MembersModel::find($QuoteList->buyer_id);
                }
                $messageAdmin = input::get('message');
                $data = array(
                    'content' =>$messageAdmin,
                    'list' =>'test',
                );
                $email = $member->email;
                Mail::send('emails.admin.sampleRequestMessage', $data, function($message) use($email){
                    $message->from('noreply@purchasetree.com', 'From Admin');
                    $message->to($email, 'Admin')->subject('From Admin');
                });
                return Response::json(['result' =>'success','message' =>'Message send successfully.']);
            }
        }
    }

    public function approve($id){
        $quoteID = $id;
        $quoteList = QuoteModel::find($quoteID);
        $quoteList->status = 5;
        $quoteList->admin_active = 1;
        $quoteList->save();

        $sellerEmail = $quoteList->sellerMember->email;
        $buyerEmail = $quoteList->buyerMember->email;
        $messageList = EmailModel::whereRaw('title = ?', array('Sample request approved to seller'))->get();
        $sellerContent = $messageList[0]->content;
        $data = array(
            'content' =>$sellerContent,
        );
        Mail::send('emails.admin.sendMessage', $data, function($message) use($sellerEmail){
            $message->from('noreply@purchasetree.com', 'Sample Request Approved');
            $message->to($sellerEmail, 'Admin')->subject('Sample Request Approved');
        });
        $messageList = EmailModel::whereRaw('title = ?',array('Sample request approved to buyer'))->get();
        $sellerContent = $messageList[0]->content;
        $data = array(
            'content' =>$sellerContent,
        );
        Mail::send('emails.admin.sendMessage', $data, function($message) use($buyerEmail){
            $message->from('noreply@purchasetree.com', 'Sample Request Approved');
            $message->to($buyerEmail, 'Admin')->subject('Sample Request Approved');
        });
        $alert['msg'] = 'This sample request has been approved.';
        $alert['type'] = 'success';
        return Redirect::route('admin.samplerfq')->with('alert', $alert);
    }
}