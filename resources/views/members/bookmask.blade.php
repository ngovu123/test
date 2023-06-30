@extends('layouts.content')
@section('title')
  bookmarks
@stop
@section('content')
<div class="container">
  @include('layouts.member-menu')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default" style="padding: 0; margin: 0">
                <div class="panel-body">
                   <div class="col-xs-12">  
                    @if ( Session::has('flash_message') )            
                      <div class="alert {{ Session::get('flash_type') }}">
                          <h3>{{ Session::get('flash_message') }}</h3>
                      </div>
                    @endif                 
                       <div class="table-responsive">
                        <h4 class="pull-left"> &nbsp; Bookmasks by : <strong>{!!Auth::user()->name!!}</strong></h4>
                           <table class="table table-hover table-bordered">
                               <thead>
                                   <tr>
                                    <th class="text-center" >Title</th>                    
                                    <th class="text-center" ><span class="glyphicon glyphicon-usd"></span></th>
                                    <th class="text-center" >Created At</th>
                                    <th class="text-center"  style="width:100px;">Actions</th>
                                  </tr>
                               </thead>
                               <tbody>
                                <?php foreach($mask as $item): ?>
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
                                    </td>
                                    <td style="vertical-align:middle"><?= date("j/m/Y", strtotime($item->created_at)); ?></td>
                                    <td style="vertical-align:middle">                                      
                                      <a class="btn btn-danger" style="margin-left:10px;" onclick = " return confirmDelete('Are you sure?')" href="{!!url('/member/unmask/')!!}/<?= $item->id; ?>"><i class="fa fa-trash-o"></i> Unmask</a>
                                    </td>
                                  </div>
                                <?php endforeach; ?>
                               </tbody>
                           </table>
                           <div class="paginate"><?php echo $mask->render(); ?></div>
                       </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection