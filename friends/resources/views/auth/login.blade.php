@extends('layouts.master')
@section('title')
  Log In | My Friends
@endsection
@section('content')
<h3  style="font-size:35px;">Please LogIn</h3>
       <div class="row">
          <div class="col-lg-6">
             <form class="form-vertical" action="{{route('auth.login')}}" role="form" method="post">
               <div class="form-group{{ $errors->has('email') ? ' has-error': ''}}">
             <label for="email" class="control-label" style="font-size:25px;">Your Email</label>
             <input type="email" name="email" class="form-control" id="email"
             value="{{ Request::old('email') ?: ''}}" >
             @if($errors->has('email'))
                 <span class="help-block">{{ $errors->first('email')}}</span>
             @endif
           </div>
           <div class="form-group{{ $errors->has('password') ? ' has-error': ''}}">
             <label for="password" class="control-label"  style="font-size:25px;">Your Password</label>
             <input type="password" name="password" class="form-control" id="password" value="">
             @if($errors->has('password'))
                 <span class="help-block">{{ $errors->first('password')}}</span>
             @endif
            </div>
                  <div class="checkbox">
                     <label>
                       <input type="checkbox" name="remember">Remember Me
                     </label>
                  </div>
                  <div class="form-group">
                      <button type="submit" class="btn btn-default">LogIn</button>
                   </div>
                   <input type="hidden" name="_token" value="{{Session::token()}}">
             </form>
          </div>
       </div>
@stop
