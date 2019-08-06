<?php namespace Admin;

use Illuminate\Routing\Controllers\Controller;
use View, Input, Redirect, Session, Validator, DB,Request,Response,Mail;
use EscrowAdmin as EscrowAdminModel, EscrowPayment as EscrowPaymentModel, EscrowEscrow as EscrowEscrowModel,EscrowMessageTemplate as EscrowMessageTemplateModel,
    EscrowUser as EscrowUserModel, Country as CountryModel, EscrowPages as EscrowPagesModel, Quote as QuoteModel, Members as MembersModel,
    EscrowDispute as EscrowDisputeModel, Fee as FeeModel, Currency as CurrencyModel;
class EscrowController extends \BaseController
{

    public function __construct()
    {
        $this->beforeFilter(function () {
            if (!Session::has('admin_id')) {
                return Redirect::route('admin.auth.login');
            }
        });
    }
    public function commission(){
        $param['pageNo'] = 71;
        $param['commission'] = EscrowAdminModel::all();
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        return View::make('admin.escrow.commission.index')->with($param);
    }
    public function commissionEdit($id){
        $param['pageNo'] = 71;
        $param['commission'] = EscrowAdminModel::find($id);
        return View::make('admin.escrow.commission.edit')->with($param);
    }
    public function commissionStore(){
        $rules = ['commission'  => 'required|numeric'
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else{
            $commissionID =Input::get('commission_id');
            $commission = Input::get('commission');
            $list = EscrowAdminModel::find($commissionID);
            $list->commission = $commission;
            $list->save();
            $alert['msg']="Commission changed successfully.";
            $alert['type'] ='success';
            return Redirect::route('admin.escrow.commission')->with('alert', $alert);
        }
    }
    public function users(){
        $param['pageNo']=72;
        $param['escrowUsers'] = EscrowUserModel::all();
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        return View::make('admin.escrow.users.index')->with($param);
    }
    public function usersCreate(){
        $param['pageNo']=72;
        $param['country'] = CountryModel::whereRaw(true)->orderBy('country_name','asc')->get();
        return View::make('admin.escrow.users.create')->with($param);
    }
    public function usersEdit($id){
        $param['pageNo']=72;
        $param['country'] = CountryModel::whereRaw(true)->orderBy('country_name','asc')->get();
        $escrowUser = EscrowUserModel::find($id);
        $escrowUser->admin_active = 1;
        $escrowUser->save();
        $param['escrowUser'] = EscrowUserModel::find($id);
        $param['userCountry'] =CountryModel::find($param['escrowUser']->usercountry);
        return View::make('admin.escrow.users.edit')->with($param);
    }
    public function usersStore(){
        if (Input::has('escrow_member_id')) {
            $rules = [
                'username'  => 'required ',
                'password'  => 'required |confirmed',
                'password_confirmation' =>'required',
                'email' => 'required |email',
            ];
        }else{
            $rules = [
                'purchasetree_username' =>'required',
                'purchasetree_userpassword'=>'required',
                'username'  => 'required |unique:escrow_users',
                'password'  => 'required |confirmed',
                'password_confirmation' =>'required',
                'email' => 'required |email | unique:escrow_users',
            ];
        }
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else{
            $escrowMemberUserID = Input::get('escrow_member_id');
            if($escrowMemberUserID ==""){
                $username = Input::get('purchasetree_username');
                $password = Input::get('purchasetree_userpassword');
                $list = MembersModel::whereRaw('username = ? and userpassword = md5(?) and status = ?', array($username, $password, '1'))->get();
                if(count($list)>0){
                    if($escrowMemberUserID != "") {
                        $escrowUser = EscrowUserModel::find($escrowMemberUserID);
                    }else{
                        $escrowUser = new EscrowUserModel;
                    }
                    $purchasetreID = $list[0]->id;
                }else{
                    $listEmail = MembersModel::whereRaw('email = ? and userpassword = md5(?) and status = ?', array($username, $password, '1'))->get();
                    if(count($listEmail)>0){
                        if($escrowMemberUserID != "") {
                            $escrowUser = EscrowUserModel::find($escrowMemberUserID);
                        }else{
                            $escrowUser = new EscrowUserModel;
                        }

                        $purchasetreID = $listEmail[0]->id;
                    }else{
                        $alert['msg'] = 'Please insert correct purchasetree  login information.';
                        $alert['type'] = 'danger';
                        return Redirect::route('admin.escrow.users.create')->with('alert', $alert);
                    }
                }
            }else{
                $escrowUser = EscrowUserModel::find($escrowMemberUserID);
                $purchasetreID = $escrowUser->purchasetree_id;
            }
            $password = Input::get('password');
            $email = Input::get('email');
            $escrowUser->purchasetree_id = $purchasetreID;
            $escrowUser->username= Input::get('username');
            $escrowUser->userpass= md5(Input::get('password'));
            $escrowUser->userfullname= Input::get('full_name');
            $escrowUser->useremail= Input::get('email');
            $escrowUser->userbusiness= Input::get('business_name');
            $escrowUser->useraddress1= Input::get('address1');
            $escrowUser->useraddress2= Input::get('address2');
            $escrowUser->usercity= Input::get('city');
            $escrowUser->userstate= Input::get('state_province');
            $escrowUser->userzip= Input::get('postal_code');
            $escrowUser->usercountry= Input::get('country');
            $escrowUser->paymentaccepttype= Input::get('payment');
            $escrowUser->registrationdate=date('Y-m-d H:i:s');
            $escrowUser->admin_active = 1;
            $escrowUser->save();
            $alert['msg'] = 'User has been saved successfully';
            $alert['type'] = 'success';
            $data = array(
                'email'    =>$email,
                'content' =>"Your escrow account created by admin. You can use escrow part for your business",
                'password' =>$password,
                'username' =>Input::get('username')
            );
            Mail::send('emails.admin.escrowAccount', $data, function($message) use ($email){
                $message->from('noreply@purchasetree.com', 'Created Escrow Account');
                $message->to($email, 'User')->subject('Created Escrow Account');
            });
            return Redirect::route('admin.escrow.users')->with('alert', $alert);
        }
    }
    public function usersDelete($id){
        try {
            EscrowUserModel::find($id)->delete();
            $alert['msg'] = 'This escrow user  has been deleted successfully';
            $alert['type'] = 'success';
        } catch(\Exception $ex) {
            $alert['msg'] = 'This escrow user has been already used';
            $alert['type'] = 'danger';
        }
        return Redirect::route('admin.escrow.users')->with('alert', $alert);
    }

     public function pages(){
        $param['pageNo'] = 73;
         if ($alert = Session::get('alert')) {
             $param['alert'] = $alert;
         }
         $param['pages'] = EscrowPagesModel::all();
         return View::make('admin.escrow.pages.index')->with($param);
     }
    public function pagesCreate(){
        $param['pageNo'] = 73;
        return View::make('admin.escrow.pages.create')->with($param);
    }
    public  function pagesStore(){
        $rules = ['page_name'  => 'required',
            'realContent' => 'required',
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else{
            if(Input::has('page_id')){
                $page_id = Input::get('page_id');
                $escrowPage = EscrowPagesModel::find($page_id);
            }else{
                $escrowPage = new EscrowPagesModel;
            }
            $escrowPage->page_name = Input::get('page_name');
            $escrowPage->page_content = Input::get('realContent');
            $escrowPage->save();
            $alert['msg'] = "Escrow page saved successfully.";
            $alert['type'] = "success";
            return Redirect::route('admin.escrow.pages')->with('alert',$alert);
        }
    }
    public function pagesEdit($id){
        $param['pageNo'] = 73;
        $param['pages'] = EscrowPagesModel::find($id);
        return View::make('admin.escrow.pages.edit')->with($param);
    }
    public function  payments(){
        $param['pageNo'] = 74;
        $param['allPayment'] = EscrowEscrowModel::all();
        $param['waitingPayment'] = EscrowEscrowModel::whereRaw('status = 1')->get();
        $param['escrowPayment'] = EscrowEscrowModel::whereRaw('status = 2')->get();
        $param['cancelPayment'] = EscrowEscrowModel::whereRaw('status = 4')->get();
        $param['disputePayment'] = EscrowEscrowModel::whereRaw('status = 3')->get();
        $param['approvePayment'] = EscrowEscrowModel::whereRaw('status = 5')->get();
        $param['emailSend'] = EscrowMessageTemplateModel::whereRaw('type =?', array('email'))->get();
        return view::make('admin.escrow.escrow.index')->with($param);
    }
    public function paymentsConfirm(){
        if(Request::ajax()){
            $id = Input::get('id');
            $escrow = EscrowEscrowModel::find($id);
            if($escrow->confirm == 0){
                $confirm = 1;
            }else{
                $confirm = 0;
            }
            $escrow->confirm = $confirm;
            $escrow->confirmDate = date('Y-m-d');
            $escrow->save();
            if( $confirm == 1){
                $quote= QuoteModel::find($escrow->quote_id);
                $sellerEmail = $quote->sellerMember->email;
                $buyerEmail = $quote->buyerMember->email;
                $data = array(
                    'content' =>"Escrow payment approved by admin. This payment status changed from pending to escrow.",
                    'escrow_id' => $escrow->escrow_id,
                );
                Mail::send('emails.admin.pending', $data, function($message) use ($sellerEmail){
                    $message->from('noreply@purchasetree.com', 'Approved payment by admin');
                    $message->to($sellerEmail)->subject('Approved payment by admin');
                });
                Mail::send('emails.admin.pending', $data, function($message) use ($buyerEmail){
                    $message->from('noreply@purchasetree.com', 'Approved payment by admin');
                    $message->to($buyerEmail)->subject('Approved payment by admin');
                });
            }
            $data = "Escrow confirm saved successfully.";
            return Response::json(['result' =>'success', 'content' =>$data]);
        }
    }
    Public function disputeSolve(){
        if(Request::ajax()) {
            $id = Input::get('id');
            $escrow = EscrowEscrowModel::find($id);
            if ($escrow->confirm == 2) {
                $confirm = 3;
            } elseif($escrow->confirm == 3) {
                $confirm = 2;
            }
            $escrow->confirm = $confirm;
            $escrow->save();
            if( $confirm == 3){
                $quote= QuoteModel::find($escrow->quote_id);
                $sellerEmail = $quote->sellerMember->email;
                $buyerEmail = $quote->buyerMember->email;
                $data = array(
                    'content' =>"Dispute has been solved  by admin.",
                    'escrow_id' => $escrow->escrow_id,
                );
                Mail::send('emails.admin.dispute', $data, function($message) use ($sellerEmail){
                    $message->from('noreply@purchasetree.com', 'Dispute Payment Solved  by Admin');
                    $message->to($sellerEmail)->subject('Dispute Payment Solved  by Admin');
                });
                Mail::send('emails.admin.dispute', $data, function($message) use ($buyerEmail){
                    $message->from('noreply@purchasetree.com', 'Dispute Payment Solved  by Admin');
                    $message->to($buyerEmail)->subject('Dispute Payment Solved  by Admin');
                });
                $data = "Escrow dispute has been solved.";
            }else{
                $data = "Escrow  has been dispute state.";
            }
            return Response::json(['result' =>'success', 'content' =>$data]);
        }
    }
    public function paymentEscrowEdit(){
        $invoice_number = Input::get('invoice_number');
        $paid_payment = Input::get('paid_price');
        $escrow_id = Input::get('escrow_id');
        $escrow = EscrowEscrowModel::find($escrow_id);
        $escrow->invoice_number = $invoice_number;
        $escrow->total = $paid_payment;
        $escrow->escrowDate = date('Y-m-d');
        $escrow->save();
        return Response::json(['result' =>'success']);
    }
    public function getPaymentEscrowEdit(){
        $id = Input::get('id');
        $escrow = EscrowEscrowModel::find($id);
        return Response::json(['result' =>'success', 'content' =>$escrow]);
    }
    public function getUserEmailAddress(){
        $id = Input::get('id');
        $escrow = EscrowEscrowModel::find($id);
        $buyerId = $escrow->buyer_id;
        $email = EscrowUserModel::find($buyerId);
        return Response::json(['result' =>'success', 'content' => $email, 'escrow_id' => $id]);
    }
    public function sendUserEmailAddress(){
        $rules = [
            'content' => 'required',
        ];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Response::json(['result' => 'failed', 'error' => $validator->getMessageBag()->toArray()]);
        }else{
            $id = Input::get('escrow_id');
            $escrow = EscrowEscrowModel::find($id);
            $buyerId = $escrow->buyer_id;
            $emailLst = EscrowUserModel::find($buyerId);
            $member = MembersModel::find($emailLst->purchasetree_id);
            $emails =[$emailLst->useremail,$member->email];
            $content = Input::get('content');
            $list = EscrowMessageTemplateModel::find($content);
            $data = array(
                'escrow_id' => $escrow->escrow_id,
                'admin_username' =>Admin_Email,
                'content' =>$list->content,
                'title' => $list->title

            );
            $title = $list->title;
            Mail::send('emails.admin.escrowProblem', $data, function($message) use ($emails, $title)
            {
                $message->from('noreply@purchasetree.com', $title);
                $message->to($emails, 'Admin')->subject($title);
            });
            return Response::json(['result' =>'success']);
        }
    }
    public function dispute($id){
        $param['pageNo'] = 74;
        $param['escrow'] = EscrowEscrowModel::find($id);
        $escrow = $param['escrow'];
        $quote= QuoteModel::find($escrow->quote_id);
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
        $buyerCountry = CountryModel::find($escrow->buyerMember->usercountry);
        $sellerCountry = CountryModel::find($escrow->sellerMember->usercountry);
        $param['buyerPurchasetree'] = MembersModel::find($escrow->buyerMember->purchasetree_id);
        $param['sellerPurchasetree'] = MembersModel::find($escrow->sellerMember->purchasetree_id);
        $param['buyerCountry'] = $buyerCountry;
        $param['sellerCountry'] = $sellerCountry;
        $param['totalPrice'] = $totalPrice;
        $param['escrowFeePrice'] = $escrowFeePrice;
        $param['reallyPrice'] =$reallyPrice;
        $param['disputeContent'] = EscrowDisputeModel::whereRaw('escrow_table_id=?',array($id))->get();
        $param['disputeID'] = $id;
        return View::make('admin.escrow.escrow.dispute')->with($param);
    }
    public function sendDisputeEmail(){
        $rules = [
            'userType' => 'required',
            'title' => 'required',
            'message' => 'required',
        ];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Response::json(['result' => 'failed', 'error' => $validator->getMessageBag()->toArray()]);
        }else{
            $escrow_id = Input::get('escrow_id');
            $escrow = EscrowEscrowModel::find($escrow_id);
            $userType = Input::get('userType');
            $escrowBuyerEmail = $escrow->buyerMember->useremail;
            $escrowSellerEmail = $escrow->sellerMember->useremail;
            $escrowDispute =  new EscrowDisputeModel;
            $escrowDispute ->escrow_table_id  = $escrow_id;
            $escrowDispute ->escrow_id  = $escrow->escrow_id;
            $escrowDispute ->title  = Input::get('title');
            $escrowDispute ->content  = Input::get('message');
            $escrowDispute ->escrow_user_id  = 0;
            $escrowDispute->save();
            $data = array(
                 'title' => Input::get('title'),
                'content' =>Input::get('message'),
                'escrow_id' => $escrow->escrow_id,
                'admin_username' =>Admin_Email,
            );
            $title = Input::get('title');
            if($userType == 'seller'){
                $emails = [$escrowSellerEmail];
                Mail::send('emails.admin.escrowProblem', $data, function($message) use ($emails, $title)
                {
                    $message->from('noreply@purchasetree.com', $title);
                    $message->to($emails, 'Admin')->subject($title);
                });
            }else if($userType == 'buyer'){
                $emails = [$escrowBuyerEmail];
                Mail::send('emails.admin.escrowProblem', $data, function($message) use ($emails, $title)
                {
                    $message->from('noreply@purchasetree.com', $title);
                    $message->to($emails, 'Admin')->subject($title);
                });
            }else if($userType == 'both'){
                Mail::send('emails.admin.escrowProblem', $data, function($message) use ($escrowSellerEmail, $title)
                {
                    $message->from('noreply@purchasetree.com', $title);
                    $message->to($escrowSellerEmail, 'Admin')->subject($title);
                });
                Mail::send('emails.admin.escrowProblem', $data, function($message) use ($escrowBuyerEmail, $title)
                {
                    $message->from('noreply@purchasetree.com', $title);
                    $message->to($escrowBuyerEmail, 'Admin')->subject($title);
                });
            }
            return Response::json(['result' => 'success']);

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