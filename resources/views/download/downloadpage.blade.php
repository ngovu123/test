@extends('layouts.content')
@section('title')
	Download media
@stop
@section('content')
	<div class="content contentHome">
		<div class="container">
			<div class="row">						
				<div class="contentdownload">
					<div class="col-sm-8">
					<?php $item= $images ?>
						<div class="titledownload">
							<h3> {!! ucwords($item->title) !!}</h3>
							<p>
								Upload By: <a href="{!!url('/users/'.$info->slug.'/'.$item->user_id)!!}" title="Find more upload" style="color:#c0392b;">{!!$info->name!!}</a>
								<span style="font-style:italic;color:#9BA0A5;padding-left:5px;">{!!date("F j, Y", strtotime($item->created_at)) !!}</span> - 

								<?php $tags = explode ( ", " , $item->tags); ?>
								Tag:
								@foreach($tags as $itemtags)							
									<a href="{!!url('/tags/')!!}/{!!$itemtags !!}">{!!$itemtags !!}</a>,
								@endforeach
							</p>
						</div>
						<div class="imgdownload">	
							<div class="col-md-12" style="padding:0;">
								<div class="imagescnt" style="background: #f1f1f1;">
									<div class="item" style="background: #f1f1f1;">  
									@if($md->images_preview->count() == 0)          
							            <div class="clearfix" style="width:100%; min-height: 100%; border-radius: 10px;">
							                <ul id="image-gallery" class="gallery list-unstyled cS-hidden" >
							                	<li class="slide" data-thumb=""> 
							                    	<img src="{!!url(config('view.downloadpath')) !!}/{!!$item->name!!}" style="display: block; margin: 0 auto; border-radius: 10px;" >
							                    </li>
							                </ul>
							            </div>
							        @else
							        	<div class="clearfix" style="width:100%; min-height: 100%; border-radius: 10px;">
							                <ul id="image-gallery" class="gallery list-unstyled cS-hidden" >
							                @foreach($md->images_preview as $row)
							                    <li class="slide" data-thumb="">
							                    	<img src="{!! url('public/content/files/downloads/images/') !!}/{!!$row->image_name!!} " style="display: block; margin: 0 auto;border-radius: 10px;"  >
							                    </li>
							                @endforeach
							                </ul>
							            </div>
							        @endif
							        </div>
								</div>
							</div>						
							<div class="col-md-12" style="padding:0; background: #f1f1f1;">
								<div class="sharedownload" style="background: #f1f1f1;">
									<?php $media_url = URL::to('downloadpage') . '/' . $item->id. '/' . $item->slug; ?>
									<div class="share_twitter share col-md-3">
										<a href="https://twitter.com/intent/tweet?text={!!ucwords($item->title) !!}&url={!!$media_url!!}" target="_blank" onclick="javascript:window.open(this.href, '_blank', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600');return false;">Share on Twitter</a>
									</div>
									<div class="share_facebook share col-md-3">
										<a href="http://www.facebook.com/sharer.php?u={!!$media_url !!}" target="_blank" onclick="javascript:window.open(this.href, '_blank', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600');return false;">Share on Facebook</a>
									</div>
									<div class="share_pinterest share col-md-3">
										<a href="http://pinterest.com/pin/create/button/?url={!!$media_url !!}" target="_blank" onclick="javascript:window.open(this.href, '_blank', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600');return false;">Share on Pinterest</a>
									</div>
									<div class="share_google share col-md-3">
										<a href="https://plus.google.com/share?url={!!$media_url !!}" target="_blank" onclick="javascript:window.open(this.href, '_blank', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600');return false;">Share on Google+</a>
									</div>
									
									<div style="clear:both"></div>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="description">
								<strong>Style :</strong> {!!$item->style !!}	<br>
								<strong>Flatform :</strong> {!!$item->platform!!}	<br>
								<strong>Render :</strong> {!!$item->render !!}		<br>					
								<h3> Media description </h3>
								<p>{!!$item->description !!}</p>
							</div>
							<div class="clearfix"></div>
							<div class="btn-down-like">
							<div class="row">
								<div class="col-md-6">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="_token2" value="{{ csrf_token() }}">
									<?php 
										$price = $item->price; 
										$name = $item->title;
										$m_id = $item->id;
										$user_id = $item->user_id;
									?>
									<a data-toggle="modal" href='#modal-buy' class="btnbuy btn btn-success" image-id="{!! $item->id !!}">
										<i class="fa fa-cloud-download"></i> Download<span class="glyphicon glyphicon-usd"></span><span id="id{!! $item->id !!}">{!! $price !!}</span> 
										(<b id="id{!! $item->id !!}">{!! $item->count_download !!}</b>) 
									</a>
									

								</div>
								<div class="col-md-6">									
									@if (Auth::user())
									<?php
										$bm = DB::table('bookmarks')->where('media_id','=',$item->id)->where('user_id','=',Auth::user()->id)->count();
										if ($bm==0) {
											$title = 'Bookmark';
										} else {
											$title = ' Unmark';
										}
									?>
									<a href="javascript:void(0)" class="buttonbookmarks btnbookmark btn btn-default pull-right" image-id="{!! $item->id !!}"><i class="glyphicon glyphicon-bookmark"></i>{!!$title!!}</a>
									@else
										<a data-toggle="modal" href='#modal-buy' class="buttonbookmarks btnbookmark btn btn-default pull-right" title="Make bookmask this media" image-id="{!! $item->id !!}"><i class="glyphicon glyphicon-bookmark"></i> Bookmark</a>
									@endif		
									<a data-toggle="modal" href='#modal-report' class="buttonreport btn btn-danger pull-right" title="Make bookmask this media" image-id="{!! $item->id !!}"><i class="glyphicon glyphicon-flag"></i> Report</a>
									<a href="javascript:void(0)" class="buttonlike btn btn-danger pull-right" image-id="{!! $item->id !!}"><i class="fa fa-heart"></i> Like (<b id="id{!! $item->id !!}">{!! $item->count_like !!}</b>)</a>	

								</div>					
							</div>
							</div>
							
						</div>		
						<div class="clearfix"></div>			
						<div class="comment">
							<h3>Comments</h3>
								<div class="fb-comments" data-href="{!!Request::url()!!}" data-width="100%" data-numposts="5"></div>
						</div>
					</div>
					<div class="col-sm-4">								
						<div class="mostlike">
							<h3>Member Infomation</h3>
							<div class="row">
								<div class="memberavata col-md-4" style="padding:1px;">
									@if ($info->avata_img !='')
										<img  src="{!!url('public/application/assets/img/user/'.$info->avata_img)!!}" alt="Avata" width="100%" height="110" style="border-radius: 5px ">
									<div class="text-center">	
										@if ($info->website !='')									
										<a href="<?= $info->website ;?>" class="socialIcon" target="_blank" title="website" ><i class="fa fa-link"></i></a>
										@endif
										@if ($info->facebook !='')	
										<a href="http://facebook.com/<?= $info->facebook ;?>" class="socialIcon facebook" target="_blank" title="facebook"><i class="fa fa-facebook"></i></a>
										@endif
										@if ($info->googleplus !='')		
										<a href="http://plus.google.com/<?= $info->googleplus ;?>" class="socialIcon" target="_blank" title="google plus"><i class="fa fa-google-plus"></i></a>
										@endif
										@if ($info->twitter !='')		
										<a href="http://twitter.com/<?= $info->twitter ;?>" class="socialIcon" target="_blank" title="twitter"><i class="fa fa-twitter"></i></a>
										@endif
										@if ($info->skype !='')		
										<a href="http://www.skype.com/<?= $info->skype ;?>" class="socialIcon" target="_blank" title="skype"><i class="fa fa-skype"></i></a>
										@endif											
									</div>

									@else
										<img src="{!!url('public/application/assets/img/user/photo.png')!!}" alt="Avata" width="100%">
									@endif
								
								</div>
								<div class="memberinfo col-md-8" style="padding:1px;">
									<li>Full name : <strong>{!!$info->name!!}</strong> </li>
									<li>Registration Date : <strong> {!!date("j/m/Y", strtotime($info->created_at)) !!} </strong></li>
									<li>Address: <strong>{!!$info->address!!}</strong>  </li>
									<li>Date of birth:<strong> {!!date("j/m/Y", strtotime($info->created_at)) !!} </strong>  </li>
									<li>Total Upload: <strong>{!!$total!!}</strong></li>
									<li><a class="btn btn-danger" href="{!!url('/users/'.$info->slug.'/'.$item->user_id)!!}" title="Find more"> <i class="glyphicon glyphicon-search"></i> </a> 
									<a data-toggle="modal" href="#modal-msg" class="btn btn-success" title="Send message" ><i class="glyphicon glyphicon-comment"></i> </a>

									</li>
								</div>
							</div>
						</div>
						<div class="popular">
							<h3>Top Selling </h3>
							<?php foreach($top as $itemPop): ?>
								<a href="{!!url('downloadpage/'.$itemPop->id.'/'.$itemPop->slug)!!}" class="popular-child">
									<div class="img_popular">
										<img src="{{url(config('view.downloadpath')) }}/thumb/<?= $itemPop->name ?>">
									</div>
									<p class="titlepop">
										<?= ucwords($itemPop->title) ?><br />
										<small>Downloaded : {!!$itemPop->count_download!!}</small> <br>
										<small>Liked : {!!$itemPop->count_like!!}</small> <br>
										<small>Added on <?= date("F j, Y", strtotime($itemPop->created_at)); ?></small>
									</p>
								</a>
							<?php endforeach; ?>
						</div>		
					
						<div class="alsolike">
							<?php
								$img = DB::table('media')->where('user_id','=',$item->user_id)->orderBy('created_at', 'DESC')->take(2)->paginate(4);
							?>
							<h3> Other uploads by : <a href="{!!url('/users/'.$info->slug.'/'.$item->user_id)!!}" title="Find more upload" style="color:#c0392b;">{!!$info->name!!}</a></h3>
							 @foreach($img as $item)   	

						    	<?php 
						    		if ($item->user_id == 0) {
						    			$us = 'Admin';
						    		} else {
						    			$tb = DB::table('users')->where('id','=',$item->user_id)->first();
						    			$us = $tb->name;
						    		}    		
						    	?>
								<a href="{!!url('downloadpage/'.$item->id.'/'.$item->slug)!!}" class="popular-child">
									<div class="img_popular">
										<img src="{{url(config('view.downloadpath')) }}/thumb/<?= $item->name ?>">
									</div>
									<p class="titlepop">
										<?= ucwords($item->title) ?><br />
										<small>Downloaded : {!!$item->count_download!!}</small> <br>
										<small>Liked : {!!$item->count_like!!}</small> <br>
										<small>Added on <?= date("F j, Y", strtotime($item->created_at)); ?></small>
									</p>
								</a>
							@endforeach
							<div class="clearfix">
								
							</div>
							<div class="text-center" >
								{{-- {!!$img->render() !!} --}}
								@include('partials/pagination', ['paginator' => $img])
							</div>
						</div>				
					</div>
				</div><!-- .contentdownload -->
			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- .contentHome -->
	<!-- BEGIN JS FRAMEWORK -->
	<script type="text/javascript">
	    /* * * CONFIGURATION VARIABLES * * */
	    var disqus_shortname = '<?= $settings->disqus; ?>';
	    
	    /* * * DON'T EDIT BELOW THIS LINE * * */
	    (function () {
	        var s = document.createElement('script'); s.async = true;
	        s.type = 'text/javascript';
	        s.src = '//' + disqus_shortname + '.disqus.com/count.js';
	        (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
	    }());
	</script>
	<script type="text/javascript">
		$(document).ready(function () {
			$("iframe").contents().find(".FP").css("background", "blue");
		});
	</script>

	{{-- show login - paypall --}}
	<div class="modal fade" id="modal-buy">
		<div class="modal-dialog" style="border: 1px solid #2980b9;">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close btn-danger" data-dismiss="modal" aria-hidden="true"><strong style="color: red;"> X </strong></button>
					@if(Auth::user())
						<h4 class="modal-title text-center">Download</h4>
					@else
						<h4 class="modal-title text-center">Needed Login </h4>
					@endif
				</div>
				<div class="modal-body" style="border-top: 1px solid #2980b9;">
	            	<div class="row">

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
	                <?php
	            		$id_pay = DB::table('download_log')
	            				->where('media_id','=',$m_id)
	            				->where('user_id','=',Auth::user()->id)
	            				->whereRaw('DAY( download_log.created_at ) = DAY (CURRENT_DATE) and YEAR( download_log.created_at ) = YEAR (CURRENT_DATE) ')
	            				->first();
	            	?>       	
		            	@if($id_pay=='')
	                	 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	                      	<div class="well">                      	
	                          	<form class="form-horizontal" role="form" method="POST" action="{!!url('/payment')!!}">
		                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
		                            <div class="form-group">
		                                <label class="control-label">Account  : <strong style="color:#e67e22;">{!!Auth::user()->name!!}</strong></label>
		                            </div>
		                             <div class="form-group">
		                                <label class="control-label">Pay Method</label>
			                                <select name="slcpt" id="inputSlcpt" class="form-control" required="required">
			                                	<option value="Paypal"> Online With Paypal</option>	                                	
			                                </select>
		                            </div>		                            
		                            <div class="form-group">
		                                <label class="control-label"> Name :</label>
		                                <input type="hidden" name="txtname" readonly value="{!!$name!!}" style="width: 80%;"> <span>{!!$name!!}</span> 
		                            </div>                            
		                            <div class="form-group">
		                                <label class="control-label"> Price :</label>
		                                <input type="hidden" name="txtid" value="{!!$m_id!!}" >
		                                <input type="hidden" name="txtuid" value="{!!$user_id!!}" >
		                                <input type="hidden" name="txtprice" readonly value="{!!$price!!}" style="width: 50px;"><span class="glyphicon glyphicon-usd"></span>{!!$price!!} <br>
		                                <label class="control-label"><small style="color: #e74c3c;">After payment, Today You can download this file again !</small> </label>
		                            </div>
		                            <div class="form-group"> 
	                                	<button type="submit" class="btn btn-danger" style="margin-left: 30%;">Donwload Now</button>	 

		                            </div>
		                        </form>	                     
	                      	</div>
		                </div>
		                @else
		                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	                      	<div class="well">                      	
	                          	<form class="form-horizontal" role="form" method="get" action="{!!url('/afterdownload/'.$m_id)!!}">

		                            {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
		                            <div class="form-group">
		                                <label class="control-label">Account  : <strong style="color:#e67e22;">{!!Auth::user()->name!!}</strong></label>
		                                <input type="hidden" name="u_id" value="{{Auth::user()->id }}">
		                            </div>		                             
		                            <div class="form-group">
		                                <label class="control-label"> Name :</label>
		                                <input type="hidden" name="media" readonly value="{!!$name!!}" style="width: 80%;"> <span>{!!$name!!}</span>
		                            </div>                            
		                            <div class="form-group">
		                                <input type="hidden" name="payid" value="{{ $id_pay->payment_id }}">
		                            </div>
		                            <div class="form-group"> 
	                                	<button type="submit" class="btn btn-danger" style="margin-left: 30%;">Donwload Now</button>	 

		                            </div>
		                        </form>	                     
	                      	</div>
		                </div>
		                @endif

                	@endif		                  
	              </div>
	          	</div>
			</div>
		</div>
	</div>
		{{-- show report form --}}
	<div class="modal fade" id="modal-report">
		<div class="modal-dialog" style="border: 1px solid #2980b9;">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close btn-danger" data-dismiss="modal" aria-hidden="true"><strong style="color: red;"> X </strong></button>
					@if(Auth::user())
						<h4 class="modal-title text-center">What's happening this media </h4>
					@else
						<h4 class="modal-title text-center">Needed Login </h4>
					@endif					
				</div>
				<div class="modal-body" style="border-top: 1px solid #2980b9;">
	            	<div class="row">
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
			                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		                      	<div class="well" style="min-height: 290px;">
		                      		<h4 class="btnreport flash_message"></h4>
		                      		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		                            <div class="form-group">
		                                <input type="hidden" name="txtid"  value="{!!$m_id!!}">
		                                <label class="control-label">Media name : <span style="color:#e74c3c;">{!!$name!!}</span> </label>
		                            </div>
		                            <div class="form-group">
		                                <label class="control-label">Enter your messager</label>	                                
		                                    <textarea name="tarContent" id="txtflag" rows="5" cols="75" required style="width: 100%; height: 100%;resize: vertical;" > </textarea>
		                            </div>
		                            <div class="form-group">  
		                            	<div class="col-xs-6">   
		                            		<a href="javascript:void(0)" class="buttonreportsend btn btn-success" image-id="{!! $m_id !!}">Send report</a>
		                            	</div>  
		                            </div>                   
		                      	</div>
			                </div>	
		              	@endif                  
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
					<button type="button" class="close btn-danger" data-dismiss="modal" aria-hidden="true"><strong style="color: red;"> X </strong></button>
					@if(Auth::user())
						<h4 class="modal-title text-center">Send messager</h4>
					@else
						<h4 class="modal-title text-center">Needed Login </h4>
					@endif
				</div>
				<div class="modal-body" style="padding:0;">
	            		@if (!Auth::user())			                
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
		                @else         
	                      	<div class="well" style="min-height: 270px;border:none; padding:2px; margin: 0;">
	                      		<h4 class="btnmessager"></h4>
	                      		<input type="hidden" name="_token" value="{{ csrf_token() }}">
	                            <div class="form-group">
	                                <label class="control-label">Type message to : <i style="color:red;"> {{$info->name}} </i> </label>	                                
	                                    <textarea name="tarmsg" id="tarmsg" rows="8" required style="width: 100%; height: 100%;resize: vertical;" > </textarea>	                                    
	                            </div>
	                            <div class="form-group"> 
                            		{!!Captcha::img('flat');!!}
                                    <input type="text" name="captcha">
                                    <a href="javascript:void(0)" class="buttonmessager btn btn-success" image-id="{!!$item->user_id!!}">Send</a>
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