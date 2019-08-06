<?php
namespace User;

use Illuminate\Routing\Controllers\Controller;
use View, Input, Redirect, Session, Validator, DB, Mail,File, Request,Response,Lang,URL;
use Members as MembersModel, Country as CountryModel,CompanyProfile as CompanyProfileModel, EmailSend as EmailSendModel,
    Rfq as RfqModel, RfqPicture as RfqPictureModel,RfqFile as RfqFileModel,RfqSpe as RfqSpeModel, RfqEmail as RfqEmailModel,
    RfqSpePicture as RfqSpePictureModel,Currency as CurrencyModel,Unit as UnitModel, Quote as QuoteModel, QuoteNote as QuoteNoteModel, QuotePicture as QuotePictureModel,
    QuoteSpe as QuoteSpeModel, QuoteSample as QuoteSampleModel, Fee as FeeModel, BuyerCard as BuyerCardModel,Accept as AcceptModel,ShoppingCartEmail as ShoppingCartEmailModel,
    EscrowUser as  EscrowUserModel,EscrowEscrow as EscrowEscrowModel,ShoppingCartProduct as ShoppingCartProductModel, Product as ProductModel;
class BuyerGroupController extends \BaseController {
    public function __construct()
    {
        $this->beforeFilter(function () {
            if (!Session::has('user_id')) {
                return Redirect::route('user.auth.login');
            }
            if(Session::get('user_type') == 1){
                return Redirect::route('user.seller.dashboard');
            }
        });
    }
    /****************Cart Start*************/
    public function cart(){
        $param['pageNo'] = 25;
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $param['subPageNo'] = 5;
        $param['title'] = Lang::get('user.my_orders');
        $param['subTitle'] = Lang::get('user.orders');
        $user_id = session::get('user_id');
        $emailList = EmailSendModel::where('parent','=',0)
            ->where( function ($query) use ($user_id) {
                $query->where('sender_id', '=', $user_id)->whereNotIn('sender_delete', array(1))
                    ->orWhere('receiver_id', '=', $user_id)->whereNotIn('receiver_delete', array(1));
            })->orderBy('created_at','desc')->paginate(10);

        $param['emailCount'] = count($emailList);
        $param['carts'] = ShoppingCartProductModel::whereRaw('buyer_id=?', array(Session::get('user_id')))->orderBy('id','DESC')->paginate(10);
        return View::make('user.buyer.cart')->with($param);
    }

    public function cartSeller(){
        $id = Input::get('id');
        $shoppingCartProductID = $id-100000;
        $shoppingCartProduct = ShoppingCartProductModel::find($shoppingCartProductID);
        $product =ProductModel::find($shoppingCartProduct->product_id);
        $seller = MembersModel::find($shoppingCartProduct->seller_id);
        $list = '';

        $list .='<div class="row">';
            $list .='<div class="col-md-12">';
                $list .='<div class="form-horizontal">';
                    $list .='<div class="form-group">';
                        $list .='<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                             $list .=Lang::get('user.shopping_cart_buyer_user_name');
                        $list .='</label>';
                        $list .='<div class="col-md-8 col-lg-8 col-sm-7">';
                            $list.='<p class="form-control border-none-important">'.$seller->username.'</p>';
                        $list .='</div>';
                    $list .='</div>';
                    $list .='<div class="form-group">';
                        $list .='<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                            $list .=Lang::get('user.status');
                        $list .='</label>';
                        $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                            $list.='<p class="form-control border-none-important">';
                                if($shoppingCartProduct->status == 1){
                                    $list .=Lang::get('user.shopping_cart_pending');
                                }else if($shoppingCartProduct->status == 2){
                                    $list .=Lang::get('user.shopping_cart_escrow');
                                }else if($shoppingCartProduct->status == 3 ){
                                    $list .=Lang::get('user.request_payment');
                                }else if($shoppingCartProduct->status == 4 ){
                                    $list .=Lang::get('user.wait_admin_confirm');
                                }else if($shoppingCartProduct->status == 5){
                                    $list .=Lang::get('user.admin_confirmed');
                                }else if($shoppingCartProduct->status == 6){
                                    $list .=Lang::get('user.seller_send_product');
                                }
                            $list .='</p>';
                        $list .='</div>';
                    $list .='</div>';
                    $list .='<div class="form-group">';
                        $list .='<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                            $list .=Lang::get('user.shopping_cart_full_name');
                        $list .='</label>';
                        $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                            $list.='<p class="form-control border-none-important">';
                                $list .=$seller->firstname." ". $seller->lastname;
                            $list .='</p>';
                        $list .='</div>';
                    $list .='</div>';
                    $list .='<div class="form-group">';
                        $list .='<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                            $list .=Lang::get('user.shopping_cart_address');
                        $list .='</label>';
                        $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                            $list.='<p class="form-control border-none-important">';
                                $list .=$seller->street;
                            $list .='</p>';
                        $list .='</div>';
                    $list .='</div>';
                    $list .='<div class="form-group">';
                        $list .= '<div class="col-md-8 col-lg-8 col-sm-7 col-md-offset-4 col-lg-offset-4 col-sm-offset-5">';
                            $list.='<p class="form-control border-none-important">';
                                $list .= $seller->city." , ";
                                if($seller->state !=""){
                                    $list.=$seller->state." , ";
                                }
                                $list.= $seller->zipcode." , ". $seller->country->country_name;
                            $list .='</p>';
                        $list .='</div>';
                    $list .='</div>';
                $list .='</div>';
            $list .='</div>';
        $list .='</div>';
        $title = Lang::get('user.shopping_cart_title') . $product->product_name;
        $data =array('result'=>'success', 'content' =>$list, 'title' =>$title);
        return Response::json($data);
    }
    public function cartMail(){
        $id = Input::get('id');
        $shoppingCartProductID = $id - 100000;
        $shoppingCartProduct = ShoppingCartProductModel::find($shoppingCartProductID);
        $shoppingCart = $shoppingCartProduct->ShoppingCart;
        $seller  = MembersModel::find($shoppingCartProduct->seller_id);
        $user_id = Session::get('user_id');

        $cartMails = ShoppingCartEmailModel::whereRaw('shopping_cart_product_id=?',array($shoppingCartProductID))
            ->where( function ($query) use ($user_id) {
                $query->where('sender_id', '=', $user_id)->orWhere('receiver_id', '=', $user_id);
            })->get();


        $list ='';
        $list .='<div class="row">';
        $list .='<div class="col-md-12">';
        $list .='<div class="form-horizontal">';
        if(count($cartMails)>0) {
            $list .='<div class="row">
                                    <div class="panel panel-default margin-bottom-40 change-panel">
                                        <div class="panel-body">
                                            <div class="panel-group acc-v1" id="accordion-1">';
            foreach ($cartMails as $key => $value) {
                $list .='<div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <h4 class="panel-title">';
                $list .='<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-1" href="#collapse'. $key.'">';
                if($value->sender_id == Session::get('user_id')){
                    $list .=Lang::get('user.me').' , '.$value->receiver->username;
                }else{
                    $list .=$value->sender->username.' , '.Lang::get('user.me');
                }
                $list .='</a>';
                $list .='</h4>';
                $list .='    </div>';
                $list .='<div id="collapse'.$key.'" class="panel-collapse collapse">';
                $list .='<div class="panel-body">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <h4 style="color: rgb(26, 114, 229);font-weight: 700;">'.$value->subject.'</h4>
                                                                                '.$value->message.'
                                                                        </div>
                                                                    </div>
                                                                </div>';
                $list .='</div>';
                $list .=' </div>';
            }
            $list .='</div>';

            $list .='</div>';
            $list .='</div>';
            $list .='</div>';
        }
        $list .=' <div class="col-md-12">';
        $list .='<form action="'.URL::route('user.buyer.cart.postMail').'" method="post" class="form-horizontal reg-page" id="emailSendForm">';
        $list .='<div class="form-group">
                                         <label for="inputEmail1" class="col-lg-3 col-sm-4 col-md-4 col-xs-5 control-label">'.Lang::get('user.to').'</label>
                                        <div class="col-lg-8 col-md-6 col-sm-6 col-xs-7">
                                            <input type="text" class="form-control" id="inputEmail1" placeholder="Email" value="'.$seller->username.'" readonly style="border:0px!important">
                                        </div>
                                    </div>';
        $list .='<div class="form-group">
                                     <label for="inputEmail1" class="col-lg-3 col-sm-4 col-md-4 col-xs-5 control-label"><span style="color:red">*</span> '.Lang::get('user.message_subject').' :</label>
                                    <div class="col-lg-8 col-md-6 col-sm-6 col-xs-7">
                                        <textarea class="form-control" id="inputEmail1" placeholder="'.Lang::get('user.message_subject').'"  rows="1" name="subject"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                     <label for="inputEmail1" class="col-lg-3 col-sm-4 col-md-4 col-xs-5 control-label"><span style="color:red">*</span> '.Lang::get('user.message_content').' :</label>
                                    <div class="col-lg-8 col-md-6 col-sm-6 col-xs-7">
                                        <textarea class="form-control" id="inputEmail1" placeholder="'.Lang::get('user.message_content').'"  rows="10" name="content"></textarea>
                                    </div>
                                </div>';
        $list .='<input type="hidden" name="user_id" value="'.(100000*1+$seller->id).'">
                                         <input type="hidden" name="shoppingCartProductID" value="'.$id.'" >';
        $list .='<div class="form-group">
                                            <div class="col-lg-offset-3 col-md-offset-3 col-sm-offset-4 col-xs-offset- col-lg-8 col-md-6 col-sm-6 col-xs-7">
                                                <input type="button" class="btn-u btn-u-blue" value="'.Lang::get('user.send').'" onclick = "onSendFormButton()" id="semd">

                                                <a href="javascript:void(0)" class="btn-u btn-u-red" onclick="onHideMessageForm()">'.Lang::get('user.cancel').'</a>
                                                <div id="spin"></div>
                                            </div>
                                        </div>';
        $list .='</form>';
        $list .='</div>';
        $list .='</div>';
        $list .='</div>';
        $list .='</div>';

        $title = Lang::get('user.shopping_cart_email_to_seller') ." ". $seller->username;
        $data =array('result'=>'success', 'content' =>$list, 'title' =>$title);
        return Response::json($data);
    }

