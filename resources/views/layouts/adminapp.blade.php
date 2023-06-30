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
    <meta property="og:image"         content="<?php if(isset($imgshare)) echo URL::to('public/content/files/downloads/images/'). $imgshare->name ;?>" />
    <link rel="canonical" href="<?php if(isset($imgshare)) echo $media_url . '/path/' . $imgshare->name ;?>" />
    @if(isset($settings->favicon))
        <link rel="icon" href="{{ url('public/content/files/settings/') }}/{!!$settings->favicon!!}" type="image/x-icon">
    @else
        <link rel="icon" href="{{ url('public/content/files/settings/') }}/img/favicon.png" type="image/x-icon">
    @endif
    <!-- BEGIN CSS FRAMEWORK -->
    <link rel="stylesheet" href="{{ url('public/application/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('public/application/assets/css/pixel.css') }}">
    <link rel="stylesheet" href="{{ url('public/application/assets/plugins/font-awesome/css/font-awesome.min.css') }}">
    <!-- END CSS FRAMEWORK -->  
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="{{ url('public/application/assets/css/style.css') }}">
    <!-- END CUSTOM CSS -->
    <!-- ANIMATE CSS -->
    <link rel="stylesheet" href="{{ url('public/application/assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ config('view.rootpath') }}/css/c_style.css">
    <!-- END ANIMATE CSS -->
    <!-- BEGIN CSS TEMPLATE -->
    <link rel="stylesheet" href="{{ url('public/application/assets/css/main.css') }}">

    <!-- END CSS TEMPLATE -->

    <!-- BEGIN JS FRAMEWORK -->
    <script src="{{ url('public/application/assets/plugins/jquery-2.1.0.min.js') }}"></script>
    <script src="{{ url('public/application/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- END JS FRAMEWORK -->
     <link rel="stylesheet" href="{{ asset('public/jquery/css/style.css') }}" type="text/css" />
    <style>
        .action
        {
            width: 650px;
            height: 30px;
            margin: 10px 0;
        }
        .cropped{
            width: 80px;
            height: 60px;
            border: 1px solid;
            float:left;
            margin-left: 15px;
        }
        .cropped>img
        {
            margin-right: 10px;
        }
    </style>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="{{asset('/public/jquery/cropbox.js')}}"></script>
</head>

<body>
    <!-- BEGIN HEADER -->
    <header class="header">
        <div class="headerSocial">
            <div class="container">
                <div class="row headrow">
                    <p class="topHeadline">Admin Manager</p>
                    <ul class="socialTop social">
                        <li><a href="{!!url('/')!!}" class="about"><i class="fa fa-home"></i> Home </a></li>
                        <li><a href="{!!url('/admin/media')!!}" class="about"><i class="fa fa-calendar"></i> media </a></li>
                        <li><a href="{!!url('admin/categories')!!}" class="about"><i class="fa fa-star"></i> Danh mục</a></li>
                        <li><a href="{!!url('/admin/settings')!!}" class="about"><i class="fa fa-question-circle"></i> Cài đặt</a></li>
                        <li><a href="{!!url('/admin/about')!!}" class="contact"><i class="fa fa-envelope"></i> Giới thiệu</a></li>
                        <li><a href="{!!url('/admin/members')!!}" class="contact"><i class="fa fa-envelope"></i> members</a></li>                        
                        <li><a href="{!!url('/admin/banner')!!}" class="contact"><i class="fa fa-envelope"></i> banner</a></li>                        

                        @if(Auth::guard('admin')->user())
                            <li>&nbsp;<a href="{!!url('/admin')!!}" class="admin"> Vào trang quản trị :<strong style="color:#c0392b;"> {!! Auth::guard('admin')->user()->name !!}</strong </a></li>
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
                        @else
                            <li>&nbsp;<a href="{!!url('login')!!}">&nbsp;<i class="glyphicon glyphicon-lock"></i> Login</a></li>                            
                        @endif                  
                        
                    </ul>
                </div>
            </div>
        </div>

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
                            <h1 class="animated slideInLeft">Nhập nội dung bạn cần tìm</h1>
                            {!! Form::open(array('action' =>array('PagesController@seacrh') , 'class'=>'form-horizontal formsettings','enctype'=>'multipart/form-data')) !!}
                                {!!Form::text('search', null,array('id'=>'search', 'class'=>'form-control', 'placeholder'=>'Nhập nội dung'))!!}
                                {!!Form::submit('Tìm kiếm', array('id'=>'submit', 'class'=>'btn btn-danger submit-media'))!!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END FOOTER -->
    <script>
        var rootpath = "{{ url('/') }}";
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
            $("a.remove").click(function() {               
                var id     = $(this).attr("image-id");                 
                var _token = $('input[name=_token2]').val();   
                var url = rootpath+"/admin/msg/del/" + id;
                $.ajax
                ({
                    type: "POST",
                    url: url,
                    data: {id: id, _token: _token },
                    success: function(msg)
                    {
                        
                    }
                });
        });

    </script>
    <script type="text/javascript">
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
                    url: '{{url('admin/media/uploadimg')}}',
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
    
    <!-- END JS BUTTON LIKE HOMEPAGE -->
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
    <!-- BEGIN JS TEMPLATE -->
    <script src="{{ url('public/application/assets/') }}/js/main.js"></script>
    <script src="{{ url('public/application/assets/') }}/js/slug.js"></script>
    <script src="{{ url('public/application/assets/') }}/js/myscript.js"></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script type="text/javascript" src="{{ url('public/application/assets/') }}/js/tinymce/tinymce.min.js"></script>
    
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