<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Media;
use App\Bookmarks;
use App\Messenger;
use App\Reports;
use View,Session;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use Illuminate\Cookie\CookieJar;
use Symfony\Component\HttpFoundation\Cookie;
use Illuminate\Routing\Controller as BaseController;
use Auth,DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
class PagesController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'PagesController@showWelcome');
	|
	*/

	// ********** Main Home Controller //

	public function home($page = 0){

		if(Input::get('theme') == 'dark'):
			return Redirect::to('/')->withCookie('theme', 'dark');
		endif;

		if(Input::get('theme') == 'clear'):
			$cookie = Cookie::forget('theme');
			return Redirect::to('/')->withCookie($cookie);
		endif;

		$images = DB::table('media')->where('status','=',1)->orderBy('created_at', 'DESC')->paginate(20);

		// $top = DB::table('download_log')
		// 		->join('media', 'media.id', '=', 'download_log.media_id')
		// 		->selectRaw('media.*, COUNT(download_log.media_id) as total')
		// 		->whereRaw('WEEK( download_log.created_at ) = WEEK (CURRENT_DATE) and YEAR( download_log.created_at ) = YEAR (CURRENT_DATE) ')
		// 		->groupBy('download_log.media_id')
		// 		->orderBy('total','DESC')
		// 		->paginate(4);		
		$settings = DB::table('settings')->first();
		return view('home.homepage', ['images'=>$images, 'settings'=>$settings]);
	}
	public function loadmore($pageNumber){
		$page = config('view.numPage');
		$pageNumber = $pageNumber;
		$offset = ($pageNumber - 1) * $page;
		$imagesLoad = DB::table('media')->where('status','=',1)->offset($offset)->take($page)->orderBy('created_at', 'DESC')->get();
		return view('partials.loadmore', ['imagesLoad'=>$imagesLoad]);
	}

	public function like(Request $request, $id){	
		if(isset($_POST['id'])){			
			$id = intval($_POST['id']);
			$image = Media::where("id", "=", $id)->first();
			if ($request->session()->has('like')) {
				$arrLikes = $request->session()->get('like');
				if (in_array($id,$arrLikes)) {
					$image->count_like = $image->count_like - 1;
					$arrLikes = array_diff($arrLikes, [$id]);
					$request->session()->forget('like');
					$request->session()->put('like', $arrLikes);
				} else {
					$image->count_like = $image->count_like + 1;
					array_push($arrLikes,$id);
					$request->session()->forget('like');
					$request->session()->put('like', $arrLikes);
				}
			} else {
				$image->count_like = $image->count_like + 1;
				$arrLikes = [$id];		
				$request->session()->forget('like');
				$request->session()->put('like', $arrLikes);
			}
			$image->save();
			echo $image->count_like;
		}
	}
	// bookmarks
	public function bookmarks($id){	
		if(isset($_POST['id']))
		{
			$media = DB::table('bookmarks')->where('media_id','=',$id)->where('user_id','=',Auth::user()->id)->count();
			if ($media==0) {
				$bookmarks = new Bookmarks();
				$bookmarks->media_id = $id;
				$bookmarks->user_id = Auth::user()->id;
				$bookmarks->created_at = new DateTime();
				$bookmarks->save();
				echo '<i class="glyphicon glyphicon-bookmark"></i> Bookmarks done';
			} 
			else {

				$bookmarks = Bookmarks::where("media_id", "=", $id)->where('user_id','=',Auth::user()->id)->first();
				$bookmarks->delete();
				echo '<i class="glyphicon glyphicon-bookmark"></i> Removed Bookmarks';
			}
			
		}
	}
	// report
	public function report( Request $rq, $id){	
		if(isset($_POST['id']))
		{
			$count = DB::table('reports')->where('media_id','=',$id)->where('user_id','=',Auth::user()->id)->count();
			if ($count==0) {
				if (strlen ($rq->content)<=10) {
					echo '<span class="label label-warning"> Error: Messages must be longer than 10 characters !</span>';
				} 
				else {
					$rp = new Reports();
					$rp->media_id = $id;
					$rp->content = $rq->content;
					$rp->user_id = Auth::user()->id;				
					$rp->created_at = new DateTime();
					$rp->save();				
					echo '<span class="label label-success"> Success: message has been send  to Admin!</span>';
				}				
			} 
			else {
				echo '<span class=" label label-danger"> Error: You reported this media, then please wait for admin review</span>';
			}
			
		}
	}
	// send messager
	public function msg( Request $rq, $id){	

	 $validator = Validator::make(
            $rq->only('msg', 'captcha'),
            Messenger::$validators,Messenger::$msg
            );
        if ($validator->fails()) {
        		if ($validator->errors()->first('msg') !=''){
        			echo  '<span class="label label-danger"> error : '.$validator->errors()->first('msg').' !</span>';
        		} elseif($validator->errors()->first('captcha') !='') {
        			echo '<span class="label label-danger"> error :'.$validator->errors()->first('captcha').' !</span>';
        		}
				
				
        } else{

			if(isset($_POST['id']))
			{	

				if (Auth::user()->id != $id) {
					if (strlen ($rq->msg)<=10) {
						echo '<span class="label label-warning"> Error: Messages must be longer than 10 characters !</span>';
					}
					else {
						$rp = new Messenger();
						$rp->from = Auth::user()->id;
						$rp->to = $id;
						$rp->content = $rq->msg;				
						$rp->created_at = new DateTime();
						$rp->save();				
						echo 'Success: <span class="label label-success"> message has been sended !</span>';
					}
									
				} 
				else {
					echo '<span class="label label-danger"> Error: You can not send messages to yourself !</span>';	
				}
				
				
			}
		}
	}
	public function seacrh(Request $request){
		$name = $request->input('search');
		$search =Media::where('title', 'LIKE', '%'.$name.'%')->where('status','=',1)->get();
		return view('home.search', ['search'=>$search, 'name'=>$name]);
	}
	public function rss(){
		$rss = Media::where('status','=',1)->orderBy('time_download', 'DESC')->take(20)->get();
		return view('home.rss', ['rss'=>$rss]);
	}
	public function popular(){
		$popular  = DB::table('media')->where('status','=',1)->orderBy('count_download', 'DESC')->orderBy('time_download','DESC')->take(99)->get();
		return view('home.popular', ['popular'=>$popular]);
	}
	public function rules()
	{		
		$abouts = DB::table('about')->where('id', '=', 2)->first();
		return view('about.rulespage', ['abouts'=>$abouts]);
	}
}