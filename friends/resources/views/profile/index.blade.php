@extends('layouts.master')
@section('title')
  Profile | My Friends
@endsection
@section('content')

<div class="row">
    <div class="col-lg-5">
       @include('user.user-header.userblock')
       <hr>
        <!--Showing statuses-->
       @if(!$statuses->count())
         <p>{{$user->getFirstNameOrUsername()}} didnt post anything yet</p>
       @else
         @foreach($statuses as $status)
            <div class="media">
               <a href="{{route('profile.index',['username'=>$status->user->username])}}" class="pull-left">
 <img class="media-object" src="{{$status->user->getAvatarUrl()}}"
         alt="{{$status->user->getNameOrUsername()}}">
               </a>
               <div class="media-body">
       <h4 class="media-heading">
         <a href="{{route('profile.index',['username'=>$status->user->username])}}">
                {{$status->user->getNameOrUsername()}}
         </a></h4>
       <p>{{$status->body}}</p>
        <ul class="list-inline">
          <li>{{$status->created_at->diffForHumans()}}</li>
          @if($status->user->id !== Auth::user()->id)
          <li><a href="{{route('status.like',['statusId'=>$status->id])}}">Like</a></li>
           <li>{{ $status->likes->count()}}
               {{ str_plural('like',$status->likes->count())}}</li>
           @endif
        </ul>

        @foreach($status->replies as $reply)
            <div class="media">
              <a href="{{route('profile.index',['username' =>$reply->user->username])}}"
               class="pull-left">
    <img class="media-object"
       src="{{$reply->user->getAvatarUrl()}}"
       alt="{{$reply->user->getNameOrUsername()}}">
              </a>
              <div class="media-body">
      <h5 class="media-heading"><a href="{{route('profile.index',['username' =>$reply->user->username])}}">
        {{$reply->user->getNameOrUserName()}}
      </a></h5>
      <p>{{$reply->body}}</p>
       <ul class="list-inline">
         <li>{{$reply->created_at->diffForHumans()}}</li>
         @if($reply->user->id !== Auth::user()->id)
         <li><a href="{{route('status.like',['statusId'=>$reply->id])}}">Like</a></li>

          @endif
          <li>{{ $reply->likes->count()}}
              {{ str_plural('like',$reply->likes->count())}}</li>
       </ul>
            </div>
               </div>
         @endforeach
    <!--if user friend if uesr is current user we show form to reply -->
       @if($authUserIsFriend || Auth::user()->id === $status->user->id)
       <form role="form" action="{{route('status.reply',
       ['statusId'=> $status->id])}}" method="post">
<div class="form-group{{
$errors->has("reply-{$status->id}") ? ' has-error': ''}}">
     <textarea name="reply-{{ $status->id}}" class="form-control" rows="2"
     placeholder="Reply"></textarea>
     @if($errors->has("reply-{$status->id}"))
      <span class="help-block">{{$errors->first("reply-{$status->id}")}}</span>
     @endif
               </div>
       <input type="submit" class="btn btn-default btn-sm" value="Reply">
        <input type="hidden" name="_token" value="{{Session::token()}}">
             </form>
             @endif
            </div>
          </div>

         @endforeach
       @endif

    </div>
    <div class="col-lg-4 col-lg-offset-3">
      <!--if current user is sent requests we show this-->
      @if(Auth::user()->hasFriendRequestsPending($user))
         <p>Waiting for {{$user->getNameOrUsername()}} to accept your requests</p>
      <!--if user recive requests we show this-->
      @elseif(Auth::user()->hasFriendRequestsReceived($user))
          <a href="{{route('friends.accept',['username'=>$user->username])}}"
           class="btn btn-primary">Accept Friend Request</a>
      <!--if user is friend with other user we show this-->
      @elseif(Auth::user()->isFriendWith($user))
          <p>You and {{$user->getNameOrUsername()}} are Friends</p>
          <!--Using Form To Remove Friend-->
          <form  action="{{route('friends.remove',[
               'username' => $user->username
          ])}}" method="post">
              <input type="submit" value="Remove Friend" class="btn btn-primary">
            <!--using csrf:Cross Site request Fogery-->  
              <input type="hidden" name="_token" value="{{csrf_token()}}">
          </form>
      <!--if we are in current user page we show this to avoid to showing add ability-->
      @elseif(Auth::user()->id !== $user->id)
            <!--and if non of the up rules was active we show this-->
          <a href="{{route('friends.add',['username'=>$user->username])}}"
          class="btn btn-primary">Add as Friend</a>
      @endif
       <h4>{{$user->getFirstNameOrUsername()}}'s Friend's</h4>
         @if(!$user->friends()->count())
           <p>{{$user->getFirstNameOrUsername()}} has No Friends yet!</p>
         @else
             @foreach($user->friends() as $user)
                @include('user.user-header.userblock')
             @endforeach
         @endif
    </div>
</div>
@stop
