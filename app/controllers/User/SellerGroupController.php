<?php namespace User;

use Illuminate\Routing\Controllers\Controller;
use Intervention\Image\Facades\Image;
use View, Input, Redirect, Session, Validator, DB, Mail,File, Request,Response,Lang,SoapClient,URL;
use Members as MembersModel, Country as CountryModel,CompanyProfile as CompanyProfileModel, EmailSend as EmailSendModel,Rfq as RfqModel,
    RfqPicture as RfqPictureModel,RfqFile as RfqFileModel,RfqSpe as RfqSpeModel,RfqSpePicture as RfqSpePictureModel,Email as EmailModel,
    Currency as CurrencyModel,Unit as UnitModel, Quote as QuoteModel, QuoteNote as QuoteNoteModel, QuotePicture as QuotePictureModel,
    QuoteSpe as QuoteSpeModel,RfqEmail as RfqEmailModel, QuoteSample as QuoteSampleModel, Fee as FeeModel, Product as ProductModel, ShoppingCart as ShoppingCartModel,
    ProductPicture as ProductPictureModel,SubCategory as SubCategoryModel, Category as CategoryModel, QuickDetails as QuickDetailsModel,Accept as AcceptModel,
    EscrowUser as  EscrowUserModel,EscrowEscrow as EscrowEscrowModel,ProductQuickDetail as ProductQuickDetailModel,ShoppingCartEmail as ShoppingCartEmailModel,
    AdditionalCategory as AdditionalCategoryModel, ProductAdditionalCategory as ProductAdditionalCategoryModel,ShoppingCartProduct as ShoppingCartProductModel,
    ProductAdditionalImage as  ProductAdditionalImageModel, ProductShipping as ProductShippingModel;

class SellerGroupController  extends \BaseController {
    public function __construct()
    {
        $this->beforeFilter(function () {
            if (!Session::has('user_id')) {
                return Redirect::route('user.auth.login');
            }
            if(Session::get('user_type') == 2){
                return Redirect::route('user.buyer.dashboard');
            }
        });
    }
    /*********************cart start*****************************/
    public function cart(){
        $param['pageNo'] = 35;
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $param['subPageNo'] = 6;
        $user_id =Session::get('user_id');
        $param['title'] = Lang::get('user.shopping_cart');
        $param['subTitle'] = Lang::get('user.shopping_cart');
        $emailList = EmailSendModel::where('parent','=',0)
            ->where( function ($query) use ($user_id) {
                $query->where('sender_id', '=', $user_id)->whereNotIn('sender_delete', array(1))
                    ->orWhere('receiver_id', '=', $user_id)->whereNotIn('receiver_delete', array(1));
            })->orderBy('created_at','desc')->paginate(10);
        $param['emailCount'] = count($emailList);
        $param['carts'] = ShoppingCartProductModel::whereRaw('seller_id=?', array(Session::get('user_id')))->orderBy('id','DESC')->paginate(10);
        return View::make('user.seller.cart')->with($param);
    }



    public function cartBuyer(){
        $id = Input::get('id');
        $shoppingCartProductID = $id-100000;
        $shoppingCartProduct = ShoppingCartProductModel::find($shoppingCartProductID);
        $shoppingCart = $shoppingCartProduct->ShoppingCart;
        $product = ProductModel::find($shoppingCartProduct->product_id);
        $list = '';

        $list .='<div class="row">';
            $list .='<div class="col-md-12">';
                $list .='<div class="form-horizontal">';
                     $list .='<div class="form-group">';
                          $list .='<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                                $list .=Lang::get('user.shopping_cart_buyer_user_name');
                          $list .='</label>';
                          $list .='<div class="col-md-8 col-lg-8 col-sm-7">';
                                $list.='<p class="form-control border-none-important">'.$shoppingCart->member->username.'</p>';
                          $list .='</div>';
                     $list .='</div>';
                    $list .='<div class="form-group">';
                        $list .='<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                            $list .=Lang::get('user.status');
                        $list .='</label>';
                        $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                            $list.='<p class="form-control border-none-important">';
                                if($shoppingCart->status == 1){
                                    $list .=Lang::get('user.shopping_cart_pending');
                                }else if($shoppingCart->status == 2){
                                    $list .=Lang::get('user.shopping_cart_escrow');
                                }else if($shoppingCart->status == 3 ){
                                    $list .=Lang::get('user.request_payment');
                                }else if($shoppingCart->status == 4 ){
                                    $list .=Lang::get('user.wait_admin_confirm');
                                }else if($shoppingCart->status == 5){
                                    $list .=Lang::get('user.admin_confirmed');
                                }else if($shoppingCart->status == 6){
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
                                $list .=$shoppingCart->shipping_firstname." ". $shoppingCart->shipping_lastname;
                            $list .='</p>';
                        $list .='</div>';
                    $list .='</div>';
                    $list .='<div class="form-group">';
                        $list .='<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                            $list .=Lang::get('user.shopping_cart_address');
                        $list .='</label>';
                        $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                            $list.='<p class="form-control border-none-important">';
                                $list .=$shoppingCart->shipping_address1." ". $shoppingCart->shipping_address2;
                            $list .='</p>';
                        $list .='</div>';
                    $list .='</div>';
                    $list .='<div class="form-group">';
                        $list .= '<div class="col-md-8 col-lg-8 col-sm-7 col-md-offset-4 col-lg-offset-4 col-sm-offset-5">';
                            $list.='<p class="form-control border-none-important">';
                                $list .=$shoppingCart->shipping_city." , ". $shoppingCart->shipping_state." , ". $shoppingCart->shipping_zip." , ". $shoppingCart->shoppingCountry->country_name;
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
        $buyer  = MembersModel::find($shoppingCart->buyer_id);
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
        $list .='<form action="'.URL::route('user.seller.cart.postMail').'" method="post" class="form-horizontal reg-page" id="emailSendForm">';
        $list .='<div class="form-group">
                                         <label for="inputEmail1" class="col-lg-3 col-sm-4 col-md-4 col-xs-5 control-label">'.Lang::get('user.to').'</label>
                                        <div class="col-lg-8 col-md-6 col-sm-6 col-xs-7">
                                            <input type="text" class="form-control" id="inputEmail1" placeholder="Email" value="'.$buyer->username.'" readonly style="border:0px!important">
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
                                $list .='<input type="hidden" name="user_id" value="'.(100000*1+$buyer->id).'">
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

        $title = Lang::get('user.shopping_cart_email_to_buyer') ." ". $buyer->username;
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

            $receiver_id = Input::get('user_id');
            $cartEmail = new ShoppingCartEmailModel;
            $cartEmail->sender_id = Session::get('user_id');
            $cartEmail->receiver_id = ($receiver_id-100000);
            $cartEmail->subject = $subject;
            $cartEmail->message = $content;
            $cartEmail->sender_red = 1;
            $cartEmail->receiver_red = 0;
            $cartEmail->shopping_cart_product_id = (Input::get('shoppingCartProductID') -100000);
            $cartEmail->save();
            $sender_id= Session::get('user_id');
            $shoppingCartProductID = Input::get('shoppingCartProductID');
            $reallyProductID = $shoppingCartProductID-100000;
            $cartProduct = ShoppingCartProductModel::find($reallyProductID);
            $cart = ShoppingCartModel::find($cartProduct->cart_id);
            $recevier = MembersModel::find($receiver_id-100000);
            $sender =  MembersModel::find($sender_id);
            $email = $recevier->email;
            $emails = [];
            $emails[0] = $email;
            if($cart->billing_email != $email){
                $countEmail  = count($emails);
                $emails[$countEmail] = $cart->billing_email;
            }
            if($cart->shipping_email != $email &&  $cart->shipping_email != $cart->billing_email){
                $countEmail  = count($emails);
                $emails[$countEmail] = $cart->billing_email;
            }
            $data =array(
                'username' =>$sender->username,
                'subject' =>$subject,
                'content' =>$content
            );
            Mail::send('emails.contact.sendMessage', $data, function($message) use ($emails){
                $message->from('noreply@purchasetree.com', Lang::get('alert.Send_Message'));
                $message->to($emails, Lang::get('alert.Send_Message'))->subject(Lang::get('alert.Send_Message'));
            });
            $message = Lang::get('missing.Message_has_been_send_successfully');
            return Response::json(['result' =>'success', 'error' =>$message]);
        }
    }
    public function cartShipping($id){
        $param['pageNo'] = 35;
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $id = $id-100000;
        $param['subPageNo'] = 6;
        $user_id =Session::get('user_id');
        $param['title'] = Lang::get('user.my_orders');
        $param['subTitle'] = Lang::get('user.orders');
        $shoppingCartProduct = ShoppingCartProductModel::findOrFail($id);
        $emailList = EmailSendModel::where('parent','=',0)
            ->where( function ($query) use ($user_id) {
                $query->where('sender_id', '=', $user_id)->whereNotIn('sender_delete', array(1))
                    ->orWhere('receiver_id', '=', $user_id)->whereNotIn('receiver_delete', array(1));
            })->orderBy('created_at','desc')->paginate(10);
        $param['emailCount'] = count($emailList);
        if($shoppingCartProduct->status<2){
            $alert['msg'] = Lang::get('alert.Shopping_cart_product_is_not_in_the_escrow');
            $alert['type'] = 'success';
            return back()->with('alert',$alert);
        }else{
            $param['shoppingCartProduct']= $shoppingCartProduct;
            $param['shoppingCart'] = $shoppingCartProduct->ShoppingCart;
            $buyer = MembersModel::find($param['shoppingCart']->buyer_id);
            $param['sellerCountry'] = $buyer->country;
            return View::make('user.seller.cart_shipping')->with($param);
        }
    }

    public function sendSellerConfirm(){
        $id = Input::get('id');
        $product_id = $id - 100000;
        $shoppingProduct = ShoppingCartProductModel::find($product_id);
        $shoppingProduct->status = 4;
        $shoppingProduct->save();
        return Response::json(['result' =>'success']);
    }



