@extends('layouts.content')
@section('title')
	Categories page
@stop
@section('content')
	<div class="content contentCategories">
		<div class="container">
			<div class="row">
				@include('partials.topsell-7day')
				<div class="col-sm-12 cntcategories">
					<h1><?= ucfirst($category->name) ?> Category</h1>
					<div id="media" style="padding-bottom:30px;">
					<?php
						$total = $total;
				        $page = config('view.numPage');
						$categoriesparent = DB::table('categories')->where('parentID', '=', 0)->where('url_slug', '=', $category->url_slug)->first();
						// dd($categoriesparent);
						if ($categoriesparent != null) {
							$categorychild = DB::table('categories')->where('parentID', '=', $categoriesparent->id)->get();
							$count = DB::table('categories')->where('parentID', '=', $categoriesparent->id)->count();
							if ($count>0) {								
								foreach($categorychild as $item){
									$mediachild = DB::table('media')->where('category_id', '=', $item->id)->where('status','=',1)->orderBy('created_at', 'DESC')->paginate(12);
					        		foreach($mediachild as $item){
					        			?>
					        			<?php 
								    		if ($item->user_id == 0) {
								    			$us = 'Admin';
								    		} else {
								    			$tb = DB::table('users')->where('id','=',$item->user_id)->first();
								    			$us = $tb->name;
								    		}    		
								    	?>
					        			<div class="item_larger col-xs-12 col-sm-6 col-md-3" data-id="" id="item_hover">
											<div class="item" id="{!!$item->id !!}" >
												<input type="hidden" name="_token" value="{{ csrf_token() }}">
												<a href="{!! url('downloadpage/'.$item->id.'/'.$item->slug) !!}" class="head_item ">	
													<div class="dim"></div>	
													<img src="{!!url('').'/'.config('view.filepath') !!}thumb/{!! $item->name !!}">			
																		
												</a>
												<a class="content_item" href="{!! url('downloadpage/'.$item->id.'/'.$item->slug) !!}">
													<h3>{!!strtoupper($item->title)!!}</h3>
													<span class="the-date">{!!date("F j, Y", strtotime($item->created_at)) !!}</span>
												</a>
												<div class="item_info">
													<a href="javascript:void(0);" class="buttonlike" align="right" image-id="{!!$item->id !!}"><img src="{!! config('view.rootpath') !!}/img/icon_like.png"> <b id="id{!!$item->id !!}">{!!$item->count_like !!}</b></a>
													<a href="{!!url('downloadpage/'.$item->id.'/'.$item->slug) !!}" class="download" align="right"><img src="{!! config('view.rootpath') !!}/img/icon_download.png"> {!!$item->count_download !!}</a>
													<a href="{!!url('downloadpage/'.$item->id.'/'.$item->slug) !!}" class="download" align="right"> <strong style="color:#d35400">{!! $item->price!!}</strong><span class="glyphicon glyphicon-usd"></span> </a>
												</div>
											</div>
										</div>
						<?php		}
								}
							} else{
								$mediachild = DB::table('media')->where('category_id', '=', $categoriesparent->id)->where('status','=',1)->orderBy('created_at', 'DESC')->paginate(12);
								
								foreach ($mediachild as $item) { ?>
									<?php 
							    		if ($item->user_id == 0) {
							    			$us = 'Admin';
							    		} else {
							    			$tb = DB::table('users')->where('id','=',$item->user_id)->first();
							    			$us = $tb->name;
							    		}    		
							    	?>
									<div class="item_larger col-xs-12 col-sm-6 col-md-3" data-id="" id="item_hover">
										<div class="item" id="{!!$item->id !!}" >
											<input type="hidden" name="_token" value="{{ csrf_token() }}">
											<a href="{!! url('downloadpage/'.$item->id.'/'.$item->slug) !!}" class="head_item">	
												<div class="dim"></div>	
												<img src="{!!url('').'/'.config('view.filepath') !!}thumb/{!! $item->name !!}">			
																	
											</a>
											<a class="content_item" href="{!! url('downloadpage/'.$item->id.'/'.$item->slug) !!}">
												<h3>{!!strtoupper($item->title)!!}</h3>
												<span class="the-date">{!!date("F j, Y", strtotime($item->created_at)) !!}</span>
											</a>
											<div class="item_info">
												<a href="javascript:void(0);" class="buttonlike" align="right" image-id="{!!$item->id !!}"><img src="{!! config('view.rootpath') !!}/img/icon_like.png"> <b id="id{!!$item->id !!}">{!!$item->count_like !!}</b></a>
												<a href="{!!url('downloadpage/'.$item->id.'/'.$item->slug) !!}" class="download" align="right"><img src="{!! config('view.rootpath') !!}/img/icon_download.png"> {!!$item->count_download !!}</a>
												<a href="{!!url('downloadpage/'.$item->id.'/'.$item->slug) !!}" class="download" align="right"> <strong style="color:#d35400">{!! $item->price!!}</strong><span class="glyphicon glyphicon-usd"></span> </a>
											</div>
										</div>
									</div>
						<?php	}
							}
						} else{
					        if (!empty($media->toArray())) {
					    		foreach($media as $item): ?>
					    			<?php 
							    		if ($item->user_id == 0) {
							    			$us = 'Admin';
							    		} else {
							    			$tb = DB::table('users')->where('id','=',$item->user_id)->first();
							    			$us = $tb->name;
							    		}    		
							    	?>
									<div class="item_larger col-xs-12 col-sm-6 col-md-3" data-id="" id="item_hover">
										<div class="item" id="{!!$item->id !!}" >
											<input type="hidden" name="_token" value="{{ csrf_token() }}">
											<a href="{!! url('downloadpage/'.$item->id.'/'.$item->slug) !!}" class="head_item">	
												<div class="dim"></div>	
												<img src="{!!url('').'/'.config('view.filepath') !!}thumb/{!! $item->name !!}">			
																	
											</a>
											<a class="content_item" href="{!! url('downloadpage/'.$item->id.'/'.$item->slug) !!}">
												<h3>{!!strtoupper($item->title)!!}</h3>
												<span class="the-date">{!!date("F j, Y", strtotime($item->created_at)) !!}</span>
											</a>
											<div class="item_info">
												<a href="javascript:void(0);" class="buttonlike" align="right" image-id="{!!$item->id !!}"><img src="{!! config('view.rootpath') !!}/img/icon_like.png"> <b id="id{!!$item->id !!}">{!!$item->count_like !!}</b></a>
												<a href="{!!url('downloadpage/'.$item->id.'/'.$item->slug) !!}" class="download" align="right"><img src="{!! config('view.rootpath') !!}/img/icon_download.png"> {!!$item->count_download !!}</a>
												<a href="{!!url('downloadpage/'.$item->id.'/'.$item->slug) !!}" class="download" align="right"> <strong style="color:#d35400">{!! $item->price!!}</strong><span class="glyphicon glyphicon-usd"></span> </a>
											</div>
										</div>
									</div>
						<?php 
								endforeach;
							} else{
							echo "<p style='font-size: 18px;color: #159;'>Sorry, it looks like there are not any items in this Category</p>";
							}
						}
					?>
				</div>
					<div class="pagination">
						{!!$media->render();!!}
					</div>
				</div>
			</div>
		</div>
	</div>
@stop