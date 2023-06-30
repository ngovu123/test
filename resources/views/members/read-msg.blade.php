@extends('layouts.content')
@section('title')
	messenger
@stop
@section('content')
<?php
	if (($data_msg->u_from == 0) || ($data_msg->u_to == 0) ) {
		$name = 'admin';
		$email = 'admin';
	} else {
		$us = DB::table('users')->where('id',$data_msg->u_from)->first();
			$name = $us->name;
			$email = $us->email;
	} 
?>
	<div class="container">
	@include('layouts.member-menu')
 			<div class="mail-box">
	          <aside class="sm-side">
	              <div class="user-head">
	                  <a class="inbox-avatar" href="javascript:;">
	                      <img  width="64" hieght="60" src="{!!url('public/application/assets/img/user/'.Auth()->user()->avata_img)!!}">
	                  </a>
	                  <div class="user-name">
	                      <h5><a href="#">{!!Auth()->user()->name!!}</a></h5>
	                      <span><a href="#">{!!Auth()->user()->email!!}</a></span>
	                  </div>
	              </div>
	              <ul class="inbox-nav inbox-divider">
	                  <li class="active">
	                      <a href="{!!url('member/msg')!!}"><i class="fa fa-inbox"></i> Inbox <span class="label label-danger pull-right">{!!$data->count()!!}</span></a>

	                  </li>
	              </ul>
	          </aside>
            <aside class="lg-side">
                <div class="inbox-head">
                    <h3>Messenger detail - Reply </h3>
                </div>
                <div class="inbox-body">
                  <table class="table table-inbox table-hover">                    
                    	<div class="form-group">
                    		<label for="">From : {!!$email!!}  </label>
                    	</div>
                    	<div class="form-group">
                    		<label for="">To : {!! Auth()->user()->email !!} </label>
                    	</div>
                    	<label> Messager </label>
	                    	<p style="padding-left: 10px;">{!!$data_msg->content!!}</p>	                    
	                   		@include('partials.memmsglog')
	                    <div class="clearfix"></div>

	                 <?php
	                 	$p_id = Session::get('p_id');
        				Session::forget('p_id');
        			?>

	                <form action="{!!url('/member/msg/'.$p_id)!!}" method="POST" role="form">  
                    	<input type="hidden" name="_token" value="{{ csrf_token() }}">    
                    	@if (Auth::user()->id == $data_msg->u_from )                 	
                    		<input type="hidden" name="toid" value="{{ $data_msg->u_to }}"> 
                    	@else
                    		<input type="hidden" name="toid" value="{{ $data_msg->u_from }}"> 
                    	@endif

	                    <label for="">Reply </label>
	                    <textarea name="reply" id="description" class="form-control" rows="5" required >	                    	
	                    </textarea>  
	                    <br>  
                    	<button type="submit" class="btn btn-primary">Reply</button>
                    </form>
                  </table>  
                </div>
            </aside>        
        </div>
</div>
@stop