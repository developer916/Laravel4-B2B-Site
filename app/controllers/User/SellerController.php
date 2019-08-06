<?php namespace User;

use Illuminate\Routing\Controllers\Controller;
use View, Input, Redirect, Session, Validator, DB, Mail,File, Request,Response,Lang,Image;
use Members as MembersModel,Category as CategoryModel,Product as ProductModel,ProductPicture as ProductPictureModel,
    SubCategory as SubCategoryModel, UserCategory as UserCategoryModel,Currency as CurrencyModel,CompanyProfile as CompanyProfileModel,
    Business as BusinessModel, ProductFocus as ProductFocusModel,Employees as EmployeesModel, FactorySize as FactorySizeModel,UserMarketingPicture as UserMarketingPictureModel,
    Rfq as RfqModel, RfqFile as RfqFileModel, RfqPicture as RfqPictureModel, RfqSpe as RfqSpeModel, RfqSpePicture as RfqSpePictureModel,
    Unit as UnitModel, Quote as QuoteModel, QuoteNote as QuoteNoteModel, QuotePicture as QuotePictureModel,ProductQuickDetail as ProductQuickDeailModel,
    QuoteSpe as QuoteSpeModel,RfqEmail as RfqEmailModel, QuoteSample as QuoteSampleModel, Fee as FeeModel,QuickDetails as QuickDetailsModel,
    UserCategoryImage as UserCategoryImageModel, UserSubCategoryImage as UserSubCategoryImageModel,AdditionalCategory as AdditionalCategoryModel;
