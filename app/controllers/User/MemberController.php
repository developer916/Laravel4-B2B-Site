<?php namespace User;

use Illuminate\Routing\Controllers\Controller;
use Intervention\Image\Facades\Image;

use View, Input, Redirect, Session, Validator, DB, Mail,File, Request,Response,Lang;
use Members as MembersModel, Country as CountryModel,CompanyProfile as CompanyProfileModel,Business as BusinessModel,
    ProductFocus as ProductFocusModel,FactorySize as FactorySizeModel,Category as CategoryModel,Employees as EmployeesModel,
    SubCategory as SubCategoryModel, UserCategory as UserCategoryModel,UserMarketingPicture as UserMarketingPictureModel;
class MemberController extends \BaseController {
    public function __construct()
    {
        $this->beforeFilter(function () {
            if (!Session::has('user_id')) {
                return Redirect::route('user.auth.login');
            }
        });
    }
    public function index(){
        $param['pageNo'] = 130;
        $user_id  = Session::get('user_id');
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $param['userProfile'] = MembersModel::find($user_id);
        $param['country'] = CountryModel::whereRaw(true)->orderBy('country_name','asc')->get();
        return View::make('user.member.index')->with($param);
    }
    public function personal(){
        $rules = [
            'firstname' => 'required ',
            'lastname'  => 'required',
            'email'     => 'required |email',
            'address'    => 'required ',
            'city'     => 'required ',
            'country'  => 'required ',
            'zipcode'  => 'required ',
            'phone_number' => 'required',
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else {
            $userID = Session::get('user_id');
            $member = MembersModel::find($userID);
            $member->firstname = Input::get('firstname');
            $member->lastname = Input::get('lastname');
            $member->email = Input::get('email');
            $member->street = Input::get('address');
            $member->city = Input::get('city');
            $member->state = Input::get('state');
            $member->country_id = Input::get('country');
            $member->zipcode = Input::get('zipcode');
            $member->phonenumber = Input::get('phone_number');
            $member->workingnumber = Input::get('working_number');
            $member->companyname = Input::get('companyname');
            $member->save();
            $alert['msg'] = Lang::get('alert.Personal_information_has_been_saved_successfully');
            $alert['type'] = 'success';
        }
        return Redirect::route('user.member')->with('alert', $alert);
    }
    public function password(){
        $param['pageNo'] = 131;
        $user_id  = Session::get('user_id');
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        return View::make('user.member.password')->with($param);
    }
    public function passwordStore(){
        $rules = [
            'currentPassword' => 'required ',
            'password'  => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/|confirmed',
            'password_confirmation'     => 'required',
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else {
            $user_id  = Session::get('user_id');
            $currentPassword = Input::get('currentPassword');
            $newPassword = Input::get('password');
            $confirmPassword = Input::get('password_confirmation');
            if($newPassword != $confirmPassword) {
                $alert['msg'] = Lang::get('alert.New_password_and_confirm_password_are_not_same');
                $alert['type'] = 'danger';
            }else{
                $result = MembersModel::whereRaw('id = ? and userpassword =md5(?)', array($user_id,$currentPassword))->get();
                if(count($result) == 0){
                    $alert['msg'] = Lang::get('alert.Current_password_is_not_correct');
                    $alert['type'] = 'danger';
                }else{
                    $password = MembersModel::find($user_id);
                    $password->userpassword =  md5($newPassword);
                    $password->save();
                    $alert['msg'] = Lang::get('alert.Password_changed_successfully');
                    $alert['type'] = 'success';
                }
            }
            return Redirect::route('user.member.password')->with('alert', $alert);
        }
    }
    public function company(){
        $param['pageNo'] = 132;
        $user_id  = Session::get('user_id');
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $param['category'] = CategoryModel::whereRaw(true)->orderBy('categoryname','asc')->get();
        $param['business'] = BusinessModel::whereRaw(true)->orderBy('businesstype','asc')->get();
        $param['factorysize'] = FactorySizeModel::whereRaw(true)->orderBy('factorysize','asc')->get();
        $param['productfocus'] = ProductFocusModel::whereRaw(true)->orderBy('productfocus','asc')->get();
        $param['employees'] = EmployeesModel::whereRaw(true)->orderBy('employees','asc')->get();
        $param['country'] = CountryModel::whereRaw(true)->orderBy('country_name','asc')->get();

        $param['companyProfile'] = CompanyProfileModel::whereRaw('user_id = ?', array($user_id))->get();
        $param['subCategoryList'] = UserCategoryModel::whereRaw('user_id = ?', array($user_id))->get();

        return View::make('user.member.company')->with($param);
    }
    public function companyStore(){
        $rules = [
            'companyname'  => 'required ',
            'companyaddress'  => 'required ',
            'companycity' =>'required',
            'country'=>'required',
            'business_type' => 'required ',
            'categories'  => 'required',
            'mainFocus'  => 'required ',
            'companyyear'    => 'required ',
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else{
            $getCategory = Input::get('categories');
            $categories = '';
            for($i=0; $i<count($getCategory); $i++){
                if($i ==0) {
                    $categories =$getCategory[0];
                }else{
                    $categories .= ",".$getCategory[$i];
                }

            }
            $user_id  = Session::get('user_id');
            $member = CompanyProfileModel::whereRaw('user_id = ?', array($user_id))->get();
            $member[0]->companyname = Input::get('companyname');
            $member[0]->companyaddress = Input::get('companyaddress');
            $member[0]->companycity = Input::get('companycity');
            $member[0]->companystate = Input::get('companystate');
            $member[0]->companycountry = Input::get('country');
            $member[0]->companyphonenumber = Input::get('phonenumber');
            $member[0]->companyfax = Input::get('faxaddress');
            $companylogo ='';
            if (Input::hasFile('companylogo')) {
                $filename = str_random(24).".".Input::file('companylogo')->getClientOriginalExtension();
                Input::file('companylogo')->move(ABS_LOGO_PATH, $filename);
                $companylogo = $filename;
            }
            if($companylogo !=""){
                $member[0]->companylogo  = $companylogo;
            }
            $member[0]->busineestype = Input::get('business_type');
            $member[0]->categories = $categories;
            $member[0]->mainforcus = Input::get('mainFocus');
            $member[0]->companyyoutube = Input::get('youtube');
            $member[0]->companydescription = Input::get('subContent');
            $member[0]->companyyear = Input::get('companyyear');
            $member[0]->ceoownername = Input::get('ceo');
            $member[0]->factorysize = Input::get('factorysize');
            $member[0]->factorylocation = Input::get('factorylocation');
            $member[0]->qa_qc = Input::get('qa_qc');
            $member[0]->employees  = Input::get('employees');
            $member[0]->save();
            $alert['msg'] = Lang::get('alert.Company_profile_has_been_changed_successfully');
            $alert['type'] = 'success';
        }
        return Redirect::route('user.member.company')->with('alert', $alert);
    }
    public function video(){
        $param['pageNo'] = 133;
        $user_id  = Session::get('user_id');
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $param['companyProfile'] = CompanyProfileModel::whereRaw('user_id=?', array($user_id))->get();
        $param['user_id'] = $user_id+100000*1;
        return View::make('user.member.video')->with($param);
    }
    public function pictureStore(){
        $rules = array('image'  => 'required|image|max:1024');
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            $valid =$validator->errors();
            $valid->add('marketingImageError', 'marketingImageError');
            return Redirect::back()->withErrors($valid)->withInput();
        }else{
            $user_id  = Session::get('user_id');
            if (Input::hasFile('image')) {
                $filename = str_random(24).".".Input::file('image')->getClientOriginalExtension();
                Input::file('image')->move(ABS_LOGO_PATH, $filename);
                $userImageList = $filename;
            }
            $companyProfile = CompanyProfileModel::whereRaw('user_id = ?', array($user_id))->get();
            $companyProfile[0]->marketingpicture = $userImageList;
            $companyProfile[0]->save();
            $alert['msg'] = Lang::get('alert.Marketing_picture_has_been_saved_successfully');
            $alert['type'] = 'success';
            $alert['list'] = 'marketingImageSuccess';
        }
        return Redirect::route('user.member.video')->with('alert', $alert);
    }
    public function videoStore(){
        $rules = array('video'  => 'required|mimes:mp4,webm,ogv');
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            $valid =$validator->errors();
            $valid->add('VideoFile', 'VideoFileError');
            return Redirect::back()->withErrors($valid)->withInput();
        }else{
            $user_id  = Session::get('user_id');
            if (Input::hasFile('video')) {
                $filename = str_random(24).".".Input::file('video')->getClientOriginalExtension();
                Input::file('video')->move(ABS_LOGO_PATH, $filename);
                $userImageList = $filename;
            }
            $companyProfile = CompanyProfileModel::whereRaw('user_id = ?', array($user_id))->get();
            $companyProfile[0]->marketingvideo = $userImageList;
            $companyProfile[0]->save();
            $alert['msg'] = Lang::get('alert.Marketing_video_has_been_saved_successfully');
            $alert['type'] = 'success';
            $alert['list'] = 'VideoFileeSuccess';
        }
        return Redirect::route('user.member.video')->with('alert', $alert);
    }
    public function product(){
        $param['pageNo'] = 134;
        $user_id  = Session::get('user_id');
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $param['productPicture'] =UserMarketingPictureModel::whereRaw('user_id=?', array($user_id))->get();
        return View::make('user.member.product')->with($param);
    }
    public function productDelete(){
        if(Request::ajax()){
            $checkList = Input::get('checkList');
            for($i=0; $i<count($checkList); $i++){
                UserMarketingPictureModel::find($checkList[$i])->delete();
            }
            $data = array('result'=> 'success','message' =>Lang::get('missing.Product_picture_deleted_successfully'));
        }
        return Response::json($data);
    }
    public function productUpload(){
        if(Request::ajax()){
            $rules = [
                'imageUpload'  => 'required|image|max:1024',
            ];
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return Response::json(['result' =>'failed', 'error' =>$validator->getMessageBag()->toArray()]);
            }else{
                $imageUpload = Input::file('imageUpload');
                $user_id  = Session::get('user_id');

                $filename  = str_random(24) . '.' . $imageUpload->getClientOriginalExtension();
                $path = ABS_LOGO_PATH.$filename;
                Image::make($imageUpload->getRealPath())->resize(1920,700)->save($path);
                $companylogo = $filename;
                $userMarketingPicture = new UserMarketingPictureModel;
                $userMarketingPicture->user_id = $user_id;
                $userMarketingPicture->picture_url = $companylogo;
                $userMarketingPicture->save();
                $data = array('result'=> 'success','message' =>Lang::get('missing.Product_picture_upload_successfully'));
            }
        }
        return Response::json($data);
    }
    public function confirm(){
        if(Request::ajax()) {
            $user_type = Input::get('user_type');

            if ($user_type == "s") {
                $real_type = 1;
            } else if ($user_type == "c") {
                $real_type = 2;
            } else if ($user_type == "b") {
                $real_type = 3;
            }

            if ($real_type != 2) {
                $user_id = Session::get('user_id');
                $user_type = Session::get('user_type');

                $member = MembersModel::find($user_id);
                $member->previostype = $user_type;
                $member->usertype = $real_type;
                $member->sellrequest = 1;
                $member->sellconfirm = 0;
                $member->status = 0;
                $member->save();
                $data = array(
                        'username' => $member->username,
                        'email' => $member->email
                );

                Mail::send('emails.member.request', $data, function($message){
                    $message->from('noreply@purchasetree.com', Lang::get('alert.Seller_Request'));
                    $message->to(Admin_Email, Lang::get('alert.Seller_Request'))->subject(Lang::get('alert.Seller_Request'));
                });
                $data =Lang::get('missing.Your_user_type_is_changed_You_have_to');
                return Response::json($data);
            } else {
                $data = "This is same your user type";
                return Response::json($data);
            }
        }
    }
}
