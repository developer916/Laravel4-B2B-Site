<?php namespace User;

use Illuminate\Routing\Controllers\Controller;
use Session,Redirect;
class LanguageController  extends \BaseController {
    public function chooser($slug) {

        Session::set('locale', $slug);

        return Redirect::back();
    }
}