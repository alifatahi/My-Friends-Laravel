@extends('layouts.master')
@section('title')
   My Friends
@endsection
@section('content')
        <div class="row">
           <div class="col-lg-6">
               <form role="form" action="{{route('status.post')}}" method="post">
                  <div class="form-group{{ $errors->has('status') ? ' has-error' : ''}}">
    <textarea style="font-size:25px;" placeholder="What's Up {{Auth::user()->getFirstNameOrUsername()}}?"
    class="form-control"name="status" rows="2"></textarea>
    @if($errors->has('status'))
       <span class="help-block">{{$errors->first('status')}}</span>
    @endif
                  </div>
                  <button type="submit" class="btn btn-default">Update Status</button>
                  <input type="hidden" name="_token" value="{{Session::token()}}">
               </form>
               <hr>
           </div>
        </div>
        <div class="row">
           <div class="col-lg-5">
                @if(!$statuses->count())
                  <p>There is Nothing on your Timeline yet</p>
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
                   <!--disable Like for Current user-->
                   @if($status->user->id !== Auth::user()->id)
                   <li><a href="{{route('status.like',['statusId'=>$status->id])}}">Like</a></li>
                    @endif
                    <!--To show likes we use str_plural which is for convert
                    string to plural(all)-->
                    <li>{{ $status->likes->count()}}
                      {{ str_plural('like',$status->likes->count())}}</li>
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
                     </div>
                   </div>

                  @endforeach
                   <!--using render for paginating-->
                  {!! $statuses->render() !!}
                @endif
           </div>
        </div>
@stop
