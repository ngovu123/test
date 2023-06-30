@extends('layouts.content')
@section('title')
	Other Upload By Member
@stop
@section('content')
	<div class="content contentCategories">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-8 col-lg-8 no-padding">
					<h3 class="text-left">Member Infomation</h3>
						<div class="row" style="padding-top: 15px;padding-bottom: 15px;">
							<div class="avata-info col-md-4" style="padding:1px; max-height: 150px;">
								@if ( isset($user) && $user->avata_img !='')
									<img class="" src="{!!url('public/application/assets/img/user/'.$user->avata_img)!!}" alt="Avata" width="100%">
								@elseif(isset($user) && $user->avata_img =='')
									<img src="{!!url('public/application/assets/img/user/photo.png')!!}" alt="Avata" width="100%">
								@else 
									<img src="{!!url('public/application/assets/img/user/avatar03.png')!!}" alt="Avata" width="100%">
								
								@endif
							
							</div>
							<div class="memberinfo col-md-8" style="padding:1px; text-align: left;">
								@if ($us !='Admin')
									<li>Name :<strong>{!!$us!!}</strong> </li>
									<li>Registration Date : <strong> {!!date("j/m/Y", strtotime($user->created_at)) !!} </strong></li>
									<li>Locations: <strong>{!!$user->address!!}</strong>  </li>
									<li>Date of birth:<strong> {!!date("j/m/Y", strtotime($user->created_at)) !!} </strong>  </li>
									<li>Total Upload: <strong>{!!$total!!}</strong></li>	
									<div class="text-center">	
									@if ($user->website !='')									
									<a href="<?= $user->website ;?>" class="socialIcon" target="_blank" title="website" ><i class="fa fa-link"></i></a>
									@endif
									@if ($user->facebook !='')	
									<a href="http://facebook.com/<?= $user->facebook ;?>" class="socialIcon facebook" target="_blank" title="facebook"><i class="fa fa-facebook"></i></a>
									@endif
									@if ($user->googleplus !='')		
									<a href="http://plus.google.com/<?= $user->googleplus ;?>" class="socialIcon" target="_blank" title="google plus"><i class="fa fa-google-plus"></i></a>
									@endif
									@if ($user->twitter !='')		
									<a href="http://twitter.com/<?= $user->twitter ;?>" class="socialIcon" target="_blank" title="twitter"><i class="fa fa-twitter"></i></a>
									@endif
									@if ($user->skype !='')		
									<a href="http://www.skype.com/<?= $user->skype ;?>" class="socialIcon" target="_blank" title="skype"><i class="fa fa-skype"></i></a>
									@endif											
								</div>
								@else
									<li>Name :<strong>{!!$us!!}</strong> </li>
									<li>Registration Date : <strong>Admin </strong></li>
									<li>Locations: <strong>...</strong>  </li>
									<li>Date of birth:<strong> .... </strong>  </li>
									<li>Total Upload: <strong>{!!$total!!}</strong></li>
								@endif		
								<a data-toggle="modal" href="#modal-msg" class="btn btn-success" title="Send message" ><i class="glyphicon glyphicon-comment"></i> </a>

							</div>
						</div>
					<h3 class="text-left">Other upload by this member</h3>
					<div id="media">
					    @foreach($media as $item) 
					    	@if ($us !='Admin')
								<div class="item_larger col-xs-12 col-sm-6 col-md-4" data-id="" id="item_hover" style="padding:4px;">
									<div class="item" id="{!!$item->id !!}" >
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<a href="{!! url('downloadpage/'.$item->id.'/'.$item->slug) !!}" class="head_item " onmouseover="showtrail('{!!url('').'/'.config('view.filepath') !!}/{!! $item->name !!}','{!!strtoupper($item->title)!!}',650,500)" onmouseout="hidetrail()">	
											<div class="dim"></div>	
											<img src="{!!url('').'/'.config('view.filepath') !!}thumb/{!! $item->name !!}">			
																
										</a>
										<a class="content_item" href="{!! url('downloadpage/'.$item->id.'/'.$item->slug) !!}">
											<h3>{!!strtoupper($item->title)!!}</h3>
											<span class="the-date">{!!date("F j, Y", strtotime($item->created_at)) !!}</span>
											<span class="name-upload"> - <strong style="color:#27ae60;"> {!!$us!!}</strong> </span>
										</a>
										<div class="item_info">
											<a href="javascript:void(0);" class="buttonlike" align="right" image-id="{!!$item->id !!}"><img src="{!! config('view.rootpath') !!}/img/icon_like.png"> <b id="id{!!$item->id !!}">{!!$item->count_like !!}</b></a>
											<a href="{!!url('downloadpage/'.$item->id.'/'.$item->slug) !!}" class="download" align="right"><img src="{!! config('view.rootpath') !!}/img/icon_download.png"> {!!$item->count_download !!}</a>
											<a href="{!!url('downloadpage/'.$item->id.'/'.$item->slug) !!}" class="download" align="right"> <strong style="color:#d35400;"><span class="glyphicon glyphicon-usd"></span>{!! $item->price!!}</strong></a>
										</div>
									</div>
								</div>
							@else
								<div class="item_larger col-xs-12 col-sm-6 col-md-4" data-id="" id="item_hover" style="padding: 5px;">
									<div class="item" id="{!!$item->id !!}" >
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<a href="{!! url('downloadpage/'.$item->id.'/'.$item->slug) !!}" class="head_item " onmouseover="showtrail('{!!url('').'/'.config('view.filepath') !!}/{!! $item->name !!}','{!!strtoupper($item->title)!!}',650,500)" onmouseout="hidetrail()">	
											<div class="dim"></div>	
											<img src="{!!url('').'/'.config('view.filepath') !!}thumb/{!! $item->name !!}">			
																
										</a>										
										<a class="content_item" href="{!! url('downloadpage/'.$item->id.'/'.$item->slug) !!}">
											<h3>{!!strtoupper($item->title)!!}</h3>
											<span class="the-date">{!!date("F j, Y", strtotime($item->created_at)) !!}</span>
											<span class="name-upload"> - <strong style="color:#27ae60;"> {!!$us!!}</strong> </span>
										</a>
										<div class="item_info">
											<a href="javascript:void(0);" class="buttonlike" align="right" image-id="{!!$item->id !!}"><img src="{!! config('view.rootpath') !!}/img/icon_like.png"> <b id="id{!!$item->id !!}">{!!$item->count_like !!}</b></a>
											<a href="{!!url('downloadpage/'.$item->id.'/'.$item->slug) !!}" class="download" align="right"><img src="{!! config('view.rootpath') !!}/img/icon_download.png"> {!!$item->count_download !!}</a>
											<a href="{!!url('downloadpage/'.$item->id.'/'.$item->slug) !!}" class="download" align="right"> <strong style="color:#d35400;"><span class="glyphicon glyphicon-usd"></span>{!! $item->price!!}</strong></a>
										</div>
									</div>
								</div>
							@endif
						@endforeach
						<div class="clearfix">
							
						</div>
						<div>
							{!!$media->render() !!}
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-4 col-lg-4 no-padding">
					<div class="popular">
						<?php
							$images = DB::table('media')->where('user_id','=',$u_id)->orderBy('count_download', 'DESC')->take(6)->get();
						?>

						<h3>Top Selling </h3>
						<?php foreach($images as $itemPop): ?>
							<a href="{!!url('downloadpage/'.$itemPop->id.'/'.$itemPop->slug)!!}" class="popular-child">
								<div class="img_popular">
									<img src="{{url(config('view.downloadpath')) }}/<?= $itemPop->name ?>">
								</div>
								<p class="titlepop" style="text-align: left;">
									<?= ucwords($itemPop->title) ?><br />
									<small><img src="{!! config('view.rootpath') !!}/img/icon_download.png"> : {!!$itemPop->count_download!!}</small> <br>
									<small><img src="{!! config('view.rootpath') !!}/img/icon_like.png"> : {!!$itemPop->count_like!!}</small> <br>
									<small>Added on <?= date("F j, Y", strtotime($itemPop->created_at)); ?></small>
								</p>
							</a>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
{{--send messager --}}
	<div class="modal fade" id="modal-msg">
		<div class="modal-dialog" style="border: 1px solid #2980b9; position: relative;">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close btn-primary" data-dismiss="modal" aria-hidden="true"><strong > X </strong>
					</button>					
				</div>
				<div class="modal-body" style="padding:0;">
	            		@if (!Auth::user())
			                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		                      	<div class="well">                      		
		                          	<form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
			                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
			                            {{ Session::put('url', Request::url()) }}
			                            <div class="form-group">
			                                <label class="control-label">E-Mail Address</label>
			                                <div >
			                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">
			                                </div>
			                            </div>

			                            <div class="form-group">
			                                <label class="control-label">Password</label>
			                                <div>
			                                    <input type="password" class="form-control" name="password" placeholder="Password">
			                                </div>
			                            </div>

			                            <div class="form-group">  
			                            	<div class="col-xs-6">
			                            		<button type="submit" class="btn btn-primary btn-block">Login</button>
			                            	</div> 
			                            	<div class="col-xs-6">
			                            		<a class="btn btn-info btn-block" href="{!!url('/register')!!}" title="Register">Register</a>
			                            	</div> 
			                            </div>
			                        </form>	                     
		                      	</div>
			                </div>
		                @else         
	                      	<div class="well" style="min-height: 270px;border:none; padding:2px; margin: 0;">
	                      		<h4 class="btnmessager"></h4>
	                      		<input type="hidden" name="_token" value="{{ csrf_token() }}">
	                            <div class="form-group">
	                            	@if ($us !='Admin')
		                            		<label class="control-label">Type message to : <i style="color:red;"> {{$user->name}} </i> </label>	
		                            	@else
		                            		<label class="control-label">Type message to : <i style="color:red;">admin</i> </label>	
		                            	@endif
	                                                                
	                                    <textarea name="tarmsg" id="tarmsg" rows="8" required style="width: 100%; height: 100%;resize: vertical;" > </textarea>	                                    
	                            </div>
	                            <div class="form-group"> 
                            		{!!Captcha::img('flat');!!}
                                    <input type="text" name="captcha">
                                    @if ($us !='Admin')
		                            		<a href="javascript:void(0)" class="buttonmessager btn btn-success" image-id="{!!$user->id!!}">Send</a>
		                            	@else
		                            		<a href="javascript:void(0)" class="buttonmessager btn btn-success" image-id="0">Send</a>
		                            	@endif
	                            </div> 
	                            <div class="form-group"> 
                            		
	                            </div>                   
	                      	</div>
		              	@endif                  
	          	</div>
			</div>
		</div>
	</div>
@stop