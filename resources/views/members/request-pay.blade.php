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
                  <div class="col-xs-12"> 
                    <div class="table-responsive">
                        <h4 class="pull-left"> All payment request by  : <strong>{!!Auth::user()->name!!}</strong></h4>
                        <a class="btn btn-danger pull-right" href="{!!url('/member/pay/new')!!}" title="upload" style="margin-bottom: 10px;">New Request</a> <br>
                          <h3> status note:</h3>
                           <li class="glyphicon glyphicon-refresh" style="color: #f1c40f;"> Pendding</li> 
                           <li style="color: #27ae60;" class="glyphicon glyphicon-ok"> Success</li> 
                           <li style="color: #e74c3c;" class="glyphicon glyphicon-remove">Canceled</li>
                           <hr>
                           @if ( Session::has('flash_message') )            
                          <div class="alert {{ Session::get('flash_type') }}">
                              <h3>{{ Session::get('flash_message') }}</h3>
                          </div>
                        @endif
                           <table class="table table-hover table-bordered">
                               <thead>                               
                                   <tr>
                                    <th class="text-center" >Created at</th>                    
                                    <th class="text-center" >Payment Email</th>
                                    <th class="text-center" >pay cash</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center" >Messager</th>
                                    <th class="text-center"  style="width:150px;">Actions</th>
                                  </tr>
                               </thead>
                               <tbody>
                               @if ($pay->count()>0)
                                <?php foreach($pay as $item): ?>
                                  <?php 
                                    $p = DB::table('users')
                                      ->where('id',$item->u_id)
                                      ->first();                                   
                                  ?>
                                  @if($item->status != 0)
                                    {!!  $stt = ' disabled '!!}
                                  @else
                                    {{ $stt = '  '}}
                                  @endif
                                  <tr>
                                    <td style="vertical-align:middle"><?= date("j/m/Y", strtotime($item->created_at)); ?></td>
                                    <td class="text-center" >
                                      {!! $p->pay_id !!}
                                    </td>
                                    <td style="vertical-align:middle">
                                      {!! $item->pay_cash !!}
                                    </td>
                                    <td class="text-center" >
                                      @if( $item->status ==0)
                                        <span class="glyphicon glyphicon-refresh" style="color: #f1c40f;""> Pendding</span>
                                      @elseif($item->status ==1)
                                        <li style="color: #27ae60;" class="glyphicon glyphicon-ok"> Success</li>
                                      @else
                                      <li style="color: #e74c3c;" class="glyphicon glyphicon-remove"> Canceled</li>
                                      @endif
                                      
                                    </td>
                                    <td class="text-center" >
                                      {!! $item->message !!}
                                    </td>  
                                   <td style="vertical-align:middle">                                      
                                      <a class="btn btn-danger" style="margin-left:10px;" onclick = " return confirmDelete('Are you sure?')" href="{!!url('/member/pay/cancel/')!!}/<?= $item->id; ?>" {!!$stt!!}><i class="fa fa-trash-o"></i> cancel</a>
                                    </td> 
                                <?php endforeach; ?>
                               @else
                               <tr>
                                <td colspan="5">No result found !</td>
                                </tr>
                               @endif
                                
                               </tbody>
                           </table>
                           <div class="paginate"><?php echo $pay->render(); ?></div>
                       </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
