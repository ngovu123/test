<?php

namespace App\Http\Controllers;

use View, DB;
use App\About;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;

class AboutController extends BackendController {

	public function index(){
		$abouts = DB::table('about')->where('id', '=', 1)->first();
		return view('about.aboutpage', ['abouts'=>$abouts]);
	}
}