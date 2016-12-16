@extends('layouts.master')
@section('title')
  Sign Up | My Friends
@endsection
@section('content')
<h3  style="font-size:35px;">Please Sign Up</h3>
       <div class="row">
          <div class="col-lg-6">
             <form class="form-vertical" action="" role="form" method="post">
                 <div class="form-group{{ $errors->has('username') ? ' has-error': ''}}">
            <label for="username" class="control-label"  style="font-size:25px;">Choose Username</label>
            <input type="text" name="username" class="form-control" id="username"
             value="{{ Request::old('username') ?: ''}}">
              @if($errors->has('username'))
                  <span class="help-block">{{ $errors->first('username')}}</span>
              @endif
                 </div>
                 <div class="form-group{{ $errors->has('email') ? ' has-error': ''}}">
             <label for="email" class="control-label"  style="font-size:25px;">Your Email</label>
             <input type="email" name="email" class="form-control" id="email"
              value="{{ Request::old('email') ?: ''}}">
             @if($errors->has('email'))
                 <span class="help-block">{{ $errors->first('email')}}</span>
             @endif
                  </div>
                  <div class="form-group{{ $errors->has('password') ? ' has-error': ''}}">
             <label for="password" class="control-label"  style="font-size:25px;">Choose Password</label>
             <input type="password" name="password" class="form-control" id="password" value="">
             @if($errors->has('password'))
                 <span class="help-block">{{ $errors->first('password')}}</span>
             @endif
                  </div>
                  <div class="form-group">
                      <button type="submit" class="btn btn-default">Sign Up</button>
                   </div>
                   <input type="hidden" name="_token" value="{{Session::token()}}">
             </form>
          </div>
       </div>
@stop
