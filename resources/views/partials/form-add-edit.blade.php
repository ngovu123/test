		<div class="form-row">
			{!!Form::text('title', null,array('id'=>'contact_name', 'class'=>'form-control', 'placeholder'=>'Title'))!!}
			{!! $errors->first('name', '<span class="help-inline" style="color:red;">:message</span>') !!}
		</div>
		<div class="form-row">
			{!!Form::label('imgdownload' , 'Image of Download' , array('class'=>'control-label'))!!}
			<div class="upimage">
				<!-- <span class="btn btn-primary">Upload</span> -->
				{!!Form::file('upimage', null,array('id'=>'imageupload', 'class'=>'form-control'))!!}
				<!-- <p>Upload a Image</p> -->
			</div>
		</div>
		<div class="col-sm-12 divider"></div>
		<div class="form-row">
			{!!Form::label('filedownload' , 'Download File' , array('class'=>'control-label'))!!}
			<div class="upfile">
				<!-- <span class="btn btn-primary">Upload</span> -->
				{!!Form::file('upfile', null,array('id'=>'fileupload', 'class'=>'form-control'))!!}
				<!-- <p>Upload a file <span> or</span></p> -->
			</div>
			{!!Form::text('urldownload', null,array('id'=>'urldownload', 'class'=>'form-control', 'placeholder'=>'Paste Download URL'))!!}
		</div>
		<div class="form-row descript">									
			{!!Form::textarea('description', null,array('id'=>'description', 'class'=>'form-control', 'placeholder'=>'Description'))!!}
		</div>
		<div class="form-row">
			{!!Form::text('tags', null,array('id'=>'tag', 'class'=>'form-control', 'placeholder'=>'Tags (comma separated)'))!!}
		</div>
		<div class="form-row">
			{!!Form::submit('Add Download', array('id'=>'submit', 'class'=>'btn btn-danger submit-media'))!!}
		</div>
	