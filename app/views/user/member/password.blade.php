@extends('user.member.layout')
    @section('list')
         <li><a href="{{URL::route('user.member.password')}}">{{Lang::get('user.change_password')}}</a></li>
    @stop
    @section('body-content')
         <div class="tab-content">
             <div class="tab-pane fade active in margin-bottom-40" id="home-2">
                <h4>{{Lang::get('user.change_password')}}</h4>
                <div class="row">
                    <form method="post" action="{{URL::route('user.member.passwordStore')}}" class="col-md-12 form-horizontal">
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
                                {{Lang::get('user.current_password')}}
                                <span style="color:red">*</span>
                            </label>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type='password' class="form-control" placeholder="{{Lang::get('user.current_password')}}"  name="currentPassword">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-3 col-md-4 col-sm-4 control-label">
                                {{Lang::get('user.new_password')}}
                                <span style="color:red">*</span>
                            </label>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type='password' class="form-control" placeholder="{{Lang::get('user.new_password')}}"  name="password">
                            </div>
                        </div>
                        <div class="form-group margin-bottom-40">
                            <label for="" class="col-lg-3 col-md-4 col-sm-4 control-label">
                                {{Lang::get('user.confirm_password')}}
                                <span style="color:red">*</span>
                            </label>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type='password' class="form-control" placeholder="{{Lang::get('user.confirm_password')}}"  name="password_confirmation">
                            </div>
                        </div>
                        <div class="form-group" >
                             <div class="col-lg-7 col-md-7 col-sm-7 col-lg-offset-3 col-md-offset-4 col-sm-offset-4">
                                <input type="submit" class="btn-u btn-u-blue" value="{{Lang::get('user.change')}}">
                              </div>
                        </div>
                    </form>
                </div>
             </div>
         </div>
    @stop
@stop