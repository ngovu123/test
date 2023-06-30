@extends('layouts.admincontent')
@section('title')
	Thêm mới Media
@stop
@section('content')
	<div class="content contentAdmin">
		<div class="container">
		    <div class="row">
		        <div class="cntadmin">
		            <ol class="breadcrumb" style="margin-left: 15px;margin-right: 15px;">
		              <li><a href="{!!url('admin')!!}">Admin</a></li>   
		              <li><a href="{!!url('admin/media')!!}">Media</a></li>           
		              <li class="active">Upload </li>
		            </ol>   
		                <h3 style="margin-left: 15px;margin-right: 15px;"><i class="glyphicon glyphicon-download-alt" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;<b>Thêm mới Media</b></h3>
		            <div class="container adminpage">
		                <div class="cntaddMedia">
		                {!! Form::open(array('action' =>array('AdminHomeController@addnewmedia') , 'class'=>'form-horizontal formadddownload','enctype'=>'multipart/form-data')) !!}                            
		                    <div class="form-row">
		                        {!!Form::label('title' , 'Tiêu đề' , array('class'=>'control-label'))!!}
		                        {!!Form::text('title', null,array('id'=>'title', 'class'=>'form-control', 'placeholder'=>'Nhập tiêu đề cho Media'))!!}
		                        {!! $errors->first('title', '<span class="help-inline" style="color:red;">:message</span>') !!}
		                    </div>                      
		                    <div class="form-row" style="margin: 15px 0 0;">
		                    {!!Form::label('Category' , 'Danh mục' , array('class'=>'control-label'))!!}
		                    <select name="category" id="input" class="form-control" required="required">
		                        <?php MenuMulti($categories,$parent_id=0,'-',old('category')) ?>
		                    </select>                        
		                        {!! $errors->first('category', '<span class="help-inline" style="color:red;">:message</span>') !!}
		                    </div>
		                    <div class="form-row" style="margin: 15px 0 0;">
		                    <div class="form-row">
		                        {!!Form::label('price' , 'Giá bán (Mặc định $1)' , array('class'=>'control-label'))!!}
		                        <input type="text" name="price" id="price" class="form-control" value="1" readonly="">
		                        {!! $errors->first('price', '<span class="help-inline" style="color:red;">:message</span>') !!}
		                    </div>

		                    <div class="form-row">		                        
		                        <div class="upimage">
		                        	<label for="upimage">Hình ảnh</label>
		                        	<input type="text" name="upimage" id="upimage_name" value="{{ old('upimage')}}"  readonly required class="form-control" style="width: 500px; float: left;"> <a class="btn btn-primary" id="select_img" data-toggle="modal" href='#modal-cropimg' style="float: left;">Chọn ảnh</a> <div class="cropped"></div> 
		                            {!! $errors->first('upimage', '<span class="help-inline" style="color:red;">:message</span>') !!}		                            
		                        </div>		                        
		                    </div>
		                    <div class="form-row">
		                        {!!Form::label('imgdownload' , 'Hình ảnh cho slider (kích thước yêu cầu 800x600 nếu lớn hơn nó sẽ tự cắt nhỏ)' , array('class'=>'control-label'))!!}
		                            @for( $i=1; $i<=4; $i++)
		                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" style="text-align: left;">
		                                Ảnh {!!$i!!} : <input  type="file" name="txtdetail_img[]" value="{{ old('txtdetail_img[]') }}" accept="image/png" id="inputtxtdetail_img" class="form-control">
		                            </div>
		                            @endfor                            
		                    </div>
		                    <div class="col-sm-12 divider"></div>
		                    <div class="form-row">
		                        {!!Form::label('filedownload' , 'File tải lên' , array('class'=>'control-label'))!!}
		                        <div class="upfile">
		                            {!!Form::file('upfile', null,array('id'=>'fileupload', 'class'=>'form-control'))!!}
		                            <span>or</span>
		                        </div>
		                        {!!Form::text('urldownload', null,array('id'=>'urldownload', 'class'=>'form-control', 'placeholder'=>'Hoặc có thể dán đường Link tải vài đây'))!!}
		                    </div>
		                    <div class="form-row">
		                        {!!Form::label('style' , 'Kiểu của File' , array('class'=>'control-label'))!!}                         
		                        <select name="style" id="input" class="form-control" required="required">
		                            <option value="Classic">Classic</option>
		                            <option value="Modern">Modern</option>
		                            <option value="Ethnic">Ethnic</option>
		                        </select>                        
		                    </div>
		                    <div class="form-row">
		                        {!!Form::label('Platform' , 'Platform của file' , array('class'=>'control-label'))!!}
		                        <select name="platform" id="input" class="form-control" required="required">
		                            <option value="platform1">platform 1</option>
		                            <option value="platform2">platform 2</option>
		                            <option value="platform3">platform 3</option>
		                        </select>
		                    </div>
		                    <div class="form-row">
		                        {!!Form::label('render' , 'Render của file' , array('class'=>'control-label'))!!}
		                        <select name="render" id="input" class="form-control" required="required">
		                            <option value="Render1">Render  1</option>
		                            <option value="Render2">Render 2</option>
		                            <option value="Render3">Render 3</option>
		                        </select>
		                    </div>
		                    <div class="form-row descript">
		                        {!!Form::textarea('description', null,array('id'=>'description', 'class'=>'form-control', 'placeholder'=>'Description'))!!}
		                        {!! $errors->first('description', '<span class="help-inline" style="color:red;">:message</span>') !!}
		                    </div>
		                    <div class="form-row">
		                        {!!Form::text('tags', null,array('id'=>'tag', 'class'=>'form-control', 'placeholder'=>'Tags (Cách nhau bằng dấu phẩy (,). )'))!!}
		                    </div>
		                    <div class="form-row">
		                        {!!Form::submit('Tải lên', array('id'=>'submit', 'class'=>'btn btn-success submit-media'))!!}
		                    </div>
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