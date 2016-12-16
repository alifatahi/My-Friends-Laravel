@extends('layouts.master')
@section('title')
  Search | My Friends
@endsection
@section('content')
    <!--get user input-->
    <h3>You are Serach For "{{Request::input('query')}}"</h3>
  @if(!$users->count())
     <h4>No Results found, Sorry</h4>
  @else
    <div class="row">
       <div class="col-lg-12">
         <!--loop through users-->
         @foreach($users as $user)
         @include('user.user-header.userblock')
         @endforeach
       </div>
    </div>
    @endif
@stop
