@extends('layouts.admincontent')
@section('title')
	Members page
@stop
@section('content')
	<div class="content contentAdmin">
		<div class="container">
			<div class="row">
				<div class="cntadmin">
					<div class="container">
						<ol class="breadcrumb">
						  <li><a href="{!!url('/admin')!!}">Admin</a></li>
						  <li class="active">Members</li>
						</ol>
					</div>
					<h3><i class="glyphicon glyphicon-folder-open" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;<b>Members</b></h3>
					<div class="container adminpage admincategories">
						<div class="cntaddCate">
							@if ( Session::has('flash_message') )						 
								<div class="alert {{ Session::get('flash_type') }}">
							    	<h3>{{ Session::get('flash_message') }}</h3>
								</div>
							@endif
							
							<div class="admincate">								
								<div class="table-responsive table-striped">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th>id</th>
												<th>Name</th>
												<th>Address</th>
												<th>phone</th>
												<th>Created at</th>
												<th>cash</th>
												<th>status</th>
												<th style="width: 150px; text-align: center;">Action</th>
											</tr>
										</thead>
										<tbody>
										@foreach($mem as $item)
											<tr>
												<td>{!!$item->id!!}</td>
												<td>{!!$item->name!!}</td>
												<td>{!!$item->address!!}</td>
												<td>{!!$item->phone!!}</td>
												<td>{!!$item->created_at!!}</td>
												<td>{!!$item->cash!!}</td>
												<td>
													@if ($item->status == 1)
														<span style="color: #3498db;">Active</span>
													@else
														<span style="color: #c0392b;">deactivated</span>	
													@endif
												</td>
												<td>
													@if ($item->status == 1)
														<a class="btn btn-danger" href="#" title="Disable"><i class="glyphicon glyphicon-remove"></i></a> 
													@else
														<a class="btn btn-success" href="#" title="Enable"><i class="glyphicon glyphicon-ok"></i></a>
													@endif													
													<a class="btn btn-success" href="#" title="Send Messenger"><i class="glyphicon glyphicon-comment"></i></a> 
												</td>
											</tr>
											@endforeach
										</tbody>
									</table>						
								</div>
							</div>								
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop