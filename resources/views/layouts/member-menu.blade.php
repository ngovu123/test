<?php 
  $msg = DB::table('messenger')
            ->join('users', 'u_from', '=', 'users.id')
            ->select('users.name','users.email','messenger.*')
            ->where('u_to','=',Auth::user()->id)
            ->where('type','=','0')
            ->where('messenger.status','=','0')
            ->orderBy('created_at','DESC')
            ->get();
?>

@if(Auth::user())        
  <nav class="navbar navbar-inverse" style="font-size: 13px; line-height: 20px;">
    <div class="container-fluid" style="font-size: 13px; line-height: 20px;">
      <a class="navbar-brand" href="{!!url('/member')!!}">Member manager </a>
      <ul class="nav navbar-nav" style="font-size: 13px; line-height: 20px;">   
        <li class="active">
          <a href="{!!url('/member')!!}">My Media</a>
        </li>     
        <li>
          <a href="{!!url('/member/statistical')!!}">Account balance</a>
        </li>        
        <li>
          <a href="{!!url('/member/download')!!}">log download</a>
        </li>
        <li>
          <a href="{!!url('/member/bookmarks')!!}">bookmarks</a>
        </li>
        <li class="">
          <a href="{!!url('/member/msg')!!}">Mail - Masager<span class="label label-danger pull-right">{!!$msg->count()!!}</span></a>
        </li>
        <li class="">
          <a href="{!!url('/member/profile')!!}">Profile</a>
        </li>
        <li>
          <a href="{!!url('/member/pay')!!}">Payment</a>
        </li>
        <li>
          <a href="{!!url('users/'.Auth::user()->slug.'/'.Auth::user()->id)!!}">View my uploads</a>
        </li>
      </ul>
    </div>
  </nav>
@endif