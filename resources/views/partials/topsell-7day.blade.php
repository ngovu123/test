
	<h3 class="text-center">Top selling </h3>
	<?php
		$top = DB::table('download_log')
				->join('media', 'media.id', '=', 'download_log.media_id')
				->selectRaw('media.*, COUNT(download_log.media_id) as total')
				// ->whereRaw('WEEK( download_log.created_at ) = WEEK (CURRENT_DATE) and YEAR( download_log.created_at ) = YEAR (CURRENT_DATE) ')
				->groupBy('download_log.media_id')
				->orderBy('total','DESC')
				->take(4)
				->get();		 
	?>
    @foreach($top as $item)    	
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
					<h3 style="display: block; overflow: hidden;">{!!strtoupper($item->title)!!}</h3>
					<span class="the-date">{!!date("F j, Y", strtotime($item->created_at)) !!}</span>
					<span class="name-upload"> - <strong style="color:#27ae60;"> {!!$us!!}</strong> </span>
				</a>
				<div class="item_info">
					<a href="javascript:void(0);" class="buttonlike" align="right" image-id="{!!$item->id !!}"><img src="{!! config('view.rootpath') !!}/img/icon_like.png"> <b id="id{!!$item->id !!}">{!!$item->count_like !!}</b></a>
					<a href="{!!url('downloadpage/'.$item->id.'/'.$item->slug) !!}" class="download" align="right"><img src="{!! config('view.rootpath') !!}/img/icon_download.png"> {!!$item->total !!}</a>
					<a href="{!!url('downloadpage/'.$item->id.'/'.$item->slug) !!}" class="download" align="right"> <strong style="color:#d35400;"><span class="glyphicon glyphicon-usd"></span>{!! $item->price!!}</strong></a>
				</div>
			</div>
		</div>
	@endforeach