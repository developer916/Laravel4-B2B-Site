<?php namespace User;

use Illuminate\Routing\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Anhskohbo\NoCaptcha\NoCaptcha;
use View, Input, Redirect, Session, Validator, DB, Mail,File, Request,Response,URL,Lang;
use Members as MembersModel, Country as CountryModel,CompanyProfile as CompanyProfileModel,Business as BusinessModel,
    ProductFocus as ProductFocusModel,FactorySize as FactorySizeModel,Category as CategoryModel,Employees as EmployeesModel,
    SubCategory as SubCategoryModel, UserCategory as UserCategoryModel,UserMarketingPicture as UserMarketingPictureModel;
class AuthController extends \BaseController {
    Public function login(){
        $param['pageNo'] = 111;
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
            return View::make('user.auth.login')->with($param);
        } else {
//            $captcha = new NoCaptcha('6LcXgwgTAAAAAM6Lj972w59e1z3UqtoEQYYdUNFM', '6LcXgwgTAAAAAIC7y2Z93LwBkAtDU54nBa1no4Iu');
//
//            if ( ! empty($_POST)) {
//                var_dump($captcha->verifyResponse($_POST['g-recaptcha-response']));
//                exit();
//            }
//            $param['captcha'] = $captcha;
//            return View::make('user.auth.login')->with($param);
              return View::make('user.auth.login');
        }
    }
    public function register(){
        $param['pageNo'] = 112;
        $param['country'] = CountryModel::whereRaw(true)->orderBy('country_name','asc')->get();
        return View::make('user.auth.register')->with($param);
    }
    public function store(){
        if (Input::has('member_id')) {
            $rules = [
                'username'  => 'required ',
                'user_password'  => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!@$#%^&*()]).*$/',
                'user_type' =>'required',
                'first_name' => 'required ',
                'last_name'  => 'required',
                'email'     => 'required |email',
                'address'    => 'required ',
                'city'     => 'required ',
                'country'  => 'required ',
                'zipcode'  => 'required ',
                'phone_number' => 'required',
                'terms' =>'required',
               // 'g-recaptcha-response' => 'required|captcha',
            ];
        }else{
            $rules = [
                'username'  => 'required |unique:member',
                'user_password'  => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/',
                'user_type' =>'required',
                'first_name' => 'required ',
                'last_name'  => 'required',
                'email'     => 'required |email|unique:member',
                'address'    => 'required ',
                'city'     => 'required ',
                'country'  => 'required ',
                'zipcode'  => 'required ',
                'phone_number' => 'required',
                'terms' =>'required',
                //'g-recaptcha-response' => 'required|captcha',
            ];
        }
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else{
            if (Input::has('member_id')) {
                $id = Input::get('member_id');
                $member_id = Input::get('member_id');
                $member = MembersModel::find($id);
            }else{
                $member = new MembersModel;
                $member_id = "";
            }
            $password = Input::get('user_password');
            if(Input::get('user_type') == "s"){
                $usertype = 1;
            }else if(Input::get('user_type') == "b"){
                $usertype = 2;
            }elseif(Input::get('user_type') == "k"){
                $usertype = 3;
            }
            $member->username = Input::get('username');
            $member->userpassword = md5($password);
            $member->firstname= Input::get('first_name');
            $member->lastname= Input::get('last_name');
            $member->email = Input::get('email');
            $member->street = Input::get('address');
            $member->city = Input::get('city');
            $member->state = Input::get('state');
            $member->country_id = Input::get('country');
            $member->zipcode = Input::get('zipcode');
            $member->phonenumber = Input::get('phone_number');
            $member->workingnumber = Input::get('working_number');
            $member->companyname = Input::get('company_name');
            $member->usertype = $usertype;
            $member->suspend = 0;
            $member->sellrequest = 0;
            $member->sellconfirm = 0;
            $member->previostype = 0;
            $member->changeDate = '';
            if($usertype == "2"){
                $member->status = 1;
            }
            $member->save();
            if($usertype == "2"){

                if($member_id != "") {
                    $userID =$member_id;
                }else{
                    $sql = "SELECT MAX(id) AS maxID FROM np_member";
                    $order = DB::select($sql);
                    $userID = $order[0]->maxID;
                }
                $companyProfile = CompanyProfileModel::whereRaw('user_id =?', array($userID))->get();
                if(count($companyProfile) ==0){
                    $company = new CompanyProfileModel;
                    $company->user_id = $userID;
                    $company->save();
                }
                $memberToken = MembersModel::find($userID);
                $email =$memberToken->email;
                $name = ucfirst($memberToken->firstname)." ".ucfirst($memberToken->lastname);
                $url = URL::route('user.verifyEmail',($userID+100000*1));
                $data =array(
                    'name' =>$name,
                    'url' =>$url,
                );
                Mail::send('emails.verifyEmail', $data, function($message) use ($email){
                    $message->from('noreply@purchasetree.com', Lang::get('alert.Please_verify_your_email_address'));
                    $message->to($email, Lang::get('alert.Send_Message'))->subject( Lang::get('alert.Please_verify_your_email_address'));
                });

                $alert['msg'] = Lang::get('alert.User_has_been_saved_successfully');
                $alert['type'] = 'success';
                return Redirect::route('user.auth.login')->with('alert', $alert);
            }else{
                if($member_id != "") {
                    $order = MembersModel::find($member_id);
                    return Redirect::route('user.auth.editcompany',$member_id)->with('order', $order);
                }else{
                    $sql = "SELECT *, MAX(id) AS maxID FROM np_member";
                    $order = DB::select($sql);
                    $userID = $order[0]->maxID;
                    return Redirect::route('user.auth.company',$userID)->with('order', $order);
                }

            }
        }
    }
    public function company($id){
        $param['pageNo'] = 112;
        if ($order = Session::get('order')) {
        }
        $param['country'] = CountryModel::whereRaw(true)->orderBy('country_name','asc')->get();
        $param['category'] = CategoryModel::whereRaw(true)->orderBy('categoryname','asc')->get();
        $param['business'] = BusinessModel::whereRaw(true)->orderBy('businesstype','asc')->get();
        $param['factorysize'] = FactorySizeModel::whereRaw(true)->orderBy('factorysize','asc')->get();
        $param['productfocus'] = ProductFocusModel::whereRaw(true)->orderBy('productfocus','asc')->get();
        $param['employees'] = EmployeesModel::whereRaw(true)->orderBy('employees','asc')->get();
        $param['user_id'] = $id;
        return View::make('user.auth.company')->with($param);
    }
    public function companystore(){
        $getCategory = Input::get('categories');

        $rules = [
           'company_name'  => 'required ',
            'company_address'  => 'required ',
            'company_city' =>'required',
            'company_country'=>'required',
            'business_type' => 'required ',
            'categories'  => 'required',
            'main_focus'  => 'required ',
            'companyyear'    => 'required ',
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else {

            $userID = Input::get('user_id');
            $userMarketingPicture = UserMarketingPictureModel::whereRaw('user_id =?', array($userID))->get();
            if(count($userMarketingPicture) >0){
                UserMarketingPictureModel::whereRaw('user_id =?', array($userID))->delete();
                if(Input::hasFile('companyproducts')){
                    $company_products =Input::file('companyproducts');
                    for($i=0; $i<count($company_products); $i++){
                        $image =$company_products[$i];
                        $filename  = str_random(24) . '.' . $image->getClientOriginalExtension();
                        $path = ABS_LOGO_PATH.$filename;
                        Image::make($image->getRealPath())->resize(1920,700)->save($path);
                        $companylogo = $filename;
                        $marketingPictureUrl = new UserMarketingPictureModel;
                        $marketingPictureUrl->user_id = $userID;
                        $marketingPictureUrl->picture_url = $companylogo;
                        $marketingPictureUrl->save();
                    }
                }
            }else{
                if(Input::hasFile('companyproducts')){
                    $company_products =Input::file('companyproducts');
                    for($i=0; $i<count($company_products); $i++){
                        $image =$company_products[$i];
                        $filename  = str_random(24) . '.' . $image->getClientOriginalExtension();
                        $path = ABS_LOGO_PATH.$filename;
                        Image::make($image->getRealPath())->resize(1920,700)->save($path);
                        $companylogo = $filename;
                        $marketingPictureUrl = new UserMarketingPictureModel;
                        $marketingPictureUrl->user_id = $userID;
                        $marketingPictureUrl->picture_url = $companylogo;
                        $marketingPictureUrl->save();
                    }
                }
            }
            $categories = '';
            for ($i = 0; $i < count($getCategory); $i++) {
                if ($i == 0) {
                    $categories = $getCategory[0];
                } else {
                    $categories .= "," . $getCategory[$i];
                }
            }
            $companylogo ='';
            $marketingpicture ='';
            $userImageList ='';
           // print_r(Input::hasFile('marketing_picture'));
            if (Input::hasFile('marketing_movie')) {
                $filename = str_random(24).".".Input::file('marketing_movie')->getClientOriginalExtension();
                Input::file('marketing_movie')->move(ABS_LOGO_PATH, $filename);
                $userImageList = $filename;
            }
            if (Input::hasFile('companylogo')) {
                $filename = str_random(24).".".Input::file('companylogo')->getClientOriginalExtension();
                Input::file('companylogo')->move(ABS_LOGO_PATH, $filename);
                $companylogo = $filename;
            }
            if (Input::hasFile('marketing_picture')) {
                $filename = str_random(24).".".Input::file('marketing_picture')->getClientOriginalExtension();
                Input::file('marketing_picture')->move(ABS_LOGO_PATH, $filename);
                $marketingpicture = $filename;
            }

            if(Input::get('companyprofile_id')){
                $companyprofile_id = Input::get('companyprofile_id');
                $company = CompanyProfileModel::find($companyprofile_id);
                UserCategoryModel::where('user_id',($userID))->delete();
                for ($i=0; $i<count($getCategory); $i++){
                    $catetoryID = SubCategoryModel::find($getCategory[$i])->category_id;
                    $List = new UserCategoryModel;
                    $List->user_id = $userID;
                    $List->category_id = $catetoryID;
                    $List->subcategory_id = $getCategory[$i];
                    $List->save();
                }
            }else{
                $company = new CompanyProfileModel();
                for ($i=0; $i<count($getCategory); $i++){
                    $catetoryID = SubCategoryModel::find($getCategory[$i])->category_id;
                    $List = new UserCategoryModel;
                    $List->user_id = $userID;
                    $List->category_id = $catetoryID;
                    $List->subcategory_id = $getCategory[$i];
                    $List->save();
                }
            }
            $company->user_id =$userID;
            $company->companyname = Input::get('company_name');
            $company->companyaddress = Input::get('company_address');
            $company->companycity = Input::get('company_city');
            $company->companystate = Input::get('company_state');
            $company->companycountry = Input::get('company_country');
            $company->companyphonenumber = Input::get('phone_number');
            $company->companyfax = Input::get('fax_address');
            if(Input::get('companyprofile_id')) {
                if (Input::get('company_logo')) {
                    $company->companylogo = $companylogo;
                }
            }else{
                $company->companylogo = $companylogo;
            }
            $company->busineestype = Input::get('business_type');
            $company->categories = $categories;
            $company->mainforcus = Input::get('main_focus');
            $company->companyyoutube = Input::get('youtube_url');
            $company->companydescription = Input::get('subContent');
            $company->companyyear = Input::get('companyyear');
            $company->ceoownername = Input::get('ceo_owner_name');
            $company->factorysize = Input::get('factory_size');
            $company->factorylocation = Input::get('factory_location');
            $company->qa_qc = Input::get('qa_qc');
            $company->employees = Input::get('number_of_employees');
            if(Input::get('companyprofile_id')) {
                if (Input::get('marketing_picture')) {
                    $company->marketingpicture =$marketingpicture;
                }
            }else{
                $company->marketingpicture =$marketingpicture;
            }

            $company->marketingvideo = $userImageList;
            $company->save();
            $user_id = Input::get('user_id');
            $userProfile = MembersModel::find($user_id);
            $userType = $userProfile->usertype;
            $userProfile->sellrequest = 1;
            $userProfile->previostype  = $userType;
            $userProfile->status  = 0;
            $userProfile->save();

            $email =$userProfile->email;
            $name = ucfirst($userProfile->firstname)." ".ucfirst($userProfile->lastname);
            $url = URL::route('user.verifyEmail',($userID+100000*1));
            $data =array(
                'name' =>$name,
                'url' =>$url,
            );
            Mail::send('emails.verifyEmail', $data, function($message) use ($email){
                $message->from('noreply@purchasetree.com', Lang::get('alert.Please_verify_your_email_address'));
                $message->to($email, Lang::get('alert.Send_Message'))->subject(Lang::get('alert.Please_verify_your_email_address'));
            });
            $alert['msg'] = Lang::get('alert.User_has_been_saved_successfully_You_have_to_wait_about_administrator_confirm');
            $alert['type'] = 'success';
        }
        return Redirect::route('user.auth.login')->with('alert', $alert);
    }
    public function doLogin(){
        $rules = ['username'  => 'required',
            'password'  => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!@$#%^&*()]).*$/',
          //  'g-recaptcha-response' => 'required|captcha',
        ];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else {
           $username = Input::get('username');
           $password = Input::get('password');
            $list = MembersModel::whereRaw('username = ? and userpassword = md5(?) and status = ?', array($username, $password, '1'))->get();
            if(count($list)>0){
                if($list[0]->email_status == 1){
                    Session::set('user_id', $list[0]->id);
                    Session::set('user_type',$list[0]->usertype);
                    if($list[0]->usertype == 2){
                        return Redirect::route('user.buyer.dashboard');
                    }else{
                        return Redirect::route('user.seller.dashboard');
                    }
                }else{
                    $alert['msg'] = Lang::get('alert.You_have_to_verify_email');
                    $alert['type'] = 'danger';
                    return Redirect::route('user.auth.login')->with('alert', $alert);
                }

            }
            else{
                $listEmail = MembersModel::whereRaw('email = ? and userpassword = md5(?) and status = ?', array($username, $password, '1'))->get();
                if(count($listEmail)>0){
                    if($listEmail[0]->email_status == 1){
                        Session::set('user_id', $listEmail[0]->id);
                        Session::set('user_type',$listEmail[0]->usertype);
                        if($listEmail[0]->usertype == 2){
                            return Redirect::route('user.buyer.dashboard');
                        }else{
                            return Redirect::route('user.seller.dashboard');
                        }
                    }else{
                        $alert['msg'] = Lang::get('alert.You_have_to_email_verify_Please_check_your_email');
                        $alert['type'] = 'danger';
                        return Redirect::route('user.auth.login')->with('alert', $alert);
                    }
                }else{
                    $alert['msg'] = Lang::get('alert.User_name_or_Email_or_Password_is_incorrect');
                    $alert['type'] = 'danger';
                    return Redirect::route('user.auth.login')->with('alert', $alert);
                }
            }

        }

    }
    public function forgot(){
        $param['pageNo'] = 113;
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        return View::make('user.auth.forgot')->with($param);
    }
    public function forgotSend(){
        $rules = ['email'  => 'required',
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else{
            $email = Input::get('email');
            $list = MembersModel::whereRaw('email = ?', array($email))->get();
            if(count($list)>0){
            $len = 6;
            $result ='';
            $strpattern = "ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijklmnpqrstuvwxyz";
            for( $i = 0 ; $i < $len; $i ++ ){
                $rand = rand( 0, strlen($strpattern) - 1 );
                $result = $result.$strpattern[$rand];
            }
            $len = 2;
            $strpattern ="0123456789";
            for( $i = 0 ; $i < $len; $i ++ ){
                $rand = rand( 0, strlen($strpattern) - 1 );
                $result = $result.$strpattern[$rand];
            }
            $strpattern =")!@#$%^&*(";
            for( $i = 0 ; $i < $len; $i ++ ){
                $rand = rand( 0, strlen($strpattern) - 1 );
                $result = $result.$strpattern[$rand];
            }
                $data = array(
                    'userpassword' =>$result,
                    'email'    =>$email
                );
                $member = MembersModel::find($list[0]->id);
                $member->userpassword = md5($result);
                $member->save();
                Mail::send('emails.forgot', $data, function($message) use ($email){
                    $message->from('noreply@purchasetree.com', Lang::get('user.forgot_password'));
                    $message->to($email, 'User')->subject(Lang::get('user.forgot_password'));
                });
                $alert['msg'] = Lang::get('alert.Your_password_has_been_changed_successfully_Please_check_your_email');
                $alert['type'] = 'success';
            }else{
                $alert['msg'] = Lang::get('alert.Your_email_is_not_exist');
                $alert['type'] = 'danger';
            }
            return Redirect::route('user.auth.forgot')->with('alert', $alert);
        }
    }
    public function doLogout(){
        Session::forget(array('user_id','user_type'));
        //Session::forgot('user_type');
        return Redirect::route('user.home');
    }

}