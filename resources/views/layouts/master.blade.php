<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<!--[if IE]>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<![endif]-->
	<?php $settings = DB::table('settings')->first() ;?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?= $settings->headline ;?>">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	@if(isset($settings->sitename))
		<title>{!!$settings->sitename!!} - @yield('title')</title>
	@else
		<title> Pixel - @yield('title')</title>
	@endif
	<meta property="og:url"           content="<?= Request::url(); ?>" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="<?php if(isset($imgshare)) echo ucwords($imgshare->title); ?>" />
    <meta property="og:description"   content="<?php if(isset($imgshare)) echo ucwords(str_replace('"', '\'', $imgshare->description)); ?>" />
    <meta property="og:image"         content="<?php if(isset($imgshare)) echo URL::to('/') . config('view.filepath') . $imgshare->name ;?>" />
    <link rel="canonical" href="<?php if(isset($imgshare)) echo $media_url . '/path/' . $imgshare->name ;?>" />
    @if(isset($settings->favicon))
    	<link rel="icon" href="{{ config('view.settingspath') }}/{!!$settings->favicon!!}" type="image/x-icon">
    @else
    	<link rel="icon" href="{{ url('').config('view.rootpath') }}/img/favicon.png" type="image/x-icon">
    @endif
	<!-- BEGIN CSS FRAMEWORK -->
	<link rel="stylesheet" href="{{ config('view.rootpath') }}/plugins/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="{{ config('view.rootpath') }}/css/pixel.css">
	<link rel="stylesheet" href="{{ config('view.rootpath') }}/plugins/font-awesome/css/font-awesome.min.css">
	<!-- END CSS FRAMEWORK -->	
	<!-- CUSTOM CSS -->
	<link rel="stylesheet" href="{{ config('view.rootpath') }}/css/style.css">
	<!-- END CUSTOM CSS -->
	<!-- ANIMATE CSS -->
	<link rel="stylesheet" href="{{ config('view.rootpath') }}/css/animate.css">
	<!-- END ANIMATE CSS -->
	<!-- BEGIN CSS TEMPLATE -->
	<link rel="stylesheet" href="{{ config('view.rootpath') }}/css/main.css">
	<link rel="stylesheet" href="{{ config('view.rootpath') }}/css/c_style.css">

	@if(Request::cookie('theme') == 'dark' || $settings->theme == 'dark')
		<link rel="stylesheet" href="{{ config('view.rootpath') }}/css/dark.css">
	@endif
	<!-- END CSS TEMPLATE -->
	<!-- BEGIN JS FRAMEWORK -->
	<script src="{{ config('view.rootpath') }}/plugins/jquery-2.1.0.min.js"></script>
	<script src="{{ config('view.rootpath') }}/plugins/bootstrap/js/bootstrap.min.js"></script>

	<script src="{!!url('public/js/lightslider.js')!!}"></script> 
	<script src="{!!url('public/js/crop-image.js')!!}"></script> 
	<!-- showimage css -->
	<script src="{{ config('view.rootpath') }}/js/showimage.js"></script>
	<link rel="stylesheet" href="{{ config('view.rootpath') }}/css/showimage.css">
	<!-- END JS FRAMEWORK -->
	<link rel="stylesheet"  href="{!!url('public/css/lightslider.css')!!}">
		<link rel="stylesheet" href="{{ asset('public/jquery/css/style.css') }}" type="text/css" />
	<script type="text/javascript">
		function  readURL(input,thumbimage) {
		   if  (input.files && input.files[0]) { //Sử dụng  cho Firefox - chrome
		   var  reader = new FileReader();
		    reader.onload = function (e) {
		    $("#thumbimage").attr('src', e.target.result);
		     }
		     reader.readAsDataURL(input.files[0]);
		    }
		    else  { // Sử dụng cho IE
		      $("#thumbimage").attr('src', input.value);
		  
		    }
		    $("#thumbimage").show();
		    $('.filename').text($("#uploadfile").val());
		    $('.Choicefile').css('background', '#C4C4C4');
		    $('.Choicefile').css('cursor', 'default');
		    $(".removeimg").show();
		    $(".Choicefile").unbind('click'); //Xóa sự kiện  click trên nút .Choicefile
		          
		}
		// // click
		//  function  cropclick() {

		//    $src = $("#uploadfile").val();
		//    alert($src);
		// }
		// croped
		 function  cropclick(input,thumbimage) {
		   if  (input.files && input.files[0]) { //Sử dụng  cho Firefox - chrome
		   var  reader = new FileReader();
		    reader.onload = function (e) {
		    $("#thumbimage-croped").attr('src', $("#uploadfile").val());
		     }
		     reader.readAsDataURL(input.files[0]);
		    }
		    else  { // Sử dụng cho IE
		      $("#thumbimage-croped").attr('src', input.value);
		  
		    }
		    $("#thumbimage-croped").show();
		    $('.filename').text($("#uploadfile").val());
		    $('.Choicefile').css('background', '#C4C4C4');
		    $('.Choicefile').css('cursor', 'default');
		    $(".removeimg").show();
		    $(".Choicefile").unbind('click'); //Xóa sự kiện  click trên nút .Choicefile
		          
		  }
		  // khoi tao
		  $(document).ready(function () {
		   $(".Choicefile").bind('click', function  () { //Chọn file khi .Choicefile Click
		    $("#uploadfile").click();
		               
		   });
		   $(".removeimg").click(function () {//Xóa hình  ảnh đang xem
		      $("#thumbimage").attr('src', '').hide();
		      $("#myfileupload").html('<input type="file" id="uploadfile"  onchange="readURL(this);" >');
		      $(".removeimg").hide();
		      $(".Choicefile").bind('click', function  () {//Tạo lại sự kiện click để chọn file
		       $("#uploadfile").click();
		      });
		      $('.Choicefile').css('background','#0877D8');
		      $('.Choicefile').css('cursor', 'pointer');
		      $(".filename").text("");
		    });
		   })
		</script>
	<style type="text/css">
		 .Choicefile
		  {
		   display:block;
		   background:#0877D8;
		   border:1px solid #fff;
		   color:#fff;
		   width:250px;
		   text-align:center;
		   text-decoration:none;
		   cursor:pointer;
		   padding:5px 0px;
		   }
		   #uploadfile,.removeimg,#imagecroped
		   {
		    display:none;
		   }
		   #thumbbox
		   {
		    position:relative;
		    width:100px;
		   }
		   .removeimg
		   {
		   height: 30px;
		   position: absolute;
		   top: 5px;
		   float: right;
		   width: 30px;
		   color: red;		  
		   }
		</style>
	<script type="text/javascript">
		 $(document).ready(function() {
	    $("#content-slider").lightSlider({
	        loop:true,
	        keyPress:true
	    });
	    $('#home-slide').lightSlider({
	        gallery:false,
	        item:1,
	        thumbItem:9,
	        slideMargin: 15,
	        speed:500,
	        auto:true,
	        loop:true,
	        onSliderLoad: function() {
	            $('#home-slide').removeClass('cS-hidden');
	        }  
	    });
	});

	 $(document).ready(function() {
	    $("#content-slider").lightSlider({
	        loop:true,
	        keyPress:true
	    });
	    $('#image-gallery').lightSlider({
	        gallery:false,
	        item:1,
	        thumbItem:9,
	        slideMargin: 15,
	        speed:500,
	        auto:true,
	        loop:true,
	        onSliderLoad: function() {
	            $('#image-gallery').removeClass('cS-hidden');
	        }  
	    });
	});
	</script>
	<style type="text/css">
		.back-to-top 
		{
		    cursor: pointer;
		    position: fixed;
		    bottom: 20px;
		    right: 20px;
		    display:none;
		}
	</style>
    <style>
        .action
        {
            width: 650px;
            height: 30px;
            margin: 10px 0;
        }
        .cropped{
            width: 70px;
            height: 40px;
            border: 1px solid;
            float:left;
            margin-left: 15px;
        }
        .cropped>img
        {
            margin-right: 10px;
        }
    </style>
    <!-- <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script> -->
    <script src="{{asset('/public/jquery/cropbox.js')}}"></script>
