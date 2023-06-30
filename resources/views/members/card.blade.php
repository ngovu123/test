@extends('layouts.content')
@section('title')
  nạp card
@stop
@section('content')
<div class="container">
@include('layouts.member-menu')
  <div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">               
            <div class="panel-body">
              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 table-bordered"> 
                <div class="form-horizontal form-bk">                     
                  <legend class="text-center"><h3>Thông tin thẻ nạp</h3></legend>         
                    <form action="#" method="POST" accept-charset="utf-8">                    
                      {{ csrf_field() }}
                        <div class="form-group"> 
                          <div class="col-xs-10 col-xs-push-2">
                              @if ( Session::has('flash_message') )            
                                <div class="alertmedia col-sm-12 {{ Session::get('flash_type') }}">
                                    <strong style="color:red;">{{ Session::get('flash_message') }}</strong>
                                </div>
                              @endif
                            </div>
                        </div>
                        <div class="form-group">                            
                            <label for="txtpin" class="col-lg-3  text-left">Loại thẻ</label>
                            <div class="col-lg-12">
                              <select class="form-control" name="chonmang">
                                  <option value="VIETEL">Viettel</option>
                                  <option value="MOBI">Mobifone</option>
                                  <option value="VINA">Vinaphone</option>
                                  <option value="GATE">Gate</option>
                                  <option value="VTC">VTC</option>
                                </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="txtpin" class="col-lg-3  text-left">Mã thẻ</label>
                            <div class="col-lg-12">
                              <input type="text" class="form-control" id="txtpin" name="txtpin" placeholder="Mã thẻ" data-toggle="tooltip" data-title="Mã số sau lớp bạc mỏng"/>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="txtseri" class="col-lg-3  text-left">Số seri</label>
                            <div class="col-lg-12">
                              <input type="text" class="form-control" id="txtseri" name="txtseri" placeholder="Số seri" data-toggle="tooltip" data-title="Mã seri nằm sau thẻ">
                            </div>
                          </div>

                          <div class="form-group">
                            <div class="col-lg-12">
                              <button type="submit" class="btn btn-primary btn-block">Nạp thẻ</button>
                            </div>
                          </div>
                        </form>
                  </div>                        
                </div>
              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 table-bordered" style="font-size: 18px;">
               <legend class="text-center"><h3>Giá trị quy đổi</h3></legend>    
                  <li>Thẻ 10.000 đ    (+8 Coin)</li>
                  <li>Thẻ 20.000 đ    (+16 Coin)</li>
                  <li>Thẻ 30.000 đ    (+24 Coin)</li>
                  <li>Thẻ 50.000 đ    (+40 Coin)</li>
                  <li>Thẻ 100.000 đ    (+80 Coin)</li>
                  <li>Thẻ 200.000 đ    (+160 Coin)</li>
                  <li>Thẻ 300.000 đ    (+240 Coin)</li>
                  <li>Thẻ 500.000 đ    (+400 Coin)  </li>    
                  <small class="text-center">*(Phí thanh toán nhà mạng 20%)</small>   <br>    
                  <small class="text-center">*(Coin là đơn vị tiền tệ của website)</small>   <br>    
                  <small class="text-center">*(1 Coin = 1.000 Vnđ)</small>      
              </div>                  
              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 table-bordered" >
                 <legend class="text-center"><h3>Thông tin member</h3></legend>                       
                 <div class="form-group">
                     <label for="">Name: <span style="color:#27ae60;">{!! Auth::user()->name !!}</span></label>
                 </div>  
                 <div class="form-group">
                     <label for="">Email: <span style="color:#27ae60;">{!! Auth::user()->email !!}</label>
                 </div> 
                 <div class="form-group">
                     <label for="">Address: <span style="color:#27ae60;">{!! Auth::user()->address !!}</label>
                 </div> 
                 <div class="form-group">
                     <label for="">Phone: <span style="color:#27ae60;">{!! Auth::user()->phone !!}</label>
                 </div> 
                 <div class="form-group">
                     <label for="">Cash: <span style="color:#c0392b;">{!! Auth::user()->cash !!} Coin</label>
                 </div> 
                 <a class="btn btn-danger btn-block" href="{!!url('/member/profile')!!}" title="nạp thẻ" style="margin-bottom: 10px;">Cập nhật thông tin</a>
             </div>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection
