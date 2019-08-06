<?php namespace User;

use Illuminate\Routing\Controllers\Controller;
use View, Input, Redirect, Session, Validator, DB, Mail,File, Request,Response,Lang;
use Members as MembersModel,Category as CategoryModel,Product as ProductModel,ProductPicture as ProductPictureModel,
    SubCategory as SubCategoryModel, UserCategory as UserCategoryModel,Currency as CurrencyModel,CompanyProfile as CompanyProfileModel,
    Business as BusinessModel, ProductFocus as ProductFocusModel,Employees as EmployeesModel, FactorySize as FactorySizeModel,
    ProductQuickDetail as ProductQuickDetailModel,ProductAdditionalCategory as ProductAdditionalCategoryModel,ProductAdditionalImage as  ProductAdditionalImageModel;
class CategoryController extends \BaseController {
    public function index(){
        $param['pageNo'] =20;
        $param['category'] = CategoryModel::whereRaw(true)->orderBy('categoryname','asc')->get();
        return View::make('user.category.index')->with($param);
    }
    public function sub($id){
        $param['pageNo'] =20;
        $listID = $id-100000;
        $param['subCategoryID'] = SubCategoryModel::find($listID);
        $categoryID = $param['subCategoryID']->category_id;
        $param['selectedCategory'] = CategoryModel::find($categoryID);
        $param['subCategory'] = SubCategoryModel::whereRaw('category_id=?',array($categoryID))->get();
        $param['selectSubCategory'] = $listID;
        $param['helps'] =ProductModel::whereRaw('subcategory_id=?',array($listID))->orderBy('id','desc')->paginate(10);
        $param['selectCategory'] = $categoryID;
        $param['category'] = CategoryModel::whereRaw(true)->orderBy('categoryname','asc')->get();
        return View::make('user.category.sub')->with($param);
    }
    public function search(){
        $searchTitle = Input::get('searchTitle');
        $param['pageNo'] =20;
        $param['category'] = CategoryModel::whereRaw(true)->orderBy('categoryname','asc')->get();
        $param['helps'] = ProductModel::where('product_name','LIKE','%'.$searchTitle.'%')->orWhere('meta','LIKE','%'.$searchTitle.'%')->paginate(10);
        $param['helps']->appends(array('searchTitle' => $searchTitle));
        $param['title'] = Lang::get('user.search_result');
        return View::make('user.category.search')->with($param);
    }
    public function product($id,$id2 = false){
        $listID = $id-100000;
        if ($id2 == false){
            $param['productPicture1'] = ProductPictureModel::whereRaw('product_id =?', array($listID))->get();
            $param['main'] =0;
            $param['id'] =0;
        }else{
            $param['main'] =1;
            $param['id'] = $id2;
            $param['productAdditionalCategory'] = ProductAdditionalCategoryModel::find($id2);
            $param['productPicture1'] = ProductAdditionalImageModel::whereRaw('product_id =? and product_additional_category_id= ?', array($listID,$id2))->get();
        }
        $param['pageNo'] =20;
        $param['category'] = CategoryModel::whereRaw(true)->orderBy('categoryname','asc')->get();
        $param['productAdditionalCategorySize'] = ProductAdditionalCategoryModel::whereRaw('product_id = ? and role= ?', array($listID,0))->get();
        $param['productAdditionalCategoryColor'] = ProductAdditionalCategoryModel::whereRaw('product_id = ? and role= ?', array($listID,1))->get();
        $param['helps'] = ProductModel::find($listID);
        $param['productPicture'] = ProductPictureModel::whereRaw('product_id=?', array($listID))->get();
        $param['price1_unit'] = CurrencyModel::find($param['helps']->price1_currency);
        $param['price2_unit'] = CurrencyModel::find($param['helps']->price2_currency);
        $param['price3_unit'] = CurrencyModel::find($param['helps']->price3_currency);
        $userID = $param['helps']->user_id;
        $param['companyProfile'] = CompanyProfileModel::whereRaw('user_id = ?', array($userID))->get();
        if($param['companyProfile'][0]->busineestype !="0"){
            $param['business_type'] = BusinessModel::find($param['companyProfile'][0]->busineestype);
        }else{
            $param['business_type'] ="";
        }
        if($param['companyProfile'][0]->mainforcus !="0"){
            $param['productfocus'] = ProductFocusModel::find($param['companyProfile'][0]->mainforcus);
        }else{
            $param['productfocus'] = "";
        }
        if($param['companyProfile'][0]->employees !="0"){
            $param['employees'] = EmployeesModel::find($param['companyProfile'][0]->employees);
        }else{
            $param['employees'] = "";
        }
        if($param['companyProfile'][0]->factorysize !="0"){
            $param['factorysize'] = FactorySizeModel::find($param['companyProfile'][0]->factorysize);
        }else{
            $param['factorysize'] = "";
        }
        $param['quickDetails'] = ProductQuickDetailModel::whereRaw('product_id= ?', array($listID))->get();
        return View::make('user.category.product')->with($param);
    }
}