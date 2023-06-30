<?php

namespace App\Http\Controllers;
use View, DB;
use App\About;
use App\Media;
use App\Categories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;

class CategoriesController extends BaseController {

	public function index(){
		$categories = DB::table('about')->where('id', '=', 1)->first();
		return view('categories.categories', ['categories'=>$categories]);
	}
	public function showcategory(Request $request, $url_slug, $page = 0){
		$category = Categories::where('url_slug', '=', $url_slug)->first();

		$media = Media::where('category_id', '=', $category->id)->orderBy('created_at', 'DESC')->paginate(12);

		// dd($media);
		$total = DB::table('media')->where('status','=',1)->where('category_id', '=', $category->id)->count();
			return view('categories.categories', ['category'=>$category, 'media'=>$media, 'total'=>$total]);
		//}
		
	}
	public function loadmore($pageNumber, $url_slug){
		$id = Input::get("post_id");
		$url_slug = $url_slug;
		$page = config('view.numPage');
		$pageNumber = $pageNumber;
		$offset = ($pageNumber - 1) * $page;
		return view('partials.loadmore_categories', ['page'=>$page, 'pageNumber'=>$pageNumber, 'offset'=>$offset, 'id'=>$id, 'url_slug'=>$url_slug]);

	}
}