</head>
<body>


<div id="fb-root"></div>
	<script>
		(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=138284626640741";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
	<!-- BEGIN HEADER -->
	<header class="header">
		<div class="headerSocial">
			<div class="container">
				<div class="row headrow">					
					<p class="topHeadline"><?= $settings->subheadline ;?></p>
					<ul class="socialTop social">
						<li class="social-btn"><a href="http://facebook.com/<?= $settings->facebook ;?>" class="socialIcon facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
						<li class="social-btn"><a href="http://plus.google.com/<?= $settings->googleplus ;?>" class="socialIcon" target="_blank"><i class="fa fa-google-plus"></i></a></li>
						<li class="social-btn"><a href="http://twitter.com/<?= $settings->twitter ;?>" class="socialIcon" target="_blank"><i class="fa fa-twitter"></i></a></li>
						<li class="social-btn"><a href="{!!url('/rss')!!}" class="socialIcon"><i class="fa fa-rss"></i></a></li>

						@if(Auth::guard('admin')->user())
							<li>&nbsp;<a href="{!!url('/admin')!!}" class="admin"> Manager :<strong style="color:#c0392b;"> {!! Auth::guard('admin')->user()->name !!}</strong </a></li>
							<li> &nbsp;
                                <a href="{{ url('/admin/logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
						@elseif(Auth::user())
							<li>&nbsp;<a href="{!!url('/member')!!}" class="admin">Manager : <strong style="color:#c0392b;"> {!! Auth::user()->name !!}</strong </a></li>
							<li>&nbsp;
                                <a href="{{ url('/logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
						@else
							<li>&nbsp;<a href="{!!url('login')!!}">&nbsp;<i class="glyphicon glyphicon-lock"></i> Login</a></li>
							<li>&nbsp;<a href="{!!url('register')!!}">&nbsp;<i class="glyphicon glyphicon-new-window"></i> Register</a></li>							
						@endif					
						
					</ul>
				</div>
			</div>
		</div>

		<nav class="navbar navbar-default" role="navigation" style="background-color: #f1f1f1; text-align: center;">
			<div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">		
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
						<span class="sr-only"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					@if (isset($settings->logo) && trim($settings->logo) != "")
							<a href="{!!url('/home')!!}" class="logo"><img src="{!!config('view.settingspath')!!}/{!!$settings->logo!!}" />
							</a>
					@elseif(Request::cookie('theme') == 'dark' || $settings->theme == 'dark')
							<a href="{!!url('/home')!!}" class="logo"><img src="{!!url('public/application/assets/img/light-logo.png')!!}" /></a>
					@else
						<a href="{!!url('/home')!!}" class="logo"><img src="{!!url('public/application/assets/img/logo.png')!!}" /></a>
					@endif
				</div>
					
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<ul class="nav navbar-nav navbar-right">
					<?php
						$category = DB::table('categories')->orderBy('order', 'ASC')->orderBy('id', 'DESC')->get();
						$url_base = url('/category');
						$url = Request::url();
						$arr_url = explode("/", $url);								
						foreach($category as $item):
							$hasSub = false;
							foreach($category as $nitem):
								if($nitem->parentID == $item->id) {
									$hasSub = true;
									break;
								}
							endforeach;
							if ($item->parentID == 0 ){ ?>
				      		<li role="presentation" class="
						      		<?php
						      			if (in_array($item->url_slug, $arr_url)) 
						      			{
										    echo 'active';
										} else 
										{
											foreach ($category as $value) 
											{
						      					if ($value->parentID == $item->id)
						      					{
													if (in_array($value->url_slug, $arr_url)) 
													{
												    	echo 'active';
													}
												}
											}
										}
									?>
				      				<?= ($hasSub)? 'dropdown' : '';?>
				      				">
				      			<a <?= ($hasSub)? 'class="dropdown-toggle"' : '';?> 
				      			href="
									<?php  
										if($item->url_slug != "home"): 
											echo $url_base.'/' . $item->url_slug;
										else: echo url('home'); endif;  
									?>">
				      			<?= ucwords($item->name) ?>
				      			<?php if ($hasSub): ?>
				      				<span class="caret"></span>
				      			<?php endif ?>
				      			</a>
				      		<?php }
					      		if ($hasSub) {
					      			echo '<ul class="dropdown-menu dropfixed">';
					      			foreach ($category as $value) :
										if ($value->parentID == $item->id):											
											echo '<li><a href="'.$url_base.'/'. $value->url_slug .'">'.ucwords($value->name).'</a></li>';

										endif;
									endforeach;
									echo '</ul>';
								}?>
				      		</li>
				      	<?php endforeach; ?>
				      	<div class="searchIcon" data-toggle="modal" data-target=".search_popup" style="padding-top: 7px;">
				      		<a href="javascript:void(0)"><i class="glyphicon glyphicon-search"></i></a>
				      	</div>
					</ul>					
				</div><!-- /.navbar-collapse -->
			</div>
		</nav>
		<!-- .dixed top nav -->
		<nav class="navbar-fixed-top navbar-default hidden-xs" role="navigation" id="fixed" style="display: none; border-bottom: 1px solid;  box-shadow: 0px 2px 2px rgba(0,0,0,0.5); ">
			<div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">		
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
						<span class="sr-only"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					@if (isset($settings->logo) && trim($settings->logo) != "")
							<a href="{!!url('/home')!!}" class="logo hidden-xs"><img src="{!!config('view.settingspath')!!}/{!!$settings->logo!!}" />
							</a>
					@elseif(Request::cookie('theme') == 'dark' || $settings->theme == 'dark')
							<a href="{!!url('/home')!!}" class="logo hidden-xs"><img src="{!!url('public/application/assets/img/light-logo.png')!!}" /></a>
					@else
						<a href="{!!url('/home')!!}" class="logo hidden-xs"><img src="{!!url('public/application/assets/img/logo.png')!!}" /></a>
					@endif
				</div>
					
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<ul class="nav navbar-nav navbar-right">
					<?php
						$category = DB::table('categories')->orderBy('order', 'ASC')->orderBy('id', 'DESC')->get();
						$url_base = url('/category');
						$url = Request::url();
						$arr_url = explode("/", $url);								
						foreach($category as $item):
							$hasSub = false;
							foreach($category as $nitem):
								if($nitem->parentID == $item->id) {
									$hasSub = true;
									break;
								}
							endforeach;
							if ($item->parentID == 0 ){ ?>
				      		<li role="presentation" class="
						      		<?php
						      			if (in_array($item->url_slug, $arr_url)) 
						      			{
										    echo 'active';
										} else 
										{
											foreach ($category as $value) 
											{
						      					if ($value->parentID == $item->id)
						      					{
													if (in_array($value->url_slug, $arr_url)) 
													{
												    	echo 'active';
													}
												}
											}
										}
									?>
				      				<?= ($hasSub)? 'dropdown' : '';?>
				      				">
				      			<a <?= ($hasSub)? 'class="dropdown-toggle"' : '';?> 
				      			href="
									<?php  
										if($item->url_slug != "home"): 
											echo $url_base.'/' . $item->url_slug;
										else: echo url('home'); endif;  
									?>">
				      			<?= ucwords($item->name) ?>
				      			<?php if ($hasSub): ?>
				      				<span class="caret"></span>
				      			<?php endif ?>
				      			</a>
				      		<?php }
					      		if ($hasSub) {
					      			echo '<ul class="dropdown-menu dropfixed">';
					      			foreach ($category as $value) :
										if ($value->parentID == $item->id):
											echo '<li><a href="'.$url_base.'/'. $value->url_slug .'">'.ucwords($value->name).'</a></li>';
										endif;
									endforeach;
									echo '</ul>';
								}?>
				      		</li>
				      	<?php endforeach; ?>
				      	<div class="searchIcon" data-toggle="modal" data-target=".search_popup" style="padding-top: 7px;">
				      		<a href="javascript:void(0)"><i class="glyphicon glyphicon-search"></i></a>
				      	</div>
					</ul>					
				</div><!-- /.navbar-collapse -->
			</div>
		</nav>

		<script>
      	jQuery(document).ready(function ($) 
      	{
	    	var TopFixMenu = $('#fixed');
	    	$(window).scroll(function () {
	        if ($(this).scrollTop() >100) {

	            TopFixMenu.show();
	        } else {

	            TopFixMenu.hide();
	        }
    	});
		});
    </script>
	</header>
	<!-- END HEADER -->

	<section class="content">
	<!-- <div style="display: none; position: fixed; z-index: 110; left: 0; top: 0; width: 0; height: 0" id="preview_div"></div> -->
		@yield('container')
	</section>
	<!-- BEGIN FOOTER -->
	<footer class="footer">
		<div class="container">
			<div class="row">
				<p><a href="#"><?= $settings->sitename ?></a> - Copyright <?= date("Y"); ?></p>
				<ul class="socialBot social">					
					<li><a href="{!!url('about')!!}" class="about">About</a></li>
					<li><a href="{!!url('rules')!!}" class="about">Terms and rules</a></li>
					{{-- <li><a href="{!!url('contact')!!}" class="contact">Contact</a></li> --}}
					<li><a href="http://facebook.com/{!!$settings->facebook !!}" class="socialIcon facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
					<li><a href="http://plus.google.com/{!!$settings->googleplus !!}" class="socialIcon" target="_blank"><i class="fa fa-google-plus"></i></a></li>
					<li><a href="http://twitter.com/{!! $settings->twitter !!}" class="socialIcon" target="_blank"><i class="fa fa-twitter"></i></a></li>
					<li><a href="{!!url('/rss')!!}" class="socialIcon"><i class="fa fa-rss"></i></a></li>
				</ul>
			</div>
		</div>
	</footer>
	<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Click to return on the top page" data-toggle="tooltip" data-placement="left"><span class="glyphicon glyphicon-chevron-up"></span></a>
	<div id="modalpage">
	    <div class="modal search_popup animated slideInUp" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="padding:0;">
	        <div class="container">
	            <div class="search-modal modal-dialog col-sm-6 col-xs-6" style="float:none;">
	                <div class="modal-content row">
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	                    <div class="col-sm-12 col-xs-12 slide">
	                        <h1 class="animated slideInLeft">Search with Name</h1>
	                    	{!! Form::open(array('action' =>array('PagesController@seacrh') , 'class'=>'form-horizontal formsettings','enctype'=>'multipart/form-data')) !!}
	                    		{!!Form::text('search', null,array('id'=>'search', 'class'=>'form-control', 'placeholder'=>'Enter name to search'))!!}
	                    		{!!Form::submit('Search', array('id'=>'submit', 'class'=>'btn btn-danger submit-media'))!!}
	                    	{!! Form::close() !!}
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<!-- END FOOTER -->
	<script>
		var rootpath = "{{ config('view.rootpath') }}";
		// alert(rootpath);
	</script>
	<!-- END JS GLOBAL VARIABLE -->
	
	<script>
		$(document).ready(function(){
			$('#searchModal').on('shown.bs.modal', function() {
		        $('#search').focus();
		    });

		});
	</script> 
	<!-- BEGIN JS BUTTON LIKE DOWNLOADPAGE -->
	<script type="text/javascript">
		$(document).ready(function () {
		    $("a.buttonlike").click(function() {
		    	
				var id     = $(this).attr("image-id");
				var _token = $('input[name=_token]').val();
				$.ajax
				({
					type: "POST",
					url: "../../like/" + id,
					data: {id: id, _token: _token},
					success: function(msg)
					{	
						$('.buttonlike b#id'+id+'').html(msg);
					}
				});
			});
		    // bookmarks media 
		    $("a.buttonbookmarks").click(function() {
				var id     = $(this).attr("image-id");
				var _token2 = $('input[name=_token2]').val();

				$.ajax
				({
					type: "POST",
					url: "../../bookmarks/" + id,
					data: {id: id, _token: _token2},
					success: function(msg)
					{
						$('.btnbookmark').html(msg);
					}
				});
			});
			 // report media 
		    $("a.buttonreportsend").click(function() {
				var id     = $(this).attr("image-id");
				var _token = $('input[name=_token]').val();
				var content = $('textarea[name=tarContent]').val();

				$.ajax
				({
					type: "POST",
					url: "../../report/" + id,
					data: {id: id, _token: _token,content: content  },
					success: function(msg)
					{
						document.getElementById("txtflag").value="";						
						$('.btnreport').html(msg);
					}
				});
			}); 
			// send messager
		    $("a.buttonmessager").click(function() {
				var id     = $(this).attr("image-id");
				var _token = $('input[name=_token]').val();
				var msg = $('textarea[name=tarmsg]').val();
				var captcha = $('input[name=captcha]').val();
				$.ajax
				({
					type: "POST",
					url: "../../msg/" + id,
					data: {id: id, _token: _token,msg: msg ,captcha:captcha },
					success: function(msg)
					{						
						$('.btnmessager').html(msg);
							document.getElementById("tarmsg").value="";
						
					}
				});
			});


			$("a.btndownload").click(function() {
				var id     = $(this).attr("image-id");

				$.ajax
				({
					type: "GET",
					url: "../../countdownload/" + id,
					success: function(msg)
					{
						$('.btndownload span#id'+id+'').html(msg);
						window.location = '../afterdownload/' + id;
					}
				});
			});
		});

        $(window).load(function() {
            var options =
            {
                thumbBox: '.thumbBox',
                spinner: '.spinner',
                imgSrc: '{{asset('/public/jquery/css/avatar.png')}}'
            }
            var cropper = $('.imageBox').cropbox(options);
            $('#file').on('change', function(){
                var reader = new FileReader();
                reader.onload = function(e) {
                    options.imgSrc = e.target.result;
                    cropper = $('.imageBox').cropbox(options);
                }
                reader.readAsDataURL(this.files[0]);
                this.files = [];
            })
            $('#btnCrop').on('click', function(){
                var img = cropper.getDataURL();
                var _token = $('input[name=_token]').val();
                $.ajax({
                    type: "POST",
                    url: '{{url('member/uploadimg')}}',
                    data: {img: img, _token: _token },
                    success: function (msg) {
                        $('.cropped').append('<img class="img-responsive" src="{{url('public/content/files/downloads/images/thumb/')}}/'+msg+'">');                        
                        $(".img_cr").css({"display":"none"});
                        $("#select_img").css({"display":"none"});
                        $('#upimage_name').val(msg);                    }
                });

            })
            $('#btnZoomIn').on('click', function(){
                cropper.zoomIn();
            })
            $('#btnZoomOut').on('click', function(){
                cropper.zoomOut();
            })
        });
	</script>
	<!-- END JS BUTTON LIKE DOWNLOADPAGE -->
	<!-- BEGIN JS BUTTON LIKE HOMEPAGE -->
	
	<!-- BEGIN JS TEMPLATE -->
	<script src="{{ config('view.rootpath') }}/js/main.js"></script>
	<script src="{{ config('view.rootpath') }}/js/myscript.js"></script>
	<script src="https://apis.google.com/js/platform.js" async defer></script>
	<script type="text/javascript" src="{{ config('view.rootpath') }}/js/tinymce/tinymce.min.js"></script>
	
	<script type="text/javascript">
	    tinymce.init({
	        selector: "#description",
	        toolbar: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview media | forecolor backcolor | code",
	        plugins: [
		         "advlist autolink link image code lists charmap print preview hr anchor pagebreak spellchecker code fullscreen",
		         "save table contextmenu directionality emoticons template paste textcolor code"
		   ],
		   menubar:false,
	    });
    </script>
	<!-- END JS TEMPLATE -->

	<!-- Google Analytics -->

	<?php if(isset($settings->gganalytic) && trim($settings->gganalytic) != ""): ?>
	  <script>
	    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	    ga('create', '<?= $settings->gganalytic ?>', 'auto');
	    ga('send', 'pageview');
	  </script>
	<?php endif; ?>
	<!-- End Google Analytics -->
</body>
</html>