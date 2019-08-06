@extends('user.member.layout')
    @section('list')
         <li><a href="{{URL::route('user.member')}}">{{Lang::get('user.personal_information')}}</a></li>
    @stop
    @section('body-content')
        <div class="tab-content">
             <div class="tab-pane fade active in margin-bottom-40" id="home-2">
                <h4>{{Lang::get('user.personal_information')}} </h4>
                <div class="row" style="margin-top: 20px">
                    <form class="col-md-12 form-horizontal" action="{{URL::route('user.member.personal')}}" method="post">
                        @if ($errors->has())
                        <div class="alert alert-danger alert-dismissibl fade in">
                            <button type="button" class="close" data-dismiss="alert">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                        @endif
                        <?php if (isset($alert)) { ?>
                             <div class="alert alert-<?php echo $alert['type'];?> alert-dismissibl fade in">
                                 <button type="button" class="close" data-dismiss="alert">
                                     <span aria-hidden="true">&times;</span>
                                     <span class="sr-only">Close</span>
                                 </button>
                                 <p>
                                     <?php echo $alert['msg'];?>
                                 </p>
                             </div>
                         <?php } ?>
                        <div class="form-group">
                            <label for="" class="col-lg-3 col-md-4 col-sm-4 control-label">
                                {{Lang::get('user.email_address')}}
                                <span style="color:red">*</span>
                            </label>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type='text' class="form-control" placeholder=""  value="{{$userProfile->email}}" name="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-3 col-md-4 col-sm-4 control-label">
                                {{Lang::get('user.first_name')}}
                                <span style="color:red">*</span>
                            </label>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type='text' class="form-control" placeholder=""  value="{{$userProfile->firstname}}" name="firstname">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-3 col-md-4 col-sm-4 control-label">
                                {{Lang::get('user.last_name')}}
                                <span style="color:red">*</span>
                            </label>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type='text' class="form-control" placeholder=""  value="{{$userProfile->lastname}}" name="lastname">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-3 col-md-4 col-sm-4 control-label">
                                {{Lang::get('user.address')}}
                                <span style="color:red">*</span>
                            </label>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type='text' class="form-control" placeholder=""  value="{{$userProfile->street}}" name="address">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-3 col-md-4 col-sm-4 control-label">
                                {{Lang::get('user.city')}}
                                <span style="color:red">*</span>
                            </label>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type='text' class="form-control" placeholder=""  value="{{$userProfile->city}}" name="city">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-3 col-md-4 col-sm-4 control-label">
                                {{Lang::get('user.state')}}
                            </label>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type='text' class="form-control" placeholder=""  value="{{$userProfile->state}}" name="state">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-3 col-md-4 col-sm-4 control-label">
                                {{Lang::get('user.country')}}
                                <span style="color:red">*</span>
                            </label>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <select class="form-control" name="country">
                                    @foreach($country as $key=>$countries)
                                        @if($countries->id == $userProfile->country_id)
                                            <option value="{{$countries->id}}" selected>{{$countries->country_name}}</option>
                                        @else
                                            <option value="{{$countries->id}}">{{$countries->country_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-3 col-md-4 col-sm-4 control-label">
                                {{Lang::get('user.zip_code')}}
                                <span style="color:red">*</span>
                            </label>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type='text' class="form-control" placeholder=""  value="{{$userProfile->zipcode}}" name="zipcode">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-3 col-md-4 col-sm-4 control-label">
                                {{Lang::get('user.phone_number')}}
                                <span style="color:red">*</span>
                            </label>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type='text' class="form-control" placeholder=""  value="{{$userProfile->phonenumber}}" name="phone_number">
                            </div>
                        </div>
                         <div class="form-group">
                            <label for="" class="col-lg-3 col-md-4 col-sm-4 control-label">
                                {{Lang::get('user.working_number')}}
                            </label>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type='text' class="form-control" placeholder=""  value="{{$userProfile->workingnumber}}" name="working_number">
                            </div>
                        </div>
                        <div class="form-group margin-bottom-40">
                            <label for="" class="col-lg-3 col-md-4 col-sm-4 control-label">
                                {{Lang::get('user.company_name')}}
                            </label>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type='text' class="form-control" placeholder=""  value="{{$userProfile->companyname}}" name="companyname">
                            </div>
                        </div>
                        <div class="form-group" >
                             <div class="col-lg-7 col-md-7 col-sm-7 col-lg-offset-3 col-md-offset-4 col-sm-offset-4">
                                <input type="submit" class="btn-u btn-u-blue" value="{{Lang::get('user.save')}}">
                              </div>
                        </div>
                    </form>
                </div>
             </div>
        </div>
    @stop
@stop
