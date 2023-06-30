@extends('layouts.admincontent')
@section('title')
	Media page
@stop
@section('content')
	<div class="content contentAdmin">
		<div class="container">
			<div>
				<div class="cntadmin">
					<ol class="breadcrumb">
					  <li><a href="{!!url('/admin')!!}">Admin</a></li>
					  <li class="active">Media</li>
					</ol>
					<h3><i class="glyphicon glyphicon-download-alt" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;<b>Media/Downloads</b>&nbsp;<span>(<?= $countmedia; ?>)</span></h3>
					<div class="adminpage">
						<a href="{!!url('/admin/media/add')!!}" class="btn btn-success new-media"><i class="fa fa-plus-circle"></i> Add New Media/Download</a>
						@if ( Session::has('flash_message') )						 
							<div class="alertmedia col-sm-12 alert {{ Session::get('flash_type') }}">
						    	<p>{{ Session::get('flash_message') }}</p>
							</div>
						@endif

						<table class="table table-striped">
						    <thead>
						      <tr>
						        <th>Title</th>	
						        <th>Uploaded</th>					        
						        <th>Price</th>
						        <th>Created At</th>
						        <th style="width:200px;">Actions</th>
						      </tr>
						    </thead>
						    <tbody>
						    	<?php foreach($media as $item): ?>
						    		<?php 
						    			$us = DB::table('users')->where('id','=',$item->user_id)->first();

						    		?>
									<tr>
										<td>
											<a href="{!! url('downloadpage/'.$item->id.'/'.$item->slug) !!}" target="_blank" class="head_item item_ajax">
												<img style="max-height:50px;" src="{{ url('public/content/files/downloads/images/') }}/thumb/<?= $item->name ?>">
											</a>
											<a href="{!! url('downloadpage/'.$item->id.'/'.$item->slug) !!}" target="_blank" class="head_item item_ajax" style="margin-left:15px;">
											    <?= ucfirst($item->title); ?>
											</a>
										</td>	
										<?php 
											if (is_null($us)) {
												echo '<td style="vertical-align:middle"> Admin </td>';
											} else {
												echo '<td style="vertical-align:middle">'.$us->name.'</td>';
											}
										?>
										<td style="vertical-align:middle">{!!$item->price!!} $</td>
										<td style="vertical-align:middle"><?= date("m/j/y", strtotime($item->created_at)); ?></td>
										<td style="vertical-align:middle">
											<a href="<?= url('/admin/media/edit/').'/'.$item->slug ?>" id="<?= $item->id; ?>" class="btn btn-warning"><i class="fa fa-edit"></i> Edit</a>
											<a class="btn btn-danger" style="margin-left:10px;" onclick = " return confirmDelete('Are you sure?')" href="{!!url('/admin/delete/')!!}/<?= $item->id; ?>"><i class="fa fa-trash-o"></i> Delete</a>
											<!-- <a class="btn btn-danger" href="/admin/delete/<?= $item->id ?>">Delete</a> -->
										</td>
									</div>
								<?php endforeach; ?>
						    </tbody>
						</table>
						<div class="paginate"><?php echo $media->render(); ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop