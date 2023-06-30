@extends('layouts.content')
@section('title')
  Member manager
@stop
@section('content')
<div class="container">
  @include('layouts.member-menu')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default" style="padding: 0; margin: 0">
                <div class="panel-body">
                   <div class="col-xs-9">  
                    @if ( Session::has('flash_message') )            
                      <div class="alert {{ Session::get('flash_type') }}">
                          <h3>{{ Session::get('flash_message') }}</h3>
                      </div>
                    @endif                 
                       <div class="table-responsive">
                        <h4 class="pull-left"> &nbsp; Media upload by : <strong>{!!Auth::user()->name!!}</strong></h4>
                        <a class="btn btn-danger pull-right" href="{!!url('/member/uploads')!!}" title="upload" style="margin-bottom: 10px;">New Media</a> <br>
                        <h3> status note:</h3>
                                 <li class="glyphicon glyphicon-refresh" style="color: #f1c40f;"> Pendding</li> 
                                 <li style="color: #27ae60;" class="glyphicon glyphicon-ok"> Approved</li> 
                                 <li style="color: #e74c3c;" class="glyphicon glyphicon-ok"> Rejected</li>
                           <table class="table table-hover table-bordered">
                               <thead>                               
                                   <tr>
                                    <th class="text-center" >Title</th>                    
                                    <th class="text-center" ><span class="glyphicon glyphicon-usd"></span></th>
                                    <th class="text-center" ><img src="{!! config('view.rootpath') !!}/img/icon_download.png"></th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center" >Created At</th>
                                    <th class="text-center"  style="width:200px;">Actions</th>
                                  </tr>
                               </thead>
                               <tbody>
                                <?php foreach($media as $item): ?>
                                  <tr>
                                    <td>
                                      <a href="{!!url('downloadpage/'.$item->id.'/'.$item->slug)!!}" target="_blank" class="head_item item_ajax">
                                        <img style="max-height:50px;" src="{{ url('').'/'.config('view.filepath') }}/thumb/<?= $item->name ?>">
                                      </a>
                                      <a href="{!!url('downloadpage/'.$item->id.'/'.$item->slug)!!}" target="_blank" class="head_item item_ajax" style="margin-left:15px;">
                                          <?= ucfirst($item->title); ?>
                                      </a>
                                    </td>
                                    <td class="text-center" >
                                      {!!$item->price!!}
                                    </td>
                                    <td class="text-center" >
                                      {!!$item->count_download!!}
                                    </td>
                                    <td class="text-center" >
                                      @if($item->status ==0)
                                      <span style="color: #f1c40f;"><strong class="glyphicon glyphicon-refresh" title="Pendding"></strong></span>
                                      @elseif($item->status==1)
                                        <span class="text-center" style="color: #27ae60;"><strong class="glyphicon glyphicon-ok"></strong></span>
                                      @else
                                        <span class="text-center" style="color: #e74c3c;"><strong class="glyphicon glyphicon-remove"></strong></span>
                                      @endif
                                    </td>
                                    <td style="vertical-align:middle"><?= date("j/m/Y", strtotime($item->created_at)); ?></td>
                                    <td style="vertical-align:middle">
                                      <a href="<?= url('/member/media/edit/').'/'.$item->slug ?>" id="<?= $item->id; ?>" class="btn btn-warning"><i class="fa fa-edit"></i> Edit</a>
                                      <a class="btn btn-danger" style="margin-left:10px;" onclick = " return confirmDelete('Are you sure?')" href="{!!url('/member/delete/')!!}/<?= $item->id; ?>"><i class="fa fa-trash-o"></i> Delete</a>
                                    </td>
                                  </div>
                                <?php endforeach; ?>
                               </tbody>
                           </table>
                           <div class="paginate"><?php echo $media->render(); ?></div>
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
                       <a class="btn btn-danger btn-block" href="{!!url('/member/profile')!!}" title="update" style="margin-bottom: 10px;">Update profile</a>
                       <a class="btn btn-success btn-block" href="{!!url('/member/profile')!!}" title="pay" style="margin-bottom: 10px;">Pay Request</a>
                      
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection