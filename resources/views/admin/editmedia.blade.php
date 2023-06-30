@extends('layouts.admincontent')
@section('title')
	Edit Download page
@stop
@section('content')
	<div class="content contentAdmin">
		<div class="container">
		    <div class="row">
		        <div class="cntadmin">
		            <ol class="breadcrumb">
		              <li><a href="{!!url('admin')!!}">Admin</a></li>
		              <li><a href="{!!url('admin/media')!!}">Media</a></li>
		              <li class="active">Chỉnh sửa media</li>
		            </ol>   
		            <h3><i class="glyphicon glyphicon-download-alt" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;<b> Chỉnh sửa media </b></h3>
		            <div class="adminpage">
		                <div class="container cntaddMedia">
		                {!! Form::open(array('action' => array('AdminHomeController@editmedia',$media->slug), 'class'=>'form-horizontal formadddownload','enctype'=>'multipart/form-data')) !!}
		                    <div class="form-row">
		                    	 {!!Form::label('title' , 'Tiêu đề' , array('class'=>'control-label'))!!}
		                        {!!Form::text('title', $media->title, array('id'=>'contact_name', 'class'=>'form-control', 'placeholder'=>'Title'))!!}
		                        {!! $errors->first('title', '<span class="help-inline" style="color:red;">:message</span>') !!}
		                    </div>                      
		                    <div class="form-row" style="margin: 15px 0 0;">
		                    	 {!!Form::label('cate' , 'Danh mục' , array('class'=>'control-label'))!!}
		                        <select name="category" id="inputCategory" class="form-control" required="required">
		                            <?php MenuMulti($categories,$parent_id=0,'|-',old('category')) ?>
		                        </select>
		                    </div>

		                    {{-- <div class="form-row" style="margin: 15px 0 0;"> --}}
		                    <div class="form-row">
		                    	 {!!Form::label('price' , 'Giá bán' , array('class'=>'control-label'))!!}
		                        {!!Form::text('price', $media->price,array('id'=>'price', 'class'=>'form-control', 'placeholder'=>'Price ($)'))!!}
		                        {!! $errors->first('price', '<span class="help-inline" style="color:red;">:message</span>') !!}
		                    </div>

		                    <div class="form-row">
		                        {!!Form::label('imgdownload' , 'Hình ảnh hiện tạ' , array('class'=>'control-label'))!!}
		                        <div class="upimage">
		                            <div class="imgedit"><img src="{!! url('public/content/files/downloads/images/thumb/') !!}/<?= $media->name ?>"></div>
		                            {!!Form::file('upimage', null, array('id'=>'imageupload', 'class'=>'form-control'))!!}
		                            {!! $errors->first('upimage', '<span class="help-inline" style="color:red;">:message</span>') !!}
		                        </div>
		                    </div>
		                    <div class="form-row">		                        
		                        <div class="upimage">
		                        	<label for="upimage">Chọn ảnh mới nếu bạn cập nhật</label>
		                        	<input type="text" name="upimage" id="upimage_name" value="{{ old('upimage')}}"  readonly class="form-control" style="width: 500px; float: left;"> <a class="btn btn-primary" id="select_img" data-toggle="modal" href='#modal-cropimg' style="float: left;">Chọn ảnh</a> <div class="cropped"></div> 
		                            {!! $errors->first('upimage', '<span class="help-inline" style="color:red;">:message</span>') !!}		                            
		                        </div>		                        
		                    </div>
		                    <div class="form-row">
		                        <label for="input-id">Hình ảnh chi tiết (slide)</label>
		                        <?php $stt=0; ?>
		                        <div class="row">
		                            @foreach($media->images_preview as $row)    
		                                <?php $stt++; ?>
		                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">                       
		                                    <img src="{!!url('public/content/files/downloads/images/'.$row->image_name)!!}" alt="{!!$row->image_name!!}" width="150" height="90">
		                                </div>
		                            @endforeach
		                        </div>
		                        <div class="row">
		                            @for( $i=1; $i<=4; $i++)
		                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
		                            news images <input type="file" name="txtdetail_img[]" value="{{ old('txtdetail_img[]') }}" accept="image" id="inputtxtdetail_img" class="form-control">
		                            </div>
		                            @endfor
		                        </div>                              
		                    </div>
		                    <div class="col-sm-12 divider"></div>
		                    <div class="form-row">
		                        {!!Form::label('filedownload' , 'File tải về' , array('class'=>'control-label'))!!}
		                        <div class="upfile">
		                            @if ($media->typeFile == 'file')
		                                <a href="{{ URL::to('imgdownload') . '/' . $media->id }}" style="float:left; margin-bottom:10px;">{{ $media->file }}</a><div style="clear:both"></div>
		                            @endif
		                            {!!Form::file('upfile', null, array('id'=>'fileupload', 'class'=>'form-control'))!!}
		                            <span>Hoặc</span>
		                        </div>
		                        @if ($media->typeFile == 'url')
		                        {!!Form::text('urldownload',$media->file, array('id'=>'urldownload', 'class'=>'form-control', 'placeholder'=>'Paste Download URL'))!!}
		                        @elseif ($media->typeFile == 'file')
		                        {!!Form::text('urldownload', null, array('id'=>'urldownload', 'class'=>'form-control', 'placeholder'=>'Paste Download URL'))!!}
		                        @endif
		                    </div>
		                    <div class="form-row">
		                        {!!Form::label('style','File style' , array('class'=>'control-label'))!!}
		                        {!!Form::text('style', $media->style,array('id'=>'style', 'class'=>'form-control', 'placeholder'=>'File media style'))!!}
		                    </div>
		                    <div class="form-row">
		                        {!!Form::label('Platform', 'Platform' , array('class'=>'control-label'))!!}
		                        {!!Form::text('platform', $media->platform,array('id'=>'Platform', 'class'=>'form-control', 'placeholder'=>'Platform media'))!!}
		                    </div>
		                    <div class="form-row">
		                        {!!Form::label('render' , 'Render' , array('class'=>'control-label'))!!}
		                        {!!Form::text('render', $media->render,array('id'=>'render', 'class'=>'form-control', 'placeholder'=>'Render media'))!!}
		                    </div>
		                    <div class="form-row descript">                                 
		                        {!!Form::textarea('description', $media->description, array('id'=>'description', 'class'=>'form-control', 'placeholder'=>'Description'))!!}
		                        {!! $errors->first('description', '<span class="help-inline" style="color:red;">:message</span>') !!}
		                    </div>
		                    <div class="form-row">
		                        {!!Form::text('tags', $media->tags, array('id'=>'tag', 'class'=>'form-control', 'placeholder'=>'Tags (comma separated)'))!!}
		                    </div>
		                    <div class="form-row">
		                        {!!Form::submit('Lưu lại', array('id'=>'submit', 'class'=>'btn btn-success submit-media'))!!}
		                    </div>
		                {!! Form::close() !!}
		                </div>
		                <!-- modal form -->
		                <div class="modal fade" id="modal-cropimg">
							<div class="modal-dialog" style="border: 1px solid #2980b9; width: 710px">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close btn-danger" data-dismiss="modal" aria-hidden="true"><strong style="color: red;"> X </strong></button>					
									</div>
									<div class="modal-body">
						            	<div class="row">                     		
					                        <div class="col-md-6">				                                
				                                <div class="container img_cr">
				                                    <div class="imageBox">
				                                        <div class="thumbBox"></div>
				                                        <div class="spinner" style="display: none">Loading...</div>
				                                    </div>
				                                    <div class="action">
				                                        <input type="file" id="file" style="float:left; width: 250px; font-size: 13px;" required> <br>
				                                        <input class="btn btn-sm btn-success" type="button" id="btnCrop" data-dismiss="modal" value="Cắt Và Lưu">
				                                        <input class="btn btn-sm " type="button" id="btnZoomIn" value=" + Phóng to">
				                                        <input class="btn btn-sm " type="button" id="btnZoomOut" value="- Thu nhỏ">
				                                    </div>                                    
				                                </div>
				                            </div>	                     					               
						              </div>
						          	</div>
								</div>
							</div>
						</div>
						<!-- /modal form -->
		            </div>
		        </div>
		    </div>
		</div>
	</div>
@stop