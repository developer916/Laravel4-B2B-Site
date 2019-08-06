<?php namespace User;

use Illuminate\Routing\Controllers\Controller;

use View, Input, Redirect, Session, Validator, DB, Mail,File, Request,Response,Lang,SoapClient,URL,Cart;
use Members as MembersModel, Country as CountryModel,CompanyProfile as CompanyProfileModel, EmailSend as EmailSendModel,Rfq as RfqModel,
    RfqPicture as RfqPictureModel,RfqFile as RfqFileModel,RfqSpe as RfqSpeModel,RfqSpePicture as RfqSpePictureModel,Email as EmailModel,
    Currency as CurrencyModel,Unit as UnitModel, Quote as QuoteModel, QuoteNote as QuoteNoteModel, QuotePicture as QuotePictureModel,
    QuoteSpe as QuoteSpeModel,RfqEmail as RfqEmailModel, QuoteSample as QuoteSampleModel,Fee as FeeModel, Accept as AcceptModel,
    Product as ProductModel, ProductPicture as ProductPictureModel,ShoppingCartEmail as ShoppingCartEmailModel,
    EscrowUser as  EscrowUserModel,EscrowEscrow as EscrowEscrowModel,ShoppingCartProduct as ShoppingCartProductModel;
class SellerBuyerController  extends \BaseController {
    public function __construct()
    {
        $this->beforeFilter(function () {
            if (!Session::has('user_id')) {
                return Redirect::route('user.auth.login');
            }
        });
    }
    public function acceptInvoice($id){
        $param['pageNo'] =135;
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }

        $listID = $id-100000;
        $acceptList = AcceptModel::whereRaw('quote_id=?', array($listID))->get();
        if(count($acceptList) == 0){
            return Redirect::route('user.home');
        }else{
            $param['accept'] = $acceptList;
        }
        $user_id = Session::get('user_id');
        $member = MembersModel::find($user_id);
        $quote = QuoteModel::find($listID);
        $rfq = RfqModel::find($quote->rfq_id);
        $param['buyerCountry']= CountryModel::find($quote->buyerMember->country_id);
        $param['sellerCountry']= CountryModel::find($quote->sellerMember->country_id);
        $verticalFee = FeeModel::all();
        $param['verticalFee']=($verticalFee[0]->fee/100)*1+1;
        $param['quote'] = $quote;
        if($quote->seller_id == $user_id){
            $param['memberCheck'] = 1;
        }else{
            $param['memberCheck'] = 0;
        }
        $param['member'] = $member;

