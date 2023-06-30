<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;


class MemberController extends Controller
{
    public function findmore($slug,$id)
    {
		if ($id == 0) {
			$us = 'Admin';
			$total = DB::table('media')->where('status','=',1)->where('user_id','=',$id)->count();

    		$media = DB::table('media')->where('status','=',1)->where('user_id','=',$id)->orderBy('created_at', 'DESC')->paginate(6);
    	return view('findmore.usermore',['media'=>$media,'us'=>$us,'total'=>$total,'u_id'=>$id]);
		} else {
			$tb = DB::table('users')->where('id','=',$id)->first();
			$us = $tb->name;
			$total = DB::table('media')->where('status','=',1)->where('user_id','=',$id)->count();

    		$media = DB::table('media')->where('status','=',1)->where('user_id','=',$id)->orderBy('created_at', 'DESC')->paginate(6);
    	return view('findmore.usermore',['media'=>$media,'us'=>$us,'user'=>$tb,'total'=>$total,'u_id'=>$id]);
			
		}   
		
    }
}
