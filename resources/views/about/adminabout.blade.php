@extends('layouts.admincontent')
@section('title')
	About page
@stop
@section('content')
	<div class="content contentAbout contentAdmin">
		<div class="container">
			<div class="row">
				<div class="cntabout">
					<div class="container">
					<ol class="breadcrumb">
					  <li><a href="{!!url('/admin')!!}">Admin</a></li>
					  <li class="active">About</li>
					</ol>
					</div>
					<h3 style="margin-top:0px; margin-bottom:0px;"><i class="glyphicon glyphicon-info-sign" aria-hidden="true"></i> <b>About Page</b></h3><br />
					<div class="container adminpage">
						<div class="col-sm-12 cntaddMedia" style="padding:0px;">
							@if ( Session::has('flash_message') )						 
								<div class="alert {{ Session::get('flash_type') }}">
							    	<h3>{{ Session::get('flash_message') }}</h3>
								</div>
							@endif
		                    {!! Form::open(array('action' => array('AdminHomeController@updateabout') , 'class'=>'form-horizontal formabout','enctype'=>'multipart/form-data')) !!}
								<div class="form-row descript">
									{!!Form::textarea('contentabout', $about->contentabout,array('id'=>'description', 'class'=>'form-control', 'placeholder'=>'Add Info for your About page here...'))!!}
								</div>
								<div class="form-row" style="text-align:right;">
									{!!Form::submit('Update About Page', array('id'=>'submit', 'class'=>'btn btn-success submit-media'))!!}
								</div>
							{!! Form::close() !!}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop