<?php $i =0; ?>
@if($log->count() >0)
<label> Log messger </label>
    @foreach ($log as $row)
        <?php ++$i; ?>
    	@if($row->u_from != 0)
            <?php 
                $us = DB::table('users')->where('id',$row->u_from)->first();
                    $name = $us->name;
                    $email = $us->email;
            ?>
    		<blockquote>
    			<p> {!!$row->content!!} </p>
    			<small> <span style="color:red;">{!! $email.'</span> -'. $row->created_at!!}</small>
    		</blockquote>
    		<div class="clearfix"></div>
    	@else
    		<blockquote class="qt pull-right">
                @if ($i == $log->count() )
                <form action="{!!url('/admin/msg/del/'.$row->id)!!}" method="POST" accept-charset="utf-8">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="p_id" value="{{ $data_msg->id }}">
                    <button type="submit" class="remove btn btn-danger">x</button>                    
                </form>
                @endif   			
    			<p> {!!$row->content!!} </p>
    			<small>{!!$row->created_at!!}</small>		                    				
    		</blockquote>	
    		                    		
    		<div class="clearfix"></div>
    	@endif
    	
    @endforeach
@endif