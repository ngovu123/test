@extends('layouts.content')
@section('title')
	Home page
@stop
@section('content')
	<div class="content contentHome">
		<div class="container">
			<div class="row">
				@include('partials.topsell-7day')
				<div class="popular cntPopular">
					<h1 style="text-align:center">Phổ biến nhất</h1>
					<?php foreach($popular as $item): ?>
						<div class="item_larger animated single-left col-sm-4" data-id="">
							<div class="item" id="<?= $item->id ?>">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<a href="<?= route('downloadpage', $item->id) ?>" class="head_item" onmouseover="showtrail('{!!url('').'/'.config('view.filepath') !!}/{!! $item->name !!}','{!!strtoupper($item->title)!!}',650,500)" onmouseout="hidetrail()">
									<img src="{{ url('').'/'.config('view.filepath') }}/thumb/<?= $item->name ?>">
								</a>
								<a class="content_item" href="<?= route('downloadpage', $item->id) ?>">
									<h3><?= strtoupper($item->title) ?></h3>
									<span class="the-date"><?= date("F j, Y", strtotime($item->created_at)) ?></span>
								</a>
								<div class="item_info">
									<a href="javascript:void(0);" class="buttonlike" align="right" image-id="<?= $item->id ?>"><img src="{{ config('view.rootpath') }}/img/icon_like.png"> <b id="id<?= $item->id ?>"><?= $item->count_like ?></b></a>
									<a href="<?= route('downloadpage', $item->id) ?>" class="download" align="right"><img src="{{ config('view.rootpath') }}/img/icon_download.png"> <?= $item->count_download ?></a>
									<a href="{!!route('downloadpage', $item->id) !!}" class="download" align="right"> @if($item->price ==0) <strong style="color:#e67e22;">Free</strong> @else <strong style="color:#d35400">{!! $item->price!!}</strong><span class="glyphicon glyphicon-usd"></span>  @endif </a>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
	
@stop

	
