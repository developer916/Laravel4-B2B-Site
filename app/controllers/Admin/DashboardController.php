<?php namespace Admin;

use Illuminate\Routing\Controllers\Controller;
use View, Input, Redirect, Session, Validator;
use Bargain as BargainModel, Product as ProductModel, Members as MembersModel, Rfq as RfqModel, Quote as QuoteModel,Category as CategoryModel,
    QuoteSample as QuoteSampleModel, Accept as AcceptModel,CompanyProfile as CompanyProfileModel,Fee as FeeModel;
class DashboardController extends \BaseController {

    public function __construct() {
        $this->beforeFilter(function(){
            if (!Session::has('admin_id')) {
                return Redirect::route('admin.auth.login');
            }
        });
    }

    public function index() {
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $param['pageNo'] = 1;
        $param['members'] = MembersModel::whereRaw(' sellrequest = ? and sellconfirm =?' , array(1,0))->orderBy('created_at','desc')->get();
        $param['rfq'] = RfqModel::whereRaw(true)->orderBy('created_at', 'desc')->paginate(20);
        $param['contract'] =QuoteModel::whereRaw(true)->orderBy('created_at', 'desc')->paginate(20);
        $param['categories'] = CategoryModel::whereRaw(true)->orderBy('created_at', 'desc')->get();
        $param['countTotalMember'] = (MembersModel::all());
        $param['countSellerMember'] =(MembersModel::whereRaw('usertype =? or usertype =?', array(1,3))->get());
        $param['countBuyerMember'] = (MembersModel::whereRaw('usertype =? or usertype =?', array(3,2))->get());

        $countTotalCategory = 0;
        $categories = $param['categories'];
        foreach ($categories as $key_category => $value_category){
            $countTotalCategory = $countTotalCategory+1;
            $subCategories = $value_category->subCategories();
            $countTotalCategory = $countTotalCategory + count($subCategories);
        }
        $param['countTotalCategory'] = $countTotalCategory;
        $param['Rfq'] = RfqModel::all();
        $param['totalContracts'] = count(QuoteSampleModel::all()) + count(AcceptModel::all());
        return View::make('admin.dashboard.index')->with($param);
    }

