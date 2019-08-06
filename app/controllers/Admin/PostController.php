<?php namespace Admin;

use Illuminate\Routing\Controllers\Controller;
use Illuminate\Validation\Factory;
use Intervention\Image\Facades\Image;
use View, Input, Redirect, Session, Validator, DB,Request,Response,URL;
use Category as CategoryModel,Product as ProductModel,ProductPicture as ProductPictureModel,SubCategory as SubCategoryModel,
    CompanyProfile as CompanyProfileModel,Business as BusinessModel, ProductFocus as ProductFocusModel,Employees as EmployeesModel, FactorySize as FactorySizeModel,
    QuickDetails as QuickDetailsModel,Currency as CurrencyModel, Unit as UnitModel, AdditionalCategory as AdditionalCategoryModel,
    ProductAdditionalCategory as ProductAdditionalCategoryModel, ProductAdditionalImage as ProductAdditionalImageModel,
    ProductQuickDetail as ProductQuickDetailModel, ProductShipping as ProductShippingModel;
class PostController  extends \BaseController
{

    public function __construct()
    {
        $this->beforeFilter(function () {
            if (!Session::has('admin_id')) {
                return Redirect::route('admin.auth.login');
            }
        });
    }

    public function index()
    {
        $param['pageNo'] = 42;
        $param['product'] = ProductModel::whereRaw(true)->orderBy('created_at','desc')->get();
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        return View::make('admin.post.index')->with($param);
    }
    public function add($id){
        $param['pageNo'] = 42;
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $param['product'] = ProductModel::find($id);
        $param['productAdditionalCategory'] = ProductAdditionalCategoryModel::whereRaw('product_id=? and role= ?',array($id,1))->get();
        return View::make('admin.post.add')->with($param);
    }
    public function editImage($id){
        $param['pageNo'] = 42;
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $param['product'] = ProductModel::find($id);
        $param['productPictures'] = ProductPictureModel::whereRaw('product_id=?', array($id))->get();
        $param['productAdditionalCategory'] = ProductAdditionalCategoryModel::whereRaw('product_id=? and role= ?',array($id,1))->get();
        $param['productAdditionalCategoryImage'] = ProductAdditionalImageModel::whereRaw('product_id =?', array($id))->get();
        return View::make('admin.post.editImage')->with($param);
    }
    public function imageStore(){

        $rules = [
            'mainUrl'  => 'required'
        ];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Response::json(['result' =>'failed', 'error' =>$validator->getMessageBag()->toArray()]);
        }else{
            $productID = Input::get('productID');

            ProductAdditionalImageModel::whereRaw('product_id =?', array($productID))->delete();
            ProductPictureModel::whereRaw('product_id=?',array($productID))->delete();
            $product = ProductModel::find($productID);
            $mainUrl = Input::get('mainUrl');
            $userID = $product->user_id;
            /******Main Photo Upload****/
            $productImage = new ProductPictureModel;
            $productImage->user_id = $userID;
            $productImage->product_id = $productID;
            $productImage->picture_url = $mainUrl;
            $productImage->save();

            $main_pictures = Input::get('main_pictures');
            $main_pictureList = explode(',', $main_pictures[0]);
            if(count($main_pictureList)>1){
                for($i =0; $i<count($main_pictureList); $i++){
                    $productImage = new ProductPictureModel;
                    $productImage->user_id = $userID;
                    $productImage->product_id = $productID;
                    $productImage->picture_url = $main_pictureList[$i];
                    $productImage->save();
                }
            }

            /********color Image*******/
            $specification_descrition_pictures = Input::get('specification_descrition_pictures');
            $countAdditionalList = Input::get('countAdditionalCategory');
            $productAdditionalCategory = ProductAdditionalCategoryModel::whereRaw('product_id =? and role =? ',array($productID,1))->get();
            for($i=0;$i<$countAdditionalList; $i++){
                $specification_picture = explode(',', $specification_descrition_pictures[$i]);
                foreach($specification_picture as $key=>$value){
                    if($value !=""){
                        $productCategory = new ProductAdditionalImageModel;
                        $productCategory->user_id = $userID;
                        $productCategory->product_id = $productID;
                        $productCategory->additional_category_id = $productAdditionalCategory[$i]->additional_category_id;
                        $productCategory->product_additional_category_id = $productAdditionalCategory[$i]->id;
                        $productCategory->image_url = $value;
                       $productCategory->save();
                    }
                }
            }
        }
        return Response::json(['result' =>'success']);
    }
    public function create(){
        $param['pageNo'] = 42;
        $param['category'] = CategoryModel::whereRaw(true)->orderBy('categoryname','asc')->get();
        $param['currency'] = CurrencyModel::whereRaw(true)->orderBy('currency_name','asc')->get();
        $param['unit'] = UnitModel::whereRaw(true)->orderBy('unitname','asc')->get();
        $param['additionalCategories'] = AdditionalCategoryModel::all();
        $param['quickDetailsCategory'] = QuickDetailsModel::whereRaw(true)->groupBy('category_id')->get();
        return View::make('admin.post.create')->with($param);
    }

    public function edit($id){
        $product = ProductModel::find($id);
        $product ->admin_active = 1;
        $product ->save();

        $param['pageNo'] = 42;
        $param['product'] = ProductModel::find($id);
        $param['additionalCategories'] = AdditionalCategoryModel::all();
        $param['productAdditionalCategorySize'] = ProductAdditionalCategoryModel::whereRaw('product_id =? and role = ?', array($id,0))->get();
        $param['productAdditionalCategoryColor'] = ProductAdditionalCategoryModel::whereRaw('product_id =? and role = ?', array($id,1))->get();
        $param['productPicture'] = ProductPictureModel::whereRaw('product_id = ?', array($id))->get();
        $param['category'] = CategoryModel::whereRaw(true)->orderBy('categoryname','asc')->get();
        $param['subcategory'] = SubCategoryModel::whereRaw('category_id = ?', array($param['product']->category_id))->get();
        $param['currency'] = CurrencyModel::whereRaw(true)->orderBy('currency_name','asc')->get();
        $param['unit'] = UnitModel::whereRaw(true)->orderBy('unitname','asc')->get();
        $param['quickDetailsCategory'] = QuickDetailsModel::whereRaw(true)->groupBy('category_id')->get();
        $param['productQuickDetails'] = ProductQuickDetailModel::whereRaw('product_id=?', array($id))->get();
        $param['productShipping']= $param['product']->productShipping;
        return View::make('admin.post.edit')->with($param);
    }
    public function getSubcategory(){
        if(Request::ajax()){
            $categoryID = Input::get('categoryID');
            $subcategory = SubCategoryModel::whereRaw('category_id = ?', array($categoryID))->get();
            $data = array('result'=> 'success', 'subcategory' => $subcategory);
        }
        return Response::json($data);
    }
    public function specificationPicutre(){
        if(Request::ajax()){
            $rules = [
                'file_upload'  => 'required|image|max:1024 ',
            ];
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return Response::json(['result' =>'failed', 'error' =>$validator->getMessageBag()->toArray()]);
            }else{
                if (Input::hasFile('file_upload')) {
                    $filename = str_random(24) . "." . Input::file('file_upload')->getClientOriginalExtension();
                    $path = ABS_LOGO_PATH.$filename;
//                    Image::make(Input::file('file_upload')->getRealPath())->resize(973,615)->save($path);
                    Input::file('file_upload')->move(ABS_LOGO_PATH, $filename);
                    $userImageList = $filename;
                }
                $url = HTTP_LOGO_PATH.$userImageList;
                $data="<img src='".HTTP_LOGO_PATH.$userImageList."'>";
                return Response::json(['result' =>'success', 'content' =>$data, 'url' =>$userImageList,'image_url' =>$url]);
            }
        }
    }
    public function store(){
       // $Images = Input::get('image');

        $rules = [
            'country_id'  => 'required ',
            'subcategory'  => 'required ',
            'product_name' => 'required ',
            'meta'  => 'required',
            'product_price1'     => 'required | numeric',
            'product_price1currency'    => 'required ',
            'product_price2'     => 'required | numeric',
            'product_price2currency'    => 'required ',
            'product_price3'     => 'required | numeric',
            'product_price3currency'    => 'required ',
            'min_order' =>'required | numeric',
            'supply_ability' =>'required | numeric',
            'min_orderunit'    => 'required ',
            'supply_abilityunit'    => 'required ',
        ];



        if(Input::get('shipping1') == 1){
            $rules['flatRate1'] = "required| numeric";
            $rules['flatRateCurrency1'] = "required";
        }
        if(Input::get('shipping2') == 1){
            $rules['flatRate2'] = "required| numeric";
            $rules['flatRateCurrency2'] = "required";
        }
        if(Input::get('shipping3') == 1){
            $rules['flatRate3'] = "required| numeric";
            $rules['flatRateCurrency3'] = "required";
        }
        $sizes = Input::get('size');
        if(count($sizes) >0 ){
            foreach($sizes as $key =>$val){
                if($key != count($sizes)-1){
                    $rules['size.'.$key] ='required|max:10|regex:/^[a-zA-Z0-9]+$/';
                }
            }
        }
        $colors = Input::get('color');
        if(count($colors) >0 ){
            foreach($colors as $key =>$value){
                if($key != count($colors)-1){
                    $rules['color.'.$key] ='required|max:10|regex:/^[a-zA-Z]+$/';
                }
            }
        }

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Response::json(['result' =>'failed', 'error' =>$validator->getMessageBag()->toArray()]);
        }else{
            if (Input::has('productID')) {
                $id = Input::get('productID');
                $product = ProductModel::find($id);
//                ProductPictureModel::whereRaw('product_id = ?', array($id))->delete();
            }else{
                $product = new ProductModel;
            }

            if(session::get('admin_id') == "1"){
                $userID = 1;
            }
            $product->user_id = $userID;
            $product->category_id = Input::get('country_id');
            $product->subcategory_id = Input::get('subcategory');
            $product->product_name = Input::get('product_name');
            $product->product_description = Input::get('subContent');
            $product->meta= Input::get('meta');
            $product->product_price1 = Input::get('product_price1');
            $product->price1_currency = Input::get('product_price1currency');
            $product->product_price2 = Input::get('product_price2');
            $product->price2_currency = Input::get('product_price2currency');
            $product->product_price3 = Input::get('product_price3');
            $product->price3_currency = Input::get('product_price3currency');
            $product->min_order = Input::get('min_order');
            $product->supply_ability = Input::get('supply_ability');
            $product->min_order_unit = Input::get('min_orderunit');
            $product->supply_ability_unit = Input::get('supply_abilityunit');
            $product->additional_category_id = Input::get('additionalCategory');
            $product->save();
            if (Input::has('productID')) {
                $productID = Input::get('productID');
            }else{
                $sql = "SELECT *, MAX(id) AS maxID FROM np_product";
                $order = DB::select($sql);
                $productID = $order[0]->maxID;
            }
            $additionalCategory  = Input::get('additionalCategory');
            if($additionalCategory == 1){
                if (Input::has('productID')) {
                    $productID = Input::get('productID');
                     ProductAdditionalCategoryModel::whereRaw('product_id =? and role = ?', array($productID,0))->delete();
                }
                $sizes = Input::get('size');
                foreach ($sizes as $key_size => $value_size){
                    if($value_size != ""){
                        $productAdditionalCategory= new ProductAdditionalCategoryModel;
                        $productAdditionalCategory->user_id = $userID;
                        $productAdditionalCategory->product_id = $productID;
                        $productAdditionalCategory->additional_category_id = $additionalCategory;
                        $productAdditionalCategory->values = $value_size;
                        $productAdditionalCategory->role = 0;
                        $productAdditionalCategory->save();
                    }

                }
            }elseif($additionalCategory == 2){
                $colors = Input::get('color');
                $productAdditionalCategoryColor = ProductAdditionalCategoryModel::whereRaw('product_id =? and role = ?', array($productID,1))->get();
                if(count($productAdditionalCategoryColor)>0){
                    foreach ($colors as $key_color => $value_color) {
                        if ($value_color != "") {
                            $k = 0;
                            foreach($productAdditionalCategoryColor as $key_additional => $value_additional){
                                if($value_additional->values == $value_color){
                                    $k = $k+1;
                                }
                            }
                            if($k == 0){
                                $productAdditionalCategory= new ProductAdditionalCategoryModel;
                                $productAdditionalCategory->user_id = $userID;
                                $productAdditionalCategory->product_id = $productID;
                                $productAdditionalCategory->additional_category_id = $additionalCategory;
                                $productAdditionalCategory->values = $value_color;
                                $productAdditionalCategory->role = 1;
                                $productAdditionalCategory->save();
                            }

                        }
                    }
                    $productAdditionalCategoryColor = ProductAdditionalCategoryModel::whereRaw('product_id =? and role = ?', array($productID,1))->get();
                    foreach($productAdditionalCategoryColor as $key_additional => $value_additional){
                        $k = 0;
                        foreach ($colors as $key_color => $value_color) {
                            if ($value_color != "") {
                               if($value_additional->values == $value_color){
                                   $k = $k+1;
                               }
                            }
                        }
                        if($k ==0){
                            ProductAdditionalCategoryModel::find($value_additional->id)->delete();
                        }
                    }
                }else{
                    foreach ($colors as $key_color => $value_color){
                        if($value_color != ""){
                            $productAdditionalCategory= new ProductAdditionalCategoryModel;
                            $productAdditionalCategory->user_id = $userID;
                            $productAdditionalCategory->product_id = $productID;
                            $productAdditionalCategory->additional_category_id = $additionalCategory;
                            $productAdditionalCategory->values = $value_color;
                            $productAdditionalCategory->role = 1;
                            $productAdditionalCategory->save();
                        }

                    }
                }

            }elseif($additionalCategory == 3){
                $sizes = Input::get('size');
                if (Input::has('productID')) {
                    $productID = Input::get('productID');
                    ProductAdditionalCategoryModel::whereRaw('product_id =? and role = ?', array($productID,0))->delete();
                }
                foreach ($sizes as $key_size => $value_size){
                    if($value_size != ""){
                        $productAdditionalCategory= new ProductAdditionalCategoryModel;
                        $productAdditionalCategory->user_id = $userID;
                        $productAdditionalCategory->product_id = $productID;
                        $productAdditionalCategory->additional_category_id = $additionalCategory;
                        $productAdditionalCategory->values = $value_size;
                        $productAdditionalCategory->role = 0;
                        $productAdditionalCategory->save();
                    }

                }
                $colors = Input::get('color');
                $productAdditionalCategoryColor = ProductAdditionalCategoryModel::whereRaw('product_id =? and role = ?', array($productID,1))->get();
                if(count($productAdditionalCategoryColor)>0){
                    foreach ($colors as $key_color => $value_color) {
                        if ($value_color != "") {
                            $k = 0;
                            foreach($productAdditionalCategoryColor as $key_additional => $value_additional){
                                if($value_additional->values == $value_color){
                                    $k = $k+1;
                                }
                            }
                            if($k == 0){
                                $productAdditionalCategory= new ProductAdditionalCategoryModel;
                                $productAdditionalCategory->user_id = $userID;
                                $productAdditionalCategory->product_id = $productID;
                                $productAdditionalCategory->additional_category_id = $additionalCategory;
                                $productAdditionalCategory->values = $value_color;
                                $productAdditionalCategory->role = 1;
                                $productAdditionalCategory->save();
                            }

                        }
                    }
                    $productAdditionalCategoryColor = ProductAdditionalCategoryModel::whereRaw('product_id =? and role = ?', array($productID,1))->get();
                    foreach($productAdditionalCategoryColor as $key_additional => $value_additional){
                        $k = 0;
                        foreach ($colors as $key_color => $value_color) {
                            if ($value_color != "") {
                                if($value_additional->values == $value_color){
                                    $k = $k+1;
                                }
                            }
                        }
                        if($k ==0){
                            ProductAdditionalCategoryModel::find($value_additional->id)->delete();
                        }
                    }
                }else{
                    foreach ($colors as $key_color => $value_color){
                        if($value_color != ""){
                            $productAdditionalCategory= new ProductAdditionalCategoryModel;
                            $productAdditionalCategory->user_id = $userID;
                            $productAdditionalCategory->product_id = $productID;
                            $productAdditionalCategory->additional_category_id = $additionalCategory;
                            $productAdditionalCategory->values = $value_color;
                            $productAdditionalCategory->role = 1;
                            $productAdditionalCategory->save();
                        }

                    }
                }
            }
            if (Input::has('productID')) {
                ProductQuickDetailModel::whereRaw('user_id=? and product_id=?', array($userID,$productID))->delete();
            }
            $label_select_question = Input::get('label_select_question');
            $quickDetails = Input::get('quickDetails');
            $countLabel = count($label_select_question);
            for($i =0; $i<$countLabel; $i++){
                if($label_select_question[$i] !="" && $quickDetails[$i] != ""){
                    $ProductQuickDetailModel = new ProductQuickDetailModel;
                    $ProductQuickDetailModel->user_id = $userID;
                    $ProductQuickDetailModel->product_id = $productID;
                    $ProductQuickDetailModel->categoryname = $label_select_question[$i];
                    $ProductQuickDetailModel->categorycontent = $quickDetails[$i];
                    $ProductQuickDetailModel->save();
                }
            }

            if(Input::has('productID')){
                ProductShippingModel::whereRaw('user_id=? and product_id=?', array($userID,$productID))->delete();
            }
            $ProductShippingModel  = new ProductShippingModel;
            $ProductShippingModel->user_id = $userID;
            $ProductShippingModel->product_id = $productID;
            for($i= 1; $i<4; $i++){
                $shippingType = "shipping_type".$i;
                $flatRate = "flat_rate".$i;
                $estimatedTime = "estimated_time".$i;
                $add = "add".$i;
                $ProductShippingModel->$shippingType = Input::get('shipping'.$i);
                if(Input::get('shipping'.$i) == 1){
                    $ProductShippingModel->$flatRate = Input::get('flatRate'.$i);
                    $ProductShippingModel->$add = Input::get('flatRateCurrency'.$i);
                }

                $ProductShippingModel->$estimatedTime = Input::get('estimatedTime'.$i);
            }
            $ProductShippingModel->save();


//            for($i=0; $i<count($Images); $i++){
//                $productImage = new ProductPictureModel;
//                $productImage->user_id = $userID;
//                $productImage->product_id = $productID;
//                $productImage->picture_url = $Images[$i];
//                $productImage->save();
//            }
        }
        if (Input::has('productID')) {
//            $alert['msg'] = 'Product has been updated successfully';
//            $alert['type'] = 'success';
//            return Redirect::route('admin.post.editImage', $productID)->with('alert', $alert);
               $url = URL::route('admin.post.editImage', $productID);
        }else{
//            $alert['msg'] = 'Product has been saved successfully';
//            $alert['type'] = 'success';
//            return Redirect::route('admin.post.add', $productID)->with('alert', $alert);
                $url = URL::route('admin.post.add', $productID);
        }
        return Response::json(['result' =>'success', 'url' =>$url]);

    }

    public function delete($id){
        try {
            ProductPictureModel::whereRaw('product_id =?', array($id))->delete();
            ProductModel::find($id)->delete();
            $alert['msg'] = 'This product has been deleted successfully';
            $alert['type'] = 'success';
        } catch(\Exception $ex) {
            $alert['msg'] = 'This product has been already used';
            $alert['type'] = 'danger';
        }
        return Redirect::route('admin.post')->with('alert', $alert);
    }
    public function view($id, $id2 = false){
        $product = ProductModel::find($id);
        $product ->admin_active = 1;
        $product ->save();
        if ($id2 == false){
            $param['productPicture'] = ProductPictureModel::whereRaw('product_id =?', array($id))->get();
            $param['main'] =0;
            $param['id'] =0;
        }else{
            $param['main'] =1;
            $param['id'] = $id2;
            $param['productAdditionalCategory'] = ProductAdditionalCategoryModel::find($id2);
            $param['productPicture'] = ProductAdditionalImageModel::whereRaw('product_id =? and product_additional_category_id= ?', array($id,$id2))->get();
        }
        $param['pageNo'] = 42;
        $param['product'] = ProductModel::find($id);
        $param['productAdditionalCategorySize'] = ProductAdditionalCategoryModel::whereRaw('product_id = ? and role= ?', array($id,0))->get();
        $param['productAdditionalCategoryColor'] = ProductAdditionalCategoryModel::whereRaw('product_id = ? and role= ?', array($id,1))->get();
        $param['price1_unit'] = CurrencyModel::find($param['product']->price1_currency);
        $param['price2_unit'] = CurrencyModel::find($param['product']->price2_currency);
        $param['price3_unit'] = CurrencyModel::find($param['product']->price3_currency);
        $param['quickDetails'] = ProductQuickDetailModel::whereRaw('product_id= ?', array($id))->get();
        if($param['product']->user_id != 1){
            $userID = $param['product']->user_id;
            $param['companyProfile'] = CompanyProfileModel::whereRaw('user_id = ?', array($userID))->get();
            $param['business_type'] = BusinessModel::find($param['companyProfile'][0]->busineestype);
            $param['productfocus'] = ProductFocusModel::find($param['companyProfile'][0]->mainforcus);
            $param['employees'] =EmployeesModel::find($param['companyProfile'][0]->employees);
            $param['factorysize'] =FactorySizeModel::find($param['companyProfile'][0]->factorysize);
        }
        return View::make('admin.post.view')->with($param);
    }
}