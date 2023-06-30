@extends('layouts.admincontent')
@section('title')
	messenger
@stop
@section('content')
	<div class="container">
 			<div class="mail-box">
	          <aside class="sm-side">
	              <div class="user-head">
	                  <a class="inbox-avatar" href="javascript:;">
	                      <img  width="64" hieght="60" src="{!!url('public/application/assets/img/user/'.Auth()->guard('admin')->user()->avata_img)!!}">
	                  </a>
	                  <div class="user-name">
	                      <h5><a href="#">{!!Auth()->guard('admin')->user()->name!!}</a></h5>
	                      <span><a href="#">{!!Auth()->guard('admin')->user()->email!!}</a></span>
	                  </div>
	              </div>
	              <ul class="inbox-nav inbox-divider">
	                  <li class="active">
	                      <a href="{!!url('admin/msg')!!}"><i class="fa fa-inbox"></i> Inbox <span class="label label-danger pull-right">{!!$data->count()!!}</span></a>
	                  </li>
	              </ul>
	          </aside>
            <aside class="lg-side">
                <div class="inbox-head">
                    <h3>Messenger</h3>
                </div>
                <div class="inbox-body">
                  <table class="table table-inbox table-hover">
                    <tbody>
                    @foreach($data_msg as $row)
                    <?php 
                    	$total = DB::table('messenger')->where('parent','=',$row->id)->count();
                    	$sub = DB::table('messenger')->where('parent','=',$row->id)->where('status',0)->where('u_to','=','0')->count();
                    ?>
                    	@if($row->status == 0)                
	                    <tr class="unread">                      	
	                        <td class="inbox-small-cells"><span class="label label-danger">{!!$sub.'/'.$total!!}</span></td>
	                        <td class="view-message  dont-show content_msg" style="max-width: 100px;"><a href="{!! route('getlistmsg_detail',$row->id) !!}">{!!$row->name!!}</a></td>
	                        <td class="view-message  dont-show content_msg" style="max-width: 150px;"><a href="{!! route('getlistmsg_detail',$row->id) !!}">{!!$row->email!!}</a></td>
	                        <td class="view-message content_msg"><a href="{!! route('getlistmsg_detail',$row->id) !!}">{!!$row->content!!}</a></td>                        
	                        <td class="view-message  text-right">{!!$row->created_at!!}</td>
	                     </tr>
                      @else
                      	<tr class="">                      	
	                        <td class="inbox-small-cells"><span class="label label-danger">{!!$sub.'/'.$total!!}</span></td>
	                        <td class="view-message  dont-show content_msg" style="max-width: 100px;"><a href="{!! route('getlistmsg_detail',$row->id) !!}">{!!$row->name!!}</a></td>
	                        <td class="view-message  dont-show content_msg" style="max-width: 150px;"><a href="{!! route('getlistmsg_detail',$row->id) !!}">{!!$row->email!!}</a></td>
	                        <td class="view-message content_msg "><a href="{!! route('getlistmsg_detail',$row->id) !!}">{!!$row->content!!}</a></td>
	                        <td class="view-message  text-right">{!!$row->created_at!!}</td>
	                        <td class="view-message  text-right">
	                        	<a class="btn btn-warning" onclick = " return confirmDelete('Are you sure?')" href="{!!url('/admin/msg/delete/')!!}/<?= $row->id; ?>"><i class="glyphicon glyphicon-trash"></i> Delete</a>
	                        </td>
	                     </tr>
                      @endif                     
                    @endforeach                        
                    </tbody>
                  </table> 
                  <div class="paginate"><?php echo $data_msg->render(); ?></div> 
                </div>
            </aside>
        </div>
</div>
@stop