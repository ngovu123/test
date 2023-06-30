@extends('layouts.admincontent')
@section('title')
	Report list 
@stop
@section('content')
	<div class="content contentAdmin">
		<div class="container">
			<div>
				<div class="cntadmin">
					<ol class="breadcrumb">
					  <li><a href="{!!url('/admin')!!}">Admin</a></li>
					  <li class="active">Payment managers</li>
					</ol>
					<h3><i class="glyphicon glyphicon-download-alt" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;<b>Payment </b>&nbsp;<span>(<?= $pay_c; ?>)</span></h3>
					<div class="adminpage">
						@if ( Session::has('flash_message') )						 
							<div class="alertmedia col-sm-12 alert {{ Session::get('flash_type') }}">
						    	<p>{{ Session::get('flash_message') }}</p>
							</div>
						@endif

						<table class="table table-striped">
						    <thead>
						      <tr>
						        <th>Created At</th>	
						        <th>Member</th>	
						        <th>Payment ID</th>					        
						        <th>Cash Pay</th>
						        <th>Status</th>
						        <th style="width:250px;">Actions</th>
						      </tr>
						    </thead>
						    <tbody>
						    	@foreach($pay as $row)
						    		<?php 
						    			$us = DB::table('users')->where('id',$row->u_id)->first();
						    		?>
						    		@if($row->status != 0)
                                    	{!!  $stt = ' disabled '!!}
                                  	@else
                                    	{{ $stt = '  '}}
                                  	@endif
						    		<tr>
						    			<td>{!!$row->created_at!!}</td>
						    			<td style="vertical-align:middle">{!!$us->name.'-'.$us->email!!}</td>
						    			<td style="vertical-align:middle">{!!$us->pay_id!!}</td>
						    			<td style="vertical-align:middle">{!!$row->pay_cash!!}</td>
						    			<td style="vertical-align:middle">
						    				@if( $row->status ==0)
                                        		<span class="glyphicon glyphicon-refresh" style="color: #f1c40f;""> Pendding</span>
		                                    @elseif($row->status ==1)
		                                        <li style="color: #27ae60;" class="glyphicon glyphicon-ok"> Success</li>
		                                    @else
		                                      <li style="color: #e74c3c;" class="glyphicon glyphicon-remove"> Canceled</li>
		                                    @endif
						    			</td>
						    			<td style="vertical-align:middle">                                      
	                                      <a class="btn btn-danger" style="margin-left:10px;" onclick = " return confirmDelete('Are you sure?')" href="{!!url('/admin/pay/cancel/')!!}/<?= $row->id; ?>" {!!$stt!!}><i class="fa fa-trash-o"></i> cancel</a>
	                                       <a class="btn btn-success" style="margin-left:10px;" onclick = " return confirmDelete('Are you sure?')" href="{!!url('/admin/pay/done/')!!}/<?= $row->id; ?>" {!!$stt!!}><i class="glyphicon glyphicon-ok"></i> Done</a>
	                                    </td>
						    		</tr>
						    	@endforeach
						    </tbody>
						</table>
						<div class="paginate"><?php echo $pay->render(); ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop