<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class GetCurrency extends Eloquent {

  public static function  getCurrencyFunction($from,$amount){
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
