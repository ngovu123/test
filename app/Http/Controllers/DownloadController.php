<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Media;
use App\Setting;
use DB,Input,Auth;
use Request;
use Response;
use URL;
use View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Routing\Controller as BaseController;
use Session;

class DownloadController extends BaseController {

	public function index($id,$slug){
		$images   = DB::table('media')->where('status','=',1)->where("id", "=", $id)->first();
		$popular  = DB::table('media')->where('status','=',1)->orderBy('count_download', 'DESC')->take(5)->get();

		$mostlike = DB::table('media')->where('status','=',1)->where('user_id','=',$images->user_id)->orderBy('count_download', 'DESC')->take(4)->get();

		$alsolike = DB::table('media')->where('status','=',1)->orderByRaw("RAND()")->where("id", "!=", $id)->take(3)->get();
		$settings = Setting::first();
		$previous = DB::table('media')->where('status','=',1)->where('id', '<', $id)->max('id');
		$next     = DB::table('media')->where('status','=',1)->where('id', '>', $id)->min('id');
		$imgshare = DB::table('media')->where('status','=',1)->where("id", "=", $id)->first();
		if ($images->user_id==0) {
			$info = DB::table('admin_users')->where('id','=',1)->first();
		} else {
			$info = DB::table('users')->where('id','=',$images->user_id)->first();
		}
		$total = DB::table('media')->where('user_id','=',$images->user_id)->count();

		$md = Media::where('id','=',$id)->where('status','=',1)->first();
		return view('download.downloadpage', ['images'=>$images , 'popular'=>$popular, 'top'=>$mostlike, 'alsolike'=>$alsolike, 'settings'=>$settings, 'imgshare'=>$imgshare,'md'=>$md,'info'=>$info,'total'=>$total]);
	}

	public function countdownload($id){
		$imgdownload = Media::where("id", "=", $id)->first();
		$imgdownload->count_download = $imgdownload->count_download + 1;
		$imgdownload->time_download = date('Y-m-d H:i:s');
		$imgdownload->save();
		echo $imgdownload->count_download;
	}

	public function download($id, $page = 0){
		$imgdownload = DB::table('media')->where('status','=',1)->where("id", "=", $id)->first();
		//$filepath 	 = public_path('files\downloads\images') . "\\" . $imgdownload->name;
		$id_pay = DB::table('download_log')
				->where('media_id','=',$id)
				->where('user_id','=',Auth::user()->id)
				->whereRaw('DAY( download_log.created_at ) = DAY (CURRENT_DATE) and YEAR( download_log.created_at ) = YEAR (CURRENT_DATE) ')
				->first();
		if ($id_pay =='') {
			$images 	= DB::table('media')->where('status','=',1)->offset($page*12)->take(12)->orderBy('created_at', 'DESC')->get();
				$imghidden  = DB::table('media')->where('status','=',1)->where("id", "=", $id)->get();
			return view('download.overdownload', ['images'=>$images, 'imghidden'=>$imghidden]);
		} else {
			if ($imgdownload->typeFile == 'file') {			
				$filepath 	 = config('view.downloadfilepath'). $imgdownload->file;
				return response()->download($filepath);
			} elseif ($imgdownload->typeFile == 'url') {
				$filepath 	 = $imgdownload->file;
				return Redirect::to($filepath);
				//return header("Location:".$filepath);
			}
		}
		
	}
	public function afterdownload($id, $page = 0){
		Session::set('media_id',$id);
		$images 	= DB::table('media')->where('status','=',1)->where("id", "!=", $id)->offset($page*12)->take(12)->orderBy('created_at', 'DESC')->get();
		$imghidden  = DB::table('media')->where('status','=',1)->where("id", "=", $id)->get();
		return view('download.afterdownload', ['images'=>$images, 'imghidden'=>$imghidden]);
	}
	public function loadmore($pageNumber){
		$id = Input::get("post_id");
		$page = config('view.numPage');
		$pageNumber = $pageNumber;
		$offset = ($pageNumber - 1) * $page;
		return view('partials.loadmore_download', ['page'=>$page, 'pageNumber'=>$pageNumber, 'offset'=>$offset, 'id'=>$id]);
	}
}