    /*********************cart end*****************************/
    public function index(){
        $param['pageNo'] = 35;
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $param['subPageNo'] = 1;
        $user_id =Session::get('user_id');
        $param['title'] = Lang::get('user.my_orders');
        $param['subTitle'] = Lang::get('user.orders');
        $emailList = EmailSendModel::where('parent','=',0)
                                        ->where( function ($query) use ($user_id) {
                                            $query->where('sender_id', '=', $user_id)->whereNotIn('sender_delete', array(1))
                                                ->orWhere('receiver_id', '=', $user_id)->whereNotIn('receiver_delete', array(1));
                                        })->orderBy('created_at','desc')->paginate(10);
        $param['emailCount'] = count($emailList);

        $sql_query = "SELECT quote_id
                        FROM np_seller_sample
                        WHERE seller_id =".$user_id."
                        UNION
                        SELECT quote_id FROM np_seller_accept
                        WHERE seller_id = ".$user_id;
        $array = DB::select($sql_query);
        if(count($array)>0){
            $arrayList = array();
            for($i=0; $i<count($array); $i++){
                $arrayList[$i]= $array[$i]->quote_id;
            }
            $param['quote'] = QuoteModel::whereRaw('seller_id =?', array($user_id))->whereIn('id',$arrayList)->orderBy('id','desc')->paginate(10);
            //$param['quote'] = [];
        }else{

            //$param['rfq'] = "";
        }

        return View::make('user.seller.index')->with($param);
    }
    public function email($slug){
        $param['pageNo'] = 35;
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
                $companylogoList = CompanyProfileModel::where('user_id', $anotherUser)->first();
                $companyList[$i] =$companylogoList;
            }
            $param['companyList'] = $companyList;
            $param['emailList'] = $emailList;
            $param['slug'] = 'new';
            return View::make('user.seller.emailList')->with($param);
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
                $companylogoList = CompanyProfileModel::where('user_id', $anotherUser)->first();
                $companyList[$i] =$companylogoList;
            }
            $param['companyList'] = $companyList;
            $param['itemList'] = $ItemList;
            $param['emailList'] = $emailList;
            $param['slug'] = 'all';

            return View::make('user.seller.email')->with($param);
        }else if($slug == "sent"){
            $emailList = EmailSendModel::where('sender_id','=',$user_id)->whereNotIn('sender_delete' ,array(1))->orderBy('id','DESC')->paginate(10);
            $companyList = array();
            for($i=0; $i<count($emailList); $i++){
                if($emailList[$i]->sender_id != $user_id){
                    $anotherUser = $emailList[$i]->sender_id;
                }else{
                    $anotherUser = $emailList[$i]->receiver_id;
                }
                $companylogoList = CompanyProfileModel::where('user_id', $anotherUser)->first();
                $companyList[$i] =$companylogoList;
            }
            $param['companyList'] = $companyList;
            $param['emailList'] = $emailList;
            $param['slug'] = 'sent';
            return View::make('user.seller.emailList')->with($param);

        }else if($slug == "inbox"){
            $emailList = EmailSendModel::where('receiver_id','=',$user_id)->whereNotIn('receiver_delete' ,array(1))->orderBy('id','DESC')->paginate(10);
            $companyList = array();
            for($i=0; $i<count($emailList); $i++){
                if($emailList[$i]->sender_id != $user_id){
                    $anotherUser = $emailList[$i]->sender_id;
                }else{
                    $anotherUser = $emailList[$i]->receiver_id;
                }
                $companylogoList = CompanyProfileModel::where('user_id', $anotherUser)->first();
                $companyList[$i] =$companylogoList;
            }
            $param['companyList'] = $companyList;
            $param['emailList'] = $emailList;
            $param['slug'] = 'inbox';
            return View::make('user.seller.emailList')->with($param);
        }
    }
    public function newList($id, $slug){
        $param['pageNo'] = 35;
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $user_id =Session::get('user_id');
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
        return View::make('user.seller.newList')->with($param);
    }
    public function getEmailContent($id,$slug){
        $param['pageNo'] = 35;
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
        $email = EmailSendModel::where('id', '=', $listID)->orWhere('parent', '=',$listID)
                                ->where( function ($query) use ($user_id) {
                                    $query->where('sender_id', '=', $user_id)->whereNotIn('sender_delete', array(1))
                                        ->orWhere('receiver_id', '=', $user_id)->whereNotIn('receiver_delete', array(1));
                                })->get();
        if($email[0]->sender_id == Session::get('user_id')) {
            $param['buyerUserName'] = $email[0]->recevier->username;
            $param['buyerID'] = $email[0]->receiver_id;
        }else{
            $param['buyerUserName'] = $email[0]->sender->username;
            $param['buyerID'] = $email[0]->sender_id;
        }
        $param['email'] = $email;
        $param['parent'] = $listID+100000*1;
        return View::make('user.seller.emailContent')->with($param);
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
        return Redirect::route('user.seller.email',$slug)->with('alert', $alert);
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
            $alert['msg'] = Lang::get('alert.Message_has_been_send_successfully');
            $alert['type'] = 'success';
        }
        return Redirect::route('user.seller.getEmailContent',array($parent,$slug))->with('alert', $alert);
    }
    public function favorite(){
        $param['pageNo'] = 35;
        $param['members'] = MembersModel::where('usertype','=',1)->orWhere('usertype','=',3)->where('status','=',1)->paginate(10);
        $company = array();
        if(count($param['members']) >0){
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
        return View::make('user.seller.favorite')->with($param);
    }
    public function loginRfq(){
        $param['pageNo'] = 35;
        $param['title'] = Lang::get('user.buyer_rfq');
        $user_id = Session::get('user_id');
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $emailList = EmailSendModel::where('parent','=',0)
                                    ->where( function ($query) use ($user_id) {
                                        $query->where('sender_id', '=', $user_id)->whereNotIn('sender_delete', array(1))
                                            ->orWhere('receiver_id', '=', $user_id)->whereNotIn('receiver_delete', array(1));
                                    })->orderBy('created_at','desc')->paginate(10);
        $param['emailCount'] = count($emailList);
        $param['subPageNo'] = 4;

        $quoteList = QuoteModel::whereRaw('seller_id=?', array($user_id))->get();
        if(count($quoteList)>0){
            $quoteListID = array();
            for($i=0; $i<count($quoteList); $i++){
                $quoteListID[$i] = $quoteList[$i]->rfq_id;
            }
            $param['rfq'] = RfqModel::whereIn('id', $quoteListID)->orderBy('created_at','desc')->paginate(5);

            $buyerList = array();
            $listQuoteList = array();
            $emailList = array();
            $rfqQuote = array();
            foreach($param['rfq'] as $key=>$value){
                $buyerList[$key] = MembersModel::find($value->buyer_id);
                $listArray = QuoteModel::whereRaw('rfq_id=? and seller_id=?', array($value->id,$user_id))->get();

                if(count($listArray)>0){
                    $listQuoteList[$key] = 1;
                    $rfqQuote[$key] = $listArray[0];
                }else{
                    $listQuoteList[$key] = 0;
                    $rfqQuote[$key] = '';
                }
                $emailArray = RfqEmailModel::whereRaw('rfq_id =? and receiver_id =?',array($value->id,$user_id))->get();
                if(count($emailArray)>0){
                    $emailList[$key] =1;
                }else{
                    $emailList[$key] =0;
                }
            }

            $param['rfqQuote'] =$rfqQuote;
            $param['emailList'] =$emailList;
            $param['buyerList'] =$buyerList;
            $param['listQuoteList']=$listQuoteList;

            return View::make('user.seller.loginRfq')->with($param);
        }else{
            return View::make('user.seller.loginRfqNull')->with($param);
        }
//        $param['rfq'] = RfqModel::whereRaw(true)->orderBy('created_at','desc')->paginate(5);

    }
    public function loginSearch(){
        $param['pageNo'] = 35;
        $param['title'] = Lang::get('user.buyer_rfq');
        $user_id = Session::get('user_id');
        $emailList = EmailSendModel::where('parent','=',0)
            ->where( function ($query) use ($user_id) {
                $query->where('sender_id', '=', $user_id)->whereNotIn('sender_delete', array(1))
                    ->orWhere('receiver_id', '=', $user_id)->whereNotIn('receiver_delete', array(1));
            })->orderBy('created_at','desc')->paginate(10);
        $param['emailCount'] = count($emailList);
        $param['subPageNo'] = 4;
        $searchTitle = Input::get('searchTitle');
        $quoteList = QuoteModel::whereRaw('seller_id=?', array($user_id))->get();
        if(count($quoteList)>0) {
            $quoteListID = array();
            for ($i = 0; $i < count($quoteList); $i++) {
                $quoteListID[$i] = $quoteList[$i]->rfq_id;
            }
            if($searchTitle == ""){
                $param['rfq'] = RfqModel::whereIn('id', $quoteListID)->orderBy('created_at', 'desc')->paginate(5);
            }else{
                $param['rfq'] = RfqModel::whereIn('id', $quoteListID)->where('rfq_title','LIKE','%'.$searchTitle.'%')->orderBy('created_at','desc')->paginate(2);
            }


            $buyerList = array();
            $listQuoteList = array();
            $emailList = array();
            $rfqQuote = array();
            foreach ($param['rfq'] as $key => $value) {
                $buyerList[$key] = MembersModel::find($value->buyer_id);
                $listArray = QuoteModel::whereRaw('rfq_id=? and seller_id=?', array($value->id, $user_id))->get();

                if (count($listArray) > 0) {
                    $listQuoteList[$key] = 1;
                    $rfqQuote[$key] = $listArray[0];
                } else {
                    $listQuoteList[$key] = 0;
                    $rfqQuote[$key] = '';
                }
                $emailArray = RfqEmailModel::whereRaw('rfq_id =? and receiver_id =?', array($value->id, $user_id))->get();
                if (count($emailArray) > 0) {
                    $emailList[$key] = 1;
                } else {
                    $emailList[$key] = 0;
                }
            }

            $param['rfqQuote'] = $rfqQuote;
            $param['emailList'] = $emailList;
            $param['buyerList'] = $buyerList;
            $param['listQuoteList'] = $listQuoteList;
            return View::make('user.seller.loginSearch')->with($param);
        }else{
            return View::make('user.seller.loginRfqNull')->with($param);
        }

//        if($searchTitle == ""){
//            $param['rfq'] = RfqModel::whereRaw(true)->orderBy('created_at','desc')->paginate(5);
//        }else{
//            $param['rfq'] = RfqModel::where('rfq_title','LIKE','%'.$searchTitle.'%')->orderBy('created_at','desc')->paginate(2);
//        }
//        $param['rfq']->appends(array('searchTitle' => $searchTitle));
//        $buyerList = array();
//        $listQuoteList = array();
//        $emailList = array();
//        $rfqQuote = array();
//        foreach($param['rfq'] as $key=>$value){
//            $buyerList[$key] = MembersModel::find($value->buyer_id);
//            $listArray = QuoteModel::whereRaw('rfq_id=? and seller_id=?', array($value->id,$user_id))->get();
//
//            if(count($listArray)>0){
//                $listQuoteList[$key] = 1;
//                $rfqQuote[$key] = $listArray[0];
//            }else{
//                $listQuoteList[$key] = 0;
//                $rfqQuote[$key] = '';
//            }
//            $emailArray = RfqEmailModel::whereRaw('rfq_id =? and receiver_id =?',array($value->id,$user_id))->get();
//            if(count($emailArray)>0){
//                $emailList[$key] =1;
//            }else{
//                $emailList[$key] =0;
//            }
//        }
//
//        $param['rfqQuote'] =$rfqQuote;
//        $param['emailList'] =$emailList;
//        $param['buyerList'] =$buyerList;
//        $param['listQuoteList']=$listQuoteList;

    }
/**********Post Get Price Start***********/
    public function postGetPrice(){
        $rules = [
            'Length' =>'required',
            'Width' =>'required',
            'Height' =>'required',
            'Weight' =>'required',
            'shipper_name' =>'required',
            'shipper_street' =>'required',
            'shipper_city' =>'required',
            'shipper_postalcode' =>'required',
            'shipper_country' =>'required'
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else {
            $id = Input::get('quote_id');
            $listID = $id-100000;
            $user_id = Session::get('user_id');
            $quoteSample1 = QuoteSampleModel::WhereRaw('quote_id=? and seller_id =?', array($listID,$user_id))->get();
            $quoteSample = $quoteSample1[0];
            $quote = QuoteModel::find($listID);
            $verticalFee = FeeModel::all();
            $param['verticalFee']=($verticalFee[0]->fee/100)*1+1;
            $emails =[$quote->buyerMember->email,Admin_Email];
            $shipper = array(
                'Contact' => array(
                    'PersonName' => $_POST['shipper_name']
                ),
                'Address' => array(
                    'StreetLines' => array($_POST['shipper_street']),
                    'City' => $_POST['shipper_city'],
                    'StateOrProvinceCode' => $_POST['shipper_state'],
                    'PostalCode' => $_POST['shipper_postalcode'],
                    'CountryCode' => $_POST['shipper_country']
                )
            );

            $recipient = array(
                'Contact' => array(
                    'PersonName' => $_POST['shipto_name']
                ),
                'Address' => array(

                    'StreetLines' => array($_POST['shipto_street']),
                    'City' => $_POST['shipto_city'],
                    'StateOrProvinceCode' =>$_POST['shipto_state'],
                    'PostalCode' => $_POST['shipto_postalcode'],
                    'CountryCode' => $_POST['shipto_country'],
                    'Residential' => false
                )
            );
            $packageLineItem = array(
                'GroupPackageCount'=>$_POST['package_count'],
                'Weight' => array(
                    'Value' => $_POST['Weight'],
                    'Units' => $_POST['WeightUnit']
                ),
                'Dimensions' => array(
                    'Length' => $_POST['Length'],
                    'Width' =>  $_POST['Width'],
                    'Height' => $_POST['Height'],
                    'Units' => 'IN'
                )
            );

            $listURL= app_path().'/libraries/import/fedex-rate-common.php';
            File::requireOnce($listURL);
            $newline = " ";
            $path_to_wsdl = app_path()."/libraries/import/wsdl/RateService_v9.wsdl";
            ini_set("soap.wsdl_cache_enabled", "0");
            $client = new SoapClient($path_to_wsdl, array('trace' => 1));

            $request['WebAuthenticationDetail'] = array(
                'UserCredential' =>array(
                    'Key' => getProperty('key'),
                    'Password' => getProperty('password')
                )
            );
            $request['ClientDetail'] = array(
                'AccountNumber' => getProperty('shipaccount'),
                'MeterNumber' => getProperty('meter')
            );
            $request['TransactionDetail'] = array('CustomerTransactionId' => ' *** Rate Request v9 using PHP ***');

            $request['Version'] = array(
                'ServiceId' => 'crs',
                'Major' => '9',
                'Intermediate' => '0',
                'Minor' => '0'
            );
            $request['ReturnTransitAndCommit'] = true;
            $request['RequestedShipment']['DropoffType'] = 'REGULAR_PICKUP';
            $request['RequestedShipment']['ShipTimestamp'] = date('c');
            $request['RequestedShipment']['PackagingType'] = 'YOUR_PACKAGING';
            $request['RequestedShipment']['TotalInsuredValue']=array(
                'Ammount'=>100,
                'Currency'=>'USD'
            );

            $request['RequestedShipment']['Shipper'] = $shipper;
            $request['RequestedShipment']['Recipient'] = $recipient;
            $request['RequestedShipment']['ShippingChargesPayment'] = array('PaymentType' => 'SENDER',

                'Payor' => array('AccountNumber' => getProperty('billaccount'),

                    'CountryCode' => 'US'));
            $request['RequestedShipment']['RateRequestTypes'] = 'LIST';
            $request['RequestedShipment']['PackageCount'] = $_POST['package_count'];
            $request['RequestedShipment']['PackageDetail'] = 'INDIVIDUAL_PACKAGES';
            $request['RequestedShipment']['RequestedPackageLineItems'] = $packageLineItem;
            try {
                if (setEndpoint('changeEndpoint')) {
                    $newLocation = $client->__setLocation(setEndpoint('endpoint'));
                }
//                print_r($request);
//                exit;
                $response = $client -> getRates($request);
                if ($response -> HighestSeverity != 'FAILURE' && $response -> HighestSeverity != 'ERROR'){

                    $rateReply = $response -> RateReplyDetails;

                    $data = array();
                    $data['status'] = 'Success';

                    $data['Service_Type'] = $rateReply[0] -> ServiceType;

                    $data['Amount'] = $rateReply[0]->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount;

                    $data['Currency'] =  $rateReply[0]->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Currency;

                    //$data['Delivery_Date'] = $rateReply[0]->TransitTime;

                    if($quote->sample_price != "") {
                        $productPrice = $quote->sample_price*$quoteSample->sampleamount;
                        $sellerPriceRequestUnitList = CurrencyModel::find($quote->sample_price_currency);
                        $sellerPriceRequestUnit = $sellerPriceRequestUnitList->currency_name;
                    }else{
                        $productPrice = $quote->price*$quoteSample->sampleamount;
                        $sellerPriceRequestUnitList = CurrencyModel::find($quote->price_currency);
                        $sellerPriceRequestUnit = $sellerPriceRequestUnitList->currency_name;
                    }
                    $totalProductPrice =  $this->converCurrency(strtoupper($sellerPriceRequestUnit),$productPrice);
                    $total =  ($totalProductPrice + $data['Amount'])*$param['verticalFee'];
                    $updateQuoteSample = QuoteSampleModel::find($quoteSample->id);
                    /***update***/
                    $updateQuoteSample->shippingprice = $data['Amount'];
                    $updateQuoteSample->shippingcurrency = $data['Currency'];
                    $updateQuoteSample->invoicenumber = $this->invoicenumber(15);
                    $updateQuoteSample->createInvoiceDate = date("Y-m-d H:i:s");
                    $updateQuoteSample->totalprice = $total;
                    $updateQuoteSample->shippingwidth = $_POST['Width'];
                    $updateQuoteSample->shippingheight = $_POST['Height'];
                    $updateQuoteSample->shippinglength = $_POST['Length'];
                    $updateQuoteSample->packagecount = $_POST['package_count'];
                    $updateQuoteSample->shippingname = $_POST['shipper_name'];
                    $updateQuoteSample->shippingphonenumber = $_POST['shipper_phonenumber'];
                    $updateQuoteSample->shippingaddress = $_POST['shipper_street'];
                    $updateQuoteSample->shippingcity = $_POST['shipper_city'];
                    $updateQuoteSample->shippingstate = $_POST['shipper_state'];
                    $updateQuoteSample->shippingpostalcode = $_POST['shipper_postalcode'];
                    $updateQuoteSample->shippingcountry = $_POST['shipper_country'];
                    $updateQuoteSample->shippingweight = $_POST['Weight'];
                    $updateQuoteSample->shippingweightunit = $_POST['WeightUnit'];
                    $updateQuoteSample->shippingservicetype = $data['Service_Type'];
                    $updateQuoteSample->save();
                    $messageContent = "Seller sample request create successfully.
                                       Shipping price is  ".$data['Amount']*$param['verticalFee'] . "USD  So that Total price is ". $total. " USD";
                    $data = array(
                        'username'    =>$quote->sellerMember->username,
                        'content' =>$messageContent
                    );
                    Mail::send('emails.seller.sampleQuote', $data, function($message) use ($emails)
                    {
                        $message->from('noreply@purchasetree.com', Lang::get('alert.Sample_Request') );
                        $message->to($emails, 'User')->subject(Lang::get('alert.Sample_Request'));
                    });

                   $quoteModel = QuoteModel::find($listID);
                   $quoteModel->status =3;
                   $quoteModel->save();

                    $alert['msg'] = Lang::get('alert.Sample_Request_has_been_saved_successfully');
                    $alert['type'] = 'success';
                    return Redirect::route('user.seller.loginRfq')->with('alert', $alert);
                }else{
                    $data = array();
                    $data['status'] = 'Error';
                    $alert['msg'] = Lang::get('alert.Sample_Request_has_error');
                    $alert['type'] = 'danger';
                    return Redirect::route('user.seller.loginRfq')->with('alert', $alert);
                }
            }catch (SoapFault $exception) {
                $data = array();

                $data['status'] = 'Error';

                echo json_encode($data);
            }
        }
    }
    /**********Post Get Price End***********/
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
    function invoicenumber($len){
        $strpattern = "ABCDEFGHJKLMNPQRSTUVWXYZ1234567890";
        $result = "";
        for( $i = 0 ; $i < $len; $i ++ ){
            $rand = rand( 0, strlen($strpattern) - 1 );
            $result = $result.$strpattern[$rand];
        }
        return $result;
    }
    public function getPrice($id){
        $param['pageNo'] = 35;
        $param['title'] = Lang::get('user.buyer_rfq');
        $user_id = Session::get('user_id');
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }

        $emailList = EmailSendModel::where('parent','=',0)
            ->where( function ($query) use ($user_id) {
                $query->where('sender_id', '=', $user_id)->whereNotIn('sender_delete', array(1))
                    ->orWhere('receiver_id', '=', $user_id)->whereNotIn('receiver_delete', array(1));
            })->orderBy('created_at','desc')->paginate(10);
        $param['emailCount'] = count($emailList);
        $param['subPageNo'] = 4;
        $listID = $id-100000;
        $param['quote'] = QuoteModel::find($listID);
        $param['country'] = CountryModel::whereRaw(true)->orderBy('country_name','asc')->get();
        $param['buyerMember'] =  MembersModel::find($param['quote']->buyer_id);
        $param['buyerCountry'] = CountryModel::find($param['buyerMember']->country_id);
        $param['sellerMember'] = MembersModel::find($param['quote']->seller_id);
        $param['sellerCountry'] = CountryModel::find($param['sellerMember']->country_id);
        return View::make('user.seller.getPrice')->with($param);
    }
    public function getLabel($id){
        $param['pageNo'] = 35;
        $param['title'] = Lang::get('user.buyer_rfq');
        $user_id = Session::get('user_id');
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $emailList = EmailSendModel::where('parent','=',0)
            ->where( function ($query) use ($user_id) {
                $query->where('sender_id', '=', $user_id)->whereNotIn('sender_delete', array(1))
                    ->orWhere('receiver_id', '=', $user_id)->whereNotIn('receiver_delete', array(1));
            })->orderBy('created_at','desc')->paginate(10);
        $param['emailCount'] = count($emailList);
        $param['subPageNo'] = 4;
        $listID = $id-100000;
        $param['quote'] = QuoteModel::find($listID);
        $param['country'] = CountryModel::whereRaw(true)->orderBy('country_name','asc')->get();
        $param['sellerMember'] = MembersModel::find($param['quote']->seller_id);
        $param['sellerCountry'] = CountryModel::find($param['sellerMember']->country_id);
        $param['quoteSample'] = QuoteSampleModel::whereRaw('quote_id =?', array($listID))->get();
        return View::make('user.seller.getLabel')->with($param);
    }
    /***************************************Shopping Get Label******************************************/
    public function postCartGetLabel(){
        $rules = [
            'Length' =>'required|numeric',
            'Width' =>'required|numeric',
            'Height' =>'required|numeric',
            'Weight' =>'required|numeric',
            'shipper_name'=>'required',
            'shipper_street'=>'required',
            'shipper_city'=>'required',
            'shipper_phonenumber' =>'required',
            'shipper_postalcode'=>'required',
            'shipper_country'=>'required',
        ];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else {

            global $trackingArray;
            $id = Input::get('shoppingCart_id');
            $listID = $id-100000;
            $listURL = app_path() . '/libraries/import/fedex-common.php';
            File::requireOnce($listURL);
            $newline = " ";
            $path_to_wsdl = app_path() . "/libraries/import/wsdl/OpenShipService_v7.wsdl";
            define('SHIP_LABEL', 'shiplabel.pdf');
            ini_set("soap.wsdl_cache_enabled", "0");
            $shoppingCartProduct = ShoppingCartProductModel::where('id', $listID)->first();

            $shoppingCart = $shoppingCartProduct->ShoppingCart;

            $BuyerCountry = Input::get('shipto_country');
            $client = new SoapClient($path_to_wsdl, array('trace' => 1));

            $shipper = array(
                'Contact' => array(
                    'PersonName' => Input::get('shipper_name'),
                    'PhoneNumber' => Input::get('shipper_phonenumber'),
                ),
                'Address' => array(
                    'StreetLines' => Input::get('shipper_street'),
                    'City' => Input::get('shipper_city'),
                    'StateOrProvinceCode' =>Input::get('shipper_state'),
                    'PostalCode' =>  Input::get('shipper_postalcode'),
                    'CountryCode' =>  Input::get('shipper_country'),
                )
            );
            $recipient = array(
                'Contact' => array(
                    'PersonName' =>$shoppingCart->shipping_firstname." " . $shoppingCart->shipping_lastname,
                    'PhoneNumber' => $shoppingCart->shipping_phone
                ),
                'Address' => array(
                    'StreetLines' => $shoppingCart->shipping_address1,
                    'City' => $shoppingCart->shipping_city,
                    'StateOrProvinceCode' => $shoppingCart->shipping_state,
                    'PostalCode' => $shoppingCart->shipping_zip,
                    'CountryCode' => $BuyerCountry,
                    'Residential' => false
                )
            );

            $dimensions = array(
                'length' =>Input::get('Length'),
                'width' =>Input::get('Width'),
                'height' =>Input::get('Height'),
                'weight' =>Input::get('Weight'),
                'weight_unit' =>Input::get('WeightUnit'),
                'package_count' =>Input::get('package_count'),
            );

            try {

                if (setEndpoint('changeEndpoint')) {

                    $newLocation = $client->__setLocation(setEndpoint('endpoint'));
                }
                $index = '';

                $responseCreateOpenShipment = $client->createOpenShipment($this->buildCreateOpenCartShipmentRequest($shoppingCartProduct, $shoppingCart, $BuyerCountry,$shipper,$recipient,$dimensions));
                if ($this->isSuccess($client, $responseCreateOpenShipment)) {

                    $index = $this->processCreateOpenShipmentResponseSuccess($client, $responseCreateOpenShipment);

                    $responseAddPackagesToOpenShipment = $client->addPackagesToOpenShipment($this->buildAddCartPackagesToOpenShipmentRequest($index, $dimensions));
                    if ($this->isSuccess($client, $responseAddPackagesToOpenShipment)) {

                        $this->processAddPackageToOpenShipmentResponseSuccess($client, $responseAddPackagesToOpenShipment);
                        $responseModifyPackageInOpenShipment = $client->modifyPackageInOpenShipment(
                            $this->buildModifyCartPackageInOpenShipmentRequest($index, $responseAddPackagesToOpenShipment, $dimensions)
                        );
                        if ($this->isSuccess($client, $responseModifyPackageInOpenShipment)) {

                            $this->processModifyPackageInOpenShipmentSuccess($client, $responseModifyPackageInOpenShipment);

                            $responseValidateOpenShipment = $client->validateOpenShipment($this->buildValidateOpenShipmentRequest($index));


                            if ($this->isSuccess($client, $responseValidateOpenShipment)) {
                                $responseConfirmOpenShipment = $client->confirmOpenShipment($this->buildConfirmOpenShipmentRequest($index));
                                if ($this->isSuccess($client, $responseConfirmOpenShipment)) {

                                    $this->processConfirmOpenShipmentSuccess($client, $responseConfirmOpenShipment);
                                    /******** Email Send buyer********/
                                    $buyerMember = $shoppingCartProduct->buyer;

                                    $email = $buyerMember->email;
                                    $sellerMember = $shoppingCartProduct->seller;
                                    $data = array(
                                        'seller' => $sellerMember->username,
                                        'trackingNumber' => $trackingArray[0],
                                    );
                                    $fileName = dirname(__FILE__) . "/labels/" . $trackingArray[0] . "shiplabel.pdf";
                                    Mail::send('emails.buyer.cartSendLabel', $data, function ($message) use ($email, $fileName) {
                                        $message->from('noreply@purchasetree.com', Lang::get('alert.Fedex_Label'));
                                        $message->to($email, Lang::get('alert.Fedex_Label'))->subject(Lang::get('alert.Fedex_Label'));
                                        $message->attach($fileName);
                                    });
                                    $email = $sellerMember->email;
                                    Mail::send('emails.seller.cartSendLabel', $data, function ($message) use ($email, $fileName) {
                                        $message->from('noreply@purchasetree.com', Lang::get('alert.Fedex_Label'));
                                        $message->to($email, Lang::get('alert.Fedex_Label'))->subject(Lang::get('alert.Fedex_Label'));
                                        $message->attach($fileName);
                                    });
                                    /**************Email Send Admin************************/
                                    $data = array(
                                        'seller' => $sellerMember->username,
                                        'trackingNumber' => $trackingArray[0],
                                    );
                                    if (isset($trackingArray[1])) {
                                        $fileName = dirname(__FILE__) . "/labels/" . $trackingArray[1] . "shiplabel.pdf";
                                    } else {
                                        $fileName = dirname(__FILE__) . "/labels/" . $trackingArray[0] . "shiplabel.pdf";
                                    }
                                    Mail::send('emails.seller.cartSendLabel', $data, function ($message) use ($email, $fileName) {
                                        $message->from('noreply@purchasetree.com', Lang::get('alert.Fedex_Label'));
                                        $message->to(Admin_Email, Lang::get('alert.Fedex_Label'))->subject(Lang::get('alert.Fedex_Label'));
                                        $message->attach($fileName);
                                    });
                                    $shoppingCartProduct->status = 3;
                                    $shoppingCartProduct->trackingnumber1 =  $trackingArray[0];
                                    $shoppingCartProduct->trackingnumber2 =  $trackingArray[1];
                                    $shoppingCartProduct->save();
                                    $alert['msg'] = Lang::get('alert.Fedex_Label_has_been_sent_successfully');
                                    $alert['type'] = 'success';
                                    return Redirect::route('user.seller.cart');

                                } else {
                                 //   $this->processValidateOpenShipmentFailure($client, $responseValidateOpenShipment);
                                    $this->deleteOpenShipment($client, $index);
                                    $alert['msg'] = Lang::get('alert.Fedex_label_has_some_problem_Please_check_again');
                                    $alert['type'] = 'danger';
                                    return Redirect::route('user.seller.cart.shipping', $id)->with('alert', $alert);
                                }
                            } else {
                              //  $this->processValidateOpenShipmentFailure($client, $responseValidateOpenShipment);
                                $this->deleteOpenShipment($client, $index);
                                $alert['msg'] = Lang::get('alert.Fedex_label_has_some_problem_Please_check_again');
                                $alert['type'] = 'danger';
                                return Redirect::route('user.seller.cart.shipping', $id)->with('alert', $alert);
                            }
                        } else {
                            $this->processModifyPackageInOpenShipmentFailure($client, $responseModifyPackageInOpenShipment);
                            $this->deleteOpenShipment($client, $index);
                            $alert['msg'] = Lang::get('alert.Fedex_label_has_some_problem_Please_check_again');
                            $alert['type'] = 'danger';
                            return Redirect::route('user.seller.cart.shipping', $id)->with('alert', $alert);
                        }

                    } else {
                        $this->processAddPackageToOpenShipmentResponseFailure($client, $responseAddPackagesToOpenShipment);
                        $this->deleteOpenShipment($client, $index);
                        $alert['msg'] = Lang::get('alert.Fedex_label_has_some_problem_Please_check_again');
                        $alert['type'] = 'danger';
                        return Redirect::route('user.seller.cart.shipping', $id)->with('alert', $alert);
                    }
                } else {
                    $this->processCreateOpenShipmentResponseFailure($client, $responseCreateOpenShipment);
                    $this->deleteOpenShipment($client, $index);
                    $alert['msg'] = Lang::get('alert.Fedex_label_has_some_problem_Please_check_again');
                    $alert['type'] = 'danger';
                    return Redirect::route('user.seller.cart.shipping', $id)->with('alert', $alert);
                }

            } catch (SoapFault $exception) {
                printFault($exception, $client);
                $alert['msg'] = Lang::get('alert.Fedex_label_has_some_problem_Please_check_again');
                $alert['type'] = 'danger';
                return Redirect::route('user.seller.cart.shipping', $id)->with('alert', $alert);
            }
        }
    }
    function processValidateOpenShipmentFailure($client, $response){
        printOpenShipError($client, $response);
    }


    function buildCreateOpenCartShipmentRequest($shoppingCartProduct, $shoppingCart, $BuyerCountry,$shipper,$recipient,$dimensions){
        $request=$this->buildTransactionDetail();

        $request['RequestedShipment'] = array(

            'ShipTimestamp' => date('c'),

            'DropoffType' => 'REGULAR_PICKUP', // valid values REGULAR_PICKUP, REQUEST_COURIER, DROP_BOX, BUSINESS_SERVICE_CENTER and STATION

            'ServiceType' => 'INTERNATIONAL_PRIORITY', // valid values STANDARD_OVERNIGHT, PRIORITY_OVERNIGHT, FEDEX_GROUND, ...

            'PackagingType' => 'YOUR_PACKAGING', // valid values FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...

            'Shipper' => $shipper,

            'Recipient' =>$recipient,

            'ShippingChargesPayment' => $this->addShippingChargesPayment(),

            'LabelSpecification' => $this->addLabelSpecification(),

            'CustomsClearanceDetail' => $this->addCustomCartClearanceDetail($shoppingCartProduct,$shoppingCart,$dimensions),

            'RateRequestTypes' => array('ACCOUNT'), // valid values ACCOUNT and LIST

            'PackageCount' => $dimensions['package_count'],

            'RequestedPackageLineItems' => array(

                '0' => $this->addCartPackageLineItem1($dimensions)
            )
        );
        return $request;
    }

    function addCustomCartClearanceDetail($shoppingCartProduct,$shoppingCart,$dimensions){
        $feeModelContent = FeeModel::all();
        $fee = ($feeModelContent[0]->fee/100)+1;
        $ProductPrice1 ="";
        $productPrice1 = $shoppingCartProduct->sub_total;
        $ProductUnit ="USD";

        $ProductPrice =  $productPrice1;
        $customerClearanceDetail = array(
            'DutiesPayment' => array(
                'PaymentType' => 'SENDER', // valid values RECIPIENT, SENDER and THIRD_PARTY
                'Payor' => array(
                    'ResponsibleParty' => array(
                        'AccountNumber' => getProperty('dutyaccount'),
                        'Contact' => null,
                        'Address' => array('CountryCode' => 'US')
                    )
                )
            ),
            'DocumentContent' => 'NON_DOCUMENTS',
            'CustomsValue' => array(
                'Currency' => 'USD',
                'Amount' => round($ProductPrice*$fee,1)
            ),
            'Commodities' => array(
                '0' => array(
                    'NumberOfPieces' => 1,
                    'Description' => 'Books',
                    'CountryOfManufacture' => 'US',
                    'Weight' => array(
                        'Units' => $dimensions['weight_unit'],
                        'Value' => $dimensions['weight']
                    ),
                    'Quantity' => $dimensions['package_count'],
                    'QuantityUnits' => 'EA',
                    'UnitPrice' => array(
                        'Currency' => 'USD',
                        'Amount' => $ProductPrice
                    ),
                    'CustomsValue' => array(
                        'Currency' => 'USD',
                        'Amount' =>round($ProductPrice*$fee,1)
                    )
                )
            ),
            'ExportDetail' => array(
                'B13AFilingOption' => 'NOT_REQUIRED'
            )

        );
        return $customerClearanceDetail;
    }


    function addCartPackageLineItem1($dimensions){
        $packageLineItem = array(
            'SequenceNumber'=>1,
            'GroupPackageCount'=>$dimensions['package_count'],
            'Weight' => array(
                'Value' => $dimensions['weight'],
                'Units' => $dimensions['weight_unit']
            ),
            'Dimensions' => array(
                'Length' => $dimensions['length'],
                'Width' =>  $dimensions['width'],
                'Height' => $dimensions['height'],
                'Units' => 'IN'
            ),
            'CustomerReferences' => array(
                '0' => array(
                    'CustomerReferenceType' => 'CUSTOMER_REFERENCE',
                    'Value' => 'CR1234'
                ), // valid values CUSTOMER_REFERENCE, INVOICE_NUMBER, P_O_NUMBER and SHIPMENT_INTEGRITY
                '1' => array(
                    'CustomerReferenceType' => 'INVOICE_NUMBER',
                    'Value' => 'IV1234'
                ),
                '2' => array(
                    'CustomerReferenceType' => 'P_O_NUMBER',
                    'Value' => 'PO1234'
                )
            )
        );
        return $packageLineItem;
    }
    function buildAddCartPackagesToOpenShipmentRequest($index,$dimensions){
        $request=$this->buildTransactionDetail();
        $request['Index'] = $index;
        $request['RequestedPackageLineItems'] = array(
            '0' => $this->addCartPackageLineItem1($dimensions)
        );

        return $request;
    }
    function buildModifyCartPackageInOpenShipmentRequest($index, $response,$dimensions){

        $request= $this->buildTransactionDetail();

        $request['Index'] = $index;

        $request['TrackingId'] = array(

            'TrackingIdType' => $response->CompletedShipmentDetail->CompletedPackageDetails->TrackingIds->TrackingIdType,

            'FormId' => $response->CompletedShipmentDetail->CompletedPackageDetails->TrackingIds->FormId,

            'TrackingNumber' => $response->CompletedShipmentDetail->CompletedPackageDetails->TrackingIds->TrackingNumber);

        $request['RequestedPackageLineItem'] = $this->addCartPackageLineItem1($dimensions);
        return $request;
    }
    /*********************************Get Label**********************************/

    public function postGetLabel(){
        global $trackingArray;
        $id = Input::get('quote_id');
        $listID = $id-100000;
        $user_id = Session::get('user_id');
        $listURL= app_path().'/libraries/import/fedex-common.php';
        File::requireOnce($listURL);
        $newline = " ";
        $path_to_wsdl = app_path()."/libraries/import/wsdl/OpenShipService_v7.wsdl";
        define('SHIP_LABEL', 'shiplabel.pdf');
        ini_set("soap.wsdl_cache_enabled", "0");
        $QuoteSample = QuoteSampleModel::whereRaw('quote_id =?', array($listID))->get();
        $Quote = QuoteModel::find($listID);
        $BuyerCountry = Input::get('shipto_country');

        $client = new SoapClient($path_to_wsdl, array('trace' => 1));
        try {

            if (setEndpoint('changeEndpoint')) {

                $newLocation = $client->__setLocation(setEndpoint('endpoint'));
            }
            $index='';
            $responseCreateOpenShipment = $client->createOpenShipment($this->buildCreateOpenShipmentRequest($QuoteSample,$Quote,$BuyerCountry));
            if($this->isSuccess($client, $responseCreateOpenShipment)){
                $index =  $this->processCreateOpenShipmentResponseSuccess($client, $responseCreateOpenShipment);

                $responseAddPackagesToOpenShipment = $client->addPackagesToOpenShipment($this->buildAddPackagesToOpenShipmentRequest($index,$QuoteSample,$Quote));
                if($this->isSuccess($client, $responseAddPackagesToOpenShipment)){
                    $this->processAddPackageToOpenShipmentResponseSuccess($client, $responseAddPackagesToOpenShipment);
                    $responseModifyPackageInOpenShipment= $client->modifyPackageInOpenShipment(
                        $this->buildModifyPackageInOpenShipmentRequest($index, $responseAddPackagesToOpenShipment,$QuoteSample)
                    );
                    if($this->isSuccess($client, $responseModifyPackageInOpenShipment)){
                        $this->processModifyPackageInOpenShipmentSuccess($client, $responseModifyPackageInOpenShipment);
                        $responseValidateOpenShipment = $client->validateOpenShipment($this->buildValidateOpenShipmentRequest($index));
                        if($this->isSuccess($client, $responseValidateOpenShipment)){
                            $responseConfirmOpenShipment = $client->confirmOpenShipment($this->buildConfirmOpenShipmentRequest($index));
                            if($this->isSuccess($client, $responseConfirmOpenShipment)){
                                $this->processConfirmOpenShipmentSuccess($client, $responseConfirmOpenShipment);
                                    /******** Email Send buyer********/
                                    $buyerMember =$Quote->buyerMember;
                                    $email = $buyerMember->email;
                                    $sellerMember = $Quote->sellerMember;
                                    $data = array(
                                            'seller' =>$sellerMember->username,
                                            'trackingNumber' => $trackingArray[0],
                                            'invoiceUrl' =>URL::route('user.invoice',$id),
                                            'quoteUrl' =>URL::route('user.buyer.quoteShow',$id),
                                    );
                                    $fileName = dirname(__FILE__)."/labels/".$trackingArray[0]."shiplabel.pdf";
                                    Mail::send('emails.seller.sendLabel', $data, function($message) use ($email,$fileName){
                                        $message->from('noreply@purchasetree.com', Lang::get('alert.Fedex_Label'));
                                        $message->to($email, Lang::get('alert.Fedex_Label'))->subject(Lang::get('alert.Fedex_Label'));
                                        $message->attach($fileName);
                                    });
                                    /**************Email Send Admin************************/
                                    $data = array(
                                        'seller' =>$sellerMember->username,
                                        'trackingNumber' => $trackingArray[0],
                                        'invoiceUrl' =>URL::route('user.invoice',$id),
                                        'quoteUrl' =>URL::route('user.buyer.quoteShow',$id),
                                    );
                                    if(isset($trackingArray[1])){
                                        $fileName = dirname(__FILE__)."/labels/".$trackingArray[1]."shiplabel.pdf";
                                    }else{
                                        $fileName = dirname(__FILE__)."/labels/".$trackingArray[0]."shiplabel.pdf";
                                    }

                                    Mail::send('emails.seller.sendLabel', $data, function($message) use ($email,$fileName){
                                        $message->from('noreply@purchasetree.com',Lang::get('alert.Fedex_Label'));
                                        $message->to(Admin_Email, 'Fedex Label')->subject(Lang::get('alert.Fedex_Label'));
                                        $message->attach($fileName);
                                    });
                                    $Quote->status = 6;
                                    $Quote->save();
                                    $QuoteSample = $QuoteSample[0];
                                    if(isset($trackingArray[0])) {
                                        $QuoteSample->trackingnumber1= $trackingArray[0];
                                        $QuoteSample->shippinglabel =  $trackingArray[0];
                                    }

                                    if(isset($trackingArray[1])) {
                                        $QuoteSample->trackingnumber2= $trackingArray[1];
                                        if(!isset($trackingArray[0])){
                                            $QuoteSample->shippinglabel =  $trackingArray[1];
                                        }
                                    }
                                    $QuoteSample->save();

                                    $alert['msg'] = Lang::get('alert.Fedex_Label_has_been_sent_successfully');
                                    $alert['type'] = 'success';
                                    return Redirect::route('user.seller.loginRfq')->with('alert', $alert);

                            }else{
                                $this->processValidateOpenShipmentFailure($client, $responseValidateOpenShipment);
                                $this->deleteOpenShipment($client, $index);
                                $alert['msg'] = Lang::get('alert.Fedex_label_has_some_problem_Please_check_again');
                                $alert['type'] = 'danger';
                                return Redirect::route('user.seller.getLabel',$id)->with('alert', $alert);
                            }
                        }else{
                            $this->processValidateOpenShipmentFailure($client, $responseValidateOpenShipment);
                            $this->deleteOpenShipment($client, $index);
                            $alert['msg'] = Lang::get('alert.Fedex_label_has_some_problem_Please_check_again');
                            $alert['type'] = 'danger';
                            return Redirect::route('user.seller.getLabel',$id)->with('alert', $alert);
                        }
                    }else{
                        $this->processModifyPackageInOpenShipmentFailure($client, $responseModifyPackageInOpenShipment);
                        $this->deleteOpenShipment($client, $index);
                        $alert['msg'] = Lang::get('alert.Fedex_label_has_some_problem_Please_check_again');
                        $alert['type'] = 'danger';
                        return Redirect::route('user.seller.getLabel',$id)->with('alert', $alert);
                    }

                }else{
                    $this->processAddPackageToOpenShipmentResponseFailure($client, $responseAddPackagesToOpenShipment);
                    $this->deleteOpenShipment($client, $index);
                    $alert['msg'] = Lang::get('alert.Fedex_label_has_some_problem_Please_check_again');
                    $alert['type'] = 'danger';
                    return Redirect::route('user.seller.getLabel',$id)->with('alert', $alert);
                }
            }else{
                $this->processCreateOpenShipmentResponseFailure($client, $responseCreateOpenShipment);
                $this->deleteOpenShipment($client, $index);
                $alert['msg'] = Lang::get('alert.Fedex_label_has_some_problem_Please_check_again');
                $alert['type'] = 'danger';
                return Redirect::route('user.seller.getLabel',$id)->with('alert', $alert);
            }

        }catch (SoapFault $exception) {
                printFault($exception, $client);
            $alert['msg'] = Lang::get('alert.Fedex_label_has_some_problem_Please_check_again');
            $alert['type'] = 'danger';
            return Redirect::route('user.seller.getLabel',$id)->with('alert', $alert);
        }
    }
    function printAllLabels($response){

        $packageDetails=$response->CompletedShipmentDetail->CompletedPackageDetails;

        global $trackingArray;

        $i = 0;

        if(is_array($packageDetails)){

            foreach($packageDetails as $packageDetail){

                $labelName = $packageDetail->TrackingIds->TrackingNumber;

                $trackingArray[$i] =$labelName;

                $this->printLabel($packageDetail);

                $i++;

            }

        }else if(is_object($packageDetails)){

            $labelName = $packageDetails->TrackingIds->TrackingNumber;

            $trackingArray[$i] =$labelName;

            $this->printLabel($packageDetails);

        }

    }
    function printLabel($packageDetail){


        $labelName = $packageDetail->TrackingIds->TrackingNumber . SHIP_LABEL;

        $labelDeficultLabelName = dirname(__FILE__)."/labels/".$labelName;

        $fp = fopen($labelDeficultLabelName, 'wb');

        fwrite($fp, ($packageDetail->Label->Parts->Image));

        fclose($fp);

 	//echo 'Label <a href="./labels/'.$labelName.'">'.$labelName."</a> was generated.<br/>\n";

    }
    function processConfirmOpenShipmentSuccess($client, $response){


        $this->printAllLabels($response);

    }
    function buildConfirmOpenShipmentRequest($index){

        $request=$this->buildTransactionDetail();

        $request['Index'] = $index;

        return $request;

    }
    function processModifyPackageInOpenShipmentSuccess($client, $response){
        $this->printString($response->JobId, "Job Id");

        $this->printOpenShipSuccess($client, $response);
    }
    function buildValidateOpenShipmentRequest($index){
        $request=$this->buildTransactionDetail();
        $request['Index'] = $index;
        return $request;
    }
    function processAddPackageToOpenShipmentResponseSuccess($client, $response){
        $this->printString($response->JobId, "Job Id");
        $this->printString($response->CompletedShipmentDetail->CompletedPackageDetails->SequenceNumber, "Package Sequence Number");
        $this->printString($response->CompletedShipmentDetail->CompletedPackageDetails->TrackingIds->TrackingNumber, "Tracking Number");
        $this->printOpenShipSuccess($client, $response);
    }
    function buildModifyPackageInOpenShipmentRequest($index, $response,$QuoteSample){

        $request= $this->buildTransactionDetail();

        $request['Index'] = $index;

        $request['TrackingId'] = array(

            'TrackingIdType' => $response->CompletedShipmentDetail->CompletedPackageDetails->TrackingIds->TrackingIdType,

            'FormId' => $response->CompletedShipmentDetail->CompletedPackageDetails->TrackingIds->FormId,

            'TrackingNumber' => $response->CompletedShipmentDetail->CompletedPackageDetails->TrackingIds->TrackingNumber);

        $request['RequestedPackageLineItem'] = $this->addPackageLineItem1($QuoteSample);

        return $request;
    }
    function isSuccess($client, $response){
        if ($response->HighestSeverity != 'FAILURE' && $response->HighestSeverity != 'ERROR'){
            return true;
        }else return false;

    }
    function deleteOpenShipment($client, $index){
        $responseDeleteOpenShipment = $client->deleteOpenShipment($this->buildDeleteOpenShipmentRequest($index));
        if($this->isSuccess($client, $responseDeleteOpenShipment)){
            $this->processDeleteOpenShipmentSuccess($client, $responseDeleteOpenShipment);
        }else{
            $this->processDeleteOpenShipmentFailure($client, $responseDeleteOpenShipment);
        }
    }

    function buildDeleteOpenShipmentRequest($index){
        $request=$this->buildTransactionDetail();
        $request['Index'] = $index;
        return $request;
    }
    function buildAddPackagesToOpenShipmentRequest($index,$QuoteSample,$Quote){
        $request=$this->buildTransactionDetail();
        $request['Index'] = $index;
        $request['RequestedPackageLineItems'] = array(
            '0' => $this->addPackageLineItem1($QuoteSample)
        );
        return $request;
    }
    function processDeleteOpenShipmentSuccess($client, $response){
        $this->printOpenShipSuccess($client, $response);
    }
    function processDeleteOpenShipmentFailure($client, $response){
        $result = "NotDeleteOpenShipment";
        $this->printOpenShipError($client, $response);
    }
    function printOpenShipError($client, $response){

        printNotifications($response -> Notifications);
        exit();
    }
    function printOpenShipSuccess($client, $response) {
    }
    function processCreateOpenShipmentResponseSuccess($client, $response){
        global $index;
        $index=$response->Index;
        return $index;
//        $this->printString($index, "Index");
//        $this->printString($response->CompletedShipmentDetail->MasterTrackingId->TrackingNumber, "Master Tracking Id");
//        $this->printOpenShipSuccess($client, $response);
    }
    function printString($var, $description){
        if(!is_object($var)&&!is_array($var)){
        }
    }
    function processCreateOpenShipmentResponseFailure($client, $response){
        global $result;
        $result = "NotOpenShipment";
        $this->printOpenShipError($client, $response);
    }
    function buildCreateOpenShipmentRequest($QuoteSample,$Quote,$BuyerCountry){
        $request=$this->buildTransactionDetail();
        $request['RequestedShipment'] = array(

            'ShipTimestamp' => date('c'),

            'DropoffType' => 'REGULAR_PICKUP', // valid values REGULAR_PICKUP, REQUEST_COURIER, DROP_BOX, BUSINESS_SERVICE_CENTER and STATION

            'ServiceType' => $QuoteSample[0]->shippingservicetype, // valid values STANDARD_OVERNIGHT, PRIORITY_OVERNIGHT, FEDEX_GROUND, ...

            'PackagingType' => 'YOUR_PACKAGING', // valid values FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...

            'Shipper' => $this->addShipper($QuoteSample),

            'Recipient' =>$this->addRecipient($Quote,$BuyerCountry),

            'ShippingChargesPayment' => $this->addShippingChargesPayment(),

            'LabelSpecification' => $this->addLabelSpecification(),

            'CustomsClearanceDetail' => $this->addCustomClearanceDetail($QuoteSample,$Quote),

            'RateRequestTypes' => array('ACCOUNT'), // valid values ACCOUNT and LIST

            'PackageCount' => $QuoteSample[0]->packagecount,

            'RequestedPackageLineItems' => array(

                '0' => $this->addPackageLineItem1($QuoteSample)

            )

        );
        return $request;
    }
    function addShipper($QuoteSample){
        $shipper = array(
            'Contact' => array(
                'PersonName' => $QuoteSample[0]->shippingname,
                'PhoneNumber' => $QuoteSample[0]->shippingphonenumber,
            ),
            'Address' => array(
                'StreetLines' => $QuoteSample[0]->shippingaddress,
                'City' => $QuoteSample[0]->shippingcity,
                'StateOrProvinceCode' => $QuoteSample[0]->shippingstate,
                'PostalCode' =>  $QuoteSample[0]->shippingpostalcode,
                'CountryCode' =>  $QuoteSample[0]->shippingcountry,
            )
        );
        return $shipper;
    }
    function addRecipient($Quote,$BuyerCountry){
        $buyerMember = $Quote->buyerMember;
        $buyerName = $buyerMember->firstname ."  ". $buyerMember->lastname;
        $recipient = array(
            'Contact' => array(
                'PersonName' =>$buyerName,
                'PhoneNumber' => $buyerMember->phonenumber
            ),
            'Address' => array(
                'StreetLines' => $buyerMember->street,
                'City' => $buyerMember->city,
                'StateOrProvinceCode' => $buyerMember->state,
                'PostalCode' => $buyerMember->zipcode,
                'CountryCode' => $BuyerCountry,
                'Residential' => false
            )
        );
        return $recipient;
    }
    function addShippingChargesPayment(){

        $shippingChargesPayment = array(
            'PaymentType' => 'SENDER',
            'Payor' => array(
                'ResponsibleParty' => array(
                    'AccountNumber' => getProperty('billaccount'),
                    'Address' => array('CountryCode' => 'US')
                )
            )
        );
        return $shippingChargesPayment;
    }
    function addLabelSpecification(){
        $labelSpecification = array(
            'LabelFormatType' => 'COMMON2D', // valid values COMMON2D, LABEL_DATA_ONLY
            'ImageType' => 'PDF',  // valid values DPL, EPL2, PDF, ZPLII and PNG
            'LabelStockType' => 'PAPER_4X8'
        );
        return $labelSpecification;
    }
    function addCustomClearanceDetail($QuoteSample,$Quote){
        $feeModelContent = FeeModel::all();
        $fee = ($feeModelContent[0]->fee/100)+1;
        $ProductPrice1 ="";
        if($Quote->sample_price !=""){
            $ProductPrice1 = $Quote->sample_price*$QuoteSample[0]->sampleamount;
            $unit = CurrencyModel::find($Quote->sample_price_currency);
            $ProductUnit =$unit->currency_name;
        }else{
            $ProductPrice1 = $Quote->price*$QuoteSample[0]->sampleamount;
            $unit = CurrencyModel::find($Quote->price_currency);
            $ProductUnit =$unit->currency_name;
        }
        $ProductPrice =  $this->converCurrency(strtoupper($ProductUnit),$ProductPrice1);
        $customerClearanceDetail = array(
            'DutiesPayment' => array(
                'PaymentType' => 'SENDER', // valid values RECIPIENT, SENDER and THIRD_PARTY
                'Payor' => array(
                    'ResponsibleParty' => array(
                        'AccountNumber' => getProperty('dutyaccount'),
                        'Contact' => null,
                        'Address' => array('CountryCode' => 'US')
                    )
                )
            ),
            'DocumentContent' => 'NON_DOCUMENTS',
            'CustomsValue' => array(
                'Currency' => 'USD',
                'Amount' => round($QuoteSample[0]->shippingprice*$fee,1)
            ),
            'Commodities' => array(
                '0' => array(
                    'NumberOfPieces' => 1,
                    'Description' => 'Books',
                    'CountryOfManufacture' => 'US',
                    'Weight' => array(
                        'Units' => $QuoteSample[0]->shippingweightunit,
                        'Value' => $QuoteSample[0]->shippingweight
                    ),
                    'Quantity' => $QuoteSample[0]->packagecount,
                    'QuantityUnits' => 'EA',
                    'UnitPrice' => array(
                        'Currency' => 'USD',
                        'Amount' => $ProductPrice
                    ),
                    'CustomsValue' => array(
                        'Currency' => 'USD',
                        'Amount' =>round($QuoteSample[0]->shippingprice*$fee,1)
                    )
                )
            ),
            'ExportDetail' => array(
                'B13AFilingOption' => 'NOT_REQUIRED'
            )

        );
        return $customerClearanceDetail;
    }
    function addPackageLineItem1($QuoteSample){
        $packageLineItem = array(
            'SequenceNumber'=>1,
            'GroupPackageCount'=>$QuoteSample[0]->packagecount,
            'Weight' => array(
                'Value' => $QuoteSample[0]->shippingweight,
                'Units' => $QuoteSample[0]->shippingweightunit
            ),
            'Dimensions' => array(
                'Length' => $QuoteSample[0]->shippinglength,
                'Width' =>  $QuoteSample[0]->shippingwidth,
                'Height' => $QuoteSample[0]->shippingheight,
                'Units' => 'IN'
            ),
            'CustomerReferences' => array(
                '0' => array(
                    'CustomerReferenceType' => 'CUSTOMER_REFERENCE',
                    'Value' => 'CR1234'
                ), // valid values CUSTOMER_REFERENCE, INVOICE_NUMBER, P_O_NUMBER and SHIPMENT_INTEGRITY
                '1' => array(
                    'CustomerReferenceType' => 'INVOICE_NUMBER',
                    'Value' => 'IV1234'
                ),
                '2' => array(
                    'CustomerReferenceType' => 'P_O_NUMBER',
                    'Value' => 'PO1234'
                )
            )
        );
        return $packageLineItem;
    }
    function buildTransactionDetail(){
        $request=array();
        $request['WebAuthenticationDetail'] = array(
            'UserCredential' =>array(
                'Key' => getProperty('key'),
                'Password' => getProperty('password')
            )
        );
        $request['ClientDetail'] = array(
            'AccountNumber' => getProperty('shipaccount'),
            'MeterNumber' => getProperty('meter')
        );
        $request['TransactionDetail'] = array('CustomerTransactionId' => '*** OpenShip Request using PHP ***');
        $request['Version'] = array(
            'ServiceId' => 'ship',
            'Major' => '7',
            'Intermediate' => '0',
            'Minor' => '0'
        );
        return $request;
    }
   /*******************************Get Lable End***************************************/
    public function quoteNow($id){
        $param['pageNo'] = 35;
        $param['title'] = Lang::get('user.buyer_rfq');
        $user_id = Session::get('user_id');
        $emailList = EmailSendModel::where('parent','=',0)
            ->where( function ($query) use ($user_id) {
                $query->where('sender_id', '=', $user_id)->whereNotIn('sender_delete', array(1))
                    ->orWhere('receiver_id', '=', $user_id)->whereNotIn('receiver_delete', array(1));
            })->orderBy('created_at','desc')->paginate(10);
        $param['emailCount'] = count($emailList);
        $param['subPageNo'] = 4;
        $listID= $id-100000;
        $param['rfq'] = RfqModel::find($listID);
        $param['currencies']=CurrencyModel::find($param['rfq']->rfq_itemunit);
        $param['units'] =UnitModel::all();
        $param['rfq_id'] = $id;
        return View::make('user.seller.quoteNow')->with($param);
    }
    public function editQuoteNow($id){
        $param['pageNo'] = 35;
        $param['title'] = Lang::get('user.buyer_rfq');
        $user_id = Session::get('user_id');
        $emailList = EmailSendModel::where('parent','=',0)
            ->where( function ($query) use ($user_id) {
                $query->where('sender_id', '=', $user_id)->whereNotIn('sender_delete', array(1))
                    ->orWhere('receiver_id', '=', $user_id)->whereNotIn('receiver_delete', array(1));
            })->orderBy('created_at','desc')->paginate(10);
        $param['emailCount'] = count($emailList);
        $param['subPageNo'] = 4;
        $listID= $id-100000;
        $param['rfq'] = RfqModel::find($listID);
        $param['currencies']=CurrencyModel::find($param['rfq']->rfq_itemunit);
        $param['units'] =UnitModel::all();
        $param['rfq_id'] = $id;

        $sellerID = Session::get('user_id');
        $param['quote'] = QuoteModel::whereRaw('rfq_id =? and seller_id =?', array($listID,$sellerID))->get();
        $param['quotePic'] = QuotePictureModel::whereRaw('rfq_id =? and seller_id =?', array($listID,$sellerID))->get();
        $param['quoteNote'] = QuoteNoteModel::whereRaw('rfq_id =? and seller_id =?', array($listID,$sellerID))->get();

        $param['quoteSpec'] = QuoteSpeModel::whereRaw('rfq_id =? and seller_id =?', array($listID,$sellerID))->get();
        return View::make('user.seller.editQuoteNow')->with($param);
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
                return Response::json(['result' =>'success', 'content' =>$data]);
            }
        }
    }
    public function quoteStore(){
        if(Request::ajax()) {
            $rules = [
                'seller_quantity' => 'required|numeric',
                'seller_unit' => 'required',
                'seller_price' => 'required|numeric',
                'seller_currency' => 'required',
            ];
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return Response::json(['result' => 'failed', 'error' => $validator->getMessageBag()->toArray()]);
            } else {
                $rfqID = Input::get('rfq_id');
                $realRfqID = $rfqID-100000;
                $rfq = RfqModel::find($realRfqID);
                $buyerID = $rfq->buyer_id;
                $sellerID = Session::get('user_id');

                $sellerMember = MembersModel::find($sellerID);
                $buyerMember = MembersModel::find($buyerID);
                $buyerEmail = $buyerMember->email;
                $emails =[$buyerEmail,Admin_Email];

                QuoteNoteModel::whereRaw('rfq_id = ? and seller_id =?', array($realRfqID,$sellerID))->delete();
                QuotePictureModel::whereRaw('rfq_id = ? and seller_id =?', array($realRfqID,$sellerID))->delete();
                QuoteSpeModel::whereRaw('rfq_id = ? and seller_id =?', array($realRfqID,$sellerID))->delete();
                $sellerQuantity = Input::get('seller_quantity');
                $sellerUnit = Input::get('seller_unit');
                $sellerPrice = Input::get('seller_price');
                $sellerCurrency = Input::get('seller_currency');
                $samplePrice = Input::get('sample_price');
                $sampleCurrency = Input::get('sample_currency');
                $sellerDescription = Input::get('seller_description');
                if(Input::has('quote_id')){
                    $id= Input::get('quote_id');
                    $quote = QuoteModel::find($id);

                }else{
                    $quote = new QuoteModel;
                }

                $quote->rfq_id = $realRfqID;
                $quote->buyer_id =$buyerID;
                $quote->seller_id = $sellerID;
                $quote->quantity = $sellerQuantity;
                $quote->unit = $sellerUnit;
                $quote->price = $sellerPrice;
                $quote->price_currency = $sellerCurrency;
                $quote->sample_price = $samplePrice;
                $quote->sample_price_currency = $sampleCurrency;
                $quote->seller_product = $sellerDescription;
                $quote->status =1;
                $quote->save();
                $quoteID = $quote->id;
                $countNoteToBuyer = Input::get('count_notetobuyer');
                if($rfq->rfq_type == "detailed"){
                    $images =   Input::get('images');
                    for($i =0; $i<count($images); $i++){
                        $rfqImage = new QuotePictureModel;
                        $rfqImage->rfq_id = $realRfqID;
                        $rfqImage->buyer_id = $buyerID;
                        $rfqImage->seller_id = $sellerID;
                        $rfqImage->quote_id = $quoteID;
                        $rfqImage->picture_url = $images[$i];
                        $rfqImage->save();
                    }
                    $countSpecificationDiv = Input::get('count_specification');
                    for($i=0; $i<$countSpecificationDiv; $i++){
                        $quoteSpecification = new QuoteSpeModel;
                        $quoteSpecification->rfq_id = $realRfqID;
                        $quoteSpecification->buyer_id = $buyerID;
                        $quoteSpecification->seller_id = $sellerID;
                        $quoteSpecification->quote_id = $quoteID;
                        $quoteSpecification->specification_id = Input::get('specificationID'.$i);
                        $quoteSpecification->specification = Input::get('rfq_specificationdescription'.$i);
                        $quoteSpecification->save();
                    }
                }
                for($i=0; $i<$countNoteToBuyer; $i++){
                    $note = Input::get('noteToText'.$i);
                    if($note != "") {
                        $quoteNote = new QuoteNoteModel;
                        $quoteNote->rfq_id = $realRfqID;
                        $quoteNote->buyer_id = $buyerID;
                        $quoteNote->seller_id = $sellerID;
                        $quoteNote->quote_id = $quoteID;
                        $quoteNote->note = Input::get('noteToText'.$i);
                        $quoteNote->save();
                    }
                }
                $messageContentList = EmailModel::whereRaw('title =?',array('Create Quote'))->get();
                $messageContent = $messageContentList[0]->content;
                $data = array(
                    'username'    =>$buyerMember->username,
                    'content' =>$messageContent
                );
                Mail::send('emails.seller.quote', $data, function($message) use ($emails)
                {
                    $message->from('noreply@purchasetree.com', Lang::get('alert.Create_Quote'));
                    $message->to($emails, 'User')->subject(Lang::get('alert.Create_Quote'));
                });


                return Response::json(['result' => 'success', 'error' => $validator->getMessageBag()->toArray()]);
            }
        }
    }


    public function rfqEmail($id, $id2){
        $param['pageNo'] = 35;
        $param['title'] = Lang::get('user.buyer_rfq');
        $user_id = Session::get('user_id');
        $emailList = EmailSendModel::where('parent','=',0)
                                    ->where( function ($query) use ($user_id) {
                                        $query->where('sender_id', '=', $user_id)->whereNotIn('sender_delete', array(1))
                                            ->orWhere('receiver_id', '=', $user_id)->whereNotIn('receiver_delete', array(1));
                                    })->orderBy('created_at','desc')->paginate(10);
        $param['emailCount'] = count($emailList);
        $param['subPageNo'] = 4;
        $listID = $id-100000;
        $quoteID = $id2-100000;
        $param['quoteEmail']  = RfqEmailModel::WhereRaw('rfq_id =? and quote_id=? ', array($listID,$quoteID))->get() ;
        $param['quote'] = QuoteModel::find($quoteID);
        $buyerMember = MembersModel::find($param['quote']->buyer_id);
        $param['buyerUserName'] = $buyerMember->username;
        $param['buyerID'] = $buyerMember->id;
        $param['rfq_id'] = $id;
        return View::make('user.seller.rfqEmail')->with($param);
    }
    public  function rfqStoreEmail(){
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
            $alert['msg'] = Lang::get('missing.Message_has_been_send_successfully');
            $alert['type'] = 'success';
            return Redirect::route('user.seller.rfqEmail',array($rfq_id,$quote_id))->with('alert', $alert);
        }
    }


    /******Product create **********/
    public function productCreate($id){
        $param['pageNo'] = 35;
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $param['title'] = Lang::get('user.products');
        $user_id = Session::get('user_id');
        $emailList = EmailSendModel::where('parent','=',0)
            ->where( function ($query) use ($user_id) {
                $query->where('sender_id', '=', $user_id)->whereNotIn('sender_delete', array(1))
                    ->orWhere('receiver_id', '=', $user_id)->whereNotIn('receiver_delete', array(1));
            })->orderBy('created_at','desc')->paginate(10);
        $param['emailCount'] = count($emailList);
        $param['subPageNo'] = 5;
//        $param['category'] = CategoryModel::whereRaw(true)->orderBy('categoryname','asc')->get();
        $param['subcategory'] = SubCategoryModel::find($id);
        $param['additionalCategories'] = AdditionalCategoryModel::all();
        $param['currency'] = CurrencyModel::whereRaw(true)->orderBy('currency_name','asc')->get();
        $param['unit'] = UnitModel::whereRaw(true)->orderBy('unitname','asc')->get();
        $param['quickDetailsCategory'] = QuickDetailsModel::whereRaw(true)->groupBy('category_id')->get();
        return View::make('user.seller.product.create')->with($param);
    }
    public function  productEdit($id){
        $param['pageNo'] = 35;
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $param['title'] = Lang::get('user.products');
        $user_id = Session::get('user_id');
        $emailList = EmailSendModel::where('parent','=',0)
            ->where( function ($query) use ($user_id) {
                $query->where('sender_id', '=', $user_id)->whereNotIn('sender_delete', array(1))
                    ->orWhere('receiver_id', '=', $user_id)->whereNotIn('receiver_delete', array(1));
            })->orderBy('created_at','desc')->paginate(10);
        $param['emailCount'] = count($emailList);
        $param['subPageNo'] = 5;
        $reallyListID = $id-100000;
        $param['product'] = ProductModel::find($reallyListID);
        $param['productPicture'] = ProductPictureModel::whereRaw('product_id = ?', array($reallyListID))->get();
        $param['category'] = CategoryModel::whereRaw(true)->orderBy('categoryname','asc')->get();
        $param['subcategory'] = SubCategoryModel::whereRaw('category_id = ?', array($param['product']->category_id))->get();
        $param['currency'] = CurrencyModel::whereRaw(true)->orderBy('currency_name','asc')->get();
        $param['unit'] = UnitModel::whereRaw(true)->orderBy('unitname','asc')->get();
        $param['additionalCategories'] = AdditionalCategoryModel::all();
        $param['quickDetailsCategory'] = QuickDetailsModel::whereRaw(true)->groupBy('category_id')->get();
        $param['productQuickDetails'] = ProductQuickDetailModel::whereRaw('product_id=?', array($reallyListID))->get();
        $param['productAdditionalCategorySize'] = ProductAdditionalCategoryModel::whereRaw('product_id =? and role = ?', array($reallyListID,0))->get();
        $param['productAdditionalCategoryColor'] = ProductAdditionalCategoryModel::whereRaw('product_id =? and role = ?', array($reallyListID,1))->get();
        return View::make('user.seller.product.edit')->with($param);
    }
    public function productView($id){
        $param['pageNo'] = 35;
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $param['title'] = Lang::get('user.products');
        $user_id = Session::get('user_id');
        $emailList = EmailSendModel::where('parent','=',0)
            ->where( function ($query) use ($user_id) {
                $query->where('sender_id', '=', $user_id)->whereNotIn('sender_delete', array(1))
                    ->orWhere('receiver_id', '=', $user_id)->whereNotIn('receiver_delete', array(1));
            })->orderBy('created_at','desc')->paginate(10);
        $param['emailCount'] = count($emailList);
        $param['subPageNo'] = 5;
        $reallyListID = $id-100000;
        $param['product'] = ProductModel::find($reallyListID);
        $param['productPicutre'] = ProductPictureModel::whereRaw('product_id = ?', array($reallyListID))->get();
        $param['category'] = CategoryModel::whereRaw(true)->orderBy('categoryname','asc')->get();
        $param['subcategory'] = SubCategoryModel::whereRaw('category_id = ?', array($param['product']->category_id))->get();
        $param['currency'] = CurrencyModel::whereRaw(true)->orderBy('currency_name','asc')->get();
        $param['unit'] = UnitModel::whereRaw(true)->orderBy('unitname','asc')->get();
        return View::make('user.seller.product.view')->with($param);
    }
    public function productDelete($id){
        $reallyID = $id-100000;
        try {
            ProductPictureModel::whereRaw('product_id =?', array($reallyID))->delete();
            ProductModel::find($reallyID)->delete();
            $alert['msg'] = Lang::get('alert.This_product_has_been_deleted_successfully');
            $alert['type'] = 'success';
        } catch(\Exception $ex) {
            $alert['msg'] = Lang::get('alert.This_product_has_been_already_used');
            $alert['type'] = 'danger';
        }
        return Redirect::route('user.seller.products')->with('alert', $alert);
    }
    public  function products(){
        $param['pageNo'] = 35;
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $param['title'] = Lang::get('user.products');
        $user_id = Session::get('user_id');
        $emailList = EmailSendModel::where('parent','=',0)
            ->where( function ($query) use ($user_id) {
                $query->where('sender_id', '=', $user_id)->whereNotIn('sender_delete', array(1))
                    ->orWhere('receiver_id', '=', $user_id)->whereNotIn('receiver_delete', array(1));
            })->orderBy('created_at','desc')->paginate(10);
        $param['emailCount'] = count($emailList);
        $param['subPageNo'] = 5;
        $user_id = Session::get('user_id');
        $param['products'] = ProductModel::Where('user_id','=', $user_id)->get();
        return View::make('user.seller.product.index')->with($param);
    }
    public function getSubcategory(){
        if(Request::ajax()){
            $categoryID = Input::get('categoryID');
            $subcategory = SubCategoryModel::whereRaw('category_id = ?', array($categoryID))->get();
            $data = array('result'=> 'success', 'subcategory' => $subcategory);
        }
        return Response::json($data);
    }
    public function specificationPicture(){
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
                    $path = ABS_LOGO_PATH.$filename;
                    //Image::make(Input::file('file_upload')->getRealPath())->resize(973,615)->save($path);
                    Input::file('file_upload')->move(ABS_LOGO_PATH, $filename);
                    $userImageList = $filename;
                }
                $url = HTTP_LOGO_PATH.$userImageList;
                $data="<img src='".HTTP_LOGO_PATH.$userImageList."'>";
                return Response::json(['result' =>'success', 'content' =>$data, 'url' =>$userImageList,'image_url'=>$url]);
            }
        }
    }
    public function productImageStore(){
        $rules = [
            'mainUrl'  => 'required'
        ];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Response::json(['result' =>'failed', 'error' =>$validator->getMessageBag()->toArray()]);
        }else{
            $productID = Input::get('productID');

            ProductAdditionalImageModel::whereRaw('product_id =?', array($productID))->delete();
            ProductPictureModel::whereRaw('product_id=?',array($productID))->delete();
            $product = ProductModel::find($productID);
            $mainUrl = Input::get('mainUrl');
            $userID = $product->user_id;
            /******Main Photo Upload****/
            $productImage = new ProductPictureModel;
            $productImage->user_id = $userID;
            $productImage->product_id = $productID;
            $productImage->picture_url = $mainUrl;
            $productImage->save();

            $main_pictures = Input::get('main_pictures');
            $main_pictureList = explode(',', $main_pictures[0]);
            if(count($main_pictureList)>0){
                for($i =0; $i<count($main_pictureList); $i++){
                    $productImage = new ProductPictureModel;
                    $productImage->user_id = $userID;
                    $productImage->product_id = $productID;
                    $productImage->picture_url = $main_pictureList[$i];
                    $productImage->save();
                }
            }

            /********color Image*******/
            $specification_descrition_pictures = Input::get('specification_descrition_pictures');
            $countAdditionalList = Input::get('countAdditionalCategory');
            $productAdditionalCategory = ProductAdditionalCategoryModel::whereRaw('product_id =? and role =? ',array($productID,1))->get();
            for($i=0;$i<$countAdditionalList; $i++){
                $specification_picture = explode(',', $specification_descrition_pictures[$i]);
                foreach($specification_picture as $key=>$value){
                    if($value !=""){
                        $productCategory = new ProductAdditionalImageModel;
                        $productCategory->user_id = $userID;
                        $productCategory->product_id = $productID;
                        $productCategory->additional_category_id = $productAdditionalCategory[$i]->additional_category_id;
                        $productCategory->product_additional_category_id = $productAdditionalCategory[$i]->id;
                        $productCategory->image_url = $value;
                        $productCategory->save();
                    }
                }
            }
        }
        $url = URL::route('user.seller.storeSubCategory', array(Session::get('user_id')+100000*1, $product->subcategory_id ));
        return Response::json(['result' =>'success', 'url' =>$url]);
    }
    public function productStore(){
        $rules = [
            'category'  => 'required ',
            'subcategory'  => 'required ',
            'product_name' => 'required ',
            'meta'  => 'required',
            'product_price1'     => 'required | numeric',
            'product_price1currency'    => 'required ',
            'product_price2'     => 'required | numeric',
            'product_price2currency'    => 'required ',
            'product_price3'     => 'required | numeric',
            'product_price3currency'    => 'required ',
            'min_order' =>'required | numeric',
            'supply_ability' =>'required | numeric',
            'min_orderunit' =>'required',
            'supply_abilityunit' =>'required',
        ];
        if(Input::get('shipping1') == 1){
            $rules['flatRate1'] = "required| numeric";
            $rules['flatRateCurrency1'] = "required";
        }
        if(Input::get('shipping2') == 1){
            $rules['flatRate2'] = "required| numeric";
            $rules['flatRateCurrency2'] = "required";
        }
        if(Input::get('shipping3') == 1){
            $rules['flatRate3'] = "required| numeric";
            $rules['flatRateCurrency3'] = "required";
        }


        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Response::json(['result' =>'failed', 'error' =>$validator->getMessageBag()->toArray()]);
        }else{
            if (Input::has('productID')) {
                $id = Input::get('productID');
                $product = ProductModel::find($id);
                ProductPictureModel::whereRaw('product_id = ?', array($id))->delete();
            }else{
                $product = new ProductModel;
            }
            $userID = Session::get('user_id');
            $product->user_id = $userID;
            $product->category_id = Input::get('category');
            $product->subcategory_id = Input::get('subcategory');
            $product->product_name = Input::get('product_name');
            $product->product_description = Input::get('description');
            $product->meta= Input::get('meta');
            $product->product_price1 = Input::get('product_price1');
            $product->price1_currency = Input::get('product_price1currency');
            $product->product_price2 = Input::get('product_price2');
            $product->price2_currency = Input::get('product_price2currency');
            $product->product_price3 = Input::get('product_price3');
            $product->price3_currency = Input::get('product_price3currency');
            $product->min_order = Input::get('min_order');
            $product->supply_ability = Input::get('supply_ability');
            $product->min_order_unit = Input::get('min_orderunit');
            $product->supply_ability_unit = Input::get('supply_abilityunit');
            $product->additional_category_id = Input::get('additionalCategory');
            $product->save();
            if (Input::has('productID')) {
                $productID = Input::get('productID');
            }else{
                $sql = "SELECT *, MAX(id) AS maxID FROM np_product";
                $order = DB::select($sql);
                $productID = $order[0]->maxID;
            }
//            $Images = Input::get('image');
//            for($i=0; $i<count($Images); $i++){
//                $productImage = new ProductPictureModel;
//                $productImage->user_id = $userID;
//                $productImage->product_id = $productID;
//                $productImage->picture_url = $Images[$i];
//                $productImage->save();
//            }
            $additionalCategory  = Input::get('additionalCategory');
            if($additionalCategory == 1){
                if (Input::has('productID')) {
                    $productID = Input::get('productID');
                    ProductAdditionalCategoryModel::whereRaw('product_id =? and role = ?', array($productID,0))->delete();
                }
                $sizes = Input::get('size');
                foreach ($sizes as $key_size => $value_size){
                    if($value_size != ""){
                        $productAdditionalCategory= new ProductAdditionalCategoryModel;
                        $productAdditionalCategory->user_id = $userID;
                        $productAdditionalCategory->product_id = $productID;
                        $productAdditionalCategory->additional_category_id = $additionalCategory;
                        $productAdditionalCategory->values = $value_size;
                        $productAdditionalCategory->role = 0;
                        $productAdditionalCategory->save();
                    }

                }
            }elseif($additionalCategory == 2){
                $colors = Input::get('color');
                $productAdditionalCategoryColor = ProductAdditionalCategoryModel::whereRaw('product_id =? and role = ?', array($productID,1))->get();
                if(count($productAdditionalCategoryColor)>0){
                    foreach ($colors as $key_color => $value_color) {
                        if ($value_color != "") {
                            $k = 0;
                            foreach($productAdditionalCategoryColor as $key_additional => $value_additional){
                                if($value_additional->values == $value_color){
                                    $k = $k+1;
                                }
                            }
                            if($k == 0){
                                $productAdditionalCategory= new ProductAdditionalCategoryModel;
                                $productAdditionalCategory->user_id = $userID;
                                $productAdditionalCategory->product_id = $productID;
                                $productAdditionalCategory->additional_category_id = $additionalCategory;
                                $productAdditionalCategory->values = $value_color;
                                $productAdditionalCategory->role = 1;
                                $productAdditionalCategory->save();
                            }

                        }
                    }
                    $productAdditionalCategoryColor = ProductAdditionalCategoryModel::whereRaw('product_id =? and role = ?', array($productID,1))->get();
                    foreach($productAdditionalCategoryColor as $key_additional => $value_additional){
                        $k = 0;
                        foreach ($colors as $key_color => $value_color) {
                            if ($value_color != "") {
                                if($value_additional->values == $value_color){
                                    $k = $k+1;
                                }
                            }
                        }
                        if($k ==0){
                            ProductAdditionalCategoryModel::find($value_additional->id)->delete();
                        }
                    }
                }else{
                    foreach ($colors as $key_color => $value_color){
                        if($value_color != ""){
                            $productAdditionalCategory= new ProductAdditionalCategoryModel;
                            $productAdditionalCategory->user_id = $userID;
                            $productAdditionalCategory->product_id = $productID;
                            $productAdditionalCategory->additional_category_id = $additionalCategory;
                            $productAdditionalCategory->values = $value_color;
                            $productAdditionalCategory->role = 1;
                            $productAdditionalCategory->save();
                        }

                    }
                }

            }elseif($additionalCategory == 3){
                $sizes = Input::get('size');
                if (Input::has('productID')) {
                    $productID = Input::get('productID');
                    ProductAdditionalCategoryModel::whereRaw('product_id =? and role = ?', array($productID,0))->delete();
                }
                foreach ($sizes as $key_size => $value_size){
                    if($value_size != ""){
                        $productAdditionalCategory= new ProductAdditionalCategoryModel;
                        $productAdditionalCategory->user_id = $userID;
                        $productAdditionalCategory->product_id = $productID;
                        $productAdditionalCategory->additional_category_id = $additionalCategory;
                        $productAdditionalCategory->values = $value_size;
                        $productAdditionalCategory->role = 0;
                        $productAdditionalCategory->save();
                    }

                }
                $colors = Input::get('color');
                $productAdditionalCategoryColor = ProductAdditionalCategoryModel::whereRaw('product_id =? and role = ?', array($productID,1))->get();
                if(count($productAdditionalCategoryColor)>0){
                    foreach ($colors as $key_color => $value_color) {
                        if ($value_color != "") {
                            $k = 0;
                            foreach($productAdditionalCategoryColor as $key_additional => $value_additional){
                                if($value_additional->values == $value_color){
                                    $k = $k+1;
                                }
                            }
                            if($k == 0){
                                $productAdditionalCategory= new ProductAdditionalCategoryModel;
                                $productAdditionalCategory->user_id = $userID;
                                $productAdditionalCategory->product_id = $productID;
                                $productAdditionalCategory->additional_category_id = $additionalCategory;
                                $productAdditionalCategory->values = $value_color;
                                $productAdditionalCategory->role = 1;
                                $productAdditionalCategory->save();
                            }

                        }
                    }
                    $productAdditionalCategoryColor = ProductAdditionalCategoryModel::whereRaw('product_id =? and role = ?', array($productID,1))->get();
                    foreach($productAdditionalCategoryColor as $key_additional => $value_additional){
                        $k = 0;
                        foreach ($colors as $key_color => $value_color) {
                            if ($value_color != "") {
                                if($value_additional->values == $value_color){
                                    $k = $k+1;
                                }
                            }
                        }
                        if($k ==0){
                            ProductAdditionalCategoryModel::find($value_additional->id)->delete();
                        }
                    }
                }else{
                    foreach ($colors as $key_color => $value_color){
                        if($value_color != ""){
                            $productAdditionalCategory= new ProductAdditionalCategoryModel;
                            $productAdditionalCategory->user_id = $userID;
                            $productAdditionalCategory->product_id = $productID;
                            $productAdditionalCategory->additional_category_id = $additionalCategory;
                            $productAdditionalCategory->values = $value_color;
                            $productAdditionalCategory->role = 1;
                            $productAdditionalCategory->save();
                        }

                    }
                }
            }

            if (Input::has('productID')) {
                ProductQuickDetailModel::whereRaw('user_id=? and product_id=?', array($userID,$productID))->delete();
            }
            $label_select_question = Input::get('label_select_question');
            $quickDetails = Input::get('quickDetails');
            $countLabel = count($label_select_question);
            for($i =0; $i<$countLabel; $i++){
                if($label_select_question[$i] !="" && $quickDetails[$i] != ""){
                    $ProductQuickDetailModel = new ProductQuickDetailModel;
                    $ProductQuickDetailModel->user_id = $userID;
                    $ProductQuickDetailModel->product_id = $productID;
                    $ProductQuickDetailModel->categoryname = $label_select_question[$i];
                    $ProductQuickDetailModel->categorycontent = $quickDetails[$i];
                    $ProductQuickDetailModel->save();
                }
            }


            if(Input::has('productID')){
             ProductShippingModel::whereRaw('user_id=? and product_id=?', array($userID,$productID))->delete();
            }
            $ProductShippingModel  = new ProductShippingModel;
            $ProductShippingModel->user_id = $userID;
            $ProductShippingModel->product_id = $productID;
            for($i= 1; $i<4; $i++){
                $shippingType = "shipping_type".$i;
                $flatRate = "flat_rate".$i;
                $estimatedTime = "estimated_time".$i;
                $add = "add".$i;
                $ProductShippingModel->$shippingType = Input::get('shipping'.$i);
                if(Input::get('shipping'.$i) == 1){
                    $ProductShippingModel->$flatRate = Input::get('flatRate'.$i);
                    $ProductShippingModel->$add = Input::get('flatRateCurrency'.$i);
                }

                $ProductShippingModel->$estimatedTime = Input::get('estimatedTime'.$i);
            }
            $ProductShippingModel->save();


        }
        if (Input::has('productID')) {
            $url = URL::route('user.seller.editImage', ($productID+100000*1));
        }else{
            $url = URL::route('user.seller.addImage', ($productID+100000*1));
        }
        $alert['msg'] = Lang::get('missing.Product_has_been_saved_successfully');
        $alert['type'] = 'success';
        return Response::json(['result' =>'success', 'url' =>$url]);
    }
    public function editImage($id){
        $param['pageNo'] = 35;
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $param['title'] = Lang::get('user.products');
        $user_id = Session::get('user_id');
        $emailList = EmailSendModel::where('parent','=',0)
            ->where( function ($query) use ($user_id) {
                $query->where('sender_id', '=', $user_id)->whereNotIn('sender_delete', array(1))
                    ->orWhere('receiver_id', '=', $user_id)->whereNotIn('receiver_delete', array(1));
            })->orderBy('created_at','desc')->paginate(10);
        $param['emailCount'] = count($emailList);
        $param['subPageNo'] = 5;

        $reallyID = $id - 100000;
        $param['product'] = ProductModel::find($reallyID);
        $param['productPictures'] = ProductPictureModel::whereRaw('product_id=?', array($reallyID))->get();
        $param['productAdditionalCategory'] = ProductAdditionalCategoryModel::whereRaw('product_id=? and role= ?',array($reallyID,1))->get();
        $param['productAdditionalCategoryImage'] = ProductAdditionalImageModel::whereRaw('product_id =?', array($reallyID))->get();
        return View::make('user.seller.product.editImage')->with($param);
    }

    public function addImage($id){
        $param['pageNo'] = 35;
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $param['title'] = Lang::get('user.products');
        $user_id = Session::get('user_id');
        $emailList = EmailSendModel::where('parent','=',0)
            ->where( function ($query) use ($user_id) {
                $query->where('sender_id', '=', $user_id)->whereNotIn('sender_delete', array(1))
                    ->orWhere('receiver_id', '=', $user_id)->whereNotIn('receiver_delete', array(1));
            })->orderBy('created_at','desc')->paginate(10);
        $param['emailCount'] = count($emailList);
        $param['subPageNo'] = 5;
        $reallyID = $id- 100000;
        $param['product'] = ProductModel::find($reallyID);
        $param['productAdditionalCategory'] = ProductAdditionalCategoryModel::whereRaw('product_id=? and role= ?',array($reallyID,1))->get();
        return View::make('user.seller.product.addImage')->with($param);
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
                                $list .=Lang::get('user.buyer_name');
                            $list .='</label>';
                            $list .='<div class="col-md-6 col-lg-6 col-sm-5">';
                                $list.='<p class="form-control border-none-important">'.$quote->buyerMember->username.'</p>';
                            $list .='</div>';
                            //$list .='<div class="col-md-2 col-lg-2 col-sm-2">';
                              //  $list .='<a href="'.URL::route('user.buyer.quoteShow',(100000*1+$quote->id)).'" class="btn-u btn-u-orange" target="_blank"><i class="fa fa-comments-o"></i></a>';
                            //$list .='</div>';
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
                                    $list .= round($quote->sample_price,2).($quote->SampleCurrency->currency_name) ;
                                }else{
                                    $list .= round($quote->price,2).($quote->Currency->currency_name) ;
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
            $escrow = EscrowEscrowModel::whereRaw('seller_id=? and quote_id =?',array($escrowUser[0]->id,$reallyID))->get();
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
                                            $rfq=QuoteModel::find($reallyID)->rfq;
                                            $quote = QuoteModel::find($reallyID);
                                            $quotePrice = $rfq->rfq_quantity*$quote->price;
                                            $currencyName = $quote->Currency->currency_name;
                                            if($currencyName == "USD"){
                                                $list.=round($quotePrice,2).$currencyName;
                                                $totalProductPrice = round($quotePrice,2);
                                            }else{
                                                $list.=round($quotePrice,2).$currencyName.",";
                                                $totalProductPrice =round($this->converCurrency($currencyName,$quotePrice),2);
                                                $list .=$totalProductPrice."USD";
                                            }
                                    $list .='</p>';
                                $list .= '</div>';
                           $list .= '</div>';
                           $list .= '<div class="form-group">';
                                $list .= '<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                                    $list .= Lang::get('user.escrow_amount');
                                $list .= '</label>';
                                $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                                    $list.='<p class="form-control border-none-important">';
                                        $escrowPayment = $value->total;
                                        if($escrowPayment > $totalProductPrice){
                                           $list .= $totalProductPrice."USD"." , "."100% ".Lang::get('user.escrow');
                                        }else{
                                            $list .=$value->total."(USD)";
                                        }
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
//                $list .='<div class="col-md-2 col-lg-2 col-sm-2">';
//                $list .='<a href="'.URL::route('user.buyer.quoteShow',(100000*1+$quote->id)).'" class="btn-u btn-u-orange" target="_blank"><i class="fa fa-comments-o"></i></a>';
//                $list .='</div>';
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
                $quotePrice = $rfq->rfq_quantity*$quote->price;
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
    public function subShipping(){
        $user_id = Session::get('user_id');
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
                }elseif($quote->status == 5){
                      $list.='<a href="'.URL::route('user.seller.getLabel').'" target="_blank">'.Lang::get('missing.go_to_get_label_sample_request').'</a>';
                }else{
                    $list .='<p>'.Lang::get('missing.you_can_not_create_shipping_label').'</p>';
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
    public function subMail(){
        $user_id = Session::get('user_id');
        $id = Input::get('id');
        $reallyID= $id-100000;
        $quote = QuoteModel::find($reallyID);
        $rfq_email = RfqEmailModel::whereRaw('quote_id=?',array($reallyID))
            ->where( function ($query) use ($user_id) {
                $query->where('sender_id', '=', $user_id)->orWhere('receiver_id', '=', $user_id);
            })->get();
        $sellerName = $quote->buyerMember->username;
        $rfq=QuoteModel::find($reallyID)->rfq;
        $sellerID = $quote->buyer_id+100000*1;
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
        $list .='<form action="'.URL::route('user.seller.rfqStoreEmailPost').'" method="post" class="form-horizontal reg-page" id="emailSendForm">';
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
        $rfq=$quote->rfq;
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
        $list .='<a href="'.URL::route('user.seller.rfqEmail',array($rfq->id+100000*1,$id )).'" target ="_blank">'.Lang::get('user.email').' '.Lang::get('user.to_buyer').'</a>';

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

    public  function cartDocument(){
        $id = Input::get('id');
        $product_id = $id-100000;
        $shoppingCartProduct = ShoppingCartProductModel::find($product_id);
        $cart = $shoppingCartProduct->ShoppingCart;

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
                                $list .='<a href="'.URL::route('user.addCart.cartInvoice',$id).'" target="_blank">'.Lang::get('user.shopping_cart_invoice').'</a>';
                                $list .=" <br>";
                            $list .='</p>';
                        $list .= '</div>';
                    $list .= '</div>';

                    $list .='<div class="form-group margin-bottom-20">';
                        $list .= '<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                            $list .=Lang::get('user.contract');
                        $list .='</label>';
                        $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                            $list.='<p class="form-control border-none-important">';
                                $list .='<a href="'.URL::route('user.seller.cart.email',$id).'" target ="_blank">'.Lang::get('user.email').' '.Lang::get('user.to_buyer').'</a>';
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
                                $list .= $shoppingCartProduct->sub_total."USD";
                            $list .='</p>';
                        $list .='</div>';
                    $list .='</div>';
                    $list .='<div class="form-group ">';
                        $list .= '<label class="col-md-4 col-lg-4 col-sm-5 control-label">';
                            $list .=Lang::get('user.shopping_cart_escrow');
                        $list .='</label>';
                        $list .= '<div class="col-md-8 col-lg-8 col-sm-7">';
                            $list.='<p class="form-control border-none-important">';
                                if($shoppingCartProduct->status >=2){
                                    $list .= $shoppingCartProduct->sub_total."USD";
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
                                if($shoppingCartProduct->status == 10){
                                    $list .= $shoppingCartProduct->sub_total."USD";
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
                    $list .= $shoppingCartProduct->trackingnumber1;
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
            $list .= '</div>';
        $list .='</div>';
        $data = array('title' =>Lang::get('missing.Document_for_shopping_cart'),'content' =>$list, 'result' =>'success');
        return Response::json($data);

    }

    public function cartEmail($shoppingCartID){
        $param['pageNo'] = 35;
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $param['subPageNo'] = 6;
        $user_id =Session::get('user_id');
        $param['title'] = Lang::get('user.shopping_cart');
        $param['subTitle'] = Lang::get('user.shopping_cart');
        $emailList = EmailSendModel::where('parent','=',0)
            ->where( function ($query) use ($user_id) {
                $query->where('sender_id', '=', $user_id)->whereNotIn('sender_delete', array(1))
                    ->orWhere('receiver_id', '=', $user_id)->whereNotIn('receiver_delete', array(1));
            })->orderBy('created_at','desc')->paginate(10);
        $param['emailCount'] = count($emailList);
        $reallyShoppingCartID = $shoppingCartID - 100000;
        $param['shoppingCartProduct'] = $shoppingCartProduct = ShoppingCartProductModel::find($reallyShoppingCartID);
        $cartMails = ShoppingCartEmailModel::whereRaw('shopping_cart_product_id=?',array($reallyShoppingCartID))
            ->where( function ($query) use ($user_id) {
                $query->where('sender_id', '=', $user_id)->orWhere('receiver_id', '=', $user_id);
            })->get();
        $param['cartMails'] = $cartMails;
        $param['shoppingCart'] =$shoppingCart = $shoppingCartProduct->ShoppingCart;
        $param['buyer']  = $shoppingCartProduct->buyer;
        $param['user_id'] = Session::get('user_id');
        $param['id'] = $shoppingCartID;
        return View::make('user.seller.cartEmail')->with($param);
    }








}