@extends('layouts.content')
@section('title')
 Member Download history
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
                      <table class="table table-hover table-bordered">
                        <thead>
                          <tr>
                            <th>Media name</th>
                            <th>Payment id</th>                            
                            <th>Price</th>
                            <th>Time</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($his as $row)
                            <tr>
                              <td>{!!$row->title!!}</td>
                              <td>{!!$row->payment_id!!}</td>                              
                              <td>${!!$row->price!!}</td>
                              <td>{!!$row->created_at!!}</td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
