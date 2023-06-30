<?php

namespace App\Http\Controllers;

use App\User;
use App\Media;
use App\About;
use App\Images_preview;
use App\Setting;
use App\Categories;
use App\Bookmarks;
use App\Transition_log;
use App\Messenger;
use App\Logpays;

use View, DB, File, Auth, Mail, DateTime,Session;
use App\ImageHandler;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $media  = DB::table('media')->where('user_id','=',Auth::user()->id)->orderBy('id', 'DESC')->paginate(12);
        $us = DB::table('users')->where('id','=',Auth::user()->id)->first();
        return view('members.mem-home', ['media'=>$media,'us'=>$us]);
    }
    // member upload new media
    public function getuploads()
    {
        if (Session::get('mem_file') !='') {
            $pt = File::Delete(public_path('content/files/downloads/images/thumb/'.Session::get('mem_file')));
            Session::forget('mem_file');
        }
        $categories = Categories::all();
        return view('members.uploads',['categories'=>$categories]);
    }

    public function postuploads(Request $request)
    {
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
            $media->user_id = Auth()->user()->id;
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
                        // $row->move('public/content/files/downloads/images/thumb/',$name_img);
                        $img_detail->save();
                    }
                }
            }

            $request->session()->flash('flash_message', 'Successfully added new media.');
            $request->session()->flash('flash_type', 'alert-success');
            return redirect()->route('memhome');
            //return Redirect::to('/admin/media');
        }
    }
    public function uploadimgs(request $rq)
    {        
        list($type, $imageData) = explode(';', $rq->img);
        list(,$extension) = explode('/',$type);
        list(,$imageData)      = explode(',', $rq->img);
        $fileName = uniqid().'.'.$extension;
        $imageData = base64_decode($imageData);
        file_put_contents('public/content/files/downloads/images/thumb/'.$fileName, $imageData);
        Session::put('mem_file', $fileName);
        return $fileName;
    }
    public function delete(Request $request, $id){
        $media          = Media::find($id);
        $media_detail          = Images_preview::where('media_id',$id)->get();
        foreach ($media_detail as $row) {
           $pt = public_path('content/files/downloads/images/').$row->image_name; 
           $delimage        = File::delete($pt);
        }
        $media->delete();
        $filepath       = config('view.downloadpath') . $media->name;
        $filepaththumb  = config('view.downloadpath') . 'thumb/' . $media->name;
        $delimage       = File::delete($filepath);
        $delthumb       = File::delete($filepaththumb);
        $request->session()->flash('flash_message', 'Successfully delete media.');
        $request->session()->flash('flash_type', 'alert-success');
        return redirect()->route('memhome');
        //return Redirect::to('/admin/media');
    }

    // edit
    public function showeditmedia(Request $request, $slug){
        if (Session::get('mem_file') !='') {
            $pt = File::Delete(public_path('content/files/downloads/images/thumb/'.Session::get('mem_file')));
            Session::forget('mem_file');
        }
        $media      = Media::where("slug", "=", $slug)->where('user_id','=',Auth::user()->id)->first();
        $status = $media->status;
        $categories = Categories::all('name', 'id');
        $categorySelect = Categories::where('id', '=', $media->category_id)->first();
        if ($status !==0) {
                $request->session()->flash('flash_message', 'Media already censors may not edit !');
                $request->session()->flash('flash_type', 'alert-error');
                return redirect()->route('memhome');
        } else {
            return view('members.edit', ['media'=>$media, 'categories'=>$categories, 'categorySelect'=>$categorySelect]);
        }
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
            $media->updated_at = new datetime;
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
                        $img_detail->save();
                    }
                }
            }

            $request->session()->flash('flash_message', 'Successfully Updated Media.');
            $request->session()->flash('flash_type', 'alert-success');
            return redirect()->route('memhome');
        }

    }
    // member update profile
    public function getprofile()
    {
        $us = DB::table('users')->where('id','=',Auth::user()->id)->first();        
        return view('members.profile',['us'=>$us]);
    }
    public function postprofile(Request $request)
    {
        $us          = User::where("id", "=", Auth::user()->id)->first();
        $us->name   = $request->input('txtname');
        $us->last_name   = $request->input('txtlname');

        $us->slug   = str_slug($request->input('txtname'));
        
        if ($request->hasFile('avata')) 
        { 
            $df = $request->file('avata');             
            $pt = public_path('application/assets/img/user/'.$us->avata_img); 
            // dd($pt);
            if (file_exists($pt) && ($us->avata_img!='') )
            {
                unlink($pt);
            }
            $name_img= time().'_'.$df->getClientOriginalName();
            $df->move('public/application/assets/img/user/',$name_img);
            $us->avata_img = $name_img;

        }
        
        $us->address   = $request->input('txtaddress');
        $us->phone   = $request->input('txtphone');
        $us->pay_id   = $request->input('txtpayid');
        $us->website   = $request->input('txtwebsite');
        $us->facebook   = $request->input('txtfacebook');
        $us->googleplus   = $request->input('txtgoogleplus');
        $us->twitter   = $request->input('txttwitter');
        $us->skype   = $request->input('txtskype');
        $us->save();
        $request->session()->flash('flash_message', 'Successfully Updated profile.');
        $request->session()->flash('flash_type', 'alert-success');
        return redirect()->route('profile');        
    }
    // member history
    public function gethistory()
    {
        $his  = DB::table('transition_log')->where('user_id','=',Auth::user()->id)->orderBy('id', 'DESC')->paginate(12);
        $us = DB::table('users')->where('id','=',Auth::user()->id)->first();
        return view('members.history',['his'=>$his,'us'=>$us]);
    }
    public function posthistory()
    {
        return view('members.history');
    }
    // member new card
    public function getstatistical()
    {   
        $us = DB::table('users')->where('id','=',Auth::user()->id)->first();
        $count = DB::table('media')->selectraw('SUM(count_download) as totaldown,SUM(count_like) as totallike, COUNT(*) AS totalmedia')
                ->where('user_id','=',$us->id)->first();
        return view('members.statistical',['us'=>$us,'count'=>$count]);
    }
    public function bookmarks()
    {
        $media = DB::table('bookmarks')->join('media', 'media.id', '=', 'bookmarks.media_id')
                                        ->select('media.*')
                                        ->where('bookmarks.user_id','=',Auth::user()->id)
                                        ->paginate(10);
        $us = DB::table('users')->where('id','=',Auth::user()->id)->first();
        return view('members.bookmask',['mask'=>$media,'us'=>$us]);
    }
    public function unmask($id)
    {
        $mask  =DB::table('bookmarks')->where('media_id','=',$id)->where('user_id','=',Auth::user()->id);
        $mask->delete();
        return redirect()->route('mask');
    }
    // downlaod history
    public function download()
    {
        $his = DB::table('download_log')
                ->join('media', 'media.id', '=', 'download_log.media_id')
                ->selectRaw('media.*,download_log.payment_id, COUNT(download_log.media_id) as total')
                ->where('download_log.user_id','=',Auth::user()->id)
                ->groupBy('download_log.media_id')
                ->orderBy('total','DESC')
                ->paginate(12);
        // dd($his);
        $us = DB::table('users')->where('id','=',Auth::user()->id)->first();
        return view('members.download',['his'=>$his,'us'=>$us]);
    }
// mesager
    public function msg()
    {                     

        $msg = Messenger::where('status',0)->where('parent',0)->where('type',0)->get();

        $msg_data = DB::table('messenger')            
            ->select('*')
            ->whereRaw(' (u_to ='.Auth::user()->id.' or u_from ='.Auth::user()->id.') and type=0 and parent=0 ')
            ->orderBy('created_at','DESC')
            ->paginate(10);
         return view ('members.msg',['data'=>$msg,'data_msg'=> $msg_data]);
    }
    public function msg_detail($id)
    {
        
        Session::put('p_id',$id ); 
        
        $update = Messenger::find($id);
        $update->status=1;
        $update->updated_at =  new datetime;;
        $update->save();
        $sub = Messenger::where('parent','=',$id)->where('u_to','=',Auth::user()->id)->get();
        foreach ($sub as $row) {
            $update = Messenger::find($row->id);
            $update->status=1;
            $update->updated_at =  new datetime;;
            $update->save();
        }

        $msg = Messenger::where('status',0)->where('parent',0)->where('type',0)->get();
    
        $msg_data = Messenger::where('id',$id)->first();

        $logmsg =  DB::table('messenger')
            ->where('parent','=',$id)
            ->orderBy('created_at','ASC')
            ->take(10)->get();
        return view ('members.read-msg',['data'=>$msg,'data_msg'=>$msg_data,'log'=>$logmsg]);
    }
    public function reply($id, Request $rq)
    {
        $msg = new Messenger();
        $msg->type=0;
        $msg->status=0;
        $msg->u_from =Auth::user()->id;
        $msg->u_to =$rq->toid;
        $msg->parent = $id;
        $msg->content =$rq->reply;  

        // dd($msg);
        $msg->save();
        return redirect()->route('msg_detail',$id);
    }

    public function msg_del($id, Request $rq)
    {
        $msg = Messenger::find($id);
        $msg->delete();       
        return redirect()->route('msg_detail',$rq->p_id);

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
        return redirect()->route('msg');
    }
    // payment 

    public function pay()
    {
        $us = User::find(Auth::user()->id);
        $pay = Logpays::where('u_id',Auth::user()->id)->paginate(12);
        return view ('members.request-pay',['us'=>$us,'pay'=>$pay]);
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
        return redirect()->route('getpay');        
    }
    public function new()
    {
        $us = User::find(Auth::user()->id);
        return view ('members.new-request-pay',['us'=>$us]);
    }
    public function postnew(Request $rq)
    {
        $us = User::where('id',Auth::user()->id)->first();
        if (($us->cash- $us->f_cash) < $rq->paycash ) {
            $rq->session()->flash('flash_message', 'Balance Balance not enough to execute extract !');
            $rq->session()->flash('flash_type', 'alert-error');
            return redirect()->route('getnewpay');        
        } elseif ($us->pay_id == '0') {
            $rq->session()->flash('flash_message', ' No payment ID You Need Update Profile To Send Payment ! </label>');
            $rq->session()->flash('flash_type', 'alert-error');
            return redirect()->route('getnewpay');
        } else {
            $us = User::find(Auth::user()->id);
            $us->f_cash = $us->f_cash + $rq->paycash;
            $us->save();
            $pay = new Logpays();
            $pay->u_id = Auth::user()->id;
            $pay->pay_cash = $rq->paycash;
            $pay->message = $rq->msg;
            $pay->save();
            $rq->session()->flash('flash_message', ' Success To Send Payment !');
            $rq->session()->flash('flash_type', 'alert-success');
            return redirect()->route('getpay');
        }        

    }
}