class SellerController  extends \BaseController {
    public function index(){
        $param['pageNo'] = 35;
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        return View::make('user.seller.index')->with($param);
    }
    public function companyChangePicture(){
        if(Request::ajax()){
            $rules = [
                'file_upload'  => 'required|image|max:1024',
            ];
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return Response::json(['result' =>'failed', 'error' =>$validator->getMessageBag()->toArray()]);
            }else{
                if (Input::hasFile('file_upload')) {
                    $filename = str_random(24) . "." . Input::file('file_upload')->getClientOriginalExtension();
                    $path = ABS_LOGO_PATH.$filename;
                    Image::make(Input::file('file_upload')->getRealPath())->resize(1920,700)->save($path);
                    $userImageList = $filename;
                }
                $url =$userImageList;
                $data="<img src='".HTTP_LOGO_PATH.$userImageList."'>";
                return Response::json(['result' =>'success', 'content' =>$data, 'url' =>$url]);
            }
        }
    }
    public function companyChangePictures(){
        if(Request::ajax()) {
            $id = Input::get('company');
            $listID = $id- 100000;
            UserMarketingPictureModel::whereRaw('user_id=?',array($listID))->delete();
            $images = Input::get('image');
            if(count($images)>0){
                foreach($images as $key=>$value){
                    $marketingPicture = new UserMarketingPictureModel;
                    $marketingPicture->user_id = $listID;
                    $marketingPicture->picture_url = $value;
                    $marketingPicture->save();
                }
                $data = array('result'=> 'success');
                return Response::json($data);
            }else{
                $data = array('result'=> 'failed');
                return Response::json($data);
            }


        }
    }
    public function subCategoryChange(){
        $companyID = Input::get('companyID');
        $categoryID = Input::get('id');
        $listID = $companyID -100000;
        $UserCategoryImageModel =UserSubCategoryImageModel::whereRaw('user_id=? and subcategory_id =?', array($listID, $categoryID))->first();
        $subCategory = SubCategoryModel::find($categoryID);
        $list = '';
        $list .=' <input type="hidden" name="company" value="'.$companyID.'">';
        $list .=' <input type="hidden" name="saveCategoryID" value="'.$UserCategoryImageModel->id.'">';
        $list .='
            <div class="form-group">
                <label class="col-md-4 col-sm-4 col-xs-5 control-label">
                    '.Lang::get("user.product_sub_category").'
                </label>
                <div class="col-md-6 col-sm-5 col-xs-6">
                    <select class="form-control" name="category">';
        $list .='<option value="'.$subCategory->id.'">'.$subCategory->subcategoryname.'</option>';
        $list .=' </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 col-sm-4 col-xs-5 control-label">
                    '.Lang::get("user.subcategory_image").'
                </label>
                <div class="col-md-6 col-sm-5 col-xs-6">
                    <input type="file" name="image" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <input type="button" onclick="onSaveCategoryChangeImage()"  class="btn-u btn-u-blue" value="'.Lang::get("user.save").'" style="float:right">
                </div>

            </div>';
        return Response::json(['result' =>'success','list' =>$list]);
    }
    public function categoryChange(){
        $companyID = Input::get('companyID');
        $categoryID = Input::get('id');
        $listID = $companyID -100000;
        $UserCategoryImageModel =UserCategoryImageModel::whereRaw('user_id=? and category_id =?', array($listID, $categoryID))->first();
        $category =  CategoryModel::find($categoryID);
        $list = '';
        $list .=' <input type="hidden" name="company" value="'.$companyID.'">';
        $list .=' <input type="hidden" name="saveCategoryID" value="'.$UserCategoryImageModel->id.'">';
        $list .='<div class="form-group">
                                <label class="col-md-4 col-sm-4 col-xs-5 control-label">
                                    '.Lang::get("user.category").'
                                </label>
                                <div class="col-md-6 col-sm-5 col-xs-6">
                                    <select class="form-control" name="category">';
        $list .='<option value="'.$category->id.'">'.$category->categoryname.'</option>';
                        $list .='    </select>
                                </div>
                  </div>
                <div class="form-group">
                    <label class="col-md-4 col-sm-4 col-xs-5 control-label">
                        '.Lang::get("user.category_image").'
                    </label>
                    <div class="col-md-6 col-sm-5 col-xs-6">
                        <input type="file" name="image" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <input type="button" onclick="onSaveCategoryChangeImage()"  class="btn-u btn-u-blue" value="'.Lang::get("user.save").'" style="float:right">
                    </div>

                </div>';
        return Response::json(['result' =>'success','list' =>$list]);

    }
    public function subCategoryImageUpload(){
        $rules = [
            'category' =>'required',
            'image'  => 'required|image|max:1024 ',
        ];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Response::json(['result' =>'failed', 'error' =>$validator->getMessageBag()->toArray()]);
        }else{
            if (Input::hasFile('image')) {
                $filename = str_random(24) . "." . Input::file('image')->getClientOriginalExtension();
                $path = ABS_LOGO_PATH.$filename;
                Image::make(Input::file('image')->getRealPath())->resize(973,615)->save($path);
                $userImageList = $filename;
            }
            $subCategoryID = Input::get('saveCategoryID');
            $subCategory = Input::get('category');
            $subCategoryResult = SubCategoryModel::find($subCategory);
            if($subCategoryID != ""){
                $UserCategoryImageModel = UserSubCategoryImageModel::find($subCategoryID);
            }else{
                $UserCategoryImageModel = new UserSubCategoryImageModel;
            }
            $company = Input::get('company');
            $listID = $company - 100000;
            $UserCategoryImageModel->user_id = $listID;
            $UserCategoryImageModel->category_id =$subCategoryResult->category->id;
            $UserCategoryImageModel->subcategory_id= $subCategory;
            $UserCategoryImageModel->picture_url = $userImageList;
            $UserCategoryImageModel->save();
            return Response::json(['result' =>'success']);
        }
    }
    public function categoryImageUpload(){
        $rules = [
            'category' =>'required',
            'image'  => 'required|image|max:1024 ',
        ];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Response::json(['result' =>'failed', 'error' =>$validator->getMessageBag()->toArray()]);
        }else{
            if (Input::hasFile('image')) {
                $filename = str_random(24) . "." . Input::file('image')->getClientOriginalExtension();
                $path = ABS_LOGO_PATH.$filename;
                Image::make(Input::file('image')->getRealPath())->resize(973,615)->save($path);
                $userImageList = $filename;
            }
            $subCategoryID = Input::get('saveCategoryID');
            $category = Input::get('category');
            if($subCategoryID != ""){
                $UserCategoryImageModel = UserCategoryImageModel::find($subCategoryID);
            }else{
                $UserCategoryImageModel = new UserCategoryImageModel;
            }
            $company = Input::get('company');
            $listID = $company - 100000;
            $UserCategoryImageModel->user_id = $listID;
            $UserCategoryImageModel->category_id =$category;
            $UserCategoryImageModel->picture_url = $userImageList;
            $UserCategoryImageModel->save();
            return Response::json(['result' =>'success']);
        }
    }
    public function storeCategory($user_id,$categoryID){
        $listID = $user_id-100000;
        $param['pageNo'] = 120;
        $param['category'] = CategoryModel::whereRaw(true)->orderBy('categoryname','asc')->get();
        $param['helps'] = ProductModel::whereRaw('user_id=?',array($listID))->paginate(20);
        $param['userProfile'] = MembersModel::find($listID);
        $param['title'] = ucfirst($param['userProfile']->username." ".Lang::get('user.store'));


        $param['companyProfile'] = CompanyProfileModel::whereRaw('user_id=?',array($listID))->get();
        $param['userMakertingPicture'] =UserMarketingPictureModel::whereRaw('user_id=?',array($listID))->get();
        if(count($param['companyProfile'])>0){
            $param['business_type'] = BusinessModel::find($param['companyProfile'][0]->busineestype);
            $param['productfocus'] = ProductFocusModel::find($param['companyProfile'][0]->mainforcus);
            $param['employees'] = EmployeesModel::find($param['companyProfile'][0]->employees);
            $param['factorysize'] =FactorySizeModel::find($param['companyProfile'][0]->factorysize);
        }else{
            $param['business_type'] = '';
            $param['productfocus'] = '';
            $param['employees'] = '';
            $param['factorysize'] ='';
        }

        $price1_unit = array();
        $price2_unit = array();
        $price3_unit = array();
        $product_picture = array();
        foreach($param['helps'] as $key=>$value){
            $price1_unit[$key] = CurrencyModel::find($value->price1_currency);
            $price2_unit[$key] = CurrencyModel::find($value->price2_currency);
            $price3_unit[$key] = CurrencyModel::find($value->price3_currency);
            // $product_picture[$key] =ProductPictureModel::whereRaw('product_id=?',array($value->id))->get();
        }

        $param['price1_unit'] = $price1_unit;
        $param['price2_unit'] = $price2_unit;
        $param['price3_unit'] = $price3_unit;
        $param['user_id'] = $user_id;
        $productArray = array();
//        $param['listSubCategory'] = ProductModel::whereRaw('user_id=? and subcategory_id=?',array($listID,$categoryID))->groupBy('subcategory_id')->get();
//        for($i=0; $i<count($param['listSubCategory']); $i++){
//            //$productArray[$i] = array();
//            $listProduct= ProductModel::whereRaw('user_id = ? and subcategory_id=?', array($listID, $param['listSubCategory'][$i]->subcategory_id))->get();
//            $productArray[$i]  =$listProduct;
//            $product_picture[$i]= array();
//            for($j = 0; $j<count($listProduct); $j++){
//                $product_picture[$i][$j] = ProductPictureModel::whereRaw('product_id=?',array($listProduct[$j]->id))->get();
//            }
//        }
        $sql_select = 'SELECT *
                FROM np_subcategory
                WHERE id IN
                 (SELECT subcategory_id  FROM np_product WHERE user_id = '.$listID.'  and category_id= '.$categoryID.'
                UNION ALL
               SELECT subcategory_id FROM np_user_sub_category  WHERE user_id = '.$listID.' and category_id= '.$categoryID.')
                GROUP BY id';
        $userCategories = DB::select($sql_select);
        $arrayList = array();
        if(count($userCategories)>0){
            for($i=0; $i<count($userCategories); $i++){

                $list = UserSubCategoryImageModel::whereRaw('user_id = ? and subcategory_id =?', array($listID,$userCategories[$i]->id))->get();
                if(count($list)>0){

                    $arrayList[$i] = $list[0]->picture_url;
                }else{
                    $arrayList[$i] = "";
                }
            }
        }
        $param['categoryResult'] = CategoryModel::find($categoryID);
        $param['category'] = subCategoryModel::whereRaw('category_id=?', array($categoryID))->get();
        $param['categoryPictures'] = $arrayList;
        $param['userCategories'] = $userCategories;
        $param['listProduct'] = $productArray;
        $param['product_picture'] = $product_picture;
        $param['subcategory'] = SubCategoryModel::find($categoryID);
        $param['unit'] = UnitModel::whereRaw(true)->orderBy('unitname','asc')->get();
        $param['currency'] = CurrencyModel::whereRaw(true)->orderBy('currency_name','asc')->get();
        return View::make('user.seller.storeCategory')->with($param);
    }

    public function storeSubCategory($user_id,$categoryID){
        $listID = $user_id-100000;
        $param['pageNo'] = 120;
        $param['category'] = CategoryModel::whereRaw(true)->orderBy('categoryname','asc')->get();
        $param['helps'] = ProductModel::whereRaw('user_id=?',array($listID))->paginate(20);
        $param['userProfile'] = MembersModel::find($listID);
        $param['title'] = ucfirst($param['userProfile']->username." ".Lang::get('user.store'));


        $param['companyProfile'] = CompanyProfileModel::whereRaw('user_id=?',array($listID))->get();
        $param['userMakertingPicture'] =UserMarketingPictureModel::whereRaw('user_id=?',array($listID))->get();
        if(count($param['companyProfile'])>0){
            $param['business_type'] = BusinessModel::find($param['companyProfile'][0]->busineestype);
            $param['productfocus'] = ProductFocusModel::find($param['companyProfile'][0]->mainforcus);
            $param['employees'] = EmployeesModel::find($param['companyProfile'][0]->employees);
            $param['factorysize'] =FactorySizeModel::find($param['companyProfile'][0]->factorysize);
        }else{
            $param['business_type'] = '';
            $param['productfocus'] = '';
            $param['employees'] = '';
            $param['factorysize'] ='';
        }

        $price1_unit = array();
        $price2_unit = array();
        $price3_unit = array();
        $product_picture = array();
        foreach($param['helps'] as $key=>$value){
            $price1_unit[$key] = CurrencyModel::find($value->price1_currency);
            $price2_unit[$key] = CurrencyModel::find($value->price2_currency);
            $price3_unit[$key] = CurrencyModel::find($value->price3_currency);
            // $product_picture[$key] =ProductPictureModel::whereRaw('product_id=?',array($value->id))->get();
        }

        $param['price1_unit'] = $price1_unit;
        $param['price2_unit'] = $price2_unit;
        $param['price3_unit'] = $price3_unit;
        $param['user_id'] = $user_id;
        $productArray = array();
        $param['listSubCategory'] = ProductModel::whereRaw('user_id=? and subcategory_id=?',array($listID,$categoryID))->groupBy('subcategory_id')->get();
        for($i=0; $i<count($param['listSubCategory']); $i++){
            //$productArray[$i] = array();
            $listProduct= ProductModel::whereRaw('user_id = ? and subcategory_id=?', array($listID, $param['listSubCategory'][$i]->subcategory_id))->get();
            $productArray[$i]  =$listProduct;
            $product_picture[$i]= array();
            for($j = 0; $j<count($listProduct); $j++){
                $product_picture[$i][$j] = ProductPictureModel::whereRaw('product_id=?',array($listProduct[$j]->id))->get();
            }
        }

        $param['listProduct'] = $productArray;
        $param['product_picture'] = $product_picture;
        $param['subcategory'] = SubCategoryModel::find($categoryID);
        $param['unit'] = UnitModel::whereRaw(true)->orderBy('unitname','asc')->get();
        $param['currency'] = CurrencyModel::whereRaw(true)->orderBy('currency_name','asc')->get();
        $param['quickDetailsCategory'] = QuickDetailsModel::whereRaw(true)->groupBy('category_id')->get();
        $param['additionalCategories'] = AdditionalCategoryModel::all();
        return View::make('user.seller.storeSubCategory')->with($param);
    }
    public function store($id){
        $listID = $id-100000;
        $param['pageNo'] = 120;
        $param['category'] = CategoryModel::whereRaw(true)->orderBy('categoryname','asc')->get();
        $param['helps'] = ProductModel::whereRaw('user_id=?',array($listID))->paginate(20);
        $param['userProfile'] = MembersModel::find($listID);
        $param['title'] = ucfirst($param['userProfile']->username." ".Lang::get('user.store'));


        $param['companyProfile'] = CompanyProfileModel::whereRaw('user_id=?',array($listID))->get();
        $param['userMakertingPicture'] =UserMarketingPictureModel::whereRaw('user_id=?',array($listID))->get();
        if(count($param['companyProfile'])>0){
            $param['business_type'] = BusinessModel::find($param['companyProfile'][0]->busineestype);
            $param['productfocus'] = ProductFocusModel::find($param['companyProfile'][0]->mainforcus);
            $param['employees'] = EmployeesModel::find($param['companyProfile'][0]->employees);
            $param['factorysize'] =FactorySizeModel::find($param['companyProfile'][0]->factorysize);
        }else{
            $param['business_type'] = '';
            $param['productfocus'] = '';
            $param['employees'] = '';
            $param['factorysize'] ='';
        }

        $price1_unit = array();
        $price2_unit = array();
        $price3_unit = array();
        $product_picture = array();
        foreach($param['helps'] as $key=>$value){
            $price1_unit[$key] = CurrencyModel::find($value->price1_currency);
            $price2_unit[$key] = CurrencyModel::find($value->price2_currency);
            $price3_unit[$key] = CurrencyModel::find($value->price3_currency);
           // $product_picture[$key] =ProductPictureModel::whereRaw('product_id=?',array($value->id))->get();
        }

        $param['price1_unit'] = $price1_unit;
        $param['price2_unit'] = $price2_unit;
        $param['price3_unit'] = $price3_unit;
        $param['user_id'] = $id;

        /**********Category*************/
        $productArray = array();
        $param['listSubCategory'] = ProductModel::whereRaw('user_id=?',array($listID))->groupBy('subcategory_id')->get();
        for($i=0; $i<count($param['listSubCategory']); $i++){
            //$productArray[$i] = array();
           $listProduct= ProductModel::whereRaw('user_id = ? and subcategory_id=?', array($listID, $param['listSubCategory'][$i]->subcategory_id))->get();
            $productArray[$i]  =$listProduct;
            $product_picture[$i]= array();
            for($j = 0; $j<count($listProduct); $j++){
                $product_picture[$i][$j] = ProductPictureModel::whereRaw('product_id=?',array($listProduct[$j]->id))->get();
            }
        }

        $sql_select = 'SELECT *
                        FROM np_categories
                        WHERE id IN
                         (SELECT category_id  FROM np_product WHERE user_id = '.$listID.'
                        UNION ALL
                       SELECT category_id FROM np_user_category  WHERE user_id = '.$listID.')
                        GROUP BY id';
        $userCategories = DB::select($sql_select);
        $arrayList = array();
        if(count($userCategories)>0){
            for($i=0; $i<count($userCategories); $i++){

                $list = UserCategoryImageModel::whereRaw('user_id = ? and category_id =?', array($listID,$userCategories[$i]->id))->get();
                if(count($list)>0){
                    $arrayList[$i] = $list[0]->picture_url;
                }else{
                    $arrayList[$i] = "";
                }
            }
        }
        $param['categoryPictures'] = $arrayList;
        $param['userCategories'] = $userCategories;
        $param['listProduct'] = $productArray;
        $param['product_picture'] = $product_picture;
        return View::make('user.seller.storelist')->with($param);
    }
    public function getCategory(){
        $company = Input::get('company');
        $category = Input::get('categoryID');
        $list = '';
        $list .='<option value="">Select Sub Category </option>';
        if($category != "") {
            $listID = $company - 100000;
            $sql_select = 'SELECT *
                            FROM np_subcategory
                            WHERE id IN
                             (SELECT subcategory_id  FROM np_product WHERE user_id = ' . $listID . ' and category_id=' . $category . '
                            UNION ALL
                           SELECT subcategory_id FROM np_user_sub_category  WHERE user_id = ' . $listID . '  and category_id=' . $category . ')
                            GROUP BY id';
            $userCategories = DB::select($sql_select);
            $subCategory = SubCategoryModel::whereRaw('category_id =?', array($category))->orderBy('id','asc')->get();

            for ($i = 0; $i < count($subCategory); $i++) {
                $result = 0;
                for ($j = 0; $j < count($userCategories); $j++) {
                    if ($userCategories[$j]->id == $subCategory[$i]->id) {
                        $result = 1;
                    }
                }
                if ($result != 1) {
                    $list .= '<option value="' . $subCategory[$i]->id . '">' . ucfirst($subCategory[$i]->subcategoryname) . '</option>';
                }
            }
        }
        $data = array('result'=> 'success', 'subcategory' => $list);
        return Response::json($data);

    }
    public function category($id){
        $listID = $id-100000;
        $param['pageNo'] = 121;
        $param['category'] = UserCategoryModel::whereRaw('user_id=?', array($listID))->groupBy('category_id')->get();
        $param['subCategory'] =UserCategoryModel::whereRaw('user_id=?', array($listID))->get();
        $param['userProfile'] = MembersModel::find($listID);
        $param['user_id'] = $id;
        $param['helps'] = ProductModel::whereRaw('user_id=?',array($listID))->paginate(20);
        $product_picture = array();
        for($i=0; $i<count($param['helps']); $i++){
            $product_picture[$i] = ProductPictureModel::whereRaw('product_id= ?', array($param['helps'][$i]->id))->get();
        }
        $param['product_picture'] = $product_picture;
        $param['companyProfile'] = CompanyProfileModel::whereRaw('user_id=?',array($listID))->get();
        return View::make('user.seller.category')->with($param);
    }
    public function sub($id,$id1){
        $listID = $id-100000;
        $subCategoryID = $id1-100000;
        $param['pageNo'] = 121;
        $param['userProfile'] = MembersModel::find($listID);
        $param['user_id'] = $id;
        $param['subCategoryID'] = $id1;
        $param['companyProfile'] = CompanyProfileModel::whereRaw('user_id=?',array($listID))->get();
        $param['helps'] = ProductModel::whereRaw('user_id= ? and subcategory_id =?', array($listID,$subCategoryID))->paginate(20);
        $param['subCategorys'] =UserCategoryModel::whereRaw('user_id=?', array($listID))->get();
        $param['subCategory'] =SubCategoryModel::find($subCategoryID);
        $product_picture = array();
        for($i=0; $i<count($param['helps']); $i++){
            $product_picture[$i] = ProductPictureModel::whereRaw('product_id= ?', array($param['helps'][$i]->id))->get();
        }
        $param['product_picture'] = $product_picture;
        return View::make('user.seller.sub')->with($param);
    }
    public function profile($id){
        $listID = $id-100000;
        $param['pageNo'] = 122;
        $param['userProfile'] = MembersModel::find($listID);
        $param['companyProfile'] = CompanyProfileModel::whereRaw('user_id=?',array($listID))->get();
        $param['userMakertingPicture'] =UserMarketingPictureModel::whereRaw('user_id=?',array($listID))->get();
        $param['business_type'] = BusinessModel::find($param['companyProfile'][0]->busineestype);
        $param['productfocus'] = ProductFocusModel::find($param['companyProfile'][0]->mainforcus);
        $param['employees'] =EmployeesModel::find($param['companyProfile'][0]->employees);
        $param['factorysize'] =FactorySizeModel::find($param['companyProfile'][0]->factorysize);
        $param['user_id'] = $id;
        return View::make('user.seller.profile')->with($param);
    }
    public  function storeContact($id){
        $listID = $id-100000;
        $param['pageNo'] = 129;
        $param['userProfile'] = MembersModel::find($listID);
        $param['member'] = MembersModel::find($listID);
        $param['subject'] = Input::get('subject');
        $param['user_id'] = $id;
        return View::make('user.seller.storeContact')->with($param);
    }
    public function rfq(){
        $param['pageNo'] = 33;
        $user_id = Session::get('user_id');
        if(isset($user_id)){
            $quoteList = QuoteModel::whereRaw('seller_id=?', array($user_id))->get();
            if(count($quoteList)>0){
                $quoteListID = array();
                for($i=0; $i<count($quoteList); $i++){
                    $quoteListID[$i] = $quoteList[$i]->rfq_id;
                }
                $param['rfq'] = RfqModel::whereNotIn('id', $quoteListID)->orderBy('created_at','desc')->paginate(5);
            }else{
                $param['rfq'] = RfqModel::whereRaw(true)->orderBy('created_at','desc')->paginate(5);
            }

        }else{
            $param['rfq'] = RfqModel::whereRaw(true)->orderBy('created_at','desc')->paginate(5);
        }
        $buyerList = array();
        foreach($param['rfq'] as $key=>$value){
            $buyerList[$key] = MembersModel::find($value->buyer_id);
        }
        $param['buyerList'] =$buyerList;
        return View::make('user.seller.rfq')->with($param);
    }
    public function rfqSearch(){
        $searchTitle = Input::get('searchTitle');
        $param['pageNo'] =33;
        $param['rfq'] = RfqModel::where('rfq_title','LIKE','%'.$searchTitle.'%')->orderBy('created_at','desc')->paginate(1);
        $param['rfq']->appends(array('searchTitle' => $searchTitle));
        $buyerList = array();
        foreach($param['rfq'] as $key=>$value){
            $buyerList[$key] = MembersModel::find($value->buyer_id);
        }
        $param['buyerList'] =$buyerList;
        return View::make('user.seller.search')->with($param);
    }
    public function send(){
        if (!Session::has('user_id')) {
            return Redirect::route('user.auth.login');
        }else{

        }
    }

    public function getProductList(){
        $id = Input::get('id');
        $productID =$id-100000;
        $product = ProductModel::find($productID);
        $productPicture = ProductPictureModel::whereRaw('product_id=?',array($productID))->get();
        $unit = UnitModel::whereRaw(true)->orderBy('unitname','asc')->get();
        $currency = CurrencyModel::whereRaw(true)->orderBy('currency_name','asc')->get();
        $quickDetailsCategory = QuickDetailsModel::whereRaw(true)->groupBy('category_id')->get();
        $productQuickDetails = ProductQuickDeailModel::whereRaw('product_id=?', array($productID))->get();
        $list = '<div class="form-horizontal" id="editProductForm">';
        $list .='<input type="hidden" name="category" value="'.$product->category_id.'">
                 <input type="hidden" name="subcategory" value="'.$product->subcategory_id.'">
                 <input type="hidden" name="productID" value="'.$productID.'">';
        foreach ([
                     'product_name' => Lang::get('user.rfq_product_name'),
                     'product_description' => Lang::get('user.rfq_product_description'),
                     'quick_div' => Lang::get('user.quick_details'),
                     'quick_button' => Lang::get('user.quick_button'),
                     'meta' => Lang::get('user.product_meta'),
                     'product_price1' => Lang::get('user.product_price_1'),
                     'product_price2' => Lang::get('user.product_price_2'),
                     'product_price3' => Lang::get('user.product_price_3'),
                     'min_order'=> Lang::get('user.product_min_order'),
                     'supply_ability' =>Lang::get('user.product_supply_ability'),
                     'product_picture' => Lang::get('user.product_product_picture')] as $key=> $value){

            if($key === 'product_name' || $key === 'meta' || $key==="min_order" || $key==="supply_ability" ){
                $list .='<div class="form-group">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">'.$value.' <span style="color: red">*</span></label>';
                            if($key === 'product_name' || $key === 'meta' ){
                            $list.='<div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" placeholder="'.$value.'" class="form-control" name="'.$key.'" value="'.$product->$key.'">
                            </div>';
                        }else{
                            $list.='<div class="col-md-3 col-sm-3 col-xs-6">
                                <input type="text" placeholder="'.$value.'" class="form-control" name="'.$key.'" value="'.$product->$key.'">
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                <select name="'.$key.'unit" class="form-control">
                                <option value="">Select Unit</option>';
                                if($key ==="min_order"){
                                    foreach($unit as $key_unit=>$value_unit){
                                        if($value_unit->id == $product->min_order_unit){
                                            $list.='<option value="'.$value_unit->id.'" selected>'.$value_unit->unitname.'</option>';
                                        }else{
                                            $list.='<option value="'.$value_unit->id.'">'.$value_unit->unitname.'</option>';
                                        }
                                    }
                                }else{
                                    foreach($unit as $key_unit=>$value_unit){
                                        if($value_unit->id == $product->supply_ability_unit){
                                            $list.='<option value="'.$value_unit->id.'" selected>'.$value_unit->unitname.'</option>';
                                        }else{
                                            $list.='<option value="'.$value_unit->id.'">'.$value_unit->unitname.'</option>';
                                        }
                                    }
                                }


                                $list.='</select>
                            </div>';
                        }
                $list.=' </div>';
            }
            elseif($key === 'product_description'){
                $list .='<div class="form-group">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">'.$value.'
                           </label>
                           <div  class="col-md-6 col-sm-6 col-xs-12">
                               <textarea class="form-control" id="description" name="description" cols="50" rows="10">'.$product->$key.'</textarea>
                           </div>
                       </div>';
            }elseif($key === "quick_button"){
                $list .='<div class="form-group">
                                    <div class="col-md-10">
                                         <button class="btn-u btn-u-blue" style="float: right" onclick="onShowEditQuickDetail()">'.$value.'</button>
                                        <button class="btn-u btn-u-green" style="float:right;margin-right:10px" onclick="onEditNewQuickDetail()">'.Lang::get('user.new_quick_detail').'</button>
                                    </div>
                                </div>';
            }elseif($key === "quick_div"){
                $list .='<div class="form-group" id="quickDiv">
                                    <label class="col-md-4 col-sm-4 col-xs-12 control-label">
                                        '.$value.'
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12 form-horizontal" id="quickEditDivContent">';
                                        foreach($productQuickDetails as $key_productQuickDetail => $value_productQuickDetail){
                                            $list.='<div class="row form-group">
                                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                                            <input type="text" name="label_select_question[]" class="form-control" value="'.$value_productQuickDetail->categoryname.'">
                                                        </div>
                                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                                            <input type="text" name="quickDetails[]" class="form-control" value="'.$value_productQuickDetail->categorycontent.'">
                                                        </div>
                                                        <div class="col-md-2 col-sm-2 col-xs-2">
                                                            <button class="btn-u btn-u-red" onclick="onRemoveThisItem(this)">X</button>
                                                        </div>
                                                    </div>';
                                        }
                                    $list .='</div>
                                </div>';
            }
            elseif($key ==='product_price1' || $key ==='product_price2' || $key ==='product_price3' ){
                $list.='<div class="form-group">
                           <label class=" col-md-4 col-sm-4 col-xs-12 control-label">
                               '.$value .'
                               <span style="color: red">*</span>
                           </label>
                           <div class="col-md-3 col-sm-3 col-xs-6">
                               <input type="text" placeholder="'.$value.'" class="form-control" name="'.$key.'" value="'.$product->$key.'">
                           </div>
                           <div class="col-md-3 col-sm-3 col-xs-6">
                               <select name="'.$key.'currency" class="form-control">
                                   <option value="">Select Currency</option>';
                                   if($key ==="product_price1"){
                                      $key_token = "price1_currency";
                                   } else if($key ==="product_price1"){
                                       $key_token = "price2_currency";
                                   }else{
                                       $key_token = "price3_currency";
                                   }
                                   foreach($currency as $key_currency=>$value_currency){
                                       if($value_currency->id == $product->$key_token){
                                           $list.='<option value="'.$value_currency->id.'" selected>'.$value_currency->currency_name.'</option>';
                                       }else{
                                           $list.='<option value="'.$value_currency->id.'">'.$value_currency->currency_name.'</option>';
                                       }

                                   }
                                   $list.='
                               </select>
                            </div>
                       </div>';
            }
            else{
                $list .='<div class="form-group">
                               <label class=" col-md-4 col-sm-4 col-xs-12 control-label">
                                   '.$value .'
                               </label>
                               <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input type="file" name="file_upload" id="imageUploadPostEdit" style="display: inline-block">
                                   <input type="hidden" id="imagePrevDiv" value="previewNewsImageBuy" name="imagePrevDiv">
                                   <font style="color:red" class="normal">Multiple Image Upload</font>
                                   <div id="spin1" style ="display:none;" style="margin-top: 15px"></div>
                                   <div id="previewNewsImageEdit" class="previewMultiImage" >';
                                    foreach($productPicture as $key_picture =>$value_picture){
                                       $list.="<div class='img-wrap'><img src='".HTTP_LOGO_PATH.$value_picture->picture_url."'> <input type='hidden' value='".$value_picture->picture_url."' name='image[]'><div class='close-button'></div></div>";
                                    }
                                   $list.='</div>
                               </div>
                           </div>';
            }
        }

        $list.='<div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-4 col-sm-offset-4">
                        <button   class="btn-u btn-u-blue" type="button" onclick="onSubmitEditForm()"><i class="fa fa-check-circle-o" style="margin-right:4px"></i>'.Lang::get('user.save').'</button>
                        <button data-dismiss="modal" class="btn-u btn-u-default" type="button"><i class="fa fa-repeat" style="margin-right:4px"></i>'.Lang::get('user.cancel').'</button>
                    </div>
                </div>';
        $list .='</div>';
        $list .='<div class="form-horizontal" id="editQuickDetailFormDiv" style="display: none">
                        <div class="alert alert-danger fade in" style="display: none" id="alertEditDangerFadeIn">'.Lang::get('user.please_check_quick_details').'</div>';
                        foreach($quickDetailsCategory as $key_category =>$value_category){
                            $list.='<div class="form-group">
                                <div class="col-md-12">
                                    <h3>';
                                        $category = QuickDetailsModel::getCategory($value_category->category_id);
                                        $list .= $category->categoryname;
                                $list.='</h3>
                                </div>
                            </div>';

                                $lists = QuickDetailsModel::getAll($value_category->category_id);
                            foreach($lists as $key_list =>$value_key){
                                $list .='<div class="form-group">
                                    <div class="col-md-12">
                                        <input type="checkbox" name="quick_details[]" value="'.ucfirst($value_key->quick_details_name).'"> '.ucfirst($value_key->quick_details_name).'
                                    </div>
                                </div>';
                            }
                        }
                        $list.='<div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-4 col-sm-offset-4">
                                <button   class="btn-u btn-u-blue" type="button" onclick="onChangeEditQuickDetail()"><i class="fa fa-check-circle-o" style="margin-right:4px"></i>'.Lang::get('user.save').'</button>
                                <button   class="btn-u btn-u-default" type="button" onclick="onReturnSecondDiv()"><i class="fa fa-repeat" style="margin-right:4px"></i>'.Lang::get('user.cancel').'</button>
                            </div>
                        </div>
                    </div>';
        $data = array('result'=> 'success', 'list' => $list);
        return Response::json($data);
    }

}