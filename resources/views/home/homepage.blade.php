@extends('layouts.content')
@section('title')
	Home page
@stop
@section('content')
	<div class="container">
		<div class="row">
			<div class="text-center">
				<h1>{!!$settings->headline !!}</h1>
				<h3>{!!$settings->subheadline !!}</h3>
			</div>				
			<div class="col-md-12">      
	            <div class="clearfix" style="max-width:100%;">
	                <ul id="home-slide" class="gallery list-unstyled cS-hidden" >
	                    <img src="{!!url('public/images/slides/qc1.png')!!} " style="display: block; max-width:100%;  margin: 0 auto; padding:0; height: 250px;" >
	                    <img src="{!!url('public/images/slides/qc2.png')!!} " style="display: block; max-width:100%;  margin: 0 auto; padding:0; height: 250px;" >
	                </ul>
	            </div>
			</div>				
			<div class="col-sm-12">
				@include('partials.topsell-7day')
				@include('partials.items')
			</div>
		</div>
	</div>	
@endsection


	
