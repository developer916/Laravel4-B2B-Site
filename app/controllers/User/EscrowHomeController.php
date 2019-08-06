<?php namespace User;

use Illuminate\Routing\Controllers\Controller;
use View, Input, Redirect, Session, Validator, DB, Mail,File, Request,Response,Lang;
use Members as MembersModel, Country as CountryModel,CompanyProfile as CompanyProfileModel,Business as BusinessModel,
    ProductFocus as ProductFocusModel,FactorySize as FactorySizeModel,Category as CategoryModel,Employees as EmployeesModel,
    SubCategory as SubCategoryModel, UserCategory as UserCategoryModel, EscrowUser as EscrowUserModel, EscrowAdmin as EscrowAdminModel,
    EscrowEscrow as EscrowEscrowModel,Rfq as RfqModel, Quote as QuoteModel, Fee as FeeModel,Currency as CurrencyModel,
    EscrowPayment as EscrowPaymentModel, EscrowDispute as EscrowDisputeModel, EscrowMessageTemplate as EscrowMessageTemplateModel,
    Accept as AcceptModel,ShoppingCart as ShoppingCartModel,ShoppingCartProduct as ShoppingCartProductModel,ShoppingCartDispute as ShoppingCartDisputeModel;
class EscrowHomeController extends \BaseController {
    public function __construct()
    {
        $this->beforeFilter(function () {
            if (!Session::has('user_id')) {
                return Redirect::route('user.auth.login');
            }
        });
    }
    public function index(){
        if (!Session::has('escrow_user_id')) {
            return Redirect::route('user.escrow.login');
        }else{
            if ($alert = Session::get('alert')) {
                $param['alert'] = $alert;
            }
            $param['pageNo'] = 250;
            $userID = session::get('escrow_user_id');
            $param['account'] = EscrowUserModel::find($userID);
            $purchasetreeID = $param['account']->purchasetree_id;
            $quoteList = QuoteModel::whereRaw('buyer_id = ? and accept=1 and accept_status=1', array($purchasetreeID))->get();
            $quoteLists = array();
            $ik =0;
            for($i=0; $i<count($quoteList); $i++){
                $quoteID = $quoteList[$i]->id;
                $escrowEscrow = EscrowEscrowModel::whereRaw('quote_id = ?', array($quoteID))->get();
                if(count($escrowEscrow) == 0){
                    $quoteLists[$ik] = $quoteList[$i];
                    $ik++;
                }
            }
            $param['quoteList'] = $quoteLists;

            $param['buyerList'] = EscrowEscrowModel::whereRaw('buyer_id = ?', array($userID))->get();
            $param['sellerList'] = EscrowEscrowModel::whereRaw('seller_id = ?', array($userID))->get();
            return View::make('user.escrow.index')->with($param);
        }

    }
    public function login(){
        $param['pageNo'] = 251;
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        return View::make('user.escrow.login')->with($param);
    }
    public function forgot(){
        $param['pageNo'] = 261;
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        return View::make('user.escrow.forgot')->with($param);
    }
    public function forgotSend(){

    }
    public function register(){
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $param['pageNo'] = 252;
        $param['country'] = CountryModel::whereRaw(true)->orderBy('country_name','asc')->get();
        return View::make('user.escrow.register')->with($param);
    }
    public function registerStore(){
        $rules = [
            'purchaseName'  => 'required ',
            'purchasePassword'  => 'required ',
            'username' => 'required|unique:escrow_users',
            'password'  => 'required|confirmed',
            'password_confirmation' =>'required',
            'useremail'=> 'required|email|unique:escrow_users',
           // 'g-recaptcha-response' => 'required|captcha',
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else{
            $username = Input::get('purchaseName');
            $password = Input::get('purchasePassword');
            $list = MembersModel::whereRaw('username = ? and userpassword = md5(?) and status = ?', array($username, $password, '1'))->get();
            if(count($list)>0){
                $escrowUser = new EscrowUserModel;
                $purchasetreID = $list[0]->id;
            }else{
                $listEmail = MembersModel::whereRaw('email = ? and userpassword = md5(?) and status = ?', array($username, $password, '1'))->get();
                if(count($listEmail)>0){
                    $escrowUser = new EscrowUserModel;
                    $purchasetreID = $listEmail[0]->id;
                }else{
                    $alert['msg'] = Lang::get('alert.Please_insert_correct_main_site_login_information');
                    $alert['type'] = 'danger';
                    return Redirect::route('user.escrow.register')->with('alert', $alert);
                }
            }
            $escrowUser->purchasetree_id = $purchasetreID;
            $escrowUser->username= Input::get('username');
            $escrowUser->userpass= md5(Input::get('password'));
            $escrowUser->userfullname= Input::get('fullname');
            $escrowUser->useremail= Input::get('useremail');
            $escrowUser->userbusiness= Input::get('businessname');
            $escrowUser->useraddress1= Input::get('address1');
            $escrowUser->useraddress2= Input::get('address2');
            $escrowUser->usercity= Input::get('city');
            $escrowUser->userstate= Input::get('state');
            $escrowUser->userzip= Input::get('postcode');
            $escrowUser->usercountry= Input::get('country');
            $escrowUser->paymentaccepttype= Input::get('payment');
            $escrowUser->registrationdate=date('Y-m-d H:i:s');
            $escrowUser->save();
            $alert['msg'] = Lang::get('alert.User_has_been_saved_successfully');
            $alert['type'] = 'success';
            return Redirect::route('user.escrow.login')->with('alert', $alert);
        }
    }
    public function doLogin(){
        $rules = [
            'username'  => 'required ',
            'userpassword'  => 'required ',
            //'g-recaptcha-response' => 'required|captcha',
        ];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else{
            if(Session::get('user_id')){
                $purchasetreeID = Session::get('user_id');
                $username = Input::get('username');
                $password = Input::get('userpassword');
                $list = EscrowUserModel::whereRaw('username = ? and userpass = md5(?) and purchasetree_id =?', array($username, $password,$purchasetreeID))->get();
                if(count($list)>0) {
                    Session::set('escrow_user_id', $list[0]->id);
                    return Redirect::route('user.escrow.index');
                }else{
                    $listEmail = EscrowUserModel::whereRaw('useremail = ? and userpass = md5(?) and purchasetree_id =?', array($username, $password,$purchasetreeID))->get();
                    if(count($listEmail)>0) {
                        Session::set('escrow_user_id', $listEmail[0]->id);
                        return Redirect::route('user.escrow.index');
                    }else{
                        $alert['msg'] = Lang::get('alert.Your_information_is_not_correctly');
                        $alert['type'] = 'danger';
                        return Redirect::route('user.escrow.login')->with('alert', $alert);
                    }
                }
            }else{
                return Redirect::route('user.auth.login');
            }

        }
    }
    public function doLogout(){
        Session::forget(('escrow_user_id'));
        return Redirect::route('user.escrow.index');
    }
    public function getPrice(){
        if(Request::ajax()){
            $selectItem = Input::get('selectItem');
            $fee = FeeModel::all();
            $priceFee = 1*1+($fee[0]->fee)/100*1;
            $quote = QuoteModel::find($selectItem);
            $price = $quote->price * $quote->rfq->rfq_quantity*$priceFee;
            $currencyID =$quote->price_currency;
            $currency = CurrencyModel::find($currencyID);
            $reallyPrice = round($this->converCurrency(strtoupper($currency->currency_name),$price),2);
            $escrowFee = EscrowAdminModel::all();
            if(count($escrowFee) > 0 && $escrowFee[0]->commission != ""){
                $totalPrice = round($reallyPrice*(1*1+($escrowFee[0]->commission/100)*1),2);
            }else{
                $totalPrice = round($reallyPrice,2);
            }
            $sellerUsername = $quote->sellerMember->username;

            $data =array('result'=>'success', 'price' =>$totalPrice, 'username' =>$sellerUsername);
            return Response::json($data);
        }
    }
    public function transaction(){
        $item = Input::get('item');
        $escrowPrice = Input::get('escrowPrice');
        $username = Input::get('username');
        $member = MembersModel::whereRaw('username=?', array($username))->get();
        if(count($member)>0){
            $buyerID = Session::get('escrow_user_id');
            $escrowID = $this->invoicenumber(10);
            $escrowUser = EscrowUserModel::whereRaw('purchasetree_id = ?', array($member[0]->id))->get();
            if(count($escrowUser)>0){
                $escrow = new EscrowEscrowModel;
                $quote = QuoteModel::find($item);
                $escrow->quote_id = $item;
                $escrow->buyer_id = $buyerID;
                $escrow->escrow_id = $escrowID;
                $escrow->seller_id = $escrowUser[0]->id;
                $escrow->item =$quote->rfq->rfq_title;
                $escrow->price = $escrowPrice;
                $escrow->confirm = 0;
                $escrow->status = 1;
                $escrow->date = date('Y-m-d H:i:s');
                $escrow->save();

                $alert['msg'] = Lang::get('alert.Your_transaction_saved_successfully');
                $alert['type'] = "success";
                return Redirect::route('user.escrow.escrow',$escrowID)->with('alert', $alert);
            }else{
                $alert['msg'] = Lang::get('alert.You_can_not_create_transaction_Because_seller_do_not_have_escrow_id_for_now');
                $alert['type'] = "danger";
                return Redirect::route('user.escrow.index')->with('alert', $alert);
            }
        }else{
            $alert['msg'] = Lang::get('alert.You_can_not_create_transaction_Because_seller_do_not_have_escrow_id_for_now');
            $alert['type'] = "danger";
            return Redirect::route('user.escrow.index')->with('alert', $alert);
        }
    }
    public function escrow($id,$id2 = false, $escrowID = false){
        if (!Session::has('escrow_user_id')) {
            return Redirect::route('user.escrow.login');
        }
        if($id2 == false){
            $param['pageNo'] = 250;
            $escrow = EscrowEscrowModel::whereRaw('escrow_id =?',array($id))->get();
            $quote= QuoteModel::find($escrow[0]->quote_id);
            $accept = AcceptModel::whereRaw('quote_id = ?',array($escrow[0]->quote_id))->get();
            $param['accept'] = $accept;
            $fee = FeeModel::all();
            $priceFee = 1*1+($fee[0]->fee)/100*1;
            $price = $quote->price * $quote->rfq->rfq_quantity*$priceFee;
            $currencyID =$quote->price_currency;
            $currency = CurrencyModel::find($currencyID);
            $reallyPrice = round($this->converCurrency(strtoupper($currency->currency_name),$price),2);
            $escrowFee = EscrowAdminModel::all();
            if(count($escrowFee) > 0 && $escrowFee[0]->commission != ""){
                $totalPrice = round($reallyPrice*(1*1+($escrowFee[0]->commission/100)*1),2);
                $escrowFeePrice = $totalPrice - $reallyPrice;
            }else{
                $totalPrice = round($reallyPrice,2);
                $escrowFeePrice = 0;
            }
            $buyerMember = EscrowUserModel::find($escrow[0]->buyer_id);
            $sellerMember =EscrowUserModel::find($escrow[0]->seller_id);
            $buyerCounty = CountryModel::find($buyerMember->usercountry);
            $sellerCountry = CountryModel::find($sellerMember->usercountry);
            if(Session::get('escrow_user_id') == $escrow[0]->seller_id){
                $param['userMemberCheck'] ="seller";
            }else{
                $param['userMemberCheck'] ="buyer";
            }
            $param['escrow'] =$escrow[0];
            $param['totalPrice'] = $totalPrice;
            $param['reallyPrice'] =$reallyPrice;
            $param['ecrowFeePrice'] = $escrowFeePrice;
            $param['buyerCountry'] = $buyerCounty;
            $param['sellerCountry'] = $sellerCountry;
            $param['buyerMember'] = $buyerMember;
            $param['sellerMember'] = $sellerMember;
            $param['quote_id'] = 100000+1*$escrow[0]->quote_id;
            $param['electronic'] = EscrowMessageTemplateModel::whereRaw('type=?',array('electronic'))->get();
            return View::make('user.escrow.escrow')->with($param);
        }else{
            $param['pageNo'] = 256;
            $fee = FeeModel::all();
            $priceFee = ($fee[0]->fee)/100*1;
            $param['id2'] = $id2;
            $param['id'] = $id;
            if($escrowID == false){
                $cart = ShoppingCartModel::whereRaw('invoice_number=?',array($id))->first();
                $param['cart'] = $cart;
                $param['cartProductList'] ="";
                $param['escrowID'] = 0;
                $param['fee'] =$priceFee;
            }else{
                $param['cart'] = ShoppingCartModel::whereRaw('invoice_number=?',array($id))->first();
                $param['cartProductList'] = ShoppingCartProductModel::find($escrowID);
                $param['escrowID'] = $escrowID;
                $param['fee'] =$priceFee;
            }
            return View::make('user.escrow.shoppingCartEscrow')->with($param);
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
                $escrowID = Input::get('escrow_id');
                $realQuoteID = $quoteID-100000;
                $quote = QuoteModel::find($realQuoteID);
                $fee = FeeModel::all();
                $priceFee = 1*1+($fee[0]->fee)/100*1;
                $price = $quote->price * $quote->rfq->rfq_quantity*$priceFee;
                $currencyID =$quote->price_currency;
                $currency = CurrencyModel::find($currencyID);
                $reallyPrice = round($this->converCurrency(strtoupper($currency->currency_name),$price),2);
                $escrowFee = EscrowAdminModel::all();
                if(count($escrowFee) > 0 && $escrowFee[0]->commission != ""){
                    $totalPrice = round($reallyPrice*(1*1+($escrowFee[0]->commission/100)*1),2);
                    $escrowFeePrice = $totalPrice - $reallyPrice;
                }else{
                    $totalPrice = round($reallyPrice,2);
                    $escrowFeePrice = 0;
                }

                $listData = array();
                $listData['Total']= $totalPrice;
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
                    /***change list *****/
                    /*$listQuoteBuyerCard = EscrowPaymentModel::whereRaw('escrow_id =?', array($escrowID))->get();
                    if(count($listQuoteBuyerCard)>0){
                        $buyerCard = EscrowPaymentModel::find($listQuoteBuyerCard[0]->id);
                    }else{
                        $buyerCard = new EscrowPaymentModel;
                    }*/
                    $listQuoteBuyerCard = EscrowEscrowModel::whereRaw('escrow_id =?', array($escrowID))->get();
                    if(count($listQuoteBuyerCard)>0){
                        $buyerCard = EscrowEscrowModel::find($listQuoteBuyerCard[0]->id);
                    }else{
                        $buyerCard = new EscrowEscrowModel;
                    }
                    $buyerCard->total =$listData['Total'];
                    $buyerCard->type = "credit";
                    $buyerCard->escrow_id = $escrowID;
                    $buyerCard->quote_id = $realQuoteID;
                    $buyerCard ->invoice_number = $InvoiceNumber;
                    $buyerCard ->transaction_id = $tracsactionID;
                    $buyerCard ->avs_response = $avsResponse;
                    $buyerCard ->cvv_response = $cvvResponse;
                    $buyerCard ->escrowDate = date('Y-m-d');
                    $buyerCard->status = 2;
                    $buyerCard->save();
                    $quote = QuoteModel::find($realQuoteID);
                    $user_id = $quote->buyer_id;
                    $BuyerMember = MembersModel::find($user_id);
                    $email = $BuyerMember->email;
                    $data = array(
                        'name' =>$BuyerMember->username,
                        'email'    =>$BuyerMember->email,
                        'price' =>$listData['Total'],
                    );
                    Mail::send('emails.escrow.paynow', $data, function($message){
                        $message->from('noreply@purchasetree.com', Lang::get('alert.Escrow_Payment'));
                        $message->to(Admin_Email, 'Admin')->subject(Lang::get('alert.Escrow_Payment'));
                    });
                    Mail::send('emails.escrow.paynowuser', $data, function($message) use($email){
                        $message->from('noreply@purchasetree.com', Lang::get('alert.Escrow_Payment'));
                        $message->to($email, 'Admin')->subject(Lang::get('alert.Escrow_Payment'));
                    });
                }
                return Response::json(['result' => 'success', 'message' => $result]);
            }
        }
    }
    public function wirePayNow(){
        if(Request::ajax()){
            $quoteID = Input::get('quote_id');
            $escrowID = Input::get('escrow_id');
            $realQuoteID = $quoteID-100000;
            $quote = QuoteModel::find($realQuoteID);
            $fee = FeeModel::all();
            $priceFee = 1*1+($fee[0]->fee)/100*1;
            $price = $quote->price * $quote->rfq->rfq_quantity*$priceFee;
            $currencyID =$quote->price_currency;
            $currency = CurrencyModel::find($currencyID);
            $reallyPrice = round($this->converCurrency(strtoupper($currency->currency_name),$price),2);
            $escrowFee = EscrowAdminModel::all();
            if(count($escrowFee) > 0 && $escrowFee[0]->commission != ""){
                $totalPrice = round($reallyPrice*(1*1+($escrowFee[0]->commission/100)*1),2);
                $escrowFeePrice = $totalPrice - $reallyPrice;
            }else{
                $totalPrice = round($reallyPrice,2);
                $escrowFeePrice = 0;
            }
           /* $listQuoteBuyerCard = EscrowPaymentModel::whereRaw('escrow_id =?', array($escrowID))->get();
            if(count($listQuoteBuyerCard)>0){
                $buyerCard = EscrowPaymentModel::find($listQuoteBuyerCard[0]->id);
            }else{
                $buyerCard = new EscrowPaymentModel;
            }*/
            $listQuoteBuyerCard = EscrowEscrowModel::whereRaw('escrow_id =?', array($escrowID))->get();
            if(count($listQuoteBuyerCard)>0){
                $buyerCard = EscrowEscrowModel::find($listQuoteBuyerCard[0]->id);
            }else{
                $buyerCard = new EscrowEscrowModel;
            }
            $InvoiceNumber =Input::get('invoice_number');
            $buyerCard->type = "wire";
            $buyerCard->escrow_id = $escrowID;
            $buyerCard->quote_id = $realQuoteID;
            $buyerCard ->invoice_number = $InvoiceNumber;
            $buyerCard ->total = 0;
            $buyerCard ->transaction_id = '';
            $buyerCard ->avs_response = '';
            $buyerCard ->cvv_response = '';
            $buyerCard->bank_info= Input::get('wire_information');
            $buyerCard->status = 2;
            $buyerCard->save();
            $quote = QuoteModel::find($realQuoteID);
            $user_id = $quote->buyer_id;
            $BuyerMember = MembersModel::find($user_id);
            $email = $BuyerMember->email;
            $data = array(
                'name' =>$BuyerMember->username,
                'email'    =>$BuyerMember->email,
                'price' =>$totalPrice,
            );
            Mail::send('emails.escrow.wirepaynow', $data, function($message){
                $message->from('noreply@purchasetree.com', Lang::get('alert.Escrow_Payment'));
                $message->to(Admin_Email, 'Admin')->subject(Lang::get('alert.Escrow_Payment'));
            });
            Mail::send('emails.escrow.wirepaynowuser', $data, function($message) use($email){
                $message->from('noreply@purchasetree.com', Lang::get('alert.Escrow_Payment'));
                $message->to($email, 'Admin')->subject(Lang::get('alert.Escrow_Payment'));
            });
            $result= Lang::get("missing.Please_send_funds_via_wire_transfer_Your_invoice_number_is").$InvoiceNumber;
            return Response::json(['result' => 'success', 'message' => $result]);
        }
    }
    public function disputeDiv(){
        if(Request::ajax()){
            $rules = [
                'dispute_title' => 'required',
                'dispute_content' => 'required',
            ];
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return Response::json(['result' => 'failed', 'error' => $validator->getMessageBag()->toArray()]);
            } else {
                $escrow_dispute_id = Input::get('escrow_dispute_id');
                $title = Input::get('dispute_title');
                $contentDescription = Input::get('dispute_content');
                $escrow_really_table_id = $escrow_dispute_id - 100000;
                $escrow = EscrowEscrowModel::find($escrow_really_table_id);
                $content = new EscrowDisputeModel;
                $content->escrow_table_id = $escrow_really_table_id;
                $content->escrow_id = $escrow->escrow_id;
                $content->escrow_user_id = Session::get('escrow_user_id');
                $content->title = $title;
                $content->content = $contentDescription;
                $content->save();
                if ($escrow->status != 3) {
                    if ($escrow->confirm != 3) {
                        $escrow->confirm = 2;
                    }
                    $escrow->status = 3;
                    $escrow->save();
                }
                if ($escrow->seller__id == Session::get('escrow_user_id')) {
                    $userContent = EscrowUserModel::find($escrow->buyer_id);
                    $userSentContent = EscrowUserModel::find($escrow->seller_id);
                    $memberList = MembersModel::find($userSentContent->purchasetree_id);
                } elseif ($escrow->buyer_id == Session::get('escrow_user_id')) {
                    $userContent = EscrowUserModel::find($escrow->seller_id);
                    $userSentContent = EscrowUserModel::find($escrow->buyer_id);
                    $memberList = MembersModel::find($userSentContent->purchasetree_id);
                }

                $emails = [$userContent->useremail, $memberList->email, Admin_Email];
                $data = array(
                    'escrow_id' => $escrow->escrow_id,
                    'escrow_username' => $userSentContent->username,
                    'purchasetree_username' => $memberList->username,
                    'title' => $title,
                    'content' => $contentDescription,
                );
                Mail::send('emails.escrow.dispute', $data, function ($message) use ($emails) {
                    $message->from('noreply@purchasetree.com', Lang::get('alert.Dispute_Payment'));
                    $message->to($emails)->subject( Lang::get('alert.Dispute_Payment'));
                });
                $result = Lang::get("missing.Your_Message_has_been_sent");
                return Response::json(['result' => 'success', 'message' => $result]);
            }
        }
    }
    public function cancel(){
        $escrowID = Input::get('escrow_id');
        $reallyEscrowID = $escrowID-100000;
        $escrow = EscrowEscrowModel::find($reallyEscrowID);
        $escrow->cancelDate = date('Y-m-d');
        $escrow->status=4;
        $escrow->save();

        $alert['msg'] = Lang::get('alert.Your_escrow_canceled_successfully');
        $alert['type'] = "success";
        return Redirect::route('user.escrow.escrow', $escrow->escrow_id)->with('alert', $alert);
    }
    public function approved(){
        $escrowID = Input::get('escrow_id');
        $reallyEscrowID = $escrowID-100000;
        $escrow = EscrowEscrowModel::find($reallyEscrowID);
        $escrow->approvedDate = date('Y-m-d');
        $escrow->status=5;
        $escrow->save();

        $alert['msg'] = Lang::get('alert.Your_escrow_approved_successfully');
        $alert['type'] = "success";
        return Redirect::route('user.escrow.escrow', $escrow->escrow_id)->with('alert', $alert);
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
    /***********print*****************/
    function wirePrintButton($quote_id,$escrow_id){
        $quote_id = $quote_id-100000;
        $escrow_id = $escrow_id-100000;
        $accept = AcceptModel::whereRaw('quote_id=?', array($quote_id))->get();
        $quote = QuoteModel::find($quote_id);
        $fee = FeeModel::all();
        $priceFee = 1*1+($fee[0]->fee)/100*1;
        $price = $quote->price * $quote->rfq->rfq_quantity*$priceFee;
        $currencyID =$quote->price_currency;
        $currency = CurrencyModel::find($currencyID);
        $reallyPrice = round($this->converCurrency(strtoupper($currency->currency_name),$price),2);
        $escrowFee = EscrowAdminModel::all();
        $escrow = EscrowEscrowModel::find($escrow_id);
        if(count($escrowFee) > 0 && $escrowFee[0]->commission != ""){
            $totalPrice = round($reallyPrice*(1*1+($escrowFee[0]->commission/100)*1),2);
            $escrowFeePrice = $totalPrice - $reallyPrice;
        }else{
            $totalPrice = round($reallyPrice,2);
            $escrowFeePrice = 0;
        }
        $param['accept'] = $accept;
        $param['totalPrice'] = $totalPrice;
        $param['escrow'] = $escrow;
        return View::make('user.escrow.wirePrintButton')->with($param);
    }
    public function wirePrintButtonInstruction(){
        return View::make('user.escrow.wirePrintButtonInstruction');
    }


    public function shoppingCart(){
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $param['pageNo'] = 256;
        $param['carts'] = ShoppingCartModel::whereRaw('status >= 1')->orderBy('id','desc')->get();
        return View::make('user.escrow.shoppingCart')->with($param);
    }


    /*** shopping cart release part *****/

    public function shoppingCartRelease(){
        $shoppingCartProductID = Input::get('id');
        $reallyProductID = $shoppingCartProductID -100000;
        $shoppingCartProduct = ShoppingCartProductModel::find($reallyProductID);
        $shoppingCartProduct->stauts = 9;
        $shoppingCartProduct->save();
        $seller = $shoppingCartProduct->seller;
        $buyer = $shoppingCartProduct->buyer;
        $seller_email = $seller->email;
        $buyer_email  = $buyer->email;
        /** email send to seller */
        $user_type = "seller";
        $data =array();
        $data['subject']="Release escrow";
        $data[ 'shoppingCartProduct']    =$shoppingCartProduct;
        $data['user_type'] = $user_type;
        $data['seller'] = $seller;
        $data['buyer']  = $buyer;
        Mail::send('emails.escrow.release', $data, function($message) use ($seller_email){
            $message->from('noreply@purchasetree.com', Lang::get('alert.Release_escrow'));
            $message->to($seller_email, Lang::get('alert.Release_escrow'))->subject(Lang::get('alert.Release_escrow'));
        });
        /** email send to buyer */
         $data['user_type'] = "buyer";
        Mail::send('emails.escrow.release', $data, function($message) use ($buyer_email, $user_type){
            $message->from('noreply@purchasetree.com', Lang::get('alert.Release_escrow'));
            $message->to($buyer_email, Lang::get('alert.Release_escrow'))->subject(Lang::get('alert.Release_escrow'));
        });
        $data['user_type'] = "admin";
        $Admin_Email = Admin_Email;
        Mail::send('emails.escrow.release', $data, function($message) use ($Admin_Email,$user_type){
            $message->from('noreply@purchasetree.com', Lang::get('alert.Release_escrow'));
            $message->to($Admin_Email, Lang::get('alert.Release_escrow'))->subject(Lang::get('alert.Release_escrow'));
        });
        return Response::json(['result' =>'success']);
    }


    public function shoppingCartDisputePost(){
        if (!Session::has('escrow_user_id')) {
            return Redirect::route('user.escrow.login');
        }
        $shoppingCartProductID = Input::get('id');
        $reallyProductID = $shoppingCartProductID -100000;
        $shoppingCartProduct = ShoppingCartProductModel::find($reallyProductID);
        $shoppingCartProduct->stauts = 8;
        $shoppingCartProduct->save();

        $seller = $shoppingCartProduct->seller;
        $buyer = $shoppingCartProduct->buyer;
        $seller_email = $seller->email;
        $buyer_email  = $buyer->email;
        /** email send to seller */

        $user_type = "seller";
        $data =array();
        $data['subject']="Dispute escrow";
        $data[ 'shoppingCartProduct']    =$shoppingCartProduct;

        $data['user_type'] = $user_type;
        $data['seller'] = $seller;
        $data['buyer']  = $buyer;

        Mail::send('emails.escrow.cartDispute', $data, function($message) use ($seller_email){
            $message->from('noreply@purchasetree.com', Lang::get('alert.Dispute_Payment'));
            $message->to($seller_email, Lang::get('alert.Dispute_Payment'))->subject(Lang::get('alert.Dispute_Payment'));
        });
        /** email send to buyer */
        $data['user_type'] = "buyer";
        Mail::send('emails.escrow.cartDispute', $data, function($message) use ($buyer_email, $user_type){
            $message->from('noreply@purchasetree.com', Lang::get('alert.Dispute_Payment'));
            $message->to($buyer_email, Lang::get('alert.Dispute_Payment'))->subject(Lang::get('alert.Dispute_Payment'));
        });
        $data['user_type'] = "admin";
        $Admin_Email = Admin_Email;
        Mail::send('emails.escrow.cartDispute', $data, function($message) use ($Admin_Email,$user_type){
            $message->from('noreply@purchasetree.com', Lang::get('alert.Dispute_Payment'));
            $message->to($Admin_Email, Lang::get('alert.Dispute_Payment'))->subject(Lang::get('alert.Dispute_Payment'));
        });
        return Response::json(['result' =>'success','cart_id' =>$shoppingCartProductID]);
    }
    public function shoppingCartDispute($cartProductID){
        if (!Session::has('escrow_user_id')) {
            return Redirect::route('user.escrow.login');
        }
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $param['pageNo'] = 256;
        $reallyID = $cartProductID - 100000;
        $param['cartProduct'] = ShoppingCartProductModel::find($reallyID);
        $param['fee'] =(FeeModel::whereRaw(true)->first()->fee)/100;
        $param['seller'] = $param['cartProduct']->seller;
        $param['buyer'] = $param['cartProduct']->buyer;
        $param['disputeContents'] = ShoppingCartDisputeModel::where('cart_product_id',$reallyID)->get();
        return View::make('user.escrow.shoppingCartDispute')->with($param);
    }
    public function shoppingCartDisputeSendContent(){
        if (!Session::has('escrow_user_id')) {
            return Redirect::route('user.escrow.login');
        }
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
            $cartProductID = Input::get('cart_product_id');
            $reallyProductID = $cartProductID - 100000;
            $cartProduct = ShoppingCartProductModel::find($reallyProductID);
            if((Session::get('user_id') == $cartProduct->seller_id) || (Session::get('user_id') == $cartProduct->buyer_id)){
                $shoppingCartDisputeContent = new ShoppingCartDisputeModel();
                $shoppingCartDisputeContent->cart_product_id = $reallyProductID;
                $shoppingCartDisputeContent->cart_id = $cartProduct->ShoppingCart->id;
                $shoppingCartDisputeContent->sender_id = Session::get('user_id');
                $shoppingCartDisputeContent->title = Input::get('subject');
                $shoppingCartDisputeContent->content = Input::get('content');
                $data = array();
                $data['subject'] = Input::get('subject');
                $data['content'] = Input::get('content');
                $data['shoppingCartProduct'] = $cartProduct;
                if (Session::get('user_id') == $cartProduct->seller_id) {
                    $shoppingCartDisputeContent->receiver_id = $cartProduct->buyer_id;
                    $data['user_type'] = "seller";
                    $data['sender'] = "seller";
                    $data['receiver'] = "buyer";
                    $user = $cartProduct->buyer;
                    $sender = $cartProduct->seller;
                    $title = "Seller has been send message to buyer for dispute.";
                } else {
                    $shoppingCartDisputeContent->receiver_id = $cartProduct->seller_id;
                    $data['user_type'] = "buyer";
                    $data['sender'] = "buyer";
                    $data['receiver'] = "seller";
                    $user = $cartProduct->seller;
                    $sender = $cartProduct->buyer;
                    $title = "Buyer has been send message to seller for dispute.";
                }
                $shoppingCartDisputeContent->save();
                $data['user'] = $sender;
                $email = $user->email;
                Mail::send('emails.escrow.sendDisputeMessage', $data, function($message) use ($email){
                    $message->from('noreply@purchasetree.com', Lang::get('alert.Send_Dispute_Message'));
                    $message->to($email, Lang::get('alert.Send_Dispute_Message'))->subject(Lang::get('alert.Send_Dispute_Message'));
                });

                $email = Admin_Email;
                $data['user_type'] = "admin";
                Mail::send('emails.escrow.sendDisputeMessage', $data, function($message) use ($email, $title){
                    $message->from('noreply@purchasetree.com',$title);
                    $message->to($email, 'Send Message')->subject($title);
                });
                $alert['msg'] =  Lang::get('missing.Message_has_been_send_successfully');
                $alert['type'] = 'success';
            }else{
                $alert['msg'] = Lang::get('alert.You_can_not_send_message_in_this_page');
                $alert['type'] = 'success';
            }
            return Redirect::back()->with('alert',$alert);
        }
    }


    public function shoppingCartDisputeAgreement(){
        if (!Session::has('escrow_user_id')) {
            return Redirect::route('user.escrow.login');
        }
        $rules = [
          'message' =>'required'
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            $messages = ($validator->getMessageBag()->toArray());
            $list ="";
            foreach($messages as $message){
                if(count($message)>0){
                    $list .= $message[0];
                }
            }
           return Response::json(['result' =>'error', 'message' =>$list ]);
        }else {
            $dispute_type = Input::get('dispute_type');
            $cartProductID = Input::get('cart_product_id');
            $reallyCartProductID = $cartProductID - 100000;
            $cartProduct = ShoppingCartProductModel::find($reallyCartProductID);
            $content = Input::get('message');
            if($dispute_type == "agreement"){
                $cartProduct->status = 11;
                $cartProduct->save();
                $data = array(
                    'content' =>$content,
                    'shoppingCartProduct' =>$cartProduct,
                    'type' =>"agreement",
                );
                $email = Admin_Email;
                $title = "Agreement Mode";
                Mail::send('emails.escrow.agreementDispute', $data, function($message) use ($email, $title){
                    $message->from('noreply@purchasetree.com',$title);
                    $message->to($email, $title)->subject($title);
                });
            }elseif($dispute_type == "escalation"){
                $cartProduct->status = 12;
                $cartProduct->save();
                $data = array(
                    'content' =>$content,
                    'shoppingCartProduct' =>$cartProduct,
                    'type' =>"escalation",
                );
                $email = Admin_Email;
                $title = "Escalation Mode";
                Mail::send('emails.escrow.agreementDispute', $data, function($message) use ($email, $title){
                    $message->from('noreply@purchasetree.com',$title);
                    $message->to($email, $title)->subject($title);
                });

            }
            return Response::json(['result' =>'success','message' =>Lang::get('missing.Successfully')]);
        }


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