@extends('layouts.admincontent')
@section('title')
	Settings page
@stop
@section('content')
	<div class="content contentAdmin">
		<div class="container">
			<div class="row">
				<div class="cntadmin">
				<div class="container">
					<ol class="breadcrumb">
					  <li><a href="{!!url('/admin')!!}">Admin</a></li>
					  <li class="active">Settings</li>
					</ol>
				</div>
					<h3 style="float:none;"><i class="glyphicon glyphicon-cog" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;<b>Settings</b></h3>
					<div class="container adminpage adminsetting">
						<div class="cntaddMedia">
						@if ( Session::has('flash_message') )						 
							<div class="alert {{ Session::get('flash_type') }}">
						    	<h3>{{ Session::get('flash_message') }}</h3>
							</div>
						@endif

						{!! Form::open(array('action' =>array('AdminHomeController@postsettings') , 'class'=>'form-horizontal formsettings','enctype'=>'multipart/form-data')) !!}
                            <div class="form-row">
                                <label for="sitename">Site Name</label>
								{!!Form::text('sitename', @$sitename, array('id'=>'sitename', 'class'=>'form-control', 'placeholder'=>'Site Name'))!!}
							</div>
                            <div class="form-row">
                                <label for="headlinge">Headline</label>
								{!!Form::text('headline', @$headline,array('id'=>'headline', 'class'=>'form-control', 'placeholder'=>'Homepage Headline'))!!}
							</div>
                            <div class="form-row">
                                <label for="subheadline">Sub-headline</label>
								{!!Form::text('subheadline', @$subheadline,array('id'=>'headline', 'class'=>'form-control', 'placeholder'=>'Homepage sub-headline'))!!}
							</div>
                            <div class="form-row">
								{!!Form::label('sitelogo' , 'Site Logo' , array('class'=>'control-label'))!!}
								<div class="upimage">
									<?php if (isset($logo) && trim($logo) != ""): ?>
										<img src="{{ config('view.settingspath') }}/<?= @$logo ?>" style="max-width:200px; float:left;" />
									<?php else: ?>
										<img src="{!!url('public/application/assets/img/logo.png')!!}" style="max-width:200px; float:left;" />
									<?php endif; ?>
									<div style="clear:both"></div><br />
									<!-- <span class="btn btn-primary">Upload</span> -->
									{!!Form::file('logo', null,array('id'=>'logoupload', 'class'=>'form-control'))!!}
									<!-- <p>Upload a File</p> -->
								</div>
							</div>
							<div class="col-sm-12 divider"></div>
                            <div class="form-row">
								{!!Form::label('sitefavicon' , 'Site Favicon' , array('class'=>'control-label'))!!}
								<div class="upimage">
									<img src="{{ config('view.settingspath') }}/<?= @$favicon ?>" style="max-width:50px; float:left;" />
									<div style="clear:both"></div><br />
									<!-- <span class="btn btn-primary">Upload</span> -->
									{!!Form::file('favicon', null,array('id'=>'faviconupload', 'class'=>'form-control'))!!}
									<!-- <p>Upload a File</p> -->
								</div>
							</div>
							<div class="col-sm-12 divider divider2"></div>
							<div class="divider2"></div>
                            <div class="form-row">
                                <label for="theme">Color Theme</label>
                                <select id="theme" name="theme" style="float:left;">
                                    <option value="light" @if(isset($theme) && $theme == 'light') selected @endif>Light</option>
                                    <option value="dark" @if(isset($theme) && $theme == 'dark') selected @endif>Dark</option>
                                </select>
                                <label for="googleplus">Google Plus Page ID</label>
								{!!Form::text('googleplus', @$googleplus,array('id'=>'googleplus', 'class'=>'form-control', 'placeholder'=>'Google Plus Page'))!!}
							</div>
                            <div class="form-row">
                                <label for="facebook">Facebook Page ID</label>
								{!!Form::text('facebook', @$facebook,array('id'=>'facebook', 'class'=>'form-control', 'placeholder'=>'Facebook Page'))!!}
							</div>
                            <div class="form-row">
                                <label for="twitter">Twitter Username</label>
								{!!Form::text('twitter', @$twitter,array('id'=>'twitter', 'class'=>'form-control', 'placeholder'=>'Twitter Page'))!!}
							</div>
							<div class="divider3"></div>
                            <div class="form-row">
                                <label for="disqus">Disqus Shortname</label>
								{!!Form::text('disqus', @$disqus,array('id'=>'disqus', 'class'=>'form-control', 'placeholder'=>'Disqus Comments Short Name'))!!}
							</div>
                            <div class="form-row">
                                <label for="gganalytic">Google Analytics Code (Example: UA-12345678-9)</label>
								{!!Form::text('gganalytic', @$gganalytic,array('id'=>'gganalytic', 'class'=>'form-control', 'placeholder'=>'Google Analytics Code (Example UA-12345678-9'))!!}
							</div>						
							
							<div class="adsadmin">
								{!!Form::label('advertisements' , @$adsadmin , array('class'=>'control-label'))!!}
                                <div class="form-row">
                                    <label for="ads728x90">728x90 Advertisement</label>
									{!!Form::textarea('ads728x90', @$ads728x90,array('class'=>'form-control', 'rows'=>'3', 'placeholder'=>'728x90 Headline Banner Advertisement Code'))!!}
								</div>
                                <div class="form-row">
                                    <label for="ads300x250">300x250 Advertisement</label>
									{!!Form::textarea('ads300x250', @$ads300x250,array('class'=>'form-control', 'rows'=>'3', 'placeholder'=>'300x250 Square Advertisement Code'))!!}
								</div>
							</div>
							<div class="form-row">
								{!!Form::submit('Lưu cài đặt', array('id'=>'submit', 'class'=>'btn btn-success submit-media'))!!}
							</div>
						{!! Form::close() !!}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop
