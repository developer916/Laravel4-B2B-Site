<?php namespace User;

use Illuminate\Routing\Controllers\Controller;
use View, Input, Redirect, Session, Validator, DB, Mail,File, Request,Response,Lang;
use Members as MembersModel, Rfq as RfqModel, Currency as CurrencyModel;
class BuyerController extends \BaseController {
    public function index(){
        $param['pageNo'] = 25;
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $param['subPageNo'] = 1;
        $param['title'] = Lang::get('user.my_orders');
        $param['subTitle'] = Lang::get('user.orders');
        return View::make('user.buyer.index')->with($param);
    }
    public function rfq($id){
        if(Session::has('user_id')){
            $listID = $id-100000;
            $param['pageNo'] = 25;
            $param['rfq'] = RfqModel::find($listID);
            $param['currencies']=CurrencyModel::find($param['rfq']->rfq_itemunit);
            return View::make('user.sellerbuyer.list')->with($param);
        }else{
            return Redirect::route('user.auth.login');
        }
    }
}