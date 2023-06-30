<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Media;
class TagsController extends Controller
{
    public function tags(Request $request, $tagname){
		$tags 	= Media::where('tags', 'LIKE', '%'.$tagname.'%')->where('status','=',1)->get();
		return view("media.media_tags", ['tags'=>$tags, 'tagname'=>$tagname]);
	}
}