        $param['rfq'] = RfqModel::find($quote->rfq_id);
        $unit = UnitModel::find($quote->unit);
        $priceCurrency = CurrencyModel::find($quote->price_currency);
        $param['priceCurrency'] = $priceCurrency;
        if($param['memberCheck'] == 0){
            $total = $rfq->rfq_quantity * $quote->price * $param['verticalFee'];
            $totalProductPrice =  $this->converCurrency(strtoupper($priceCurrency->currency_name),$total);
            $param['price'] = $quote->price*$param['verticalFee'];
        }else{
            $total = $rfq->rfq_quantity * $quote->price;
            $totalProductPrice =  $this->converCurrency(strtoupper($priceCurrency->currency_name),$total);
            $param['price'] = $quote->price;
        }
        $param['totalProduct'] = round($totalProductPrice,2);;
        $param['total'] = round($total,2);
        $param['unit'] = $unit;
        $param['buyerCountry']= CountryModel::find($quote->buyerMember->country_id);
        $param['sellerCountry']= CountryModel::find($quote->sellerMember->country_id);
        return View::make('user.sellerbuyer.acceptInvoice')->with($param);
    }
    public function invoice($id){
        $param['pageNo'] =135;
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $listID = $id-100000;
        $user_id = Session::get('user_id');
        $member = MembersModel::find($user_id);
        $quote = QuoteModel::find($listID);
        $param['buyerCountry']= CountryModel::find($quote->buyerMember->country_id);
        $param['sellerCountry']= CountryModel::find($quote->sellerMember->country_id);
        $verticalFee = FeeModel::all();
        $param['verticalFee']=($verticalFee[0]->fee/100)*1+1;
        if($quote->seller_id == $user_id){
            $param['memberCheck'] = 1;
        }else{
            $param['memberCheck'] = 0;
        }
        if($param['memberCheck'] == 0){
            $quoteSample1  = QuoteSampleModel::whereRaw('quote_id =? and buyer_id =?', array($listID,$user_id))->get();
        }else{
            $quoteSample1  = QuoteSampleModel::whereRaw('quote_id =? and seller_id =?', array($listID,$user_id))->get();
        }
        $param['member'] = $member;
        $param['quote'] = $quote;
        $param['quoteSample'] = $quoteSample1[0];
        if($quote->sample_price){
            $productItemPrice= $quote->sample_price;
            $productPrice = $quote->sample_price*$param['quoteSample']->sampleamount;
            $sellerPriceRequestUnitList = CurrencyModel::find($quote->sample_price_currency);
            $sellerPriceRequestUnit = $sellerPriceRequestUnitList->currency_name;
        }else{
            $productPrice = $quote->price*$param['quoteSample']->sampleamount;
            $productItemPrice= $quote->price;
            $sellerPriceRequestUnitList = CurrencyModel::find($quote->price_currency);
            $sellerPriceRequestUnit = $sellerPriceRequestUnitList->currency_name;
        }
        $totalShippingPrice = round($param['quoteSample']->shippingprice*$param['verticalFee'],1);
        if($param['memberCheck'] == 0){
            $productPrice  = round($productPrice*$param['verticalFee'],1);
            $productItemPrice = round($productItemPrice*$param['verticalFee'],1);
            $totalProductPrice =  $this->converCurrency(strtoupper($sellerPriceRequestUnit),$productPrice);
            $totalproduct = round($totalProductPrice*1,1);
            $total =  ($totalProductPrice +$totalShippingPrice);
        }else{
            $totalProductPrice =  $this->converCurrency(strtoupper($sellerPriceRequestUnit),$productPrice);
            $totalproduct = round($totalProductPrice,1);
            $total =  ($totalProductPrice + $totalShippingPrice);
        }
        $param['total'] = round($total,1);
        $param['prodcutPrice'] = $productPrice;
        $param['productUnit'] = $sellerPriceRequestUnit;
        $param['productItemPrice'] =$productItemPrice;
        $param['totalProduct'] = round($totalproduct,1);
        $param['totalShipping'] =$totalShippingPrice;

        return View::make('user.sellerbuyer.invoice')->with($param);
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


    public function dashboardIndex(){
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
    public function cartDocument(){
        $id = Input::get('id');
        $product_id = $id-100000;
        $shoppingCartProduct = ShoppingCartProductModel::find($product_id);
        $cart = $shoppingCartProduct->ShoppingCart;
        $fee = FeeModel::whereRaw(true)->first()->fee;

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
        $list .='<a href="'.URL::route('user.buyer.cart.email',$id).'" target ="_blank">'.Lang::get('user.email').' '.Lang::get('user.to_seller').'</a>';
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
        $list .= round($shoppingCartProduct->sub_total* (1+$fee/100),2) ."USD";
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
            $list .=round($shoppingCartProduct->sub_total* (1+$fee/100),2) ."USD";
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
            $list .=round($shoppingCartProduct->sub_total* (1+$fee/100),2) ."USD";
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

    public function cartEmail($id){

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
        $shoppingCartProductID = $id - 100000;
        $shoppingCartProduct = ShoppingCartProductModel::find($shoppingCartProductID);
        $cartMails = ShoppingCartEmailModel::whereRaw('shopping_cart_product_id=?',array($shoppingCartProductID))
            ->where( function ($query) use ($user_id) {
                $query->where('sender_id', '=', $user_id)->orWhere('receiver_id', '=', $user_id);
            })->get();
        $param['cartMails'] = $cartMails;
        $param['shoppingCart'] = $shoppingCartProduct->ShoppingCart;
        $param['shoppingCartProduct'] = $shoppingCartProduct;
        $param['seller']  = $shoppingCartProduct->seller;
        $param['user_id'] = Session::get('user_id');
        $param['id'] = $id;
        $param['emailCount'] = count($emailList);
        return View::make('user.buyer.cartEmail')->with($param);
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
                $message->to($email,  Lang::get('alert.Send_Message'))->subject( Lang::get('alert.Send_Message'));
            });
            $message = Lang::get('missing.Message_has_been_send_successfully');
            return Response::json(['result' => 'success', 'error' => $message]);
        }
    }
    public function cartOrders(){
        $id = Input::get('id');
        $cartProductID = $id -100000;
        $cartProduct = ShoppingCartProductModel::find($cartProductID);
        $product = ProductModel::find($cartProduct->product_id);
        $list ='';
        $list .='<div class="row">';
        $list .='<div class="col-md-12">';
        $list .='<div class="form-horizontal">';
        $list .='<div class="form-group">';
        $list.='<div class="col-md-4 col-sm-4 col-xs-12">';
        $list.='<img src="'.$cartProduct->image_url.'" style="width:100%">';
        $list .='</div>';
        $list.='<div class="col-md-8 col-sm-8 col-xs-12">';
        $list.='<div class="row margin-bottom-20">';
        $list .='<div class="col-md-4 col-sm-4 col-xs-5">';
        $list.=Lang::get('user.rfq_product_name');
        $list.='</div>';
        $list .='<div class="col-md-8 col-sm-8 col-xs-7">';
        $list.=$product->product_name;
        $list.='</div>';
        $list.='</div>';
        $list.='<div class="row margin-bottom-20">';
        $list .='<div class="col-md-4 col-sm-4 col-xs-5">';
        $list.=Lang::get('user.product_size');
        $list.='</div>';
        $list .='<div class="col-md-8 col-sm-8 col-xs-7">';
        $list.=$cartProduct->size;
        $list.='</div>';
        $list.='</div>';
        $list.='<div class="row margin-bottom-20">';
        $list .='<div class="col-md-4 col-sm-4 col-xs-5">';
        $list.=Lang::get('user.color');
        $list.='</div>';
        $list .='<div class="col-md-8 col-sm-8 col-xs-7">';
        $list.=$cartProduct->color;
        $list.='</div>';
        $list.='</div>';
        $list.='<div class="row margin-bottom-20">';
        $list .='<div class="col-md-4 col-sm-4 col-xs-5">';
        $list.=Lang::get('user.quantity');
        $list.='</div>';
        $list .='<div class="col-md-8 col-sm-8 col-xs-7">';
        $list.=$cartProduct->qty." ".$cartProduct->unit;
        $list.='</div>';
        $list.='</div>';

        $list.='<div class="row margin-bottom-20">';
        $list .='<div class="col-md-4 col-sm-4 col-xs-5">';
        $list.=Lang::get('user.price');
        $list.='</div>';
        $list .='<div class="col-md-8 col-sm-8 col-xs-7">';
        $list.="$ ".$cartProduct->product_price."<br>";
        if($cartProduct->shipping_price !=""){
            $list.="+$ ".$cartProduct->shipping_price;
        }
        $list.='</div>';
        $list.='</div>';
        $list.='<div class="row margin-bottom-20">';
        $list .='<div class="col-md-4 col-sm-4 col-xs-5">';
        $list.=Lang::get('user.subtotal');
        $list.='</div>';
        $list .='<div class="col-md-8 col-sm-8 col-xs-7">';
        $list.="$ ".$cartProduct->sub_total;
        $list.='</div>';
        $list.='</div>';

        $list .='</div>';
        $list .='</div>';
        $list .='</div>';
        $list .='</div>';
        $list .='</div>';
        $title = Lang::get('user.shopping_cart_order') ." ". $product->product_name;
        $data =array('result'=>'success', 'content' =>$list, 'title' =>$title);
        return Response::json($data);
    }
    public function getStatus(){
        $id = Input::get('id');
        $product_id = $id - 100000;
        $shoppingProduct = ShoppingCartProductModel::find($product_id);

        if($shoppingProduct->seller_id == Session::get('user_id')){
            if($shoppingProduct->status == 4) {
                $content = "<p>This product is sending to the buyer. When buyer get product, you can get funds from buyer.</p>";
            }elseif($shoppingProduct->status == 1){
                $content = "<p>Buyer bought this product.</p>";
            }elseif($shoppingProduct->status == 2){
                $content = "<p>Buyer has been made escrow for  this product. Please send product to buyer</p>";
            }elseif($shoppingProduct->status == 3){
                $content = "<pYou have to send product.</p>";
            }elseif($shoppingProduct->status == 5){
                $content = "<p> Buyer has been get this product.</p>";
            }else{
                $content = "<p> Shipping part was passed</p>";
            }
        }else{
            if($shoppingProduct->status == 4){
                $content = "<p>Seller has been send product to you. If you have get product, Please confirm about that.</p>";
            }elseif($shoppingProduct->status == 1){
                $content = "<p>You bought this product. If you want to get this product from seller, you have to make escrow for this product.</p>";
            }elseif($shoppingProduct->status == 2){
                $content = "<p>You has been made escrow for this product.</p>";
            }elseif($shoppingProduct->status == 3){
                $content = "<p>Seller is sending product to you.</p>";
            }elseif($shoppingProduct->status == 5){
                $content = "<p> You has been get this product.</p>";
            }else{
                $content = "<p> Shipping part was passed</p>";
            }
        }
        return Response::json(['result' =>'success', 'content' =>$content,'title' =>Lang::get('missing.Product_Sending'),'id' =>$id]);
    }
    public function getConfirm(){
        $id = Input::get('id');
        $product_id = $id - 100000;
        $shoppingProduct = ShoppingCartProductModel::find($product_id);
        $shoppingProduct->status =5;
        $shoppingProduct->save();
        $seller = $shoppingProduct->seller;
        $buyer = $shoppingProduct->buyer;
        $email = $seller->email;
        $data = array(
            'buyer_name' =>$buyer->username,
        );
        Mail::send('emails.buyer.sendProductConfirm', $data, function($message) use ($email){
            $message->from('noreply@purchasetree.com', Lang::get('alert.Confirm_Product'));
            $message->to($email, Lang::get('alert.Confirm_Product'))->subject(Lang::get('alert.Confirm_Product'));
        });



        return Response::json(['result' =>'success']);
    }
    public function cartEscrow(){
        $id = Input::get('id');
        $cartProductID = $id -100000;
        $cartProduct = ShoppingCartProductModel::find($cartProductID);
        $product = ProductModel::find($cartProduct->product_id);
        $list = '';

        if($cartProduct->status >= 2) {
            if($cartProduct->seller_id == Session::get('user_id')){
                $title = Lang::get('user.shopping_cart_escrow');
            }else{
                $title = Lang::get('user.shopping_cart_escrow_buyer');
            }

            $list .='<div class="row">';
            $list .='<div class="col-md-12">';
                $list .='<div class="form-horizontal">';

                    $list .='<div class="form-group">';
                        $list .='<label class="col-md-4 col-sm-4 col-xs-5">';
                        $list.=Lang::get('user.rfq_product_name');
                        $list.='</label>';
                        $list .='<div class="col-md-8 col-sm-8 col-xs-7">';
                        $list.=$product->product_name;
                        $list.='</div>';
                    $list.='</div>';


            if($cartProduct->size !=""){
                $list .='<div class="form-group">';
                $list .='<label class="col-md-4 col-sm-4 col-xs-5">';
                $list.=Lang::get('user.product_size');
                $list.='</label>';
                $list .='<div class="col-md-8 col-sm-8 col-xs-7">';
                $list.=$cartProduct->size;
                $list.='</div>';
                $list.='</div>';
            }


            if($cartProduct->color !="") {
                $list .= '<div class="form-group">';
                $list .= '<label class="col-md-4 col-sm-4 col-xs-5">';
                $list .= Lang::get('user.color');
                $list .= '</label>';
                $list .= '<div class="col-md-8 col-sm-8 col-xs-7">';
                $list .= $cartProduct->color;
                $list .= '</div>';
                $list .= '</div>';
            }

            $list .='<div class="form-group">';
            $list .='<label class="col-md-4 col-sm-4 col-xs-5">';
            $list.=Lang::get('user.quantity');
            $list.='</label>';
            $list .='<div class="col-md-8 col-sm-8 col-xs-7">';
            $list.=$cartProduct->qty." ".$cartProduct->unit;
            $list.='</div>';
            $list.='</div>';

            $list .='<div class="form-group">';
            $list .='<label class="col-md-4 col-sm-4 col-xs-5">';
            $list.=Lang::get('user.price');
            $list.='</label>';
            $list .='<div class="col-md-8 col-sm-8 col-xs-7">';
            $list.="$ ".$cartProduct->product_price."<br>";
            if($cartProduct->shipping_price !=""){
                $list.="+$ ".$cartProduct->shipping_price;
            }
            $list.='</div>';
            $list.='</div>';


            $list .='<div class="form-group">';
            $list .='<label class="col-md-4 col-sm-4 col-xs-5">';
            $list.=Lang::get('user.subtotal');
            $list.='</label>';
            $list .='<div class="col-md-8 col-sm-8 col-xs-7">';
            $list.="$ ".$cartProduct->sub_total;
            $list.='</div>';
            $list.='</div>';



                $list.='</div>';
            $list.='</div>';
            $list.='</div>';


            $data =array('result'=>'success', 'content' =>$list, 'title' =>$title);
        }else{
            $data =array('result'=>'failed','message' =>Lang::get('missing.This_money_is_not_in_the_escrow'));
        }
        return Response::json($data);
    }






}