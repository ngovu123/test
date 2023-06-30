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
    	<link rel="icon" href="{{ url('public/application/assets/img/favicon.png')}} type="image/x-icon">
    @endif
	<!-- BEGIN CSS FRAMEWORK -->
	<link rel="stylesheet" href="{{ url('public/application/assets/plugins/bootstrap/css/bootstrap.min.css')}}">
	
	<link rel="stylesheet" href="{{ url('public/application/assets/plugins/font-awesome/css/font-awesome.min.css')}}">
	<!-- END CSS FRAMEWORK -->	
	<!-- CUSTOM CSS -->
	<link rel="stylesheet" href="{{ url('public/custome_style/style.css')}}">
	<!-- END CUSTOM CSS -->

	<!-- END ANIMATE CSS -->
	<!-- BEGIN CSS TEMPLATE -->
	<link rel="stylesheet" href="{{ url('public/application/assets/css/showimage.css') }}">
	<!-- END CSS TEMPLATE -->
	<!-- BEGIN JS FRAMEWORK -->
	<script src="{{ url('public/application/assets/plugins/jquery-2.1.0.min.js') }}"></script>
	<script src="{{ url('public/application/assets//plugins/bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ url('public/application/assets/js/mouseover_popup.js') }}"></script>

	<script src="{!!url('public/js/lightslider.js')!!}"></script>
	<!-- END JS FRAMEWORK -->
	<link rel="stylesheet"  href="{!!url('public/css/lightslider.css')!!}">
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
	<header>
		<div class="headerSocial" style="background: #f1f1f1;">
			<div class="container" style="background: #f1f1f1;">
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
		<div class="headerMenu">
			<nav class="navbar navbar-default" role="navigation">
				<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#">
							@if (isset($settings->logo) && trim($settings->logo) != "")
								<a href="{!!url('/home')!!}" class="logo"><img src="{!!config('view.settingspath')!!}/{!!$settings->logo!!}" /></a>
							@elseif(Request::cookie('theme') == 'dark' || $settings->theme == 'dark')
								<a href="{!!url('/home')!!}" class="logo"><img src="{!!url('public/application/assets/img/light-logo.png')!!}" /></a>
							@else
								<a href="{!!url('/home')!!}" class="logo"><img src="{!!url('public/application/assets/img/logo.png')!!}" /></a>
							@endif
						</a>
					</div>
			
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse navbar-ex1-collapse">
						<ul class="nav navbar-nav">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="#">Action</a></li>
									<li><a href="#">Another action</a></li>
									<li><a href="#">Something else here</a></li>
									<li><a href="#">Separated link</a></li>
								</ul>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="#">Action</a></li>
									<li><a href="#">Another action</a></li>
									<li><a href="#">Something else here</a></li>
									<li><a href="#">Separated link</a></li>
								</ul>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="#">Action</a></li>
									<li><a href="#">Another action</a></li>
									<li><a href="#">Something else here</a></li>
									<li><a href="#">Separated link</a></li>
								</ul>
							</li>
						</ul>						
						<ul class="nav navbar-nav navbar-right">
							<form class="navbar-form navbar-left" role="search">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Search">
								</div>
								<button type="submit" class="btn btn-default">Search</button>
							</form>
						</ul>
					</div><!-- /.navbar-collapse -->
				</div>
			</nav>
		</div>
		{{-- fixed top menu --}}
		<div class="navbar-fixed-top navbar-default" id="fixed" style="background-color: #ecf0f1; display: none; border-bottom: 1px solid;  box-shadow: 0px 2px 2px rgba(0,0,0,0.5); height: 55px; ">
			<nav class="navbar navbar-default" role="navigation">
				<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#">
							@if (isset($settings->logo) && trim($settings->logo) != "")
								<a href="{!!url('/home')!!}" class="logo"><img src="{!!config('view.settingspath')!!}/{!!$settings->logo!!}" /></a>
							@elseif(Request::cookie('theme') == 'dark' || $settings->theme == 'dark')
								<a href="{!!url('/home')!!}" class="logo"><img src="{!!url('public/application/assets/img/light-logo.png')!!}" /></a>
							@else
								<a href="{!!url('/home')!!}" class="logo"><img src="{!!url('public/application/assets/img/logo.png')!!}" /></a>
							@endif
						</a>
					</div>
			
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse navbar-ex1-collapse">
						<ul class="nav navbar-nav">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="#">Action</a></li>
									<li><a href="#">Another action</a></li>
									<li><a href="#">Something else here</a></li>
									<li><a href="#">Separated link</a></li>
								</ul>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="#">Action</a></li>
									<li><a href="#">Another action</a></li>
									<li><a href="#">Something else here</a></li>
									<li><a href="#">Separated link</a></li>
								</ul>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="#">Action</a></li>
									<li><a href="#">Another action</a></li>
									<li><a href="#">Something else here</a></li>
									<li><a href="#">Separated link</a></li>
								</ul>
							</li>
						</ul>						
						<ul class="nav navbar-nav navbar-right">
							<form class="navbar-form navbar-left" role="search">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Search">
								</div>
								<button type="submit" class="btn btn-default">Search</button>
							</form>
						</ul>
					</div><!-- /.navbar-collapse -->
				</div>
			</nav>
		</div>
	<script>
      	jQuery(document).ready(function ($) 
      	{
	    	var TopFixMenu = $('#fixed');
	    	$(window).scroll(function () {
	        if ($(this).scrollTop() >75) {

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
		@yield('container')
	</section>
	<!-- BEGIN FOOTER -->
	<footer class="footer">
		<div class="container">
			<div class="row">
				<p><a href="#"><?= $settings->sitename ?></a> - Copyright <?= date("Y"); ?></p>
				<ul class="socialBot social">					
					<li><a href="{!!url('about')!!}" class="about">About</a></li>
					<li><a href="{!!url('contact')!!}" class="contact">Contact</a></li>
					<li><a href="http://facebook.com/{!!$settings->facebook !!}" class="socialIcon facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
					<li><a href="http://plus.google.com/{!!$settings->googleplus !!}" class="socialIcon" target="_blank"><i class="fa fa-google-plus"></i></a></li>
					<li><a href="http://twitter.com/{!! $settings->twitter !!}" class="socialIcon" target="_blank"><i class="fa fa-twitter"></i></a></li>
					<li><a href="{!!url('/rss')!!}" class="socialIcon"><i class="fa fa-rss"></i></a></li>
				</ul>
			</div>
		</div>
	</footer>
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
		$(document).ready(function(){
			$('#searchModal').on('shown.bs.modal', function() {
		        $('#search').focus();
		    });

		});
	</script> 
	<!-- BEGIN JS BUTTON LIKE DOWNLOADPAGE ajax -->
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
				$.ajax
				({
					type: "POST",
					url: "../../msg/" + id,
					data: {id: id, _token: _token,msg: msg  },
					success: function(msg)
					{
						
						document.getElementById("txt").value="";
	
						$('.btnmessager').html(msg);
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
	</script>
	<!-- BEGIN JS TEMPLATE -->
	<script src="{{ url('public/application/assets/js/myscript.js') }}"></script>

	<script src="https://apis.google.com/js/platform.js" async defer></script>
	<script type="text/javascript" src=" {{url('public/application/assets/js/tinymce/tinymce.min.js')}}"></script>
	
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