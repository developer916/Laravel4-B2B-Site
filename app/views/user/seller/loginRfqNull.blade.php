@extends('user.seller.layout')
    @section('custom-styles')
         {{HTML::style('/assets/asset_view/css/blocks.css')}}
    @stop
    @section('body-right')
        <div class="col-md-offset-1 col-md-8 rightMenu col-sm-8 col-sm-offset-1">
            <div class="row">
                <div class="col-md-12 favoriteContentBody">
                    <div class="row" style="margin-top: 40px">
                        <div class="col-md-8 col-sm-8 col-md-offset-2 col-sm-offset-2">
                            <form action="{{URL::route('user.seller.loginSearch')}}">
                                <div class="col-md-9 col-sm-9 col-xs-9" id="bloodhound">
                                    <input type="text" class="form-control" placeholder='{{Lang::get('user.what_you_are_looking_for')}}' id="helpSearchText" name="searchTitle">
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-3 helpSearchButtonDiv">
                                    <button class="btn-u btn-u-blue helpSearchButton"><i class="search fa fa-search search-button"></i> {{Lang::get('user.search')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                 </div>
            </div>
        </div>
    @stop
    @section('custom-scripts')
        <script type="text/javascript">
            function onSendEmail(){
                bootbox.alert("{{ Lang::get('missing.you_did_not_get_email_from_buyer') }}");
            }

        </script>
    @endsection
@stop