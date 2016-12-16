@extends('layouts.master')
@section('title')
  Friends | My Friends
@endsection
@section('content')
     <div class="row">
        <div class="col-lg-6">
           <h3>Your Friends</h3>
           @if(!$friends->count())
             <p>You have No Friends yet!</p>
           @else
               @foreach($friends as $user)
                  @include('user.user-header.userblock')
               @endforeach
           @endif
        </div>
        <div class="col-lg-6">
           <h4>Friends Request</h4>
             @if(!$requests->count())
               <p>You Have No Request</p>
             @else
               @foreach($requests as $user)
                  @include('user.user-header.userblock')
               @endforeach
             @endif
        </div>
     </div>
@stop
