@extends('layouts.content')
@section('title')
  History
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
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th colspan="2">Statistical your account</th>
                          </tr>
                        </thead>
                        <tbody style="font-weight: bold;">
                          <tr>
                            <td>Total media Upload : </td>
                            <td>{!!$count->totalmedia!!}</td>
                          </tr>
                          <tr>
                            <td>Total downloads : </td>
                            <td>{!!$count->totaldown!!}</td>
                          </tr>
                          <tr>
                            <td>Total liked : </td>
                            <td>{!!$count->totallike!!}</td>
                          </tr>
                          <tr>
                            <td>Total money get : </td>
                            <td>{!!$us->cash!!} <i class="glyphicon glyphicon-usd"></i></td>
                          </tr>
                          <tr style="color: #f39c12">
                            <td><strong>Account balance :</strong> </td>
                            <td><strong>{!!$us->cash!!}</strong> <i class="glyphicon glyphicon-usd"></i></td>
                          </tr>
                          <tr style="color: #1abc9c">
                            <td><strong>Available balances :</strong> </td>
                            <td><strong>{!!$us->cash - $us->f_cash !!}</strong> <i class="glyphicon glyphicon-usd"></i></td>
                          </tr>
                          <tr style="color: #c0392b">
                            <td><strong>Frozen balance :</strong> </td>
                            <td><strong>{!!$us->f_cash!!}</strong> <i class="glyphicon glyphicon-usd"></i></td>
                          </tr>
                        </tbody>
                      </table>
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
                     <a class="btn btn-danger btn-block" href="{!!url('/member/profile')!!}" title="nạp thẻ" style="margin-bottom: 10px;">Update profile</a>
                     <a class="btn btn-success btn-block" href="{!!url('/member/pay/new')!!}" title="nạp thẻ" style="margin-bottom: 10px;">Pay Request</a>
                     <hr>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
