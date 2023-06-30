@extends('layouts.admincontent')
@section('title')
	messenger
@stop
@section('content')
	<div class="container">
 			<div class="mail-box">
	          <aside class="sm-side">
	              <div class="user-head">
	                  <a class="inbox-avatar" href="javascript:;">
	                      <img  width="64" hieght="60" src="{!!url('public/application/assets/img/user/'.Auth()->guard('admin')->user()->avata_img)!!}">
	                  </a>
	                  <div class="user-name">
	                      <h5><a href="#">{!!Auth()->guard('admin')->user()->name!!}</a></h5>
	                      <span><a href="#">{!!Auth()->guard('admin')->user()->email!!}</a></span>
	                  </div>
	              </div>
	              <ul class="inbox-nav inbox-divider">
	                  <li class="active">
	                      <a href="{!!url('admin/msg')!!}"><i class="fa fa-inbox"></i> Inbox <span class="label label-danger pull-right">{!!$data->count()!!}</span></a>

	                  </li>
	              </ul>
	          </aside>
            <aside class="lg-side">
                <div class="inbox-head">
                    <h3>messenger </h3>
                </div>
                <div class="inbox-body">
                  <table class="table table-inbox table-hover">                    
                    	<div class="form-group">
                    		<label for="">From :  {!!$data_msg->email!!}</label>
                    	</div>
                    	<div class="form-group">
                    		<label for="">To : {!! Auth()->guard('admin')->user()->email !!}</label>
                    	</div>
                    	<label> Messager </label>
	                    	<p style="padding-left: 10px;">{!!$data_msg->content!!}</p>	                    
	                   		@include('partials.logmsg')
	                    <div class="clearfix"></div>
	                <form action="{!!url('/admin/msg/'.$data_msg->id)!!}" method="POST" role="form">  
                    	<input type="hidden" name="_token" value="{{ csrf_token() }}">                     	
                    	<input type="hidden" name="toid" value="{{ $data_msg->u_from }}"> 

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