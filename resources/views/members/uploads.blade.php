@extends('layouts.content')
@section('title')
    Upload new media
@stop
@section('content')
<div class="container">
@include('layouts.member-menu')
    <div class="row">
        <div class="cntadmin">
            <ol class="breadcrumb" style="margin-left: 15px;margin-right: 15px;">
              <li><a href="{!!url('member')!!}">member</a></li>              
              <li class="active">Upload </li>
            </ol>   
                <h3 style="margin-left: 15px;margin-right: 15px;"><i class="glyphicon glyphicon-download-alt" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;<b>New Download</b></h3>
            <div class="container adminpage">
                <div class="cntaddMedia">
                {!! Form::open(array('action' =>array('HomeController@postuploads') , 'class'=>'form-horizontal formadddownload','enctype'=>'multipart/form-data')) !!}                            
                    <div class="form-row">
                        {!!Form::label('title' , 'title' , array('class'=>'control-label'))!!}
                        {!!Form::text('title', null,array('id'=>'title', 'class'=>'form-control', 'placeholder'=>'Title'))!!}
                        {!! $errors->first('title', '<span class="help-inline" style="color:red;">:message</span>') !!}
                    </div>                      
                    <div class="form-row" style="margin: 15px 0 0;">
                    {!!Form::label('Category' , 'category' , array('class'=>'control-label'))!!}
                    <select name="category" id="input" class="form-control" required="required">
                        <?php MenuMulti($categories,$parent_id=0,'-',old('category')) ?>
                    </select>                        
                        {!! $errors->first('category', '<span class="help-inline" style="color:red;">:message</span>') !!}
                    </div>
                    <div class="form-row" style="margin: 15px 0 0;">
                    <div class="form-row">
                        {!!Form::label('price' , 'price' , array('class'=>'control-label'))!!}
                        <input type="text" name="price" id="price" class="form-control" value="1" readonly="">
                        {!! $errors->first('price', '<span class="help-inline" style="color:red;">:message</span>') !!}
                    </div>

                    <div class="form-row">                              
                            <div class="upimage">
                                    <label for="upimage">Image Media thumb</label>
                                    <input type="text" name="upimage" id="upimage_name" value="{{ old('upimage')}}"  readonly required class="form-control" style="width: 500px; float: left;"> <a class="btn btn-primary" id="select_img" data-toggle="modal" href='#modal-cropimg' style="float: left;">Select</a> <div class="cropped"></div> 
                                    {!! $errors->first('upimage', '<span class="help-inline" style="color:red;">:message</span>') !!}                                   
                                </div>                              
                            </div>
                    <div class="form-row">
                        {!!Form::label('imgdownload' , 'Image on slider (Size 800x600 cropped if larger )' , array('class'=>'control-label'))!!}                           
                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                Image 1 : <input type="file" name="txtdetail_img[]" value="{{ old('txtdetail_img[]') }}" accept="image/png" id="inputtxtdetail_img" class="form-control">
                            </div>    
                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                Image 2 : <input type="file" name="txtdetail_img[]" value="{{ old('txtdetail_img[]') }}" accept="image/png" id="inputtxtdetail_img" class="form-control">
                            </div>                    
                    </div>
                    <div class="col-sm-12 divider"></div>
                    <div class="form-row">
                        {!!Form::label('filedownload' , 'Upload File' , array('class'=>'control-label'))!!}
                        <div class="upfile">
                            {!!Form::file('upfile', null,array('id'=>'fileupload', 'class'=>'form-control'))!!}
                        </div>

                    </div>
                    <div class="form-row">
                        {!!Form::label('style' , 'File style' , array('class'=>'control-label'))!!}                         
                        <select name="style" id="input" class="form-control" required="required">
                            <option value="Classic">Classic</option>
                            <option value="Modern">Modern</option>
                            <option value="Ethnic">Ethnic</option>
                        </select>                        
                    </div>
                    <div class="form-row">
                        {!!Form::label('Platform' , 'Platform' , array('class'=>'control-label'))!!}
                        <select name="platform" id="input" class="form-control" required="required">
                            <option value="platform1">platform 1</option>
                            <option value="platform2">platform 2</option>
                            <option value="platform3">platform 3</option>
                        </select>
                    </div>
                    <div class="form-row">
                        {!!Form::label('render' , 'Render' , array('class'=>'control-label'))!!}
                        <select name="render" id="input" class="form-control" required="required">
                            <option value="Render1">Render 1</option>
                            <option value="Render2">Render 2</option>
                            <option value="Render3">Render 3</option>
                        </select>
                    </div>
                    <br>
                    <div class="form-row descript">
                        {!!Form::textarea('description', null,array('id'=>'description', 'class'=>'form-control', 'placeholder'=>'Description'))!!}
                        {!! $errors->first('description', '<span class="help-inline" style="color:red;">:message</span>') !!}
                    </div>
                    <div class="form-row">
                        {!!Form::text('tags', null,array('id'=>'tag', 'class'=>'form-control', 'placeholder'=>'Tags (comma separated)'))!!}
                    </div>
                    <div class="form-row">
                        {!!Form::submit('Add Download', array('id'=>'submit', 'class'=>'btn btn-success submit-media'))!!}
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
@endsection