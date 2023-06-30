@extends('layouts.content')
@section('title')
	Contact Us page
@stop
@section('content')
	<div class="content contentContact">
		<div class="container">
			<div class="row">
				<div class="col-sm-7 cntcontactus">
					<h1>Contact Us</h1>
                    <?php $success = Session::get('success')?>
                    @if($success)
                        <div class="alert-box success">
                            <h2>{{ $success }}</h2>
                        </div>
                    @endif
                    @if ( Session::has('flash_message') )                        
                        <div class="alert {{ Session::get('flash_type') }}">
                            <h3>{{ Session::get('flash_message') }}</h3>
                        </div>
                    @endif
					<h3>Feel free to contact us, we would love to hear from you</h3>
                    
					{!! Form::open(array('action' => array('ContactController@sendcontact') , 'class'=>'form-horizontal formcontact','enctype'=>'multipart/form-data')) !!}
						<div class="form_row">
                            {!!Form::label('contact_name' , 'Name' , array('class'=>'control-label'))!!}
                            {!!Form::text('contact_name', null,array('id'=>'contact_name', 'class' => 'form-control'))!!}
                            {!! $errors->first('contact_name', '<span class="help-inline" style="color:red;">:message</span>') !!}
                        </div>
                        <div class="form_row">
                           {!!Form::label('contact_email' , 'Email' , array('class'=>'control-label'))!!}
                           {!!Form::text('contact_email',null,array('id'=>'contact_email', 'class' => 'form-control'))!!}
                            {!! $errors->first('contact_email', '<span class="help-inline" style="color:red;">:message</span>') !!}
                        </div>
                        <div class="form_row">
                           {!!Form::label('contact_messages' , 'Message' , array('class'=>'control-label'))!!}
                           {!!Form::textarea ('contact_messages',null,array('id'=>'contact_phone', 'placeholder'=>'Messages...', 'class' => 'form-control'))!!}
                           {!! $errors->first('contact_messages', '<span class="help-inline" style="color:red;">:message</span>') !!}
                        </div>
                        <div>
                            {!! Form::submit('Send',array('class'=>'submitButton btn btn-danger')) !!}
                        </div>
                        
					{!! Form::close() !!}
                    
				</div>
			</div>
		</div>
	</div>
@stop