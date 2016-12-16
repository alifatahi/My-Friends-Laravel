<!--this is Flash Message Page-->
@if(Session::has('info'))

     <div class="alert alert-info" role="alert">
        {{Session::get('info')}}
     </div>
@endif