    public function cartMailPost(){
        $rules = [
            'subject' =>'required',
            'content' =>'required'
        ];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Response::json(['result' => 'failed', 'error' => $validator->getMessageBag()->toArray()]);
        }else {
            $subject = Input::get('subject');
            $content = Input::get('content');
            $email_pattern = '/[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/';
            $content = preg_replace_callback($email_pattern, function ($matches) {
                return '##################';
            }, $content);
            $subject = preg_replace_callback($email_pattern, function ($matches) {
                return '##################';
            }, $subject);


            $receiver_id = Input::get('user_id');
            $cartEmail = new ShoppingCartEmailModel;
            $cartEmail->sender_id = Session::get('user_id');
            $cartEmail->receiver_id = ($receiver_id - 100000);
            $cartEmail->subject = $subject;
            $cartEmail->message = $content;
            $cartEmail->sender_red = 1;
            $cartEmail->receiver_red = 0;
            $cartEmail->shopping_cart_product_id = (Input::get('shoppingCartProductID') - 100000);
            $cartEmail->save();
            $sender_id = Session::get('user_id');

            $recevier = MembersModel::find($receiver_id - 100000);
            $sender = MembersModel::find($sender_id);
            $email = $recevier->email;
            $data = array(
                'username' => $sender->username,
                'subject' => $subject,
                'content' => $content
            );
            Mail::send('emails.contact.sendMessage', $data, function ($message) use ($email) {
                $message->from('noreply@purchasetree.com', Lang::get('alert.Send_Message'));
                $message->to($email, Lang::get('alert.Send_Message'))->subject(Lang::get('alert.Send_Message'));
            });
            $message = Lang::get('missing.Message_has_been_send_successfully');
            return Response::json(['result' => 'success', 'error' => $message]);
        }
    }


    /****************Cart End*************/

    public function index(){
        $param['pageNo'] = 25;
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $param['subPageNo'] = 1;
        $param['title'] = Lang::get('user.my_orders');
        $param['subTitle'] = Lang::get('user.orders');
        $user_id = session::get('user_id');
        $emailList = EmailSendModel::where('parent','=',0)
            ->where( function ($query) use ($user_id) {
                $query->where('sender_id', '=', $user_id)->whereNotIn('sender_delete', array(1))
                    ->orWhere('receiver_id', '=', $user_id)->whereNotIn('receiver_delete', array(1));
            })->orderBy('created_at','desc')->paginate(10);

        $param['emailCount'] = count($emailList);
        $sql_query = "SELECT quote_id
                        FROM np_seller_sample
                        WHERE buyer_id =".$user_id."
                        UNION
                        SELECT quote_id FROM np_seller_accept
                        WHERE buyer_id = ".$user_id;
        $array = DB::select($sql_query);
        if(count($array)>0){
            $arrayList = array();
            for($i=0; $i<count($array); $i++){
                $arrayList[$i]= $array[$i]->quote_id;
            }
           $param['quote'] = QuoteModel::whereRaw('buyer_id =?', array($user_id))->whereIn('id',$arrayList)->orderBy('id','desc')->get();
        }else{
        }
        return View::make('user.buyer.index')->with($param);
    }
    /****email***/
    public function email($slug){
        $param['pageNo'] = 25;
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $param['title'] = Lang::get('user.email');
        $param['subPageNo'] = 2;
        $user_id = Session::get('user_id');
        $emailList = EmailSendModel::where('parent','=',0)
            ->where( function ($query) use ($user_id) {
                $query->where('sender_id', '=', $user_id)->whereNotIn('sender_delete', array(1))
                    ->orWhere('receiver_id', '=', $user_id)->whereNotIn('receiver_delete', array(1));
            })->orderBy('created_at','desc')->paginate(10);
        $param['emailCount'] = count($emailList);
        if($slug == "new"){
            $emailList = EmailSendModel::where('receiver_id','=',$user_id)->where('receiver_red','=','0')->whereNotIn('receiver_delete' ,array(1))->orderBy('id','DESC')->paginate(10);
            $companyList = array();
            for($i=0; $i<count($emailList); $i++){
                if($emailList[$i]->sender_id != $user_id){
                    $anotherUser = $emailList[$i]->sender_id;
                }else{
                    $anotherUser = $emailList[$i]->receiver_id;
                }
                $companylogoList = CompanyProfileModel::whereRaw('user_id =?', array($anotherUser))->get();
                $companyList[$i] =$companylogoList[0];
            }
            $param['companyList'] = $companyList;
            $param['emailList'] = $emailList;
            $param['slug'] = 'new';
            return View::make('user.buyer.emailList')->with($param);
        }
        else if($slug == "all"){
            $emailList = EmailSendModel::where('parent','=',0)
                                         ->where( function ($query) use ($user_id) {
                                             $query->where('sender_id', '=', $user_id)->whereNotIn('sender_delete', array(1))
                                                 ->orWhere('receiver_id', '=', $user_id)->whereNotIn('receiver_delete', array(1));
                                         })->orderBy('created_at','desc')->paginate(10);
            $ItemList = array();
            $companyList = array();
            for($i=0; $i<count($emailList); $i++){
                $itemListEmail =EmailSendModel::where('parent','=',array($emailList[$i]->id))
                                                ->where( function ($query) use ($user_id) {
                                                    $query->where('sender_id', '=', $user_id)->whereNotIn('sender_delete', array(1))
                                                          ->orWhere('receiver_id', '=',$user_id)->whereNotIn('receiver_delete' ,array(1));
                                                })->get();
                $ItemList[$i] =  count($itemListEmail);
                if($emailList[$i]->sender_id != $user_id){
                    $anotherUser = $emailList[$i]->sender_id;
                }else{
                    $anotherUser = $emailList[$i]->receiver_id;
                }
                $companylogoList = CompanyProfileModel::whereRaw('user_id =?', array($anotherUser))->get();
                $companyList[$i] =$companylogoList[0];
            }
            $param['companyList'] = $companyList;
            $param['itemList'] = $ItemList;
            $param['emailList'] = $emailList;
            $param['slug'] = 'all';
            return View::make('user.buyer.email')->with($param);
        }else if($slug == "sent"){
            $emailList = EmailSendModel::where('sender_id','=',$user_id)->whereNotIn('sender_delete' ,array(1))->orderBy('id','DESC')->paginate(10);
            $companyList = array();
            for($i=0; $i<count($emailList); $i++){
                if($emailList[$i]->sender_id != $user_id){
                    $anotherUser = $emailList[$i]->sender_id;
                }else{
                    $anotherUser = $emailList[$i]->receiver_id;
                }
                $companylogoList = CompanyProfileModel::whereRaw('user_id =?', array($anotherUser))->get();
                $companyList[$i] =$companylogoList[0];
            }
            $param['companyList'] = $companyList;
            $param['emailList'] = $emailList;
            $param['slug'] = 'sent';
            return View::make('user.buyer.emailList')->with($param);

        }else if($slug == "inbox"){
            $emailList = EmailSendModel::where('receiver_id','=',$user_id)->whereNotIn('receiver_delete' ,array(1))->orderBy('id','DESC')->paginate(10);
            $companyList = array();
            for($i=0; $i<count($emailList); $i++){
                if($emailList[$i]->sender_id != $user_id){
                    $anotherUser = $emailList[$i]->sender_id;
                }else{
                    $anotherUser = $emailList[$i]->receiver_id;
                }
                $companylogoList = CompanyProfileModel::whereRaw('user_id =?', array($anotherUser))->get();
                $companyList[$i] =$companylogoList[0];
            }
            $param['companyList'] = $companyList;
            $param['emailList'] = $emailList;
            $param['slug'] = 'inbox';
            return View::make('user.buyer.emailList')->with($param);
        }

    }
    public function newList($id, $slug){
        $param['pageNo'] = 25;
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $user_id = Session::get('user_id');
        $emailList = EmailSendModel::where('parent','=',0)
            ->where( function ($query) use ($user_id) {
                $query->where('sender_id', '=', $user_id)->whereNotIn('sender_delete', array(1))
                    ->orWhere('receiver_id', '=', $user_id)->whereNotIn('receiver_delete', array(1));
            })->orderBy('created_at','desc')->paginate(10);
        $param['emailCount'] = count($emailList);
        $param['slug'] = $slug;
        $param['title'] = Lang::get('user.email');
        $param['subPageNo'] = 2;
        $listID = $id-100000;
        $email = EmailSendModel::where('id', '=', $listID)->get();
        if($email[0]->sender_id == Session::get('user_id')) {
            $param['buyerUserName'] = $email[0]->recevier->username;
            $param['buyerID'] = $email[0]->receiver_id;
        }else{
            $param['buyerUserName'] = $email[0]->sender->username;
            $param['buyerID'] = $email[0]->sender_id;
        }
        if($slug == "new" || $slug == "inbox"){
            $message = EmailSendModel::find($listID);
            $message->receiver_red =1;
            $message->save();
        }

        $param['email'] = $email;
        $param['parent'] = $listID+100000*1;
        return View::make('user.buyer.newList')->with($param);
    }
    public function getEmailContent($id,$slug){
        $param['pageNo'] = 25;
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $param['slug'] = $slug;
        $param['title'] = Lang::get('user.email');
        $param['subPageNo'] = 2;
        $user_id = Session::get('user_id');
        $emailList = EmailSendModel::where('parent','=',0)
            ->where( function ($query) use ($user_id) {
                $query->where('sender_id', '=', $user_id)->whereNotIn('sender_delete', array(1))
                    ->orWhere('receiver_id', '=', $user_id)->whereNotIn('receiver_delete', array(1));
            })->orderBy('created_at','desc')->paginate(10);
        $param['emailCount'] = count($emailList);
        $listID = $id-100000;
        $email = EmailSendModel::where('id', '=', $listID)->orWhere('parent', '=',$listID)->get();
        if($email[0]->sender_id == Session::get('user_id')) {
            $param['buyerUserName'] = $email[0]->recevier->username;
            $param['buyerID'] = $email[0]->receiver_id;
        }else{
            $param['buyerUserName'] = $email[0]->sender->username;
            $param['buyerID'] = $email[0]->sender_id;
        }
        $param['email'] = $email;
        $param['parent'] = $listID+100000*1;
        return View::make('user.buyer.emailContent')->with($param);
    }
    public function storeEmail(){
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
            $subject = Input::get('subject');
            $content = Input::get('content');
            $email_pattern = '/[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/';

            $content = preg_replace_callback($email_pattern, function($matches){
                return '##################';
            }, $content);
            $subject = preg_replace_callback($email_pattern, function ($matches){
                return '##################';
            }, $subject);

            $slug = Input::get('slug');
            $receiver_id = Input::get('user_id') - 100000;
            $sender_id = Session::get('user_id');
            $parent = Input::get('parent');
            $parentList = Input::get('parent')-100000;
            $listMessage = EmailSendModel::find($parentList);
            if($listMessage->parent != 0){
                $parentList = $listMessage->parent;
            }
            $message = new EmailSendModel;
            $message->sender_id = $sender_id;
            $message->receiver_id = $receiver_id;
            $message->subject = $subject;
            $message->content = $content;
            $message->sender_red = 1;
            $message->receiver_red =0;
            $message->parent =$parentList;
            $message->save();
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
        return Redirect::route('user.buyer.getEmailContent',array($parent,$slug))->with('alert', $alert);
    }
    public function getEmail(){

    }
    public function deleteEmail($id,$slug){

        try {
            $listID = $id -100000;
            $user_id = Session::get('user_id');
            $emailLists = EmailSendModel::where('id','=', $listID)->orWhere('parent','=',$listID)->get();
            foreach($emailLists as $key =>$emailList){
                if($emailList->sender_id == $user_id ){
                    $emailList->sender_delete = 1;
                    $emailList->save();
                }else if($emailList->receiver_id == $user_id){
                    $emailList->receiver_delete = 1;
                    $emailList->save();
                }
            }
            $alert['msg'] = Lang::get('alert.This_emails_has_been_deleted_successfully');
            $alert['type'] = 'success';
        } catch(\Exception $ex) {
            $alert['msg'] = Lang::get('alert.This_emails_has_been_already_used');
            $alert['type'] = 'danger';
        }
        return Redirect::route('user.buyer.email',$slug)->with('alert', $alert);
    }
    /*************email end*********/
    /*************favorite**********/
    public function favorite(){
        $param['pageNo'] = 25;
        $param['members'] = MembersModel::where('usertype','=',1)->orWhere('usertype','=',3)->where('status','=',1)->paginate(2);
        $company = array();
        if(count($param['members']) >0) {
            foreach($param['members'] as $key=>$value){
                $company[$key] = CompanyProfileModel::whereRaw('user_id =?', array($value->id))->get();
            }
        }

        $user_id = Session::get('user_id');
        $emailList = EmailSendModel::where('parent','=',0)
            ->where( function ($query) use ($user_id) {
                $query->where('sender_id', '=', $user_id)->whereNotIn('sender_delete', array(1))
                    ->orWhere('receiver_id', '=', $user_id)->whereNotIn('receiver_delete', array(1));
            })->orderBy('created_at','desc')->paginate(10);
        $param['emailCount'] = count($emailList);
        $param['subPageNo'] = 3;
        $param['title'] = Lang::get('user.favorite');
        $param['company'] = $company;
        return View::make('user.buyer.favorite')->with($param);
    }
    public function rfq(){
        $param['pageNo'] = 25;
        $user_id = Session::get('user_id');
        $param['rfq'] = RfqModel::whereRaw('buyer_id =?' , array($user_id))->orderBy('created_at','desc')->paginate(10);
        $param['subPageNo'] = 4;
        $param['title'] = Lang::get('user.buyer_rfq');
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $user_id = Session::get('user_id');
        $emailList = EmailSendModel::where('parent','=',0)
            ->where( function ($query) use ($user_id) {
                $query->where('sender_id', '=', $user_id)->whereNotIn('sender_delete', array(1))
                    ->orWhere('receiver_id', '=', $user_id)->whereNotIn('receiver_delete', array(1));
            })->orderBy('created_at','desc')->paginate(10);
        $param['emailCount'] = count($emailList);
        $buyerList = array();
        $emailList = array();
        foreach($param['rfq'] as $key=>$value){
            $buyerList[$key] = MembersModel::find($value->buyer_id);
            $emailArray = RfqEmailModel::whereRaw('rfq_id =? and sender_id =?',array($value->id,$user_id))->get();
            if(count($emailArray)>0){
                $emailList[$key] =1;
            }else{
                $emailList[$key] =0;
            }
        }
        $param['emailList'] =$emailList;
        $param['buyerList'] =$buyerList;

        return View::make('user.buyer.rfq.index')->with($param);
    }
    public function rfqCreate(){
        $param['pageNo'] = 25;
        $user_id = Session::get('user_id');
        $emailList = EmailSendModel::where('parent','=',0)
            ->where( function ($query) use ($user_id) {
                $query->where('sender_id', '=', $user_id)->whereNotIn('sender_delete', array(1))
                    ->orWhere('receiver_id', '=', $user_id)->whereNotIn('receiver_delete', array(1));
            })->orderBy('created_at','desc')->paginate(10);
        $param['emailCount'] = count($emailList);
        $param['subPageNo'] = 4;
        $param['title'] = Lang::get('user.buyer_rfq');
        $param['currencies']= CurrencyModel::whereRaw(true)->orderBy('currency_name','asc')->get();
        $param['units'] = UnitModel::all();
        return View::make('user.buyer.rfq.create')->with($param);
    }
    public function specificationPicutre(){
        if(Request::ajax()){
            $rules = [
                'file_upload'  => 'required|image|max:1024 ',
            ];
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return Response::json(['result' =>'failed', 'error' =>$validator->getMessageBag()->toArray()]);
            }else{
                if (Input::hasFile('file_upload')) {
                    $filename = str_random(24) . "." . Input::file('file_upload')->getClientOriginalExtension();
                    Input::file('file_upload')->move(ABS_LOGO_PATH, $filename);
                    $userImageList = $filename;
                }
                $data="<img src='".HTTP_LOGO_PATH.$userImageList."'>";
                return Response::json(['result' =>'success', 'content' =>$data, 'url' =>$userImageList]);
            }
        }
    }
    public function file(){
        if(Request::ajax()){
            $rules = [
                'file'  => 'required|mimes:txt,pdf,doc,docx'
            ];
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return Response::json(['result' =>'failed', 'error' =>$validator->getMessageBag()->toArray()]);
            }else{
                if (Input::hasFile('file')) {
                    $name = Input::file('file')->getClientOriginalName();
                    $fileExt = strtoupper(Input::file('file')->getClientOriginalExtension());
                    $filename = str_random(24) . "." . Input::file('file')->getClientOriginalExtension();
                    Input::file('file')->move(ABS_LOGO_PATH, $filename);
                    $userImageList = $filename;
                    $datalist = '';
                    if($fileExt == "PDF"){
                        $listData = "<img src='".HTTP_PATH."/assets/assest_admin/images/pdf.jpg' class='fileItemPDF' >
                                    <input type='hidden' value='".$userImageList."' id='files_list'>
                                    <div class='fileHref'>
                                        <a href='".HTTP_LOGO_PATH.$userImageList."' target='_blank'><span class='fileName'>".$name."</span></a>
                                        <input type='hidden' value='PDF' class='forestchange' id='forestchange'>
                                    </div>";
                    }else if($fileExt == "DOC" ||$fileExt == "DOCX" ){
                        $listData = "<img src='".HTTP_PATH."/assets/assest_admin/images/word.jpg' class='fileItemPDF' >
                                    <input type='hidden' value='".$userImageList."' id='files_list'>
                                    <div class='fileHref'>
                                        <a href='".HTTP_LOGO_PATH.$userImageList."' target='_blank'><span class='fileName'>".$name."</span></a>
                                        <input type='hidden' value='DOC' class='forestchange' id='forestchange'>
                                    </div>";
                    }else if($fileExt == "TXT" ){
                        $listData = "<img src='".HTTP_PATH."/assets/assest_admin/images/txt.jpg' class='fileItemPDF' >
                                    <input type='hidden' value='".$userImageList."' id='files_list'>
                                    <div class='fileHref'>
                                        <a href='".HTTP_LOGO_PATH.$userImageList."' target='_blank'><span class='fileName'>".$name."</span></a>
                                         <input type='hidden' value='TXT' class='forestchange' id='forestchange'>
                                    </div>";
                    }
                    return Response::json(['result' =>'success', 'content' =>$listData]);
                }
            }

        }
    }
    public function store(){
        if(Request::ajax()){
            $item_price = Input::get('target_price');
            if(isset($item_price) && $item_price != ""){
                $rules = [
                    'product_name'  => 'required',
                    'product_description' => 'required',
                    'purchase_quantity' => 'required|numeric',
                    'quantity_unit' => 'required',
                    'target_price' => 'required|numeric',
                    'currency' => 'required',
                ];
            }else{
                $rules = [
                    'product_name'  => 'required',
                    'product_description' => 'required',
                    'purchase_quantity' => 'required|numeric',
                    'quantity_unit' => 'required',
                ];
            }
            $images =   Input::get('images');
            if(count($images) == 0)
            {
                $rules['product_pictures'] = 'required';
            }
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return Response::json(['result' =>'failed', 'error' =>$validator->getMessageBag()->toArray()]);
            }else{
                $images = array();
                $files = array();
                $rfq_type = Input::get("rfq_type");
                $images =   Input::get('images');
                $files =    Input::get('files');
                $rfq = new RfqModel;
                $buyerID = Session::get('user_id');
                $rfq->buyer_id = $buyerID;
                $rfq->rfq_title= Input::get('product_name');
                $rfq->rfq_description = Input::get('product_description');
                $rfq->rfq_quantity = Input::get('purchase_quantity');
                $rfq->rfq_unit = Input::get('quantity_unit');
                $rfq->rfq_unitprice = Input::get('target_price');
                $rfq->rfq_itemunit =Input::get('currency');
                $rfq->rfq_type = $rfq_type;
                $rfq->rfq_approve =1;
                $rfq->save();
                $sql = "SELECT  MAX(id) AS maxID FROM np_rfq";
                $order = DB::select($sql);
                $rfqID = $order[0]->maxID;
                for($i =0; $i<count($images); $i++){
                    $rfqImage = new RfqPictureModel;
                    $rfqImage->rfq_id = $rfqID;
                    $rfqImage->buyer_id = $buyerID;
                    $rfqImage->picture_url = $images[$i];
                    $rfqImage->save();
                }
                if(count($files) != 0) {
                    for ($i = 0; $i < count($files); $i++) {
                        $files_list = explode(',', $files[$i]);
                        $rfqFile = new RfqFileModel;
                        $rfqFile->rfq_id = $rfqID;
                        $rfqFile->buyer_id = $buyerID;
                        $rfqFile->file_name = $files_list[1];
                        $rfqFile->file_url = $files_list[0];
                        $rfqFile->file_type = $files_list[2];
                        $rfqFile->save();
                    }
                }
                if($rfq_type == "detailed"){
                    $specification_description = Input::get('specification_description');
                    $specification_allowAlternative= Input::get('specification_allowAlternative');
                    $specification_descrition_pictures = Input::get('specification_descrition_pictures');

                    for($i=0; $i<count($specification_description); $i++){
                        if($specification_description[$i] != ""){
                            $rfq_specification = new RfqSpeModel;
                            $rfq_specification->rfq_id = $rfqID;
                            $rfq_specification->buyer_id = $buyerID;
                            $rfq_specification->rfq_description = $specification_description[$i];
                            $rfq_specification->rfq_alternative_ok = $specification_allowAlternative[$i];
                            $rfq_specification->save();

                            $sql = "SELECT  MAX(id) AS maxID FROM np_rfq_specification";
                            $order = DB::select($sql);
                            $rfq_specificationID = $order[0]->maxID;

                            $specification_picture = explode(',', $specification_descrition_pictures[$i]);
                            for($j=0; $j<count($specification_picture); $j++){
                                $rfq_specification_picture = new RfqSpePictureModel;
                                $rfq_specification_picture->rfq_id = $rfqID;
                                $rfq_specification_picture->buyer_id = $buyerID;
                                $rfq_specification_picture->specification_id = $rfq_specificationID;
                                $rfq_specification_picture->picture_url = $specification_picture[$j];
                                $rfq_specification_picture->save();
                            }
                        }
                    }
                }

            }
        }
        return Response::json(['result' =>'success']);
    }
    public function restore(){
        if(Request::ajax()) {
            $rules = [
                'product_name' => 'required',
                'product_description' => 'required',
                'purchase_quantity' => 'required|numeric',
                'quantity_unit' => 'required',
                'target_price' => 'required|numeric',
                'currency' => 'required',
            ];
            $images = Input::get('images');
            if(count($images) == 0){
                $rules['product_pictures'] ='required';
            }

            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return Response::json(['result' => 'failed', 'error' => $validator->getMessageBag()->toArray()]);
            } else {
                $rfqID = Input::get('rfq_id');
                RfqPictureModel::whereRaw('rfq_id = ?', array($rfqID))->delete();
                RfqFileModel::whereRaw('rfq_id = ?', array($rfqID))->delete();
                $images = array();
                $files = array();
                $images = Input::get('images');
                $files = Input::get('files');
                $rfq = RfqModel::find($rfqID);
                if(session::get('admin_id') == "1"){
                    $buyerID = 1;
                }else{
                    $buyerID = $rfq->buyer_id;
                }

                $rfq_type = Input::get("rfq_type");
                $rfq->rfq_title= Input::get('product_name');
                $rfq->rfq_description = Input::get('product_description');
                $rfq->rfq_quantity = Input::get('purchase_quantity');
                $rfq->rfq_unit = Input::get('quantity_unit');
                $rfq->rfq_unitprice = Input::get('target_price');
                $rfq->rfq_itemunit =Input::get('currency');
                $rfq->rfq_type = $rfq_type;
                $rfq->rfq_approve =1;
                $rfq->save();

                for($i =0; $i<count($images); $i++){
                    $rfqImage = new RfqPictureModel;
                    $rfqImage->rfq_id = $rfqID;
                    $rfqImage->buyer_id = $buyerID;
                    $rfqImage->picture_url = $images[$i];
                    $rfqImage->save();
                }


                if(count($files) != 0) {
                    for ($i = 0; $i < count($files); $i++) {
                        $files_list = explode(',', $files[$i]);
                        $rfqFile = new RfqFileModel;
                        $rfqFile->rfq_id = $rfqID;
                        $rfqFile->buyer_id = $buyerID;
                        $rfqFile->file_name = $files_list[1];
                        $rfqFile->file_url = $files_list[0];
                        $rfqFile->file_type = $files_list[2];
                        $rfqFile->save();
                    }
                }
                if($rfq_type == "detailed") {
                    $specification_description = Input::get('specification_description');
                    $specification_allowAlternative= Input::get('specification_allowAlternative');
                    $specification_descrition_pictures = Input::get('specification_descrition_pictures');
                    $specification_id = Input::get('specification_id');
                    for($i=0; $i<count($specification_description); $i++){
                        $description = explode(',',$specification_description[$i]);
                        if($description[1] != ""){
                            $rfq_specification = RfqSpeModel::find($description[1]);
                            RfqSpePictureModel::whereRaw('specification_id = ? ', array($description[1]))->delete();
                        }else{
                            $rfq_specification = new RfqSpeModel;
                        }
                        $rfq_specification->rfq_id = $rfqID;
                        $rfq_specification->buyer_id = $buyerID;
                        $rfq_specification->rfq_description = $description[0];
                        $rfq_specification->rfq_alternative_ok = $specification_allowAlternative[$i];
                        $rfq_specification->save();
                        if($description[1] != ""){
                            $rfq_specificationID = $description[1];
                        }else{
                            $sql = "SELECT  MAX(id) AS maxID FROM np_rfq_specification";
                            $order = DB::select($sql);
                            $rfq_specificationID = $order[0]->maxID;
                        }
                        $specification_picture = explode(',', $specification_descrition_pictures[$i]);
                        for($j=0; $j<count($specification_picture); $j++){
                            $rfq_specification_picture = new RfqSpePictureModel;
                            $rfq_specification_picture->rfq_id = $rfqID;
                            $rfq_specification_picture->buyer_id = $buyerID;
                            $rfq_specification_picture->specification_id = $rfq_specificationID;
                            $rfq_specification_picture->picture_url = $specification_picture[$j];
                            $rfq_specification_picture->save();
                        }

                    }
                }

            }
        }
        return Response::json(['result' =>'success']);
    }
    public function rfqEdit($id){
        $param['pageNo'] = 25;
        $user_id = Session::get('user_id');
        $emailList = EmailSendModel::where('parent','=',0)
            ->where( function ($query) use ($user_id) {
                $query->where('sender_id', '=', $user_id)->whereNotIn('sender_delete', array(1))
                    ->orWhere('receiver_id', '=', $user_id)->whereNotIn('receiver_delete', array(1));
            })->orderBy('created_at','desc')->paginate(10);
        $param['emailCount'] = count($emailList);
        $listID = $id-100000;
        $param['subPageNo'] = 4;
        $param['title'] = Lang::get('user.buyer_rfq');
        $param['currencies']=CurrencyModel::whereRaw(true)->orderBy('currency_name','asc')->get();
        $param['units'] = UnitModel::all();
        $param['rfq'] = RfqModel::find($listID);
        return View::make('user.buyer.rfq.edit')->with($param);
    }
    public function rfqView($id){
        $param['pageNo'] = 25;
        $user_id = Session::get('user_id');
        $emailList = EmailSendModel::where('parent','=',0)
            ->where( function ($query) use ($user_id) {
                $query->where('sender_id', '=', $user_id)->whereNotIn('sender_delete', array(1))
                    ->orWhere('receiver_id', '=', $user_id)->whereNotIn('receiver_delete', array(1));
            })->orderBy('created_at','desc')->paginate(10);
        $param['emailCount'] = count($emailList);

        $listID = $id-100000;
        $param['subPageNo'] = 4;
        $param['title'] = Lang::get('user.buyer_rfq');
        $param['rfq'] = RfqModel::find($listID);
        $param['currencies']=CurrencyModel::find($param['rfq']->rfq_itemunit);
        return View::make('user.buyer.rfq.view')->with($param);
    }
    public function rfqDelete($id){
        try {
            $listID = $id-100000;
            RfqModel::find($listID)->delete();
            $alert['msg'] = Lang::get('alert.This_RFQ_has_been_deleted_successfully');
            $alert['type'] = 'success';
        } catch(\Exception $ex) {
            $alert['msg'] = Lang::get('alert.This_RFQ_focus_has_been_already_used');
            $alert['type'] = 'danger';
        }
        return Redirect::route('user.buyer.rfq')->with('alert', $alert);
    }
    public function getEmails(){
        if(Request::ajax()) {
            $RFQID = Input::get('RFQ');
            $rfq_id = $RFQID -100000;
            $user_id = Session::get('user_id');
            $emailLists = RfqEmailModel::whereRaw('rfq_id = ? and sender_id =?', array($rfq_id,$user_id))->groupBy('receiver_id')->get();
            $content = '';
            if(count($emailLists)>0){
                $content .='<div class="form-group" style="text-align: center">
                            <div class="col-md-8 col-sm-8 col-xs-8">'.Lang::get('user.user_name').'</div>
                            <div class="col-md-4 col-sm-4 col-xs-4">'.Lang::get('user.action').'</div>
                        </div>';
                for($i=0; $i<count($emailLists); $i++){
                    $content .='<div class="form-group" style="text-align: center">
                                    <div class="col-md-8 col-sm-8 col-xs-8">';
                        $content .=$emailLists[$i]->receiver->username;
                        $content .='</div>
                                    <div class="col-md-4 col-sm-4 col-xs-4">';
                        $content .='<a href="'.URL::route('user.buyer.emailShow',array((100000*1+$emailLists[$i]->quote_id),(100000*1+$emailLists[$i]->rfq_id))).'" class="btn-u"  target="_blank"><i class="fa fa-envelope"></i></a>';
                    $content .='</div>';
                    $content .='</div>';
                }
                $data =array('result'=>'success', 'content' =>$content);
                return Response::json($data);
            }else{
                $data = array('result'=> 'empty');
                return Response::json($data);
            }
        }
    }
    public function getQuotes(){
        if(Request::ajax()) {
            $RFQID = Input::get('RFQ');
            $rfq_id = $RFQID -100000;
            $user_id = Session::get('user_id');
            $quoteLists = QuoteModel::whereRaw('rfq_id =? and buyer_id =? and status !=0 ', array($rfq_id, $user_id))->get();
            $content = '';

            if(count($quoteLists)>0){
                $content .='<div class="form-group" style="text-align: center">
                            <div class="col-md-3 col-sm-3 col-xs-4">'.Lang::get('user.user_name').'</div>
                            <div class="col-md-2 col-sm-2 col-xs-3">'.Lang::get('user.posted_date').'</div>
                            <div class="col-md-3 col-sm-3 col-xs-3">'.Lang::get('user.status').'</div>
                            <div class="col-md-4 col-sm-4 col-xs-3">'.Lang::get('user.action').'</div>
                        </div>';
                foreach($quoteLists as $key=>$quoteList){
                    $content .='<div class="form-group" style="text-align: center">';
                    $content .='<div class="col-md-3 col-sm-3 col-xs-4">';
                        $content .= $quoteList->sellerMember->username;
                    $content .='</div>';
                    $content .='<div class="col-md-2 col-sm-2 col-xs-3">';
                    $content .=substr($quoteList->created_at,0,10);
                    $content .='</div>';
                    $content .='<div class="col-md-3 col-sm-3 col-xs-3">';

                                        if($quoteList->status == 1){
                                            $content .=Lang::get('user.pending');
                                        }else if($quoteList->status == 2){
                                            $content .=Lang::get('user.request_sample');
                                        }else if($quoteList->status == 3 ){
                                            $content .=Lang::get('user.request_payment');
                                        }else if($quoteList->status == 4 ){
                                            $content .=Lang::get('user.wait_admin_confirm');
                                        }else if($quoteList->status == 5){
                                            $content .=Lang::get('user.admin_confirmed');
                                        }else if($quoteList->status == 6){
                                            $content .=Lang::get('user.seller_send_product');
                                        }
                    $content .='</div>';
                    $content .='<div class="col-md-4 col-sm-4 col-xs-3">';
                    $content .='<a href="'.URL::route("user.buyer.quoteShow",($quoteList->id*1+100000)).'" class=" tooltips btn-u btn-u-orange " data-toggle="tooltip" data-placement="top" title="'.Lang::get('user.view') . Lang::get("user.quote").'" style="margin-right:5px" target="_blank">
                                                <i class="fa fa-comments-o"></i>
                                           </a>';
                    $content .='<a href="'.URL::route("user.buyer.emailShow",array($quoteList->id*1+100000,$quoteList->rfq_id+100000*1)).'" class="btn-u btn-u-blue " data-toggle="tooltip" data-placement="top" title="'.Lang::get("user.emails").'"  style="margin-right:5px" target="_blank">
                                                <i class="fa fa-envelope"></i>
                                           </a>';
                    if($quoteList->status == 3 || $quoteList->status == 4) {
                    $content .='<a href="'.URL::route("user.invoice",($quoteList->id*1+100000)).'" class="tooltips btn-u btn-u-green" data-toggle="tooltip" data-placement="top" title ="'.Lang::get('user.invoice').'" target="_blank">
                                    <i class="fa fa-tasks"></i>
                                </a>';
                    }
                    $content .='</div>';
                    $content .='</div>';
                }
                $data =array('result'=>'success', 'content' =>$content);
                return Response::json($data);
            }else{
                $data = array('result'=> 'empty');
                return Response::json($data);
            }
        }
    }
    public function sampleStore(){
        if(Request::ajax()){
            $rules = [
                'quote_id' => 'required',
                'sample_amount' => 'required|numeric',
            ];
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return Response::json(['result' => 'failed', 'error' => $validator->getMessageBag()->toArray()]);
            } else {
                $QuoteID = Input::get('quote_id')-100000;
                $sample_amount = Input::get('sample_amount');
                $quoteList = QuoteModel::find($QuoteID);
                $quoteList->status = 2;
                $quoteList->save();
                $sample =new QuoteSampleModel;
                $sample->rfq_id = $quoteList->rfq_id;
                $sample->quote_id = $QuoteID;
                $sample->seller_id = $quoteList->seller_id;
                $sample->buyer_id = $quoteList->buyer_id;
                $sample->sampleamount = $sample_amount;
                $sample->save();
                $sender = MembersModel::find($quoteList->seller_id);
                $receiver = MembersModel::find($quoteList->buyer_id);
                $email = $sender->email;

                $data =array(
                    'username' =>$receiver->username,
                    'sample_request' =>$sample_amount,
                );
                Mail::send('emails.buyer.sample', $data, function($message) use ($email){
                    $message->from('noreply@purchasetree.com', Lang::get('alert.Sample_Request'));
                    $message->to($email,  Lang::get('alert.Sample_Request'))->subject( Lang::get('alert.Sample_Request'));
                });
                return Response::json(['result' => 'success', 'message' => Lang::get('Sample_request_has_been_send_successfully')]);
            }
        }

    }
    public function samplePayNow(){
        if(Request::ajax()){
            $rules = [
                'card_no' => 'required',
                'exp_month' => 'required',
                'exp_year' => 'required',
                'total' => 'required',
                'address' => 'required',
                'zipCode' => 'required',
                'email' => 'required|email',
                'cvv2' => 'required',
            ];
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return Response::json(['result' => 'failed', 'error' => $validator->getMessageBag()->toArray()]);
            } else {
                $quoteID = Input::get('quote_id');
                $realQuoteID = $quoteID-100000;
                $listData = array();
                $getTotalPrice = Input::get('total');
                $listTotal = explode('USD',$getTotalPrice);
                $listData['Total']= $listTotal[0];
                $listData['ePNAccount']= escrow_payment_account;
                $listData['CardNo']= Input::get('card_no');
                $listData['ExpMonth']= Input::get('exp_month');
                $listData['ExpYear']= Input::get('exp_year');
                $listData['Address']= Input::get('address');
                $listData['Zip']= Input::get('zipCode');
                $listData['EMail']=Input::get('email');
                $listData['CVV2Type']="1";
                $listData['CVV2']=Input::get('cvv2');
                $listData['RestrictKey']=escrow_RestrictKey;
                $listData['HTML']="No";
                $listData['TranType']="Sale";
                $inputsString = http_build_query($listData);

                $url = "https://www.eprocessingnetwork.com/cgi-bin/tdbe/transact.pl";

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_URL, str_replace(' ', '%20', $url));
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, str_replace(' ', '%20', $inputsString));
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

                $server_output = curl_exec ($ch);
                curl_close ($ch);
                if($server_output[1] !="Y"){
                    if($server_output[1] == "U"){
                        $result = "Unable to perform the transaction";
                    }else{
                        $result = "Declined";
                    }
                }else{
                    $list = explode(",", $server_output);
                    $listFirst= explode('"', $list[0]);
                    $listFirst= explode(" ", $listFirst[1]);
                    $listSecond=explode('"', $list[1]);
                    $avsResponse = $listSecond[1];
                    $listFifth=explode('"', $list[2]);
                    $cvvResponse =$listFifth[1];
                    $listThird= explode('"' ,$list[3]);
                    $listFourth =explode('"' ,$list[4]);
                    $InvoiceNumber = $listThird[1];
                    $tracsactionID = $listFourth[1];
                    $result= "Approved. Your invoice number is ".$InvoiceNumber;
                    $listQuoteBuyerCard = BuyerCardModel::whereRaw('quote_id =?', array($realQuoteID))->get();
                    if(count($listQuoteBuyerCard)>0){
                        $buyerCard = BuyerCardModel::find($listQuoteBuyerCard[0]->id);

                    }else{
                          $buyerCard = new BuyerCardModel;
                    }
                    $buyerCard->quote_id = $realQuoteID;
                    $buyerCard ->card_number = $listData['CardNo'];
                    $buyerCard ->card_month = $listData['ExpMonth'];
                    $buyerCard ->card_year   = $listData['ExpYear'];
                    $buyerCard ->total_payment = $listTotal[0];
                    $buyerCard ->card_address = $listData['Address'];
                    $buyerCard ->card_zip = $listData['Zip'];
                    $buyerCard ->card_email = $listData['EMail'];
                    $buyerCard ->card_cvv = $listData['CVV2'];
                    $buyerCard ->invoice_number = $InvoiceNumber;
                    $buyerCard ->transaction_id = $tracsactionID;
                    $buyerCard ->avs_response = $avsResponse;
                    $buyerCard ->cvv_response = $cvvResponse;

                   // $buyerCard->save();
                    $sampleList =QuoteSampleModel::whereRaw('quote_id=?', array($realQuoteID))->get();
                    $sampleList[0]->paidcheck = "111";
                    $sampleList[0]->invoicepaid = $InvoiceNumber;
                    $sampleList[0]->save();
                    $quote = QuoteModel::find($realQuoteID);
                    $quote->status = 4;
                    $quote->save();
                    $user_id = Session::get('user_id');
                    $BuyerMember = MembersModel::find($user_id);
                    $email = $BuyerMember->email;
                    $data = array(
                        'name' =>$BuyerMember->username,
                        'email'    =>$BuyerMember->email,
                        'price' =>$listTotal[0],
                    );
                    Mail::send('emails.buyer.paynow', $data, function($message){
                        $message->from('noreply@purchasetree.com', Lang::get('alert.Buyer_Payment'));
                        $message->to(Admin_Email, 'Admin')->subject(Lang::get('alert.Buyer_Payment'));
                    });
                    Mail::send('emails.buyer.paynowuser', $data, function($message) use($email){
                        $message->from('noreply@purchasetree.com', Lang::get('alert.Buyer_Payment'));
                        $message->to($email, 'Admin')->subject(Lang::get('alert.Buyer_Payment'));
                    });
                }
                return Response::json(['result' => 'success', 'message' => $result]);
            }
        }
    }
    public function quoteShow($id){
        $param['pageNo'] = 25;
        $user_id = Session::get('user_id');
        $listID = $id-100000;
        $param['subPageNo'] = 4;
        $param['title'] = Lang::get('user.buyer_rfq');
        $param['quote'] = QuoteModel::find($listID);
//        $acceptList = AcceptModel::where('quote_id', '=',$listID)->get();
        $acceptList = AcceptModel::whereRaw('quote_id=?',array($listID))->get();
        if(count($acceptList) >0 ){
            $param['quoteAccept'] = $acceptList;
            $param['quoteAcceptCheck'] = 1;
        }else{
            $param['quoteAcceptCheck'] = 0;
            //$param['quoteAccept'] = MembersModel::where('id','=',$param['quote']->buyer_id)->get();
            $param['quoteAccept'] = MembersModel::whereRaw('id=?',array($param['quote']->buyer_id))->get();
        }

        $param['country'] = CountryModel::whereRaw(true)->orderBy('country_name','asc')->get();
        $param['rfq1'] = RfqModel::whereRaw('id =?', array($param['quote']->rfq_id))->get();
        $param['rfqCurrencies']=CurrencyModel::find($param['rfq1'][0]->rfq_itemunit);
        $param['currencies'] =CurrencyModel::all();
        $param['units'] = UnitModel::all();
        $verticalFee = FeeModel::all();
        $param['verticalFee']=($verticalFee[0]->fee/100)*1+1;
        $param['rfq'] = $param['rfq1'][0];

        $param['seller'] = MembersModel::find($param['quote']->seller_id);
        $param['quotePic'] = QuotePictureModel::whereRaw('quote_id =?', array($param['quote']->id))->get();
        $param['quoteNote'] = QuoteNoteModel::whereRaw('quote_id =?', array($param['quote']->id))->get();
        if($param['quote']->status == 3){
               $quoteSample= QuoteSampleModel::whereRaw('quote_id =? and buyer_id =?', array($listID,$user_id))->get();
            $param['quoteSample'] = $quoteSample[0];
        }
        $param['rfqSpecificationDescription'] = RfqSpeModel::whereRaw('rfq_id=?',array($param['rfq']->id))->get();
        $param['quoteSpecificationDescription'] = QuoteSpeModel::whereRaw('quote_id =?', array($param['quote']->id))->get();
        return View::make('user.buyer.quoteView')->with($param);
    }
    public function emailShow($id, $id2){
        $param['pageNo'] = 25;
        $user_id = Session::get('user_id');
        $emailList = EmailSendModel::where('parent','=',0)
            ->where( function ($query) use ($user_id) {
                $query->where('sender_id', '=', $user_id)->whereNotIn('sender_delete', array(1))
                    ->orWhere('receiver_id', '=', $user_id)->whereNotIn('receiver_delete', array(1));
            })->orderBy('created_at','desc')->paginate(10);
        $param['emailCount'] = count($emailList);
        $listID = $id-100000;
        $rfqListID = $id2-100000;
        $param['subPageNo'] = 4;
        $param['title'] = Lang::get('user.buyer_rfq');
        $param['quote'] = QuoteModel::find($listID);
        $param['quoteEmail'] =RfqEmailModel::whereRaw('quote_id=?',array($listID))->get();
        $sellerMember = MembersModel::find($param['quote']->seller_id);
        $param['buyerUserName'] = $sellerMember->username;
        $param['buyerID'] = $sellerMember->id;
        $param['rfq_id'] = $id2;
        return View::make('user.buyer.emailShow')->with($param);
    }
    public function rfqStoreEmail(){
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
            $subject = Input::get('subject');
            $content = Input::get('content');
            $email_pattern = '/[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/';
            $content = preg_replace_callback($email_pattern, function($matches){
                return '##################';
            }, $content);
            $subject = preg_replace_callback($email_pattern, function ($matches){
                return '##################';
            }, $subject);
                $rfq_id = Input::get('rfq_id');
                $quote_id = Input::get('quote_id');
                $receiver_id = Input::get('user_id');
                $rfqEmail = new RfqEmailModel;
                $rfqEmail->rfq_id = ($rfq_id-100000);
                $rfqEmail->quote_id = ($quote_id-100000);
                $rfqEmail->sender_id = Session::get('user_id');
                $rfqEmail->receiver_id = ($receiver_id-100000);
                $rfqEmail->subject = $subject;
                $rfqEmail->message = $content;
                $rfqEmail->sender_red = 1;
                $rfqEmail->receiver_red = 0;
                $rfqEmail->save();
                $sender_id= session::get('user_id');

                $recevier = MembersModel::find($receiver_id-100000);
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
                return Redirect::route('user.buyer.emailShow',array($quote_id,$rfq_id))->with('alert', $alert);
        }
    }
    public  function rfqStoreEmail1(){
        if(Request::ajax()){
            $rules = [
                'subject' =>'required',
                'content' =>'required'
            ];
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return Response::json(['result' =>'failed', 'error' =>$validator->getMessageBag()->toArray()]);
            }else{
                $subject = Input::get('subject');
                $content = Input::get('content');
                $email_pattern = '/[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/';
                $content = preg_replace_callback($email_pattern, function($matches){
                    return '##################';
                }, $content);
                $subject = preg_replace_callback($email_pattern, function ($matches){
                    return '##################';
                }, $subject);
                $rfq_id = Input::get('rfq_id');
                $quote_id = Input::get('quote_id');
                $receiver_id = Input::get('user_id');
                $rfqEmail = new RfqEmailModel;
                $rfqEmail->rfq_id = ($rfq_id-100000);
                $rfqEmail->quote_id = ($quote_id-100000);
                $rfqEmail->sender_id = Session::get('user_id');
                $rfqEmail->receiver_id = ($receiver_id-100000);
                $rfqEmail->subject = $subject;
                $rfqEmail->message = $content;
                $rfqEmail->sender_red = 1;
                $rfqEmail->receiver_red = 0;
                $rfqEmail->save();
                $sender_id= Session::get('user_id');

                $recevier = MembersModel::find($receiver_id-100000);
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
               $message = Lang::get('missing.Quote_has_been_send_successfully');
                return Response::json(['result' =>'success', 'error' =>$message]);
            }
        }
    }
    public function decline(){
        if(Request::ajax()) {
            $QuoteID = Input::get('QuoteID');
            $realQuoteID = $QuoteID-100000;

            $list = QuoteModel::find($realQuoteID);
            $list->status = 0;
            $list->save();
            $data = array('result' =>'success', 'message'=>Lang::get('missing.Decline_successfully'), 'url' =>URL::route('user.buyer.rfq'));
        }
        return Response::json($data);
    }
    /*******Accept  part start*******/
    public  function getBuyerLocation(){
        if(Request::ajax()){
            $id = Input::get('id');
            $reallyID = $id-100000;
            $quote = QuoteModel::find($reallyID);
            $memberlist = MembersModel::find($quote->buyer_id);
            $content = '';
            if(count($memberlist)>0) {

                $data = array('result' => 'success', 'content' => $content);
                return Response::json($data);
            }
        }
    }
    public function rfqAccept(){

        $rules = [
            'address' =>'required',
            'city' =>'required',
            'zipcode' =>'required',
            'country_id' =>'required'
        ];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Response::json(['result' =>'failed', 'error' =>$validator->getMessageBag()->toArray()]);
        }else{
            $id = Input::get('quote_id');
            $reallyId = $id-100000;
            $quote = QuoteModel::find($reallyId);

            if($quote->status == 0){
                $alert['msg'] = Lang::get('alert.This_quote_has_been_declined');
                $alert['type'] = 'danger';
            }else{
                $acceptList = AcceptModel::whereRaw('quote_id =?', array($reallyId))->get();
                if(count($acceptList)> 0){
                    $acceptListModel = AcceptModel::find($acceptList[0]->id);
                }else{
                    $acceptListModel = new AcceptModel;
                }
                $acceptListModel->rfq_id = $quote->rfq_id;
                $acceptListModel->quote_id = $reallyId;
                $acceptListModel->seller_id = $quote->seller_id;
                $acceptListModel->buyer_id = $quote->buyer_id;
                $acceptListModel->buyer_address = Input::get('address');
                $acceptListModel->buyer_city = Input::get('city');
                $acceptListModel->buyer_state = Input::get('state');
                $acceptListModel->buyer_zip = Input::get('zipcode');
                $acceptListModel->buyer_country = Input::get('country_id');
                $acceptListModel->invoice_number = $this->invoicenumber(15);
                //$acceptListModel->invoice_date =date("Y-m-d H:i:s");
                $acceptListModel->invoice_date =date("Y-m-d H:i:s");
                $acceptListModel->save();

                $quote->accept = 1;
                $quote->accept_status = 1;
                $quote->save();
                $alert['msg'] = Lang::get('alert.This_quote_has_been_accepted');
                $alert['type'] = 'danger';
                return Response::json(['result' =>'success','url' => route('user.acceptInvoice',(100000*1+$reallyId))]);
                //return Redirect::route('user.invoice',(100000*1+$reallyId))->with('alert', $alert);
            }
        }
    }
    public function subShipping(){
        $id = Input::get('id');
        $reallyID= $id-100000;
        $quote = QuoteModel::find($reallyID);
        $list ="";
        $list .='<div class="row">';
        $list .='<div class="col-md-12">';
        $list .='<h4>'.Lang::get("missing.sample_shipping_for_this_quote").'</h4>';
        $list .='</div>';
        $list .='<div class="col-md-12">';
        if($quote->status == 6){
            $quoteSample = QuoteSampleModel::where('quote_id',$reallyID)->first();
            if(count($quoteSample)>0){
                $list .="<p>".Lang::get('missing.this_tracking_number_is')." ".$quoteSample->trackingnumber1."</p>";
            }
        }else{
            $list .='<p>'.Lang::get('missing.seller_did_not_create_shipping_label').'</p>';
        }
        $list .='</div>';
//            if($quote->accepet ==1){
//                $list .='<div class="col-md-12">';
//                    $list .='<h1>'.Lang::get("missing.accept_shipping_for_this_quote").'</h1>';
//                $list .='</div>';
//                $list .='<div class="col-md-12">';
//                    if($quote->admin_active == 0){
//                        $list .='<p>'.Lang::get('missing.you_have_to_wait_admin_confirm').'</p>';
//                    }else{
//                        $escrow = EscrowEscrowModel::whereRaw('quote_id =?',array($reallyID))->first();
//                        if(count($escrow)>0){
//                            if($escrow->status ==2){
//
//                            }
//                        }
//
//                    }
//                $list .='</div>';
//            }
        $list .='</div >';
        return Response::json(['result' =>"success", 'content' =>$list,'title'=>Lang::get('miissing.shipping')]);
    }
    public function subSample(){
        $id = Input::get('id');
        $reallyID= $id-100000;
        $quote = QuoteModel::find($reallyID);
        $list = '';
        $list .='<div class="row">';
            $list .='<div class="col-md-12">';
                $list .='<div class="form-horizontal">';
                $value1 = $quote->quoteSample;
                if(count($quote)>0 && count($value1)>0){
                    $value = $value1[0];
                        $list .='<div class="form-group">';
                            $list .='<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                                $list .=Lang::get('user.seller_name');
                            $list .='</label>';
                            $list .='<div class="col-md-6 col-lg-6 col-sm-5">';
                                $list.='<p class="form-control border-none-important">'.$quote->sellerMember->username.'</p>';
                            $list .='</div>';
                            $list .='<div class="col-md-2 col-lg-2 col-sm-2">';
                                $list .='<a href="'.URL::route('user.buyer.quoteShow',(100000*1+$quote->id)).'" class="btn-u btn-u-orange" target="_blank"><i class="fa fa-comments-o"></i></a>';
                            $list .='</div>';
                        $list .='</div>';
                        $list .='<div class="form-group">';
                            $list .='<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                                $list .=Lang::get('user.status');
                            $list .='</label>';
                            $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                            $list.='<p class="form-control border-none-important">';
                                if($quote->status == 1){
                                    $list .=Lang::get('user.pending');
                                }else if($quote->status == 2){
                                    $list .=Lang::get('user.request_sample');
                                }else if($quote->status == 3 ){
                                    $list .=Lang::get('user.request_payment');
                                }else if($quote->status == 4 ){
                                    $list .=Lang::get('user.wait_admin_confirm');
                                }else if($quote->status == 5){
                                    $list .=Lang::get('user.admin_confirmed');
                                }else if($quote->status == 6){
                                    $list .=Lang::get('user.seller_send_product');
                                }
                            $list .='</p>';
                            $list .='</div>';
                        $list .='</div>';
                        $list .='<div class="form-group">';
                            $list .='<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                                $list .=Lang::get('user.amount');
                            $list .='</label>';
                            $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                                $list.='<p class="form-control border-none-important">';
                                    $list.=$value->sampleamount;
                                $list .='</p>';
                            $list .='</div>';
                        $list .='</div>';
                        $list .='<div class="form-group">';
                            $list .='<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                                $list .=Lang::get('user.price');
                            $list .='</label>';
                            $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                            $list.='<p class="form-control border-none-important">';
                                        if($quote->sample_price !=""){
                                            $list .= round($quote->sample_price*Sample_Request_Add_Price,2).($quote->SampleCurrency->currency_name) ;
                                        }else{
                                            $list .= round($quote->price*Sample_Request_Add_Price,2).($quote->Currency->currency_name) ;
                                        }
                            $list .='</p>';
                            $list .='</div>';
                        $list .='</div>';
                        $list .='<div class="form-group">';
                            $list .='<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                                $list .=Lang::get('user.invoice_number');
                            $list .='</label>';
                            $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                            $list.='<p class="form-control border-none-important">';
                                $list.=$value->invoicenumber;
                            $list .='</p>';
                            $list .='</div>';
                        $list .='</div>';
                        $list .='<div class="form-group">';
                            $list .='<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                                $list .=Lang::get('user.request_date');
                            $list .='</label>';
                            $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                            $list.='<p class="form-control border-none-important">';
                                $list.=substr($value->created_at,0,10);
                            $list .='</p>';
                            $list .='</div>';
                        $list .='</div>';
                        $list .='<div class="form-group">';
                            $list .='<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                                $list .=Lang::get('user.tracking_number');
                            $list .='</label>';
                            $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                            $list.='<p class="form-control border-none-important">';
                                $list.=$value->tracking_number1;
                            $list .='</p>';
                            $list .='</div>';
                        $list .='</div>';
                        $list .='<div class="form-group margin-bottom-20">';
                            $list .='<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                                $list .=Lang::get('user.track_date');
                            $list .='</label>';
                            $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                            $list.='<p class="form-control border-none-important">';
                                $list .=substr($value->tracking_date,0,10);
                            $list .='</p>';
                            $list .='</div>';
                        $list .='</div>';
                    }
                else{
                        $list .=Lang::get('user.no_have_sample');
                }
                $list .='</div>';
            $list .='</div>';
        $list .='</div>';
        $rfq = $quote->rfq;
        $title = Lang::get('user.sample_for') . $rfq->rfq_title;
        $data =array('result'=>'success', 'content' =>$list, 'title' =>$title);
        return Response::json($data);
    }
    public function subEscrow(){
        $user_id = Session::get('user_id');
        $id = Input::get('id');
        $reallyID= $id-100000;
        $escrowUser = EscrowUserModel::whereRaw('purchasetree_id=?', array($user_id))->get();
        $param['escrowUser'] = $escrowUser;
        $list = '';
        if(count($escrowUser)>0){
            $escrow = EscrowEscrowModel::whereRaw('buyer_id=? and quote_id =?',array($escrowUser[0]->id,$reallyID))->get();
            $list .='<div class="row">';
                $list .='<div class="col-md-12">';
                    $list .='<div class="form-horizontal">';
                        if(count($escrow)>0){
                            foreach($escrow as $key=>$value) {
                                $list .= '<div class="form-group">';
                                    $list .= '<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                                        $list .= Lang::get('user.escrow_number');
                                    $list .= '</label>';
                                    $list .= '<div class="col-md-6 col-lg-6 col-sm-5">';
                                    $list.='<p class="form-control border-none-important">';
                                        $list .= $value->escrow_id;
                                    $list .='</p>';
                                    $list .= '</div>';
                                    $list .= '<div class="col-md-2 col-lg-2 col-sm-2">';
                                        $list .= '<a href="' . URL::route('user.escrow.escrow', ($value->escrow_id)) . '" class="btn-u btn-u-orange" target="_blank"><i class="fa fa-comments-o"></i></a>';
                                    $list .= '</div>';
                                $list .= '</div>';
                                $list .= '<div class="form-group">';
                                    $list .= '<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                                        $list .= Lang::get('user.status');
                                    $list .= '</label>';
                                    $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                                    $list.='<p class="form-control border-none-important">';
                                        if ($value->status == "1") {
                                            $list .= Lang::get('user.waiting_for_payment');
                                        } elseif ($value->status == 2) {
                                            if ($value->confirm == 1) {
                                                $list .= Lang::get('user.the_money_was_put_in_the_escrow');
                                            } elseif ($value->confirm == 0) {
                                                $list .= Lang::get('user.wait_admin_confirm_escrow');
                                            }
                                        } elseif ($value->status == 3) {
                                            if ($value->confirm == "2") {
                                                $list .= Lang::get('user.the_payment_was_disputed');
                                            } elseif ($value->confirm == "3") {
                                                $list .= Lang::get('user.dispute_solved');
                                            }
                                        } elseif ($value->status == 4) {
                                            $list .= Lang::get('user.the_payment_was_canceled');
                                        } elseif ($value->status == 5) {
                                            $list .= Lang::get('user.the_payment_was_approved');
                                        }
                                    $list .='</p>';
                                   $list .= '</div>';
                                $list .= '</div>';
                                $list .= '<div class="form-group">';
                                    $list .= '<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                                         $list .= Lang::get('user.total_due');
                                     $list .= '</label>';
                                     $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                                     $list.='<p class="form-control border-none-important">';
                                        $list .=$value->price."(USD)";
                                     $list .='</p>';
                                    $list .= '</div>';
                                $list .= '</div>';
                                $list .= '<div class="form-group">';
                                    $list .= '<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                                        $list .= Lang::get('user.escrow_amount');
                                    $list .= '</label>';
                                    $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                                    $list.='<p class="form-control border-none-important">';
                                        $list .=$value->total."(USD)";
                                    $list .='</p>';
                                    $list .= '</div>';
                                $list .= '</div>';
                                $list .= '<div class="form-group">';
                                    $list .= '<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                                        $list .= Lang::get('user.request_date');
                                    $list .= '</label>';
                                    $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                                    $list.='<p class="form-control border-none-important">';
                                        $list .=substr($value->created_at,0,10);
                                    $list .='</p>';
                                    $list .= '</div>';
                                $list .= '</div>';
                                $list .= '<div class="form-group">';
                                    $list .= '<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                                        $list .= Lang::get('user.date_escrow');
                                    $list .= '</label>';
                                    $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                                    $list.='<p class="form-control border-none-important">';
                                        $list .=$value->escrowDate;
                                    $list .='</p>';
                                    $list .= '</div>';
                                $list .= '</div>';
                                $list .= '<div class="form-group">';
                                    $list .= '<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                                        $list .= Lang::get('user.date_full_payment');
                                    $list .= '</label>';
                                    $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                                    $list.='<p class="form-control border-none-important">';
                                        $list .=$value->confirmDate;
                                    $list .='</p>';
                                    $list .= '</div>';
                                $list .= '</div>';
                                $list .= '<div class="form-group">';
                                    $list .= '<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                                        $list .= Lang::get('user.date_cancel');
                                    $list .= '</label>';
                                    $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                                    $list.='<p class="form-control border-none-important">';
                                        if($value->status == 4){
                                            $list .=$value->cancelDate;
                                        }
                                    $list .='</p>';
                                    $list .= '</div>';
                                $list .= '</div>';
                                $list .= '<div class="form-group">';
                                    $list .= '<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                                        $list .= Lang::get('user.date_dispute');
                                    $list .= '</label>';
                                    $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                                    $list.='<p class="form-control border-none-important">';
                                        if($value->status ==3){
                                            $list .=$value->disputeDate;
                                        }
                                    $list .='</p>';
                                    $list .= '</div>';
                                $list .= '</div>';
                                $list .='<div class="form-group margin-bottom-20"'; if(($key+1) != count($escrow)){$list .='style="border-bottom:1px solid #eee"';} $list .='>';
                                    $list .= '<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                                        $list .= Lang::get('user.date_approved');
                                    $list .= '</label>';
                                    $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                                    $list.='<p class="form-control border-none-important">';
                                        if($value->status ==5){
                                            $value->approvedDate;
                                        }
                                    $list .='</p>';
                                    $list .= '</div>';
                                $list .= '</div>';
                            }
                        }else{
                            $list .=Lang::get('user.no_have_escrow_account');
                        }
                    $list .='</div>';
                $list .='</div>';
            $list .='</div>';
        }else{
          $list .=Lang::get('user.no_have_escrow_account');
        }
        $rfq=QuoteModel::find($reallyID)->rfq;
        $title = Lang::get('user.escrow_for') . $rfq->rfq_title;
        $data =array('result'=>'success', 'content' =>$list, 'title' =>$title);
        return Response::json($data);
    }
    public function subOrders(){
        $user_id = Session::get('user_id');
        $id = Input::get('id');
        $reallyID= $id-100000;
        $rfq=QuoteModel::find($reallyID)->rfq;
        $accept = AcceptModel::whereRaw('quote_id= ?',array($reallyID))->get();
        $list ='';
        $list .='<div class="row">';
            $list .='<div class="col-md-12">';
                $list .='<div class="form-horizontal">';
                    if(count($accept)>0){
                        foreach($accept as $key=>$value){
                            $quote = $value->quote;
                            $list .='<div class="form-group">';
                                $list .='<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                                    $list .=Lang::get('user.seller_name');
                                $list .='</label>';
                                $list .='<div class="col-md-6 col-lg-6 col-sm-5">';
                                $list.='<p class="form-control border-none-important">';
                                    $list.=$value->sellerMember->username;
                                $list .='</p>';
                                $list .='</div>';
                                $list .='<div class="col-md-2 col-lg-2 col-sm-2">';
                                    $list .='<a href="'.URL::route('user.buyer.quoteShow',(100000*1+$quote->id)).'" class="btn-u btn-u-orange" target="_blank"><i class="fa fa-comments-o"></i></a>';
                                $list .='</div>';
                            $list .='</div>';
                            $list .= '<div class="form-group">';
                                $list .= '<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                                    $list .= Lang::get('user.status');
                                $list .= '</label>';
                                $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                                $list.='<p class="form-control border-none-important">';
                                    if ($quote->accept == "1" && $quote->accept_status == "1") {
                                        $list .= Lang::get('user.escrow_status_first');
                                    } elseif ($quote->accept == "1" && $quote->accept_status == "2") {
                                            $list .= Lang::get('user.escrow_status_second');
                                    }  elseif ($quote->accept == "1" && $quote->accept_status == "3") {
                                            $list .= Lang::get('user.escrow_status_third');
                                    } elseif ($quote->accept == "1" && $quote->accept_status == "4") {
                                        $list .= Lang::get('user.escrow_status_fourth');
                                    } elseif ($quote->accept == "1" && $quote->accept_status == "5") {
                                        $list .= Lang::get('user.escrow_status_fifth');
                                    }elseif ($quote->accept == "1" && $quote->accept_status == "6") {
                                            $list .= Lang::get('user.escrow_status_sixth');
                                     }elseif ($quote->accept == "1" && $quote->accept_status == "7") {
                                            $list .= Lang::get('user.escrow_status_seventh');
                                     }
                                $list .='</p>';
                                $list .= '</div>';
                            $list .= '</div>';
                            $list .= '<div class="form-group">';
                                $list .= '<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                                    $list .= Lang::get('user.amount');
                                $list .= '</label>';
                                $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                                $list.='<p class="form-control border-none-important">';
                                    $quotePrice = $rfq->rfq_quantity*$quote->price*Sample_Request_Add_Price;
                                    $currencyName = $quote->Currency->currency_name;
                                    if($currencyName == "USD"){
                                        $list.=round($quotePrice,2).$currencyName;
                                    }else{
                                        $list.=round($quotePrice,2).$currencyName.",";
                                        $list .=round($this->converCurrency($currencyName,$quotePrice),2)."USD";
                                    }
                                $list .='</p>';
                                $list .= '</div>';
                            $list .= '</div>';
                            $list .= '<div class="form-group">';
                                $list .= '<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                                    $list .= Lang::get('user.invoice_number');
                                $list .= '</label>';
                                $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                                $list.='<p class="form-control border-none-important">';
                                    $list .=$value->invoice_number;
                                $list .='</p>';
                                $list .= '</div>';
                            $list .= '</div>';
                            $list .='<div class="form-group">';
                                $list .='<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                                    $list .=Lang::get('user.request_date');
                                $list .='</label>';
                                $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                                $list.='<p class="form-control border-none-important">';
                                    $list.=substr($value->created_at,0,10);
                                $list .='</p>';
                                $list .='</div>';
                            $list .='</div>';
                            $list .='<div class="form-group">';
                                $list .='<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                                    $list .=Lang::get('user.tracking_number');
                                $list .='</label>';
                                $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                                $list.='<p class="form-control border-none-important">';
                                    $list.=$value->trackingnumber1;
                                $list .='</p>';
                                $list .='</div>';
                            $list .='</div>';
                            $list .='<div class="form-group margin-bottom-20"'; if(($key+1) != count($accept)){$list .='style="border-bottom:1px solid #eee"';} $list .='>';
                                $list .='<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                                    $list .=Lang::get('user.track_date');
                                $list .='</label>';
                                $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                                $list.='<p class="form-control border-none-important">';
                                    $list .=substr($value->tracking_date,0,10);
                                $list .='</p>';
                                $list .='</div>';
                            $list .='</div>';
                        }
                    }else{
                        $list .=Lang::get('user.no_have_order');
                    }
                $list .='</div>';
            $list .='</div>';
        $list .='</div>';
        $title = Lang::get('user.orders_for') . $rfq->rfq_title;
        $data =array('result'=>'success', 'content' =>$list, 'title' =>$title);
        return Response::json($data);
    }
    public function subMail(){
        $user_id = Session::get('user_id');
        $id = Input::get('id');
        $reallyID= $id-100000;
        $quote = QuoteModel::find($reallyID);
        $rfq_email = RfqEmailModel::whereRaw('quote_id=?',array($reallyID))
            ->where( function ($query) use ($user_id) {
            $query->where('sender_id', '=', $user_id)->orWhere('receiver_id', '=', $user_id);
        })->get();
        $sellerName = $quote->sellerMember->username;
        $rfq=QuoteModel::find($reallyID)->rfq;
        $sellerID = $quote->seller_id+100000*1;
        $rfqID = $rfq->id+100000*1;
        $quoteID = $id;
        $list ='';
        $list .='<div class="row">';
            $list .='<div class="col-md-12">';
                $list .='<div class="form-horizontal">';
                    if(count($rfq_email)>0) {
                        $list .='<div class="row">
                                    <div class="panel panel-default margin-bottom-40 change-panel">
                                        <div class="panel-body">
                                            <div class="panel-group acc-v1" id="accordion-1">';
                                            foreach ($rfq_email as $key => $value) {
                                                $list .='<div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <h4 class="panel-title">';
                                                                    $list .='<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-1" href="#collapse'. $key.'">';
                                                                        if($value->sender_id == Session::get('user_id')){
                                                                            $list .=Lang::get('user.me').' , '.$value->receiver->username;
                                                                        }else{
                                                                            $list .=$value->sender->username.' , '.Lang::get('user.me');
                                                                        }
                                                                    $list .='</a>';
                                                                $list .='</h4>';
                                                $list .='    </div>';
                                                    $list .='<div id="collapse'.$key.'" class="panel-collapse collapse">';
                                                        $list .='<div class="panel-body">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <h4 style="color: rgb(26, 114, 229);font-weight: 700;">'.$value->subject.'</h4>
                                                                                '.$value->message.'
                                                                        </div>
                                                                    </div>
                                                                </div>';
                                                    $list .='</div>';
                                                $list .=' </div>';
                                            }
                                        $list .='</div>';

                                    $list .='</div>';
                                $list .='</div>';
                            $list .='</div>';
                    }
                        $list .=' <div class="col-md-12">';
                            $list .='<form action="'.URL::route('user.buyer.rfqStoreEmailPost').'" method="post" class="form-horizontal reg-page" id="emailSendForm">';
                                 $list .='<div class="form-group">
                                         <label for="inputEmail1" class="col-lg-3 col-sm-4 col-md-4 col-xs-5 control-label">'.Lang::get('user.to').'</label>
                                        <div class="col-lg-8 col-md-6 col-sm-6 col-xs-7">
                                            <input type="text" class="form-control" id="inputEmail1" placeholder="Email" value="'.$sellerName.'" readonly style="border:0px!important">
                                        </div>
                                    </div>';
                                $list .='<div class="form-group">
                                     <label for="inputEmail1" class="col-lg-3 col-sm-4 col-md-4 col-xs-5 control-label"><span style="color:red">*</span> '.Lang::get('user.message_subject').' :</label>
                                    <div class="col-lg-8 col-md-6 col-sm-6 col-xs-7">
                                        <textarea class="form-control" id="inputEmail1" placeholder="'.Lang::get('user.message_subject').'"  rows="1" name="subject"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                     <label for="inputEmail1" class="col-lg-3 col-sm-4 col-md-4 col-xs-5 control-label"><span style="color:red">*</span> '.Lang::get('user.message_content').' :</label>
                                    <div class="col-lg-8 col-md-6 col-sm-6 col-xs-7">
                                        <textarea class="form-control" id="inputEmail1" placeholder="'.Lang::get('user.message_content').'"  rows="10" name="content"></textarea>
                                    </div>
                                </div>';
                                $list .='<input type="hidden" name="user_id" value="'. $sellerID.'">
                                         <input type="hidden" name="rfq_id" value="'.$rfqID.'" >
                                         <input type="hidden" name="quote_id" value="'.$quoteID.'" >';
                                $list .='<div class="form-group">
                                            <div class="col-lg-offset-3 col-md-offset-3 col-sm-offset-4 col-xs-offset- col-lg-8 col-md-6 col-sm-6 col-xs-7">
                                                <input type="button" class="btn-u btn-u-blue" value="'.Lang::get('user.send').'" onclick = "onSendFormButton()" id="semd">

                                                <a href="javascript:void(0)" class="btn-u btn-u-red" onclick="onHideMessageForm()">'.Lang::get('user.cancel').'</a>
                                                <div id="spin"></div>
                                            </div>
                                        </div>';
                            $list .='</form>';
                    $list .='</div>';
                $list .='</div>';
            $list .='</div>';
        $list .='</div>';

        $title = Lang::get('user.email_for') ." ". $rfq->rfq_title;
        $data =array('result'=>'success', 'content' =>$list, 'title' =>$title);
        return Response::json($data);
    }
    public function rfqStoreEmailPost(){
        $rules = [
            'subject' =>'required',
            'content' =>'required'
        ];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Response::json(['result' => 'failed', 'error' => $validator->getMessageBag()->toArray()]);
        }else{
            $subject = Input::get('subject');
            $content = Input::get('content');
            $email_pattern = '/[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/';
            $content = preg_replace_callback($email_pattern, function($matches){
                return '##################';
            }, $content);
            $subject = preg_replace_callback($email_pattern, function ($matches){
                return '##################';
            }, $subject);
            $rfq_id = Input::get('rfq_id');
            $quote_id = Input::get('quote_id');
            $receiver_id = Input::get('user_id');
            $rfqEmail = new RfqEmailModel;
            $rfqEmail->rfq_id = ($rfq_id-100000);
            $rfqEmail->quote_id = ($quote_id-100000);
            $rfqEmail->sender_id = Session::get('user_id');
            $rfqEmail->receiver_id = ($receiver_id-100000);
            $rfqEmail->subject = $subject;
            $rfqEmail->message = $content;
            $rfqEmail->sender_red = 1;
            $rfqEmail->receiver_red = 0;
            $rfqEmail->save();
            $sender_id= Session::get('user_id');

            $recevier = MembersModel::find($receiver_id-100000);
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
            $message = Lang::get('missing.Quote_has_been_send_successfully');
            return Response::json(['result' =>'success', 'error' =>$message]);
        }
    }
    public function subDocuments(){
        $user_id = Session::get('user_id');
        $id = Input::get('id');
        $reallyID= $id-100000;
        $quote = QuoteModel::find($reallyID);
        $rfq=QuoteModel::find($reallyID)->rfq;
        $quoteSample = QuoteSampleModel::whereRaw('quote_id =?', array($reallyID))->get();
        $quoteAccept = AcceptModel::whereRaw('quote_id =?',array($reallyID))->get();
        $totalPrice = $quote->price*$rfq->rfq_quantity*Sample_Request_Add_Price;
        $currency =($quote->Currency->currency_name);
        $currency = strtoupper($currency);
        if(strtoupper($currency) != "USD"){
            $total=round($this->converCurrency($currency,$totalPrice),2)."USD";
        }else{
            $total = round($totalPrice,2)."USD";
        }
        $escrow = EscrowEscrowModel::whereRaw('quote_id =?',array($reallyID))->get();
        $list ='';
        $list .='<div class="row">';
            $list .='<div class="col-md-12">';
                $list .='<div class="form-horizontal">';
                    $list .="<h4 class='margin-bottom-20 text-center'>".Lang::get('user.general_information')."</h4>";
                    $list .='<div class="form-group">';
                        $list .= '<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                            $list .=Lang::get('user.order_number');
                        $list .='</label>';
                        $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                        $list.='<p class="form-control border-none-important">';
                        if(count($quoteSample)>0){
                            $list .='<a href="'.URL::route('user.invoice',$id).'" target="_blank">'.Lang::get('user.sample_invoice').'</a>';
                            $list .=" <br>";
                        }
                        if(count($quoteAccept)>0){
                            $list .='<a href="'.URL::route('user.acceptInvoice',$id).'" target="_blank">'.Lang::get('user.order_invoice').'</a>';
                        }
                        $list .='</p>';
                        $list .='</div>';
                    $list .='</div>';

                    $list .='<div class="form-group margin-bottom-20">';
                        $list .= '<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                            $list .=Lang::get('user.contract');
                        $list .='</label>';
                        $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                            $list.='<p class="form-control border-none-important">';
                                $list .='<a href="'.URL::route('user.buyer.emailShow',array($id, $rfq->id+100000*1)).'" target ="_blank">'.Lang::get('user.email').' '.Lang::get('user.to_seller').'</a>';

                            $list .='</p>';
                        $list .='</div>';
                    $list .='</div>';
                    $list .="<h4 class='margin-bottom-20 text-center'>".Lang::get('user.payment_information')."</h4>";
                    $list .='<div class="form-group">';
                        $list .= '<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                                $list .=Lang::get('user.contract_amount');
                        $list .='</label>';
                        $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                        $list.='<p class="form-control border-none-important">';
                                if($currency !="USD"){
                                    $list .=$totalPrice." ".strtoupper($currency);
                                    $list .=",".$total;
                                }else{
                                    $list .=$total;
                                }
                        $list .='</p>';
                        $list .='</div>';
                    $list .='</div>';
                    $list .='<div class="form-group ">';
                        $list .= '<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                                $list .=Lang::get('user.amount_paid');
                        $list .='</label>';
                        $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                        $list.='<p class="form-control border-none-important">';
                                if(count($escrow)>0){
                                    $list .=$escrow[0]->total."USD";
                                }
                        $list .='</p>';
                        $list .='</div>';
                    $list .='</div>';
                    $list .='<div class="form-group margin-bottom-20">';
                        $list .= '<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                                $list .=Lang::get('user.payment_date');
                        $list .='</label>';
                        $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                            $list.='<p class="form-control border-none-important">';
                                if(count($escrow)>0){
                                 $list .=$escrow[0]->escrowDate;
                                }
                            $list .='</p>';
                        $list .='</div>';
                    $list .='</div>';
                    $list .="<h4 class='margin-bottom-20 text-center'>".Lang::get('user.sample_shipping_documents')."</h4>";
                    $list .='<div class="form-group ">';
                        $list .= '<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                            $list .=Lang::get('user.sample_invoice_number');
                        $list .='</label>';
                        $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                           $list.='<p class="form-control border-none-important">';
                            if(count($quoteSample)>0){
                                $list .='<a href="'.URL::route('user.invoice',$id).'" target="_blank">'.$quoteSample[0]->invoicenumber.'</a>';
                            }
                        $list .='</p>';
                        $list .='</div>';
                    $list .='</div>';
                    $list .='<div class="form-group margin-bottom-20">';
                        $list .= '<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                            $list .=Lang::get('user.shipping_tracking_number');
                        $list .='</label>';
                        $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                            $list.='<p class="form-control border-none-important">';
                        if(count($quoteSample)>0) {
                            $list .= '<a href ="javascript:void(0)">' . $quoteSample[0]->trackingnumber1 . '</a>';
                        }
                            $list .='</p>';
                        $list .='</div>';
                    $list .='</div>';
                    $list .="<h4 class='margin-bottom-20 text-center'>".Lang::get('user.shipping_documents')."</h4>";
                    $list .='<div class="form-group margin-bottom-20">';
                        $list .= '<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                            $list .=Lang::get('user.document_tracking_number');
                        $list .='</label>';
                        $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';

                        $list .='</div>';
                    $list .='</div>';

                    $list .='<div class="form-group margin-bottom-20">';
                        $list .= '<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                            $list .=Lang::get('user.bill_of_landing');
                        $list .='</label>';
                        $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';

                        $list .='</div>';
                    $list .='</div>';
                    $list .='<div class="form-group margin-bottom-20">';
                        $list .= '<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                            $list .=Lang::get('user.packing_list');
                        $list .='</label>';
                        $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';

                        $list .='</div>';
                    $list .='</div>';
                    $list .='<div class="form-group margin-bottom-20">';
                        $list .= '<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                            $list .=Lang::get('user.invoice');
                        $list .='</label>';
                        $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';

                         $list .='</div>';
                    $list .='</div>';
                    $list .='<div class="form-group margin-bottom-20">';
                        $list .= '<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                            $list .=Lang::get('user.customs_pre_record');
                        $list .='</label>';
                        $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';

                        $list .='</div>';
                    $list .='</div>';
                    $list .='<div class="form-group margin-bottom-20">';
                        $list .= '<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                            $list .=Lang::get('user.shipping_invoice');
                        $list .='</label>';
                        $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';

                        $list .='</div>';
                    $list .='</div>';

                $list .='</div>';
            $list .='</div>';
        $list .='</div>';
        $title = Lang::get('user.document_for') ." ". $rfq->rfq_title;
        $data =array('result'=>'success', 'content' =>$list, 'title' =>$title);
        return Response::json($data);
    }




    public function subInspection(){
        $user_id = Session::get('user_id');
        $id = Input::get('id');
        $reallyID= $id-100000;
        $rfq = RfqModel::find($reallyID);
        $quoteSample = QuoteSampleModel::whereRaw('rfq_id=?',array($reallyID))->get();
        $quoteAccept = AcceptModel::whereRaw('rfq_id=?',array($reallyID))->get();

    }

    function invoicenumber($len){
        $strpattern = "ABCDEFGHJKLMNPQRSTUVWXYZ1234567890";
        $result = "";
        for( $i = 0 ; $i < $len; $i ++ ){
            $rand = rand( 0, strlen($strpattern) - 1 );
            $result = $result.$strpattern[$rand];
        }
        return $result;
    }
    function converCurrency($from,$amount){
        $to_Currency="USD";
        $from_Currency = $from;
        $amount = urlencode($amount);
        $from_Currency = urlencode($from_Currency);
        $to_Currency = urlencode($to_Currency);

        $get = file_get_contents("https://www.google.com/finance/converter?a=$amount&from=$from_Currency&to=$to_Currency");

        $get = explode("<span class=bld>",$get);
        $get = explode("</span>",$get[1]);
        $converted_amount = preg_replace("/[^0-9\.]/", null, $get[0]);
        return $converted_amount;
    }
}