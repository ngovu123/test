@extends('layouts.content')
@section('title')
    Member Profile
@stop
@section('content')
<div class="container">
@include('layouts.member-menu')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">               
                <div class="panel-body">
                  <div class="col-xs-9"> 
                  @if ( Session::has('flash_message') )            
                      <div class="alert {{ Session::get('flash_type') }}">
                          <h3>{{ Session::get('flash_message') }}</h3>
                      </div>
                    @endif
                    <form class="form-horizontal form-bk" role="form" method="post" enctype="multipart/form-data" >
                      {{ csrf_field() }}                          
                          <div class="form-group">
                            <label for="txtpin" class="col-lg-1 control-label">First name</label>
                            <div class="col-lg-5">
                              <input type="text" class="form-control" id="txtname" name="txtname" value="{!!Auth::user()->name!!}" placeholder="Enter your name" />
                            </div>
                            <label for="txtpin" class="col-lg-2 control-label" style="text-align: left;">Last Name</label>
                            <div class="col-lg-4" style="padding-left: 0">
                              <input type="text" class="form-control" id="txtlname" name="txtlname" value="{!!Auth::user()->last_name!!}" placeholder="Enter your last name" />
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="txtpin" class="col-lg-1 control-label">address</label>
                            <div class="col-lg-11">
                              <input type="text" class="form-control" id="txtaddress" name="txtaddress" value="{!!Auth::user()->address!!}" placeholder="Enter your address" />
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="txtpin" class="col-lg-1 control-label">Phone </label>
                            <div class="col-lg-11">
                              <input type="text" class="form-control" id="txtphone" name="txtphone" value="{!!Auth::user()->phone!!}" placeholder="Enter your phone number" />
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="txtseri" class="col-lg-1 control-label">PayID </label>
                            <div class="col-lg-11">
                              <input type="text" class="form-control" id="txtpayid" required="required" name="txtpayid" value="{!!Auth::user()->pay_id!!} " placeholder="Enter your pay id " data-toggle="tooltip" data-title="Email paypal account to receive payments">
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="txtpin" class="col-lg-1 control-label">Avata</label>
                            <div class="col-lg-11">
                              <img src="{!!url('public/application/assets/img/user/'.$us->avata_img)!!}" alt="avata" width="90" height="90" style="padding-bottom: 10px;">
                              <input type="file" name="avata" value="{{ old('image') }}" accept="image/png" id="image" class="form-control">
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="txtseri" class="col-lg-1 control-label">Website </label>
                            <div class="col-lg-11">
                               <input type="text" class="form-control" id="txtfacebook" name="txtwebsite" value="{!!Auth::user()->website!!}" placeholder="Enter your website" />
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="txtpin" class="col-lg-1 control-label">facebook</label>
                            <div class="col-lg-11">
                              <input type="text" class="form-control" id="txtfacebook" name="txtfacebook" value="{!!Auth::user()->facebook!!}" placeholder="Enter your facebook" />
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="txtpin" class="col-lg-1 control-label">Google plus</label>
                            <div class="col-lg-11">
                              <input type="text" class="form-control" id="txtgoogleplus" name="txtgoogleplus" value="{!!Auth::user()->googleplus!!}" placeholder="Enter your google plus" />
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="txtpin" class="col-lg-1 control-label">Twitter</label>
                            <div class="col-lg-11">
                              <input type="text" class="form-control" id="txttwitter" name="txttwitter" value="{!!Auth::user()->twitter!!}" placeholder="Enter your twitter" />
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="txtpin" class="col-lg-1 control-label">Skype</label>
                            <div class="col-lg-11">
                              <input type="text" class="form-control" id="txtskype" name="txtskype" value="{!!Auth::user()->skype!!}" placeholder="Enter your skype" />
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-lg-offset-1 col-lg-11">
                              <button type="submit" class="btn btn-primary" name="napthe">Update</button>
                            </div>
                          </div>
                      </form>
                    </div>
                    <div class="col-xs-3 table-bordered">
                       <legend class="text-center"><h3>Member info</h3></legend>   
                      <div class="form-group">
                           <img src="{!!url('public/application/assets/img/user/'.$us->avata_img)!!}" alt="avata" width="90%" height="90%" style="padding-bottom: 10px;">                              
                       </div>             
                       <div class="form-group">
                           <label for="">Name: <span style="color:#27ae60;">{!! $us->name !!}</span></label>
                       </div>  
                       <div class="form-group">
                           <label for="">Email: <span style="color:#27ae60;">{!! $us->email !!}</label>                               
                       </div> 
                       <div class="form-group">
                           <label for="">Address: <span style="color:#27ae60;">{!! $us->address !!}</label>                               
                       </div> 
                       <div class="form-group">
                           <label for="">Phone: <span style="color:#27ae60;">{!! $us->phone !!}</label>                               
                       </div> 
                       <div class="form-group">
                           <label for="">Account balance: <span style="color:#c0392b;">{!! $us->cash !!} <span class="glyphicon glyphicon-usd"></span></label>                               
                       </div> 
                       <a class="btn btn-success btn-block" href="{!!url('/member/profile')!!}" title="nạp thẻ" style="margin-bottom: 10px;">Pay Request</a>
                       <hr>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
