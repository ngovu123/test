@extends('layouts.master')
@section('title')
    Login page
@stop
@section('container')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2" style="margin-top:90px;margin-bottom:72px;">
                <div class="panel panel-default">
                    <div class="panel-heading text-center"><strong>You needed Login</strong></div>
                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            {{ Session::put('url', url('/home')) }}
                            <div class="form-group">
                                <label class="col-md-4 control-label">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="col-md-3" style="padding: 2px;">
                                        <button type="submit" class="btn btn-block btn-primary">Login</button> 
                                    </div>
                                    <div class="col-md-9" style="padding: 1px;">
                                    You do not have an account ? <a href="{!!url('/register')!!}" title="Register">Register</a> <br>
                                    Fogot passwork ? <a href="{!!url('/password/reset')!!}" title="Register">Reset passwork</a>
                                    </div>                                  
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
