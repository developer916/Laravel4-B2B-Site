<?php

use Illuminate\Database\Eloquent\Model as Eloquent;
use Members as MembersModel, Product as ProductModel, Rfq as RfqModel, QuoteSample as QuoteSampleModel, Accept as AcceptModel,
    EscrowEscrow as EscrowEscrowModel, EscrowDispute as EscrowDisputeModel,ShoppingCart as ShoppingCartModel;
class Admin extends Eloquent {
    public static function getSignUp($day){

        $dateTime =date("Y-m-d H:i:s");

        $pastDateTime =  date('Y-m-d H:i:s', strtotime('-'.$day. ' days'));
        $members = "";
        if($day == 0){
            $nextDateTime = date('Y-m-d', strtotime('+1 days'));
            //$members = MembersModel::whereBetween('created_at',[$dateTime, $nextDateTime])->get();
            $currentDay = date("Y-m-d");
            $members = MembersModel::whereRaw('date(created_at) = ?', array($currentDay) )->get();
        }else{
            $members = MembersModel::whereBetween('created_at',[$pastDateTime, $dateTime])->get();
        }

        return count($members);
    }
    public static function getPending($day){
        $dateTime =date("Y-m-d H:i:s");
        $pastDateTime =  date('Y-m-d H:i:s', strtotime('-'.$day. ' days'));
        $members = "";
        if($day ==0){
            $currentDay = date("Y-m-d");
            $members = MembersModel::whereRaw(' sellrequest = ? and sellconfirm =? and date(created_at) = ?' , array(1,0,$currentDay))->orderBy('created_at','desc')->get();
        }else{
            $members = MembersModel::whereRaw(' sellrequest = ? and sellconfirm =?' , array(1,0))->whereBetween('created_at',[$pastDateTime, $dateTime])->get();
        }
        return count($members);
    }
    public static function getNewProduct($day){
        $dateTime =date("Y-m-d H:i:s");
        $pastDateTime =  date('Y-m-d H:i:s', strtotime('-'.$day. ' days'));
        $product = "";
        if($day ==0){
            $currentDay = date("Y-m-d");
            $products = ProductModel::whereRaw('date(created_at) = ?', array($currentDay) )->get();
        }else{
            $products = ProductModel::whereBetween('created_at',[$pastDateTime, $dateTime])->get();
        }
        return count($products);
    }

    public static function getNewRfq($day){
        $dateTime =date("Y-m-d H:i:s");
        $pastDateTime =  date('Y-m-d H:i:s', strtotime('-'.$day. ' days'));
        $rfqs = "";
        if($day ==0){
            $currentDay = date("Y-m-d");
            $rfqs = RfqModel::whereRaw('date(created_at) = ?', array($currentDay) )->get();
        }else{
            $rfqs = RfqModel::whereBetween('created_at',[$pastDateTime, $dateTime])->get();
        }
        return count($rfqs);
    }

    public static function getContract($day){
        $dateTime =date("Y-m-d H:i:s");
        $pastDateTime =  date('Y-m-d H:i:s', strtotime('-'.$day. ' days'));
        $account = 0;

        if($day ==0){
            $currentDay = date("Y-m-d");
            $sample = QuoteSampleModel::whereRaw('date(created_at) = ?', array($currentDay) )->get();
            $accept = AcceptModel::whereRaw('date(created_at) = ?', array($currentDay) )->get();

        }else{
            $sample = QuoteSampleModel::whereBetween('created_at',[$pastDateTime, $dateTime])->get();
            $accept = AcceptModel::whereBetween('created_at',[$pastDateTime, $dateTime])->get();
        }
        $account = count($sample) + count($accept);
        return $account;
    }
    public static function getNewEscrow($day){
        $dateTime =date("Y-m-d H:i:s");
        $pastDateTime =  date('Y-m-d H:i:s', strtotime('-'.$day. ' days'));
        $esrows = "";
        if($day ==0) {
            $currentDay = date("Y-m-d");
            $escrows = EscrowEscrowModel::whereRaw('date(created_at) = ?', array($currentDay))->get();
        }else{
            $escrows = EscrowEscrowModel::whereBetween('created_at',[$pastDateTime, $dateTime])->get();
        }
        return count($escrows);
    }

    public static function getNewShoppingCart($day){
        $dateTime =date("Y-m-d H:i:s");
        $pastDateTime =  date('Y-m-d H:i:s', strtotime('-'.$day. ' days'));
        if($day ==0) {
            $currentDay = date("Y-m-d");
            $shoppingCart = ShoppingCartModel::whereRaw('date(created_at) = ?', array($currentDay))->get();
        }else{
            $shoppingCart = ShoppingCartModel::whereBetween('created_at',[$pastDateTime, $dateTime])->get();
        }
        return count($shoppingCart);
    }

    public static function getDisputeEscrow($day){
        $dateTime =date("Y-m-d H:i:s");
        $pastDateTime =  date('Y-m-d H:i:s', strtotime('-'.$day. ' days'));
        $esrows = "";
        if($day ==0) {
            $currentDay = date("Y-m-d");
            $escrows = EscrowEscrowModel::whereRaw('date(created_at) = ? and status = ?', array($currentDay,3))->get();
        }else{
            $escrows = EscrowEscrowModel::whereRaw('status =?', array(3))->whereBetween('created_at',[$pastDateTime, $dateTime])->get();
        }
        return count($escrows);
    }


}