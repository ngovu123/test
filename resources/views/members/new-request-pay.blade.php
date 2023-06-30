@extends('layouts.content')
@section('title')
  Send Pay request
@stop
@section('content')
<div class="container">
@include('layouts.member-menu')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">               
                <div class="panel-body">
                  <div class="col-xs-9">                     
                    <div class="table-responsive">
                        <h4 class="pull-left"> New payment request </h4> <br>                        
                          <h3> status note:</h3>
                           <li class="glyphicon glyphicon-refresh" style="color: #f1c40f;"> Pendding</li> 
                           <li style="color: #27ae60;" class="glyphicon glyphicon-ok"> Success</li> 
                           <li style="color: #e74c3c;" class="glyphicon glyphicon-ok">Canceled</li>
                           <hr>
                        @if ( Session::has('flash_message') )            
                          <div class="alert {{ Session::get('flash_type') }}">
                              <h3>{{ Session::get('flash_message') }}</h3>
                          </div>
                        @endif
                        <form action="" method="POST" role="form">
                           <legend>Send new payment request </legend>
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">  
                            <label for="">Account balance: <span style="color:#c0392b;"> <span class="glyphicon glyphicon-usd"></span>{!! $us->cash !!}</label> <br>
                            <label for="">Available balances : <span style="color:#c0392b;"> <span class="glyphicon glyphicon-usd"></span>{!! $us->cash - $us->f_cash !!}</label> <br>

                            @if($us->pay_id !='0')
                              <label for="">Payment ID (paypal Account): <span style="color:#c0392b;">{!! $us->pay_id !!}</span></label>
                            @else
                              <label for="">Payment ID (paypal Account): <span style="color:#c0392b;"> No payment ID You Need <a href="{!!url('member/profile')!!}" title="">Update Profile</a> To Send Payment ! </label>
                            @endif
                           <div class="form-group">
                             <label for="">pay cash <span class="glyphicon glyphicon-usd"> :</label>
                             <input type="number" class="form-control" id="cash" name="paycash" min="1" max="1000" required placeholder="Enter the payment you want to pay">
                           </div>
                            <div class="form-row descript">
                            <label for="">Message: </label> 
                              {!!Form::textarea('msg', null,array('id'=>'msg', 'class'=>'form-control', 'placeholder'=>'message'))!!}
                              {!! $errors->first('msg', '<span class="help-inline" style="color:red;">:message</span>') !!}
                          </div>
                           <button type="submit" class="btn btn-primary">Submit</button>
                         </form> 
                       </div>
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
