<?php

namespace App\Http\Controllers;
use App\User;
use App\Media;
use App\About;
use App\Setting;
use App\Categories;
use App\Images_preview;
use App\Messenger;
use App\Logpays;
use App\Reports;
use View, DB, File, Auth, Mail,datetime;
use App\ImageHandler;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;
use Session;

class AdminHomeController extends BackendController {

	public function __construct()
	{
		$this->middleware('admin');
	}

	public function index(){
		$media = DB::table('media')->count();
        $media_c = DB::table('media')->where('status','=',0)->count();
        $flag = DB::table('reports')->where('status','=',0)->count();
		$msg = DB::table('messenger')->where('u_to','=',0)->where('status','=',0)->count();
        $pay = DB::table('logpays')->where('status','=',0)->count();
		return view('admin.adminpage', ['media'=>$media,'media_c'=>$media_c,'r'=>$flag,'m'=>$msg,'pay'=>$pay]);
	}
	public function media(){
		$media  	= DB::table('media')->orderBy('id', 'DESC')->paginate(10);
		$countmedia = DB::table('media')->count();
		return view('admin.media', ['media'=>$media, 'countmedia'=>$countmedia]);
	}
	public function showaddmedia(){        
        if (Session::get('file') !='') {
            $pt = File::Delete(public_path('content/files/downloads/images/thumb/'.Session::get('file')) );
            Session::forget('file');
        }
		$categories = Categories::all();
		return view('admin.addmedia', ['categories'=>$categories]);
	}
    public function uploadimgs(request $rq)
    {
        
        list($type, $imageData) = explode(';', $rq->img);
        list(,$extension) = explode('/',$type);
        list(,$imageData)      = explode(',', $rq->img);
        $fileName = uniqid().'.'.$extension;
        $imageData = base64_decode($imageData);
        file_put_contents('public/content/files/downloads/images/thumb/'.$fileName, $imageData);
        Session::put('file', $fileName);
        return $fileName;
    }
	public function addnewmedia(Request $request){
		$validator  = Validator::make(
            $request->only('title', 'upimage', 'category', 'description'),
            Media::$validators
        );
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        } else{

            $media          = new Media;

            $media->title   = $request->input('title');
            $args           = array('image' => '', 'filename' => '');
            $media->name    =  $request->upimage;
            Session::forget('file');
            
            if ($request->hasFile('upfile')) {
                /*$args['image']    = $request->file('upfile');
                $args['type']   = 'upload';
                $args['folder'] = 'downloadfile/file';
                $media->file    = ImageHandler::upload($args);*/
                $imageName = uniqid(). '-' .$request->file('upfile')->getClientOriginalName();

                $request->file('upfile')->move(
                    getcwd() . '/content/files/downloadfile/', $imageName
                );
                $media->file = $imageName;
                $media->typeFile = 'file';
            } else {
                if ($request->has('urldownload')) {
                    $media->file = $request->input('urldownload');
                    $media->typeFile = 'url';
                }
            }
            $media->slug        = str_slug($request->input('title'));
            $media->price       = $request->input('price');
            $media->style       = $request->input('style');
            $media->platform       = $request->input('platform');
            $media->render       = $request->input('render');
            $media->status= 0;
            $media->description = html_entity_decode($request->input('description'));
            $media->tags        = htmlspecialchars($request->input('tags'));
            $media->user_id = 0;
            $media->category_id = $request->input('category');
            $media->save();
            $media_id = $media->id;

            if ($request->hasFile('txtdetail_img')) {
                $df = $request->file('txtdetail_img');
                foreach ($df as $row) {
                    $img_detail = new Images_preview();
                    if (isset($row)) {
                        $name_img= time().'_'.$row->getClientOriginalName();
                        $img_detail->image_name = $name_img;
                        $img_detail->media_id = $media_id;
                        $img_detail->created_at = new datetime;

                        $path_img ='public/content/files/downloads/images/'.$name_img;

                        $imgthumb       = Image::make($row)->Crop(800, 600)->save($path_img);
                        $img_detail->save();
                    }
                }
            }

            $request->session()->flash('flash_message', 'Successfully added new media.');
            $request->session()->flash('flash_type', 'alert-success');
            return redirect()->route('media');
        }
	}
	public function showeditmedia($slug){
        if (Session::get('file') !='') {
            $pt = File::Delete(public_path('content/files/downloads/images/thumb/'.Session::get('file')) );
            Session::forget('file');
        }
		$media      = Media::where("slug", "=", $slug)->first();
        $categories = Categories::all();
        $categorySelect = Categories::where('id', '=', $media->category_id)->first();
        
        return view('admin.editmedia', ['media'=>$media, 'categories'=>$categories, 'categorySelect'=>$categorySelect]);

	}
	public function editmedia(Request $request, $slug){
		$media = Media::where("slug", "=", $slug)->first();
        $status = $media->status;
        $rules = Media::$validators_1;
        $rules['upimage'] = 'image';

        $validator  = Validator::make(
            $request->only('title', 'description'),
            $rules
        );
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        } else {
            $delpaththumb   = config('$request->input') . 'thumb/' .$media->name;
            $delthumb       = File::delete($delpaththumb);
            $media->title   = $request->input('title');
            $args           = array('image' => '', 'filename' => '');
            
            if($request->upimage !=''){
                $media->name    =  $request->upimage;
            }
            
            if ($request->hasFile('upfile')) {
                $imageName = uniqid(). '-' .$request->file('upfile')->getClientOriginalName();
                $request->file('upfile')->move(
                    getcwd() . '/content/files/downloadfile/', $imageName
                );
                $media->file = $imageName;
                $media->typeFile = 'file';
            } else {
                if ($request->has('urldownload')) {
                    $media->file    = $request->input('urldownload');
                    $media->typeFile = 'url';
                }
            }
            
            $media->slug        = str_slug($request->input('title'));
            // $media->price       = $request->input('price');
            $media->style       = $request->input('style');
            $media->platform       = $request->input('platform');
            $media->render       = $request->input('render');
            $media->description = html_entity_decode($request->input('description'));
            $media->tags        = $request->input('tags');
            $media->category_id = $request->category;

            // dd($media);
            $id = $media->id;
            $media->save();

            if ($request->hasFile('txtdetail_img')) {
                $df = $request->file('txtdetail_img');
                $detail = Images_preview::where('media_id',$id)->get();
                // delete img
                foreach ($detail as $row) {                
                   $dt = Images_preview::find($row->id);
                   $pt = public_path('content/files/downloads/images/').$dt->image_name; 
                   // dd($pt);   
                    if (file_exists($pt))
                    {
                        unlink($pt);
                    }
                   $dt->delete();                              
                }
                foreach ($df as $row) {
                    $img_detail = new Images_preview();
                    if (isset($row)) {
                        $name_img= time().'_'.$row->getClientOriginalName();
                        $img_detail->image_name = $name_img;
                        $img_detail->media_id = $id;
                        $img_detail->created_at = new datetime;

                        $path_img ='public/content/files/downloads/images/'.$name_img;

                        $imgthumb       = Image::make($row)->Crop(800, 600)->save($path_img);
                        // $row->move('public/content/files/downloads/images/thumb/',$name_img);
                        $img_detail->save();
                    }
                }
            }

            $request->session()->flash('flash_message', 'Successfully Updated Media.');
            $request->session()->flash('flash_type', 'alert-success');
            return redirect()->route('media');
            //return Redirect::to('/admin/media');
        }
	}
	public function delete(Request $request, $id){
		$media 			= Media::find($id);
        $media_detail          = Images_preview::where('media_id',$id)->get();
        foreach ($media_detail as $row) {
           $pt = public_path('content/files/downloads/images/').$row->image_name; 
           $delimage_detail        = File::delete($pt);
        }
        $file = 'content/files/downloadfile/'.$media->file;
		$media->delete();
        unlink($file);
		$filepath 		= config('view.downloadpath') . $media->name;
		$filepaththumb 	= config('view.downloadpath') . 'thumb/' . $media->name;        
		$delimage 		= File::delete($filepath);
		$delthumb 		= File::delete($filepaththumb);
		$request->session()->flash('flash_message', 'Successfully delete media.');
		$request->session()->flash('flash_type', 'alert-success');
		return redirect()->route('media');
	}
	public function showsettings(){
		$settings 	= Setting::first();
		return view('admin.settings', $settings);
	}
	public function postsettings(Request $request){
		$settings 	= Setting::first();
		$args 		= array('image' => '', 'folder' => 'settings', 'filename' => '', 'type' => 'upload');

        // if ($validator->fails()) {
        //     return Redirect::back()->withInput()->withErrors($validator);
        // } else{
			$settings->sitename 	= $request->input('sitename');
			$settings->headline 	= $request->input('headline');
			$settings->subheadline  = $request->input('subheadline');
			if($request->hasFile('logo')){
				$args['image'] 	= $request->file('logo');
				$settings->logo = ImageHandler::upload($args);
			}
			if($request->hasFile('favicon')){
				$args['image']     = $request->file('favicon');
				$settings->favicon = ImageHandler::upload($args);
            }
            $settings->theme       = $request->input('theme');
			$settings->googleplus  = $request->input('googleplus');
			$settings->facebook    = $request->input('facebook');
			$settings->twitter     = $request->input('twitter');
			$settings->disqus 	   = $request->input('disqus');
			$settings->gganalytic  = $request->input('gganalytic');

			// $settings->username	   = $request->input('username');
			// $settings->email	   = $request->input('email');
			// $settings->password	   = bcrypt($request->input('password'));

			$settings->ads728x90   = $request->input('ads728x90');
			$settings->ads300x250  = $request->input('ads300x250');
			$settings->save();
			// $user = User::where('id', '=', Auth::user()->id)->first();
			// $user->email 	= $settings->email;
			// $password_request = $request->input('password');
			// if(isset($password_request) && $password_request != ""):
			// 	$user->password = $settings->password;
			// endif;
			// $user->save();
			$request->session()->flash('flash_message', 'Successfully updated site settings.');
			$request->session()->flash('flash_type', 'alert-success');
			return redirect()->route('settings');
			//return view('admin.settings');
		// }
	}
	public function showcategories(){
		$categories  = Categories::orderBy('id', 'ASC')->get();
		$parentCate  = Categories::orderBy('id', 'ASC')->get();
		return view('admin.categoriespage', ['categories'=>$categories, 'parentCate'=>$parentCate]);
	}
	public function addcategory(Request $request){
		$validator = Validator::make(
            $request->only('name', 'url_slug', 'order'),
            Categories::$validators
        );
        if ($validator->fails())
        {
            return Redirect::back()->withInput()->withErrors($validator);
        } else{
        	$category 			= new Categories;
        	$category->name 	= $request->name;
        	$category->url_slug = $request->url_slug;
        	$category->order 	= $request->order;
        	$category->parentID = $request->parentID;
        	if ($request->parentID != 0) {
        		$category->level = 2;
        	}else {
        		$category->level = 1;
        	}
        	$category->save();
        	$categories  = Categories::orderBy('id', 'ASC')->get();
			$parentCate  = Categories::orderBy('id', 'ASC')->get();
			$request->session()->flash('flash_message', 'Successfully Add Category.');
			$request->session()->flash('flash_type', 'alert-success');
			return redirect()->route('getcategories', array('categories'=>$categories, 'parentCate'=>$parentCate));
			//return view('admin.categoriespage', ['categories'=>$categories, 'parentCate'=>$parentCate]);
        }
	}
	public function	showcategory($url_slug){
		$category   = Categories::where("url_slug", "=", $url_slug)->first();
		$parentCate = Categories::where("id", "!=", $category->id)->get();
       	$categories = Categories::where("url_slug", "!=", $url_slug)->orderBy('id', 'ASC')->get();
		$parent  	= Categories::orderBy('id', 'ASC')->get();
		return view('admin.editcategory', ['categories'=>$categories, 'category'=>$category, 'parentCate'=>$parentCate, 'parent'=>$parent]);
	}
	public function editcategory(Request $request, $url_slug){
		$category   	= Categories::where("url_slug", "=", $url_slug)->first();
        $rules			= Categories::$validators;
        $rules['name']	= 'required|min:3|unique:categories,name,' . $category->id;
		$validator 		= Validator::make(
            $request->only('name', 'url_slug', 'order'),
            $rules
        );
        if ($validator->fails())
        {
            return Redirect::back()->withInput()->withErrors($validator);
        } else{
        	$category->name 	= $request->name;
        	$category->url_slug = $request->url_slug;
        	$category->order 	= $request->order;
        	$category->parentID = $request->parentID;
        	if ($request->parentID != 0) {
        		$category->level = 2;
        	}else {
        		$category->level = 1;
        	}
        	$category->save();
			$parentCate  = Categories::orderBy('id', 'ASC')->get();
			$request->session()->flash('flash_message', 'Successfully updated site Category.');
			$request->session()->flash('flash_type', 'alert-success');
			return redirect()->route('getcategories', array('parentCate'=>$parentCate));
			//return view('admin.categoriespage', ['parentCate'=>$parentCate]);
        }
	}
	public function deletecategory(Request $request, $id){		
		$category = Categories::find($id);
		$category->delete();
		$request->session()->flash('flash_message', 'Successfully delete category.');
		$request->session()->flash('flash_type', 'alert-success');
		$parentCate = Categories::orderBy('id', 'ASC')->get();
		return redirect()->route('getcategories', array('parentCate'=>$parentCate));
	}

	public function showadminabout(){
		$about = DB::table('about')->where('id', '=', 1)->first();
		return view('about.adminabout', ['about'=>$about]);
	}
	public function updateabout(Request $request){
		$updateabout = About::where('id', '=', 1)->first();
		$updateabout->contentabout = $request->contentabout;
		$updateabout->save();
		$request->session()->flash('flash_message', 'Successfully updated site About.');
		$request->session()->flash('flash_type', 'alert-success');
		return redirect()->route('about');
	}

    // rules
    public function showrules(){
        $about = DB::table('about')->where('id', '=', 2)->first();
        return view('about.adminrules', ['about'=>$about]);
    }
    public function updaterules(Request $request){
        $updateabout = About::where('id', '=', 2)->first();
        $updateabout->contentabout = $request->contentabout;
        $updateabout->save();
        $request->session()->flash('flash_message', 'Successfully updated site rules.');
        $request->session()->flash('flash_type', 'alert-success');
        return redirect()->route('rules');
    }

	public function showmember()
	{
		$mem = DB::table('users')->get();
		return view ('admin.members',['mem'=>$mem]);
	}

	// check media upload 
	public function getcheckmedia($value='')
	{
		$media  	= DB::table('media')->where('status','=',0)->orderBy('id', 'DESC')->paginate(10);
		$countmedia = DB::table('media')->where('status','=',0)->count();
		return view ('admin.check-uploads',['media'=>$media, 'countmedia'=>$countmedia]);
	}
	public function postcheckmedia($value='')
	{
		
	}
	public function Approved(Request $request, $id){
		$media 			= Media::find($id);
		$media->status = 1;
		$media->save();
		$request->session()->flash('flash_message', 'Successfully Approved media.');
		$request->session()->flash('flash_type', 'alert-success');
		return redirect()->route('checkmedia');
		//return Redirect::to('/admin/media');
	}
    // report action
    public function report(){
        $data = DB::table('reports')
                ->join('media', 'media.id', '=', 'reports.media_id')
                ->join('users','users.id','=','reports.user_id')
                ->selectRaw('media.title, media.id as m_id, media.name,media.user_id,media.slug,reports.*, users.name as us')
                ->groupBy('reports.media_id')
                ->orderBy('reports.id','ASC')
                ->paginate(10);
        $countmedia = DB::table('reports')->count();
        return view('admin.report', ['media'=>$data, 'countmedia'=>$countmedia]);
    }
    // messenger process
    public function msg()
    {
        $msg = DB::table('messenger')
            ->join('users', 'u_from', '=', 'users.id')
            ->select('users.name','users.email','messenger.*')
            ->where('u_to','=','0')
            ->where('type','=','0')
            ->where('messenger.status','=','0')
            ->where('messenger.parent','=','0')
            ->orderBy('created_at','DESC')
            ->paginate(10);

        $msg_data = DB::table('messenger')
            ->join('users', 'u_from', '=', 'users.id')
            ->select('users.name','users.email','messenger.*')
            ->where('u_to','=','0')
            ->where('type','=','0')
            ->where('messenger.parent','=','0')
            ->orderBy('created_at','DESC')
            ->paginate(10);
        return view ('admin.msg',['data'=>$msg,'data_msg'=> $msg_data]);
    }
    public function msg_detail($id)
    {
        $update = Messenger::find($id);
        $update->status=1;
        $update->updated_at =  new datetime;;
        $update->save();
        $sub = Messenger::where('parent','=',$id)->where('u_to','=','0')->get();
        foreach ($sub as $row) {
            $update = Messenger::find($row->id);
            $update->status=1;
            $update->updated_at =  new datetime;;
            $update->save();
        }

        $msg = DB::table('messenger')
            ->join('users', 'u_from', '=', 'users.id')
            ->select('users.name','users.email','messenger.*')
            ->where('u_to','=','0')
            ->where('type','=','0')
            ->where('messenger.status','=','0')
            ->orderBy('created_at','DESC')
            ->get();            
        $msg_data = DB::table('messenger')
            ->join('users', 'u_from', '=', 'users.id')
            ->select('users.id as u_id','users.name','users.email','messenger.*')
            ->where('u_to','=','0')
            ->where('type','=','0')
            ->where('messenger.id','=',$id)
            ->orderBy('created_at','DESC')
            ->first();   
        $logmsg =  DB::table('messenger')
            ->where('parent','=',$id)
            ->orderBy('created_at','ASC')
            ->take(10)->get();
        return view ('admin.read-msg',['data'=>$msg,'data_msg'=>$msg_data,'log'=>$logmsg]);
    }
    public function reply($id, Request $rq)
    {
        $msg = new Messenger();
        $msg->type=0;
        $msg->status=0;
        $msg->u_from =0;
        $msg->u_to =$rq->toid;
        $msg->parent = $id;
        $msg->content =$rq->reply;  
        $msg->save();
        return redirect()->route('getlistmsg_detail',$id);
    }
    public function msg_del($id, Request $rq)
    {
        $msg = Messenger::find($id);
        $msg->delete();       
        return redirect()->route('getlistmsg_detail',$rq->p_id);

    }
    public function remove_msg($id)
    {
        $msg = Messenger::where('parent',$id)->get();
        foreach ($msg as $item) {
           $i = Messenger::find($item->id);  
           $i->delete();   
        }
        $p= Messenger::find($id);  
        $p->delete();
        return redirect()->route('getlistmsg');
    }
    public function report_cancel($id)
    {
        $rp = Reports::find($id);
        $rp->delete();
        return redirect()->route('getlistreport');
    }
    public function getpay()
    {
        $pay_c = DB::table('logpays')->where('status','=',0)->count();
        $pay = Logpays::paginate(10);
        return view ('admin.payment',['pay'=>$pay,'pay_c'=>$pay_c]);
    }
    public function cancel($id)
    {
        $pay = Logpays::find($id);
        $c = $pay->pay_cash;
        $u= $pay->u_id;
        $us = User::find($u);

        $us->f_cash =  $us->f_cash -$c;
        $us->save();
        $pay->status = 2;
        $pay->save();
        return redirect()->route('admingetpay');        
    }
    public function done($id)
    {
        $pay = Logpays::find($id);
        $c = $pay->pay_cash;
        $u= $pay->u_id;
        $us = User::find($u);
        $us->cash =  $us->cash - $c;
        $us->f_cash =  $us->f_cash -$c;
        $us->save();
        $pay->status = 1;
        $pay->save();
        return redirect()->route('admingetpay');        
    }
}
