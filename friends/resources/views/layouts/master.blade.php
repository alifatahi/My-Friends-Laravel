<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{URL::to('css/main.css')}}">
    <link rel="stylesheet"
 href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
 crossorigin="anonymous">
  </head>
  <body>
        @include('includes.header')
      <div class="container">
        <!--Flashe Message-->
        @include('includes.alert')
         @yield('content')
      </div>
    @include('includes.footer')
  </body>
</html>