    public function searchResult(){
        $rules = [
            'search' =>'required',
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else {
            $search = Input::get('search');
            $show = Input::get('show');
            $search_in = Input::get('search_in');
            $category = Input::get('category');
            $searchResult1 = "";
            $fee = "";
            if($search_in == "rfq"){
                $searchResult = RfqModel::where('rfq_title','like','%'.$search.'%')->orderBy('created_at','desc')->get();
                $searchQuery = 'rfq';
            }else if($search_in == "quote"){
                $searchResult = QuoteModel::where('seller_product','like','%'.$search.'%')->orderBy('created_at','desc')->get();
                $searchQuery = 'quote';
            }else if($search_in == 'invoice'){
                $searchResult = QuoteSampleModel::where('invoicenumber','like','%'.$search.'%')->orderBy('created_at','desc')->get();
                $searchResult1= AcceptModel::where('invoice_number','like','%'.$search.'%')->orderBy('created_at','desc')->get();
                $verticalFee = FeeModel::all();
                $fee=($verticalFee[0]->fee/100)*1+1;
                $searchQuery = 'invoice';
            }else if($search_in == 'product'){
                if($category == ""){
                    $searchResult = ProductModel::where('product_name','like','%'.$search.'%')->orWhere('meta','like','%'.$search.'%')->orderBy('created_at','desc')->get();
                }else{
                    $searchResult = ProductModel::where('category_id','=', ($category))->where(function ($query) use ($search){
                        $query ->where('product_name','like','%'.$search.'%')->orWhere('meta','like','%'.$search.'%');
                    })->orderBy('created_at','desc')->get();
                }
                $searchQuery = 'product';
            }else if($search_in == "company"){
                $searchResult = CompanyProfileModel::where('companyname','like','%'.$search.'%')->orWhere('companydescription','like','%'.$search.'%')->orderBy('created_at','desc')->get();
                $searchQuery = 'company';
            }

            $param['pageNo'] = 1;
            $param['searchQuery'] = $searchQuery;
            $param['searchResult'] = $searchResult;
            $param['searchResult1'] = $searchResult1;
            $param['fee'] = $fee;
            return View::make('admin.dashboard.searchResult')->with($param);
        }
    }


    /*Bargain Start*/
    public function bargain(){
        $param['pageNo'] = 81;
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $param['bargain'] = BargainModel::orderBy('created_at', 'desc')->get();
        return View::make('admin.dashboard.bargain')->with($param);
    }
    public function bargainCreate(){
        $param['pageNo'] = 81;
        $bargains = BargainModel::all();
        $bargainArray = array();
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        foreach($bargains as $key =>$value){
            $bargainArray[$key] = $value->product_id;
        }
        $param['product'] =ProductModel::whereNotIn('id',$bargainArray)->get();
        return View::make('admin.dashboard.bargainCreate')->with($param);
    }
    public function bargainStore($id){
        $bargain = new BargainModel;
        $bargain->product_id = $id;
        $bargain->save();
        $alert['msg'] = 'This bargain has been deleted successfully';
        $alert['type'] = 'success';
        return Redirect::route('admin.home.bargain.create')->with('alert', $alert);
    }
    public function bargainDelete($id){
        try {
            BargainModel::find($id)->delete();
            $alert['msg'] = 'This bargain has been deleted successfully';
            $alert['type'] = 'success';
        } catch(\Exception $ex) {
            $alert['msg'] = 'This bargain focus has been already used';
            $alert['type'] = 'danger';
        }
        return Redirect::route('admin.home.bargain')->with('alert', $alert);
    }


    public function dump(){
        $servername='localhost' ;  // Replace this 'localhost' with your server name
        $database_username='root'; // Replace this  with your username
        $database_password='';
        $database_name='newpurchasetree';
        $mysqli = mysqli_connect($servername,$database_username,$database_password,$database_name);

        $tables = '*';

        if ($tables == '*') {
            $tables = array(  );
            $result = $mysqli->query( 'SHOW TABLES' );

            while ($row = mysqli_fetch_row( $result )) {
                $tables[] = $row[0];

            }
        }
        else {
            $tables = (is_array( $tables ) ? $tables : explode( ',', $tables ));
        }
        $return = '';
        foreach ($tables as $table) {
            $result = $mysqli->query( 'SELECT * FROM ' . $table );
            $num_fields = mysqli_num_fields( $result );
            $return .= 'DROP TABLE ' . $table . ';

            ';
            $row2 = mysqli_fetch_row( $mysqli->query( 'SHOW CREATE TABLE ' . $table ) );
            $return .= '' . $row2[1] . ';

					';
            $i = 0;

            while ($i < $num_fields) {
                while ($row = mysqli_fetch_row( $result )) {
                    $return .= 'INSERT INTO ' . $table . ' VALUES(';
                    $j = 0;

                    while ($j < $num_fields) {
                        $row[$j] = addslashes( $row[$j] );
                        // $row[$j] = ereg_replace( '', '\n', $row[$j] );

                        if (isset( $row[$j] )) {
                            $return .= '"' . $row[$j] . '"';
                        }
                        else {
                            $return .= '""';
                        }


                        if ($j < $num_fields - 1) {
                            $return .= ',';
                        }

                        ++$j;
                    }

                    $return .= ');
					';
                }

                ++$i;
            }

            $return .= '


			';
        }

        $handle = fopen( dirname(__FILE__)."/dbbackup/".'db-backup-' . date( 'm.d.y' ) . '-' . time(  ) . '-' . md5( implode( ',', $tables ) ) . '.sql', 'w+' );
        fwrite( $handle, $return );
        fclose( $handle );
        $filename = 'db-backup-' . date( 'm.d.y' ) . '-' . time(  ) . '-' . md5( implode( ',', $tables ) ) . '.sql';
        $alert['msg'] = 'Hello The Database Backup Has Been Created on the following location /app/controller/admin/dbbackup/ ' . $filename . '';
        $alert['type'] = 'success';
        return Redirect::route('admin.dashboard')->with('alert', $alert);

    }
}
