@extends('layouts.content')
@section('title')
 Member History
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
                            <th>Id</th>
                            <th>Trading name</th>
                            <th>Time</th>
                            <th>Trading detail</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($his as $row)
                            <tr>
                              <td>{!!$row->id!!}</td>
                              <td>{!!$row->log_type!!}</td>
                              <td>{!!$row->created_at!!}</td>
                              <td>{!!$row->log_mesage!!}</td>
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
