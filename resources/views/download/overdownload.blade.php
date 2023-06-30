@extends('layouts.content')
@section('title')
	Sorry, Downloadable content already overdue
@stop
@section('content')
	<div class="content contentHome">
		<div class="container">
			<div class="row">
				
				<div class="contentdownload">
					<?php foreach($imghidden as $item): ?>
						<?php $id = $item->id ?>
						<span image-id="<?= Session::get('media_id') ?>" class="spanHidden" style="display:none;"></span>
					<?php endforeach; ?>
					<div class="titleafter">
						<h1> Sorry, downloadable content already overdue !</h1>
						
						<h3>content only exists in 1 day !</h3>
						<p>Here are a few other goodies you may enjoy below</p>
					</div>
					<div class="col-sm-12">
						<div id="media" style="padding-bottom:30px;">

						<?php 
					        $total = DB::table('media')->count();
					        $page = config('view.numPage');
					    	foreach($images as $item): ?>
						    	<div class="item_larger animated single-left col-sm-4" data-id="">
									<div class="item" id="<?= $item->id ?>">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<a href="<?= url('downloadpage/'.$item->id.'/'.$item->slug) ?>" class="head_item">
											<img src="{{ url('').'/'.config('view.filepath') }}/thumb/<?= $item->name ?>">
										</a>
										<a class="content_item" href="<?= url('downloadpage/'.$item->id.'/'.$item->slug) ?>">
											<h3><?= strtoupper($item->title) ?></h3>
											<span class="the-date"><?= date("F j, Y", strtotime($item->created_at)) ?></span>
										</a>
										<div class="item_info">
											<a href="javascript:void(0);" class="buttonlike" align="right" image-id="<?= $item->id ?>"><img src="{{ config('view.rootpath') }}/img/icon_like.png"> <b id="id<?= $item->id ?>"><?= $item->count_like ?></b></a>
											<a href="<?= url('downloadpage/'.$item->id.'/'.$item->slug) ?>" class="download" align="right"><img src="{{ config('view.rootpath') }}/img/icon_download.png"> <?= $item->count_download ?></a>
											<a href="{!!url('downloadpage/'.$item->id.'/'.$item->slug) !!}" class="download" align="right"> @if($item->price ==0) <strong style="color:#e67e22;">Free</strong> @else <strong style="color:#d35400">{!! $item->price!!}</strong><span class="glyphicon glyphicon-usd"></span>  @endif </a>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@stop