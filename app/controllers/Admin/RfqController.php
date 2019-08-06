<?php namespace Admin;

use Illuminate\Routing\Controllers\Controller;
use Illuminate\Validation\Factory;
use View, Input, Redirect, Session, Validator, DB,Request,Response;
use Members as MembersModel,Rfq as RfqModel, RfqPicture as RfqPictureModel,RfqFile as RfqFileModel,RfqSpe as RfqSpeModel,
    RfqSpePicture as RfqSpePictureModel,Currency as CurrencyModel,Members as MemberModel,Unit as UnitModel;
class RfqController  extends \BaseController
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
        $param['pageNo'] = 41;
        $param['rfq'] = RfqModel::whereRaw(true)->orderBy('created_at','desc')->get();
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        return View::make('admin.rfq.index')->with($param);
    }
    public function create(){
        $param['pageNo'] = 41;
        $param['currencies']=CurrencyModel::whereRaw(true)->orderBy('currency_name','asc')->get();
        $param['units'] = UnitModel::all();
        return View::make('admin.rfq.create')->with($param);
    }

    public function edit($id){
        $param['pageNo'] = 41;
        $param['currencies']=CurrencyModel::whereRaw(true)->orderBy('currency_name','asc')->get();
        $rfq = RfqModel::find($id);
        $rfq->admin_active = 1;
        $rfq->save();
        $param['rfq'] = RfqModel::find($id);
        $param['units'] = UnitModel::all();
        return View::make('admin.rfq.edit')->with($param);
    }

    /**specification Image Upload**/
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
                    Input::file('file_upload')->move(ABS_LOGO_PATH, $filename);
                    $userImageList = $filename;
                }
               $data="<img src='".HTTP_LOGO_PATH.$userImageList."'>";
                return Response::json(['result' =>'success', 'content' =>$data, 'url' =>$userImageList]);
            }
        }

    }
    public function file(){
        if(Request::ajax()){
            $rules = [
                'file'  => 'required|mimes:txt,pdf,doc,docx ',
            ];
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return Response::json(['result' =>'failed', 'error' =>$validator->getMessageBag()->toArray()]);
            }else{
                if (Input::hasFile('file')) {
                    $name = Input::file('file')->getClientOriginalName();
                    $fileExt = strtoupper(Input::file('file')->getClientOriginalExtension());
                    $filename = str_random(24) . "." . Input::file('file')->getClientOriginalExtension();
                    Input::file('file')->move(ABS_LOGO_PATH, $filename);
                    $userImageList = $filename;
                    $datalist = '';
                    if($fileExt == "PDF"){
                        $listData = "<img src='".HTTP_PATH."/assets/assest_admin/images/pdf.jpg' class='fileItemPDF' >
                                    <input type='hidden' value='".$userImageList."' id='files_list'>
                                    <div class='fileHref'>
                                        <a href='".HTTP_LOGO_PATH.$userImageList."' target='_blank'><span class='fileName'>".$name."</span></a>
                                        <input type='hidden' value='PDF' class='forestchange' id='forestchange'>
                                    </div>";
                    }else if($fileExt == "DOC" ||$fileExt == "DOCX" ){
                        $listData = "<img src='".HTTP_PATH."/assets/assest_admin/images/word.jpg' class='fileItemPDF' >
                                    <input type='hidden' value='".$userImageList."' id='files_list'>
                                    <div class='fileHref'>
                                        <a href='".HTTP_LOGO_PATH.$userImageList."' target='_blank'><span class='fileName'>".$name."</span></a>
                                        <input type='hidden' value='DOC' class='forestchange' id='forestchange'>
                                    </div>";
                    }else if($fileExt == "TXT" ){
                        $listData = "<img src='".HTTP_PATH."/assets/assest_admin/images/txt.jpg' class='fileItemPDF' >
                                     <input type='hidden' value='".$userImageList."' id='files_list'>
                                    <div class='fileHref'>
                                        <a href='".HTTP_LOGO_PATH.$userImageList."' target='_blank'><span class='fileName'>".$name."</span></a>
                                         <input type='hidden' value='TXT' class='forestchange' id='forestchange'>
                                    </div>";
                    }
                    return Response::json(['result' =>'success', 'content' =>$listData]);
                }
            }

        }
    }
    public function restore(){
        if(Request::ajax()) {
            $rules = [
                'product_name' => 'required',
                'product_description' => 'required',
                'purchase_quantity' => 'required|numeric',
                'quantity_unit' => 'required',
                'item_price' => 'required|numeric',
                'currency' => 'required',
            ];
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return Response::json(['result' => 'failed', 'error' => $validator->getMessageBag()->toArray()]);
            } else {
                $rfqID = Input::get('rfq_id');
                RfqPictureModel::whereRaw('rfq_id = ?', array($rfqID))->delete();
                RfqFileModel::whereRaw('rfq_id = ?', array($rfqID))->delete();
                $images = array();
                $files = array();
                $images = Input::get('images');
                $files = Input::get('files');
                if(session::get('admin_id') == "1"){
                    $buyerID = 1;
                }
                $rfq = RfqModel::find($rfqID);
                $rfq_type = Input::get("rfq_type");
                $rfq->rfq_title= Input::get('product_name');
                $rfq->rfq_description = Input::get('product_description');
                $rfq->rfq_quantity = Input::get('purchase_quantity');
                $rfq->rfq_unit = Input::get('quantity_unit');
                $rfq->rfq_unitprice = Input::get('item_price');
                $rfq->rfq_itemunit =Input::get('currency');
                $rfq->rfq_type = $rfq_type;
                $rfq->rfq_approve =1;
                $rfq->save();

                for($i =0; $i<count($images); $i++){
                    $rfqImage = new RfqPictureModel;
                    $rfqImage->rfq_id = $rfqID;
                    $rfqImage->buyer_id = $buyerID;
                    $rfqImage->picture_url = $images[$i];
                    $rfqImage->save();
                }


                if(count($files) != 0) {
                    for ($i = 0; $i < count($files); $i++) {
                        $files_list = explode(',', $files[$i]);
                        $rfqFile = new RfqFileModel;
                        $rfqFile->rfq_id = $rfqID;
                        $rfqFile->buyer_id = $buyerID;
                        $rfqFile->file_name = $files_list[1];
                        $rfqFile->file_url = $files_list[0];
                        $rfqFile->file_type = $files_list[2];
                        $rfqFile->save();
                    }
                }
                if($rfq_type == "detailed") {
                    $specification_description = Input::get('specification_description');
                    $specification_allowAlternative= Input::get('specification_allowAlternative');
                    $specification_descrition_pictures = Input::get('specification_descrition_pictures');
                    $specification_id = Input::get('specification_id');
                    for($i=0; $i<count($specification_description); $i++){
                        if($specification_description[$i] != ""){
                        $description = explode(',',$specification_description[$i]);
                        if($description[1] != ""){
                            $rfq_specification = RfqSpeModel::find($description[1]);
                            RfqSpePictureModel::whereRaw('specification_id = ? ', array($description[1]))->delete();
                        }else{
                            $rfq_specification = new RfqSpeModel;
                        }
                        $rfq_specification->rfq_id = $rfqID;
                        $rfq_specification->buyer_id = $buyerID;
                        $rfq_specification->rfq_description = $description[0];
                        $rfq_specification->rfq_alternative_ok = $specification_allowAlternative[$i];
                        $rfq_specification->save();
                        if($description[1] != ""){
                            $rfq_specificationID = $description[1];
                        }else{
                            $sql = "SELECT  MAX(id) AS maxID FROM np_rfq_specification";
                            $order = DB::select($sql);
                            $rfq_specificationID = $order[0]->maxID;
                        }
                        $specification_picture = explode(',', $specification_descrition_pictures[$i]);
                        for($j=0; $j<count($specification_picture); $j++){
                            $rfq_specification_picture = new RfqSpePictureModel;
                            $rfq_specification_picture->rfq_id = $rfqID;
                            $rfq_specification_picture->buyer_id = $buyerID;
                            $rfq_specification_picture->specification_id = $rfq_specificationID;
                            $rfq_specification_picture->picture_url = $specification_picture[$j];
                            $rfq_specification_picture->save();
                        }
                        }
                    }
                }

            }
        }
        return Response::json(['result' =>'success']);
    }
    public function store(){
        if(Request::ajax()){
            $rules = [
                'product_name'  => 'required',
                'product_description' => 'required',
                'purchase_quantity' => 'required|numeric',
                'quantity_unit' => 'required',
                'item_price' => 'required|numeric',
                'currency' => 'required',
            ];
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return Response::json(['result' =>'failed', 'error' =>$validator->getMessageBag()->toArray()]);
            }else{
                $images = array();
                $files = array();
                $rfq_type = Input::get("rfq_type");
                $images =   Input::get('images');
                $files =    Input::get('files');
                    $rfq = new RfqModel;
                    if(session::get('admin_id') == "1"){
                        $buyerID = 1;
                    }

                    $rfq->buyer_id = $buyerID;
                    $rfq->rfq_title= Input::get('product_name');
                    $rfq->rfq_description = Input::get('product_description');
                    $rfq->rfq_quantity = Input::get('purchase_quantity');
                    $rfq->rfq_unit = Input::get('quantity_unit');
                    $rfq->rfq_unitprice = Input::get('item_price');
                    $rfq->rfq_itemunit =Input::get('currency');
                    $rfq->rfq_type = $rfq_type;
                    $rfq->admin_active = 1;
                    $rfq->rfq_approve =1;
                    $rfq->save();


                    $sql = "SELECT  MAX(id) AS maxID FROM np_rfq";
                    $order = DB::select($sql);
                    $rfqID = $order[0]->maxID;
                    for($i =0; $i<count($images); $i++){
                        $rfqImage = new RfqPictureModel;
                        $rfqImage->rfq_id = $rfqID;
                        $rfqImage->buyer_id = $buyerID;
                        $rfqImage->picture_url = $images[$i];
                        $rfqImage->save();
                    }
                    if(count($files) != 0) {
                        for ($i = 0; $i < count($files); $i++) {
                            $files_list = explode(',', $files[$i]);
                            $rfqFile = new RfqFileModel;
                            $rfqFile->rfq_id = $rfqID;
                            $rfqFile->buyer_id = $buyerID;
                            $rfqFile->file_name = $files_list[1];
                            $rfqFile->file_url = $files_list[0];
                            $rfqFile->file_type = $files_list[2];
                            $rfqFile->save();
                        }
                    }



                if($rfq_type == "detailed"){
                    $specification_description = Input::get('specification_description');
                    $specification_allowAlternative= Input::get('specification_allowAlternative');
                    $specification_descrition_pictures = Input::get('specification_descrition_pictures');

                    for($i=0; $i<count($specification_description); $i++){
                        if($specification_description[$i] != ""){
                            $rfq_specification = new RfqSpeModel;
                            $rfq_specification->rfq_id = $rfqID;
                            $rfq_specification->buyer_id = $buyerID;
                            $rfq_specification->rfq_description = $specification_description[$i];
                            $rfq_specification->rfq_alternative_ok = $specification_allowAlternative[$i];
                            $rfq_specification->save();

                            $sql = "SELECT  MAX(id) AS maxID FROM np_rfq_specification";
                            $order = DB::select($sql);
                            $rfq_specificationID = $order[0]->maxID;

                            $specification_picture = explode(',', $specification_descrition_pictures[$i]);
                            for($j=0; $j<count($specification_picture); $j++){
                                $rfq_specification_picture = new RfqSpePictureModel;
                                $rfq_specification_picture->rfq_id = $rfqID;
                                $rfq_specification_picture->buyer_id = $buyerID;
                                $rfq_specification_picture->specification_id = $rfq_specificationID;
                                $rfq_specification_picture->picture_url = $specification_picture[$j];
                                $rfq_specification_picture->save();
                            }
                        }
                    }
                }

            }
        }
        return Response::json(['result' =>'success']);
    }
    public function delete($id){
        try {
            RfqModel::find($id)->delete();
            $alert['msg'] = 'This RFQ has been deleted successfully';
            $alert['type'] = 'success';
        } catch(\Exception $ex) {
            $alert['msg'] = 'This RFQ focus has been already used';
            $alert['type'] = 'danger';
        }
        return Redirect::route('admin.rfq')->with('alert', $alert);
    }
    public function view($id){
        $param['pageNo'] = 41;
        $rfq = RfqModel::find($id);
        $rfq->admin_active = 1;
        $rfq->save();
        $param['rfq'] = RfqModel::find($id);
        $param['currencies']=CurrencyModel::find($param['rfq']->rfq_itemunit);
        return View::make('admin.rfq.view')->with($param);
    }
}