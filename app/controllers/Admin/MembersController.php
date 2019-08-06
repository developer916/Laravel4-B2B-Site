<?php namespace Admin;

use Illuminate\Routing\Controllers\Controller;
use Illuminate\Validation\Factory;
use View, Input, Redirect, Session, Validator, DB,Request,Response,Mail;
use Members as MembersModel, Country as CountryModel,CompanyProfile as CompanyProfileModel,Business as BusinessModel,Email as EmailModel,
    ProductFocus as ProductFocusModel,FactorySize as FactorySizeModel,Category as CategoryModel,Employees as EmployeesModel,
    SubCategory as SubCategoryModel, UserCategory as UserCategoryModel ,EmailSend  as EmailSendModel, RfqEmail as RfqEmailModel;
class MembersController  extends \BaseController
{

    public function __construct()
    {
        $this->beforeFilter(function () {
            if (!Session::has('admin_id')) {
                return Redirect::route('admin.auth.login');
            }
        });
    }
    public function index(){
        $param['pageNo'] = 31;
        $param['members'] = MembersModel::whereRaw(true)->orderBy('created_at','desc')->get();
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        return View::make('admin.members.index')->with($param);
    }
    public function create(){
        $param['pageNo'] = 31;
        $param['country'] = CountryModel::whereRaw(true)->orderBy('country_name','asc')->get();
        return View::make('admin.members.create')->with($param);
    }
    public function company($id){
        $param['pageNo'] = 31;
        if ($order = Session::get('order')) {
        }
        $param['country'] = CountryModel::whereRaw(true)->orderBy('country_name','asc')->get();
        $param['category'] = CategoryModel::whereRaw(true)->orderBy('categoryname','asc')->get();
        $param['business'] = BusinessModel::whereRaw(true)->orderBy('businesstype','asc')->get();
        $param['factorysize'] = FactorySizeModel::whereRaw(true)->orderBy('factorysize','asc')->get();
        $param['productfocus'] = ProductFocusModel::whereRaw(true)->orderBy('productfocus','asc')->get();
        $param['employees'] = EmployeesModel::whereRaw(true)->orderBy('employees','asc')->get();
        $param['user_id'] = $id;
        return View::make('admin.members.company')->with($param);
    }
    public function editcompany($id){
        $param['pageNo'] = 31;
        if ($order = Session::get('order')) {
        }
        $param['companyprofile'] = CompanyProfileModel::whereRaw('user_id = ?' , array($id))->get();
        $param['country'] = CountryModel::whereRaw(true)->orderBy('country_name','asc')->get();
        $param['category'] = CategoryModel::whereRaw(true)->orderBy('categoryname','asc')->get();
        $param['business'] = BusinessModel::whereRaw(true)->orderBy('businesstype','asc')->get();
        $param['factorysize'] = FactorySizeModel::whereRaw(true)->orderBy('factorysize','asc')->get();
        $param['productfocus'] = ProductFocusModel::whereRaw(true)->orderBy('productfocus','asc')->get();
        $param['employees'] = EmployeesModel::whereRaw(true)->orderBy('employees','asc')->get();
        $param['user_id'] = $id;
        return View::make('admin.members.editcompany')->with($param);
    }
    public function status(){
        $user_id = Input::get('user_id');
        $UserSendStatus = Input::get('status');
        if($UserSendStatus == "InActive") {
            $UserStatus=1;
        }elseif($UserSendStatus == "Active"){
            $UserStatus=0;
        }
        $user = MembersModel::find($user_id);
        $user->status = $UserStatus;
        $user->save();
        $alert['msg'] = 'User Status has been changed successfully';
        $alert['type'] = 'success';
        return Redirect::route('admin.members')->with('alert', $alert);
    }
    public function suspend(){
        $user_id = Input::get('user_id');
        $suspend = Input::get('suspended');
        if($suspend == 0) {
            $userSuspend = 1;
        }else{
            $userSuspend = 0;
        }
        $list = MembersModel::find($user_id);
        $email = $list->email;
        $user = MembersModel::find($user_id);
        $user->suspend = $userSuspend;
        $user->save();

        if($suspend ==0){
            $contentList = EmailModel::whereRaw('title =?', array('Suspend'))->get();
            $content = $contentList[0]->content;
            $data = array(
                'content' =>$content,
                'email'    =>$email
            );

            Mail::send('emails.admin.suspend', $data, function($message) use ($email){
                $message->from('noreply@purchasetree.com',"Account Suspend");
                $message->to($email, 'User')->subject("Account Suspend");
            });
        }else{
            $contentList = EmailModel::whereRaw('title =?', array('Not Suspend'))->get();
            $content = $contentList[0]->content;
            $data = array(
                'content' =>$content,
                'email'    =>$email
            );

            Mail::send('emails.admin.suspend', $data, function($message) use ($email){
                $message->from('noreply@purchasetree.com',"Account Restore");
                $message->to($email, 'User')->subject("Account Restore");
            });
        }

        $alert['msg'] = 'User Status has been changed successfully';
        $alert['type'] = 'success';
        return Redirect::route('admin.members')->with('alert', $alert);
    }
    public function store(){
        if (Input::has('member_id')) {
            $rules = [
                'username'  => 'required ',
                'password'  => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/|confirmed ',
                'firstname' => 'required ',
                'lastname'  => 'required',
                'email'     => 'required |email',
                'street'    => 'required ',
                'city'     => 'required ',
                'country_id'  => 'required ',
                'zipcode'  => 'required ',
                'phonenumber' => 'required',
            ];
        }else{
            $rules = [
                'username'  => 'required |unique:member',
                'password'  => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/|confirmed ',
                'firstname' => 'required ',
                'lastname'  => 'required',
                'email'     => 'required |email|unique:member',
                'street'    => 'required ',
                'city'     => 'required ',
                'country_id'  => 'required ',
                'zipcode'  => 'required ',
                'phonenumber' => 'required',
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
            $password = Input::get('password');
            if(Input::get('radiouser') == "s"){
                $usertype = 1;
            }else if(Input::get('radiouser') == "b"){
                $usertype = 2;
            }elseif(Input::get('radiouser') == "b"){
                $usertype = 3;
            }

            $member->username = Input::get('username');
            $member->userpassword = md5($password);
            $member->firstname= Input::get('firstname');
            $member->lastname= Input::get('lastname');
            $member->email = Input::get('email');
            $member->street = Input::get('street');
            $member->city = Input::get('city');
            $member->state = Input::get('state');
            $member->country_id = Input::get('country_id');
            $member->zipcode = Input::get('zipcode');
            $member->phonenumber = Input::get('phonenumber');
            $member->workingnumber = Input::get('workingnumber');
            $member->companyname = Input::get('companyname');
            $member->usertype = $usertype;
            $member->suspend = 0;
            $member->sellrequest = 0;
            $member->sellconfirm = 0;
            $member->previostype = 0;
            $member->changeDate = '';
            $member->admin_active = 0;
            if($usertype == "2"){
                $member->status = 1;
            }
            $member->save();

            if($usertype == "2"){
                if($member_id != "") {
                    $userID =$member_id;
                }else{
                    $sql = "SELECT *, MAX(id) AS maxID FROM np_member";
                    $order = DB::select($sql);
                    $userID = $order[0]->maxID;
                }
                $companyProfile = CompanyProfileModel::whereRaw('user_id =?', array($userID))->get();
                if(count($companyProfile) ==0){
                    $company = new CompanyProfileModel;
                    $company->user_id = $userID;
                    $company->save();
                }
                $alert['msg'] = 'User has been saved successfully';
                $alert['type'] = 'success';
                return Redirect::route('admin.members')->with('alert', $alert);
            }else{
                if($member_id != "") {
                    $order = MembersModel::find($member_id);
                    return Redirect::route('admin.members.editcompany',$member_id)->with('order', $order);
                }else{
                    $sql = "SELECT *, MAX(id) AS maxID FROM np_member";
                    $order = DB::select($sql);
                    $userID = $order[0]->maxID;
                    return Redirect::route('admin.members.company',$userID)->with('order', $order);
                }

            }
        }
    }
    public function companystore(){
        $getCategory = Input::get('categories');

            $rules = [
                'companyname'  => 'required ',
                'companyaddress'  => 'required ',
                'companycity' =>'required',
                'country_id'=>'required',
                'business_id' => 'required ',
                'categories'  => 'required',
                'productfocus_id'  => 'required ',
                'companyyear'    => 'required ',
            ];


        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else{
            $categories = '';
            for($i=0; $i<count($getCategory); $i++){
                if($i ==0) {
                    $categories =$getCategory[0];
                }else{
                    $categories .= ",".$getCategory[$i];
                }

            }
            if (Input::hasFile('companylogo')) {
                $filename = str_random(24).".".Input::file('companylogo')->getClientOriginalExtension();
                Input::file('companylogo')->move(ABS_LOGO_PATH, $filename);
                $companylogo = $filename;
            }
            if (Input::hasFile('marketingpicture')) {
                $filename = str_random(24).".".Input::file('marketingpicture')->getClientOriginalExtension();
                Input::file('marketingpicture')->move(ABS_LOGO_PATH, $filename);
                $marketingpicture = $filename;
            }
            $userID = Input::get('user_id');
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
            $company->companyname = Input::get('companyname');
            $company->companyaddress = Input::get('companyaddress');
            $company->companycity = Input::get('companycity');
            $company->companystate = Input::get('companystate');
            $company->companycountry = Input::get('country_id');
            $company->companyphonenumber = Input::get('companyphonenumber');
            $company->companyfax = Input::get('companyfax');
            if(Input::get('companyprofile_id')) {
                if (Input::get('companylogo')) {
                    $company->companylogo = $companylogo;
                }
            }else{
                $company->companylogo = $companylogo;
            }
            $company->busineestype = Input::get('business_id');
            $company->categories = $categories;
            $company->mainforcus = Input::get('productfocus_id');
            $company->companyyoutube = Input::get('companyyoutube');
            $company->companydescription = Input::get('subContent');
            $company->companyyear = Input::get('companyyear');
            $company->ceoownername = Input::get('ceoownername');
            $company->factorysize = Input::get('factorysize_id');
            $company->factorylocation = Input::get('factorylocation');
            $company->qa_qc = Input::get('qa_qc');
            $company->employees = Input::get('employees');
            if(Input::get('companyprofile_id')) {
                if (Input::get('marketingpicture')) {
                    $company->marketingpicture =$marketingpicture;
                }
            }else{
                $company->marketingpicture =$marketingpicture;
            }

            $company->marketingvideo = Input::get('marketingvideo');
            $company->save();

            $user_id = Input::get('user_id');
            $userProfile = MembersModel::find($user_id);
            $userType = $userProfile->usertype;
            $userProfile->sellrequest = 1;
            $userProfile->previostype  = $userType;
            $userProfile->status  = 0;
            $userProfile->save();
            $alert['msg'] = 'User has been saved successfully';
            $alert['type'] = 'success';
        }
        return Redirect::route('admin.members')->with('alert', $alert);
    }
    public function edit($id){
        $param['pageNo'] = 31;
        $param['country'] = CountryModel::whereRaw(true)->orderBy('country_name','asc')->get();
        $member = MembersModel::find($id);
        $member->admin_active = 1;
        $member->save();
        $param['member'] = MembersModel::find($id);

        return View::make('admin.members.edit')->with($param);
    }
    public function sellerconfirm(){
        $param['pageNo'] = 32;
        //$param['members'] = MembersModel::whereRaw('usertype = ? and sellrequest = ?' , array(1,1))->get();
        $param['members'] = MembersModel::whereRaw(' sellrequest = ? and sellconfirm =?' , array(1,0))->orderBy('created_at','desc')->get();
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        return View::make('admin.members.sellerconfirm')->with($param);
    }
    public function manageSeller(){
        $param['pageNo'] = 33;
        //$param['members'] = MembersModel::whereRaw('usertype = ? and sellconfirm = ? and status = ?' , array(1,1,1))->->get();
        $param['members'] = MembersModel::where('status','1')->where('sellconfirm','1')->whereIn('usertype',array(1,3))->get();
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        return View::make('admin.members.manageseller')->with($param);
    }
    public function messageManagement(){
        $param['pageNo'] = 34;
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        /***** Get all emails ****/
        $emails = EmailSendModel::where('parent','0')->get();
        $param['emails'] = $emails;
        /***** Get RFQ emails ****/
        $rfqEmails = RfqEmailModel::whereRaw(true)->groupBy('quote_id')->get();
        $param['rfqEmails'] = $rfqEmails;
        return View::make('admin.members.messageManagement')->with($param);
    }
    /******* Message  View ********/
    public function messageManagementView($id){
        $param['pageNo'] = 34;
        $email =EmailSendModel::find($id);
        $param['email'] = $email;
        $param['emails'] = EmailSendModel::where('parent',$email->id)->get();
        return View::make('admin.members.messageManagementView')->with($param);
    }

    /******** Message Delete *********/
    public function messageManagementDelete($id){
        try {
            $email =EmailSendModel::find($id);
            if($email->parent == 0){
                EmailSendModel::where('parent', $email->id)->delete();
            }
            EmailSendModel::find($id)->delete();
            $alert['msg'] = 'This messages has been deleted successfully';
            $alert['type'] = 'success';
        } catch(\Exception $ex) {
            $alert['msg'] = 'This messages has been already used';
            $alert['type'] = 'danger';
        }
        return Redirect::route('admin.members.messageManagement')->with('alert', $alert);
    }
    public function messageManagementRFQView($id){
        $param['pageNo'] = 34;
        $rfq_email = RfqEmailModel::find($id);
        $param['rfq_email'] = $rfq_email;
        $param['rfqEmails'] = RfqEmailModel::where('rfq_id', $rfq_email->rfq_id)->where('quote_id' , $rfq_email->quote_id)->get();
        return View::make('admin.members.messageManagementRFQView')->with($param);
    }

    public function messageManagementRFQDelete($id){
        try {
            RfqEmailModel::find($id)->delete();
            $alert['msg'] = 'This rfq messages has been deleted successfully';
            $alert['type'] = 'success';
        } catch(\Exception $ex) {
            $alert['msg'] = 'This rfq messages has been already used';
            $alert['type'] = 'danger';
        }
        return Redirect::route('admin.members.messageManagement')->with('alert', $alert);
    }

    /***** Message Post *******/

    public function confirmSeller($id){
        $members = MembersModel::find($id);
        $members->sellrequest = 0;
        $members->sellconfirm = 1;
        $members->status =1;
        $members->save();
        $email = $members->email;
        $content = EmailModel::whereRaw('title =?', array('Confirm Seller'))->get();
        $data = array(
            'email'    =>$email,
            'content' =>$content[0]->content

        );
        Mail::send('emails.admin.confirm', $data, function($message) use ($email){
            $message->from('noreply@purchasetree.com', 'Confirm Seller');
            $message->to($email, 'User')->subject('Confirm Seller');
        });
        $alert['msg'] = 'Seller has been saved successfully';
        $alert['type'] = 'success';
        return Redirect::route('admin.members.sellerconfirm')->with('alert', $alert);
    }
    public function confirmSellerAjax(){
        if(Request::ajax()){
            $userID = Input::get('userID');
            $members = MembersModel::find($userID);
            $members->sellrequest = 0;
            $members->sellconfirm = 1;
            $members->status =1;
            $members->save();
            $data = array('result' => 'success');
        }
        return Response::json($data);
    }
    public function viewSeller(){
        if(Request::ajax()){
            $user_id = Input::get('id');
            $member = MembersModel::find($user_id);
            $member->admin_active = 1;
            $member->save();
            if($member->usertype !=2){
            $companyprofile = CompanyProfileModel::whereRaw('user_id = ?' , array($user_id))->get();
            $content = '';
                $content .= '
                            <input type="hidden" value="'.$user_id.'" name="userID" id="userID">
                            <div class="form-horizontal" >
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group" id="countryname">
                                            <h4 class="col-md-offset-1" style="font-weight:bold">Contact  Information</h4>
                                        </div>
                                     </div>
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group" id="countryname">
                                            <label class="col-md-4 col-sm-4 col-xs-12 control-label" style="font-size:13px; padding-top:0px;">User Name: <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-sm-8 col-xs-12 ">'.$member->username.'</div>
                                        </div>
                                   </div>
                                   <div class="col-md-12 col-sm-12">
                                        <div class="form-group" id="countryname">
                                            <label class="col-md-4 col-sm-4 col-xs-12 control-label" style="font-size:13px; padding-top:0px;">Email Address: <span style="color:red">*</span></label>
                                           <div class="col-md-8 col-sm-8 col-xs-12 ">'.$member->email.'</div>
                                        </div>
                                   </div>
                                   <div class="col-md-12 col-sm-12">
                                        <div class="form-group" id="countryname">
                                            <label class="col-md-4 col-sm-4 col-xs-12 control-label" style="font-size:13px; padding-top:0px;">First Name: <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-sm-8 col-xs-12 ">
                                                '.$member->firstname.'</div>
                                        </div>
                                   </div>
                                   <div class="col-md-12 col-sm-12">
                                        <div class="form-group" id="countryname">
                                            <label class="col-md-4 col-sm-4 col-xs-12 control-label" style="font-size:13px; padding-top:0px;">Last Name: <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-sm-8 col-xs-12 ">
                                                '.$member->lastname.'
                                            </div>
                                        </div>
                                   </div>
                                   <div class="col-md-12 col-sm-12">
                                        <div class="form-group" id="countryname">
                                            <label class="col-md-4 col-sm-4 col-xs-12 control-label" style="font-size:13px; padding-top:0px;">Address: <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-sm-8 col-xs-12 ">
                                                '.$member->street.'
                                            </div>
                                        </div>
                                   </div>
                                  <div class="col-md-12 col-sm-12">
                                        <div class="form-group" id="countryname">
                                            <label class="col-md-4 col-sm-4 col-xs-12 control-label" style="font-size:13px; padding-top:0px;">City: <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-sm-8 col-xs-12 ">
                                                '.$member->city.'</span>
                                            </div>
                                        </div>
                                   </div>';
                                    if($member->state !=""){
                                        $content .='<div class="col-md-12 col-sm-12">
                                                        <div class="form-group" id="countryname">
                                                            <label class="col-md-4 col-sm-4 col-xs-12 control-label" style="font-size:13px; padding-top:0px;">State: </label>
                                                            <div class="col-md-8 col-sm-8 col-xs-12 ">
                                                                '.$member->state.'
                                                            </div>
                                                        </div>
                                                   </div>';
                                    }

                        $content .='
                                     <div class="col-md-12 col-sm-12">
                                        <div class="form-group" id="countryname">
                                            <label class="col-md-4 col-sm-4 col-xs-12 control-label" style="font-size:13px; padding-top:0px;">Country: <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-sm-8 col-xs-12 ">
                                                '.$member->country->country_name.'
                                            </div>
                                        </div>
                                     </div>
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group" id="countryname">
                                            <label class="col-md-4 col-sm-4 col-xs-12 control-label" style="font-size:13px; padding-top:0px;">Zip Code: <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-sm-8 col-xs-12 ">
                                                '.$member->zipcode.'
                                            </div>
                                        </div>
                                     </div>
                                     <div class="col-md-12 col-sm-12">
                                        <div class="form-group" id="countryname">
                                            <label class="col-md-4 col-sm-4 col-xs-12 control-label" style="font-size:13px; padding-top:0px;">Phone Number: <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-sm-8 col-xs-12 ">
                                                '.$member->phonenumber.'
                                            </div>
                                        </div>
                                     </div>
                                     <div class="col-md-12 col-sm-12">
                                        <div class="form-group" id="countryname">
                                            <label class="col-md-4 col-sm-4 col-xs-12 control-label" style="font-size:13px; padding-top:0px;">Working Number: </label>
                                            <div class="col-md-8 col-sm-8 col-xs-12 ">
                                                '.$member->workingnumber.'
                                            </div>
                                        </div>
                                     </div>
                                     <div class="col-md-12 col-sm-12">
                                        <div class="form-group" id="countryname">
                                            <h4 class="col-md-offset-1" style="font-weight:bold">Company Profile</h4>
                                        </div>
                                     </div>
                                     <div class="col-md-12 col-sm-12">
                                        <div class="form-group" id="countryname">
                                            <label class="col-md-4 col-sm-4 col-xs-12 control-label" style="font-size:13px; padding-top:0px;">Company Name: <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-sm-8 col-xs-12 ">
                                                '.$companyprofile[0]->companyname.'
                                            </div>
                                        </div>
                                     </div>
                                     <div class="col-md-12 col-sm-12">
                                        <div class="form-group" id="countryname">
                                            <label class="col-md-4 col-sm-4 col-xs-12 control-label" style="font-size:13px; padding-top:0px;">Company Address: <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-sm-8 col-xs-12 ">
                                                '.$companyprofile[0]->companyaddress.'
                                            </div>
                                        </div>
                                     </div>
                                     <div class="col-md-12 col-sm-12">
                                        <div class="form-group" id="countryname">
                                            <label class="col-md-4 col-sm-4 col-xs-12 control-label" style="font-size:13px; padding-top:0px;">Company City: <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-sm-8 col-xs-12 ">
                                                '.$companyprofile[0]->companycity.'
                                            </div>
                                        </div>
                                     </div>';
                                    if(($companyprofile[0]->companystate != "") ) {
                                        $content .=' <div class="col-md-12 col-sm-12" >
                                                        <div class="form-group" id = "countryname" >
                                                            <label class="col-md-4 col-sm-4 col-xs-12 control-label" style="font-size:13px; padding-top:0px;"> Company State:</label >
                                                            <div class="col-md-8 col-sm-8 col-xs-12 " >
                                                               '.$companyprofile[0]->companystate.'
                                                            </div >
                                                        </div >
                                                     </div >';
                                        }
                                    $content .='<div class="col-md-12 col-sm-12">
                                        <div class="form-group" id="countryname">
                                            <label class="col-md-4 col-sm-4 col-xs-12 control-label" style="font-size:13px; padding-top:0px;">Company Country: <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-sm-8 col-xs-12 ">';
                                                   $companyCountry = $companyprofile[0]->companycountry;
                                                    $companycountrylist = CountryModel::find($companyCountry);
                                                    $content .= $companycountrylist->country_name;
                                                    $content .='
                                            </div>
                                        </div>
                                     </div>';
                                    if(($companyprofile[0]->companyphonenumber!='')){
                                        $content .='
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group" id="countryname">
                                                <label class="col-md-4 col-sm-4 col-xs-12 control-label" style="font-size:13px; padding-top:0px;">Phone Number:</label>
                                                <div class="col-md-8 col-sm-8 col-xs-12 ">
                                                    '.$companyprofile[0]->companyphonenumber.'
                                                </div>
                                            </div>
                                         </div>';
                                    }
                                    if(($companyprofile[0]->companyfax !='')){
                                        $content .='
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group" id="countryname">
                                                <label class="col-md-4 col-sm-4 col-xs-12 control-label" style="font-size:13px; padding-top:0px;">Fax:</label>
                                                <div class="col-md-8 col-sm-8 col-xs-12 ">
                                                    '.$companyprofile[0]->companyfax.'
                                                </div>
                                            </div>
                                         </div>';
                                        }
                                    if(($companyprofile[0]->companylogo !='')){
                                        $content .='
                                            <div class="col-md-12 col-sm-12">
                                                <div class="form-group" id="countryname">
                                                    <label class="col-md-4 col-sm-4 col-xs-12 control-label" style="font-size:13px; padding-top:0px;">Company Logo:</label>
                                                    <div class="col-md-8 col-sm-8 col-xs-12 ">

                                                            <img src="'.HTTP_LOGO_PATH.$companyprofile[0]->companylogo.'" style="width:100%">

                                                    </div>
                                                </div>
                                             </div>';
                                    }
                                    $content .='<div class="col-md-12 col-sm-12">
                                            <div class="form-group" id="countryname">
                                                <label class="col-md-4 col-sm-4 col-xs-12 control-label" style="font-size:13px; padding-top:0px;">Business Type: <span style="color:red">*</span></label>
                                                <div class="col-md-8 col-sm-8 col-xs-12 ">';
                                                        $businessType= $companyprofile[0]->busineestype;
                                                        $businessList = BusinessModel::find($businessType);
                                                        $content.=$businessList->businesstype;
                                                    $content.='
                                                </div>
                                            </div>
                                         </div>';
                                    $content .='<div class="col-md-12 col-sm-12">
                                            <div class="form-group" id="countryname">
                                                <label class="col-md-4 col-sm-4 col-xs-12 control-label" style="font-size:13px; padding-top:0px;">Categories: <span style="color:red">*</span></label>
                                                <div class="col-md-8 col-sm-8 col-xs-12 ">
                                                    ';
                                                        $categorylist= explode(',',$companyprofile[0]->categories);
                                                         $categories = CategoryModel::all();
                                                            foreach($categories as $category){
                                                                $subcategory = $category->subCategories;
                                                                foreach($subcategory as $subcategories){
                                                                    for( $jk=0; $jk<count($categorylist); $jk++){
                                                                        if($categorylist[$jk] == $subcategories->id ) {
                                                                            if ($jk == count($categorylist) - 1) {
                                                                                $content .= '<p>';
                                                                                $content .= $category->categoryname . '->' . $subcategories->subcategoryname;
                                                                                $content .= '</p>';
                                                                            } else {
                                                                                if ($categorylist[$jk] == $subcategories->id) {
                                                                                    $content .= '<p>';
                                                                                    $content .= $category->categoryname . '->' . $subcategories->subcategoryname;
                                                                                    $content .= '</p>';

                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        $content.='
                                                            </div>
                                                        </div>
                                                     </div>';

                                        $content .='<div class="col-md-12 col-sm-12">
                                                     <div class="form-group" id="countryname">
                                                          <label class="col-md-4 col-sm-4 col-xs-12 control-label" style="font-size:13px; padding-top:0px;">Main Product Focus: <span style="color:red">*</span></label>
                                                            <div class="col-md-8 col-sm-8 col-xs-12 ">
                                                                ';
                                                                    $businessType= $companyprofile[0]->mainforcus;
                                                                    $businessList = ProductFocusModel::find($businessType);
                                                                    $content.=$businessList->productfocus;
                                                                    $content.='
                                                            </div>
                                                     </div>
                                                    </div>';
                                        if($companyprofile[0]->companyyoutube != ""){
                                            $content .='<div class="col-md-12 col-sm-12">
                                                     <div class="form-group" id="countryname">
                                                          <label class="col-md-4 col-sm-4 col-xs-12 control-label" style="font-size:13px; padding-top:0px;">Youtube Url: </label>
                                                            <div class="col-md-8 col-sm-8 col-xs-12 ">
                                                                ';
                                                                $content.= $companyprofile[0]->companyyoutube;
                                                                $content.='
                                                            </div>
                                                     </div>
                                                    </div>';
                                        }
                                        if($companyprofile[0]->companydescription != ""){
                                            $content .='<div class="col-md-12 col-sm-12">
                                             <div class="form-group" id="countryname">
                                                  <label class="col-md-4 col-sm-4 col-xs-12 control-label" style="font-size:13px; padding-top:0px;">Company Description: </label>
                                                    <div class="col-md-8 col-sm-8 col-xs-12 ">
                                                        ';
                                                            $content.= $companyprofile[0]->companydescription;
                                                            $content.='
                                                    </div>
                                             </div>
                                            </div>';
                                        }
                                        $content .='<div class="col-md-12 col-sm-12">
                                                        <div class="form-group" id="countryname">
                                                            <label class="col-md-4 col-sm-4 col-xs-12 control-label" style="font-size:13px; padding-top:0px;">Year Established:</label>
                                                            <div class="col-md-8 col-sm-8 col-xs-12 ">
                                                                '.$companyprofile[0]->companyyear.'
                                                            </div>
                                                        </div>
                                                     </div>';
                                        if($companyprofile[0]->ceoownername != ""){
                                            $content .='<div class="col-md-12 col-sm-12">
                                             <div class="form-group" id="countryname">
                                                  <label class="col-md-4 col-sm-4 col-xs-12 control-label" style="font-size:13px; padding-top:0px;">CEO Owners Name: </label>
                                                    <div class="col-md-8 col-sm-8 col-xs-12 ">
                                                        ';
                                                            $content.= $companyprofile[0]->ceoownername;
                                                            $content.='
                                                    </div>
                                                </div>
                                            </div>';
                                         }

                                        if($companyprofile[0]->factorysize != ""){
                                            $content .='<div class="col-md-12 col-sm-12">
                                             <div class="form-group" id="countryname">
                                                  <label class="col-md-4 col-sm-4 col-xs-12 control-label" style="font-size:13px; padding-top:0px;">Factory Size: </label>
                                                    <div class="col-md-8 col-sm-8 col-xs-12 ">
                                                        ';
                                                           $factoryList = FactorySizeModel::find($companyprofile[0]->factorysize);
                                                            $content .=$factoryList->factorysize;
                                                            $content.='
                                                    </div>
                                                </div>
                                            </div>';
                                        }
                                        if($companyprofile[0]->factorylocation != ""){
                                            $content .='<div class="col-md-12 col-sm-12">
                                             <div class="form-group" id="countryname">
                                                  <label class="col-md-4 col-sm-4 col-xs-12 control-label" style="font-size:13px; padding-top:0px;">Factory Location: </label>
                                                    <div class="col-md-8 col-sm-8 col-xs-12 ">
                                                        ';
                                                        $content.= $companyprofile[0]->factorylocation;
                                                        $content.='
                                                    </div>
                                             </div>
                                            </div>';
                                        }
                                        if($companyprofile[0]->employees != ""){
                                            $content .='<div class="col-md-12 col-sm-12">
                                             <div class="form-group" id="countryname">
                                                  <label class="col-md-4 col-sm-4 col-xs-12 control-label" style="font-size:13px; padding-top:0px;">Number of Employees: </label>
                                                    <div class="col-md-8 col-sm-8 col-xs-12 ">
                                                        ';
                                                            $employeesList = EmployeesModel::find($companyprofile[0]->employees);
                                                            $content.= $employeesList->employees;
                                                            $content.='
                                                    </div>
                                             </div>
                                            </div>';
                                        }
                                        if($companyprofile[0]->marketingpicture != ""){
                                            $content .='<div class="col-md-12 col-sm-12">
                                             <div class="form-group" id="countryname">
                                                  <label class="col-md-4 col-sm-4 col-xs-12 control-label" style="font-size:13px; padding-top:0px;">Marketing Picture: </label>
                                                    <div class="col-md-8 col-sm-8 col-xs-12 ">

                                                            <img src="'.HTTP_LOGO_PATH.$companyprofile[0]->marketingpicture.'">

                                                    </div>
                                             </div>
                                            </div>';
                                           }
                                            if($companyprofile[0]->marketingvideo != ""){
                                                $content .='<div class="col-md-12 col-sm-12">
                                             <div class="form-group" id="countryname">
                                                  <label class="col-md-4 col-sm-4 col-xs-12 control-label" style="font-size:13px; padding-top:0px;">Marketing Movie: </label>
                                                    <div class="col-md-8 col-sm-8 col-xs-12 ">
                                                        ';
                                                        $content.= $companyprofile[0]->marketingvideo;
                                                        $content.='
                                                    </div>
                                             </div>
                                            </div>';
                                             }
                                $content .='</div>
                            </div>';
            }else{
                $content = '';
                $content .= '
                            <input type="hidden" value="'.$user_id.'" name="userID" id="userID">
                            <div class="form-horizontal" >
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group" id="countryname">
                                            <h4 class="col-md-offset-1" style="font-weight:bold">Contact  Information</h4>
                                        </div>
                                     </div>
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group" id="countryname">
                                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">User Name: <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-sm-8 col-xs-12 ">
                                                '.$member->username.'
                                            </div>
                                        </div>
                                   </div>
                                   <div class="col-md-12 col-sm-12">
                                        <div class="form-group" id="countryname">
                                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Email Address: <span style="color:red">*</span></label>
                                           <div class="col-md-8 col-sm-8 col-xs-12 ">
                                               '.$member->email.'
                                            </div>
                                        </div>
                                   </div>
                                   <div class="col-md-12 col-sm-12">
                                        <div class="form-group" id="countryname">
                                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">First Name: <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-sm-8 col-xs-12 ">
                                                '.$member->firstname.'
                                            </div>
                                        </div>
                                   </div>
                                   <div class="col-md-12 col-sm-12">
                                        <div class="form-group" id="countryname">
                                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Last Name: <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-sm-8 col-xs-12 ">
                                                '.$member->lastname.'
                                            </div>
                                        </div>
                                   </div>
                                   <div class="col-md-12 col-sm-12">
                                        <div class="form-group" id="countryname">
                                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Address: <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-sm-8 col-xs-12 ">
                                                '.$member->street.'
                                            </div>
                                        </div>
                                   </div>
                                  <div class="col-md-12 col-sm-12">
                                        <div class="form-group" id="countryname">
                                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">City: <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-sm-8 col-xs-12 ">
                                                '.$member->city.'
                                            </div>
                                        </div>
                                   </div>';
                if($member->state !=""){
                    $content .='<div class="col-md-12 col-sm-12">
                                    <div class="form-group" id="countryname">
                                        <label class="col-md-4 col-sm-4 col-xs-12 control-label">State: </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12 ">
                                            '.$member->state.'
                                        </div>
                                    </div>
                               </div>';
                }

                $content .='
                         <div class="col-md-12 col-sm-12">
                            <div class="form-group" id="countryname">
                                <label class="col-md-4 col-sm-4 col-xs-12 control-label">Country: <span style="color:red">*</span></label>
                                <div class="col-md-8 col-sm-8 col-xs-12 ">
                                    '.$member->country->country_name.'
                                </div>
                            </div>
                         </div>
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group" id="countryname">
                                <label class="col-md-4 col-sm-4 col-xs-12 control-label">Zip Code: <span style="color:red">*</span></label>
                                <div class="col-md-8 col-sm-8 col-xs-12 ">
                                    '.$member->zipcode.'
                                </div>
                            </div>
                         </div>
                         <div class="col-md-12 col-sm-12">
                            <div class="form-group" id="countryname">
                                <label class="col-md-4 col-sm-4 col-xs-12 control-label">Phone Number: <span style="color:red">*</span></label>
                                <div class="col-md-8 col-sm-8 col-xs-12 ">
                                    '.$member->phonenumber.'
                                </div>
                            </div>
                         </div>
                         <div class="col-md-12 col-sm-12">
                            <div class="form-group" id="countryname">
                                <label class="col-md-4 col-sm-4 col-xs-12 control-label">Working Number: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12 ">
                                    '.$member->workingnumber.'
                                </div>
                            </div>
                         </div>
                         <div class="col-md-12 col-sm-12">
                            <div class="form-group" id="countryname">
                                <label class="col-md-4 col-sm-4 col-xs-12 control-label">Company Name: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12 ">
                                    '.$member->companyname.'
                                </div>
                            </div>
                         </div>
                    </div>
               </div>';
            }
            $data = array('result' => 'success', 'list' => $content);
        }
        return Response::json($data);
    }
    public function delete($id){
        try {
            MembersModel::find($id)->delete();
            $alert['msg'] = 'This member has been deleted successfully';
            $alert['type'] = 'success';
        } catch(\Exception $ex) {
            $alert['msg'] = 'This member has been already used';
            $alert['type'] = 'danger';
        }
        return Redirect::route('admin.members')->with('alert', $alert);
    }
    public function sendMessage(){
        if(Request::ajax()){

            $userID = Input::get('userMessageID');
            $messageContent = Input::get('messageContent');
            $content = MembersModel::find($userID);

            $email = $content->email;
            $data = array(
                'email'    =>$email,
                'content' =>$messageContent
            );
            Mail::send('emails.admin.sendMessage', $data, function($message) use ($email){
                $message->from('noreply@purchasetree.com', 'Admin');
                $message->to($email, 'User')->subject('Admin');
            });

        }
        return Response::json(['result' =>'success']);
    }
    public  function reject($id){
        $member = MembersModel::find($id);
        $email = $member->email;
        $userType = $member->usertype;
        $member->previostype = $userType;
        $member->usertype = 2;
        $member->sellrequest = 0;
        $member->sellconfirm= 0;
        $member->save();
        $message =  $content = EmailModel::whereRaw('title =?', array('Reject Seller'))->get();
        $data = array(
            'email'    =>$email,
            'content' =>$message[0]->content
        );
        Mail::send('emails.admin.sendMessage', $data, function($message) use ($email){
            $message->from('noreply@purchasetree.com', 'Admin');
            $message->to($email, 'User')->subject('Admin');
        });
        $alert['msg'] = 'Seller has been rejected successfully';
        $alert['type'] = 'success';
        return Redirect::route('admin.members.sellerconfirm')->with('alert', $alert);
    }
}