@extends('layouts.admincontent')
@section('title')
	Categories page
@stop
@section('content')
	<div class="content contentAdmin">
		<div class="container">
			<div class="row">
				<div class="cntadmin">
					<div class="container">
						<ol class="breadcrumb">
						  <li><a href="{!!url('/admin')!!}">Admin</a></li>
						  <li class="active">Categories</li>
						</ol>
					</div>
					<h3><i class="glyphicon glyphicon-folder-open" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;<b>Categories</b></h3>
					<div class="container adminpage admincategories">
						<div class="cntaddCate">
							@if ( Session::has('flash_message') )						 
								<div class="alert {{ Session::get('flash_type') }}">
							    	<h3>{{ Session::get('flash_message') }}</h3>
								</div>
							@endif
							{!! Form::open(array('action' =>array('AdminHomeController@addcategory') , 'class'=>'form-horizontal formsettings','enctype'=>'multipart/form-data')) !!}
							<div class="admincate">
								{!!Form::label('category' , 'Category' , array('class'=>'control-label'))!!}
								<div class="form-row">
									{!!Form::text('name', null,array('id'=>'name', 'class'=>'form-control', 'placeholder'=>'Name'))!!}
									{!! $errors->first('name', '<span class="help-inline" style="color:red;">:message</span>') !!}
								</div>
								<div class="form-row">
									{!!Form::text('url_slug', null,array('id'=>'slug', 'class'=>'form-control', 'placeholder'=>'url slug (yoursite.com/url)'))!!}
									{!! $errors->first('url_slug', '<span class="help-inline" style="color:red;">:message</span>') !!}
								</div>
								<div class="form-row">
									{!!Form::text('order', null,array('id'=>'order', 'class'=>'form-control', 'placeholder'=>'Oder #'))!!}
									{!! $errors->first('order', '<span class="help-inline" style="color:red;">:message</span>') !!}
								</div>
								<div class="form-row">
									<select name="parentID" id="parentID" class="form-control">
										<option id="0" value="0" selected>None</option>
										<?php foreach($parentCate as $item): ?>
											<option id= "<?= $item->id ?>" value="<?= $item->id ?>">
										    <?= ucfirst($item->name) ?>
										    <?php if($item->parentID == 0) echo "(none)"; ?>
											</option>
										<?php endforeach; ?>
									</select>
									<p style="float:right; display:inline; line-height:35px; margin-bottom:0px; margin-right:10px;">Parent Category</p>
								</div>
							</div>
								<div class="form-row">
									{!!Form::submit('Add Category', array('id'=>'submit', 'class'=>'btn btn-success submit-media'))!!}
								</div>
							{!! Form::close() !!}
							<div class="admincate">
								{!!Form::label('currentCate' , 'Current Categories' , array('class'=>'control-label'))!!}
								<div class="form-row-cate">
								<?php foreach($parentCate as $item): ?>
									<div class="form-row" >
										<?php echo ucfirst($item->name);
										foreach ($parentCate as $value) {
											if ($item->parentID != 0 && $value->id == $item->parentID) {
												echo "&nbsp;(parent :" .ucfirst($value->name) .')';
											}
										}
										?>
										<a onclick = " return confirmDelete('Are you sure?')" href="{!!url('/')!!}/admin/category/delete/<?= $item->id ?>">
											<i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
											Delete</a>
										<a href="{!!url('/admin/category/edit/').'/'!!}<?= $item->url_slug ?>">
											<i class="glyphicon glyphicon-pencil" aria-hidden="true"></i>
											Edit
										</a>
									</div>
								<?php endforeach; ?>
								</div>
							</div>								
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop