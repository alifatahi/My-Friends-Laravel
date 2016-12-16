<div class="media">
   <a href="{{route('profile.index',['username' => $user->username])}}"
      class="pull-left">
    <img class="media-object" src="{{$user->getAvatarUrl()}}"
    alt="{{$user->getNameOrUsername()}}">
   </a>
   <div class="meida-body">
      <h4 class="media-heading">
    <a href="{{route('profile.index',['username' => $user->username])}}">
        {{$user->getNameOrUsername()}}</a></h4>
    @if($user->location)
       <p>{{$user->location}}</p>
    @endif
   </div>
</div>
