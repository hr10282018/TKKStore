<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" href="/favicon.ico">
  <meta name="keywords" content="校园,二手交易,商品,平台">
  <meta name="description" content="二手交易平台">

  <title>@yield('title', 'onestore') - TKKStore</title>

 
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  <link href="/js/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet">

</head>

<body>
  <div id="app" class="{{ route_class() }}-page" style="overflow:hidden">

    @include('layouts._header')

    <div class="container">

      @include('shared._messages')
      @include('shared._errors')
      @yield('content')

    </div>

    @include('layouts._footer')
  </div>

  <script src="{{ mix('js/app.js') }}"></script>

  @yield('scriptsAfterJs')

  {{--  
  @if(Auth::user() && Auth::user()->email == '1902422119@qq.com')
    @include('sudosu::user-selector')
  @endif
  --}}

    @if (app()->isLocal())
      @include('sudosu::user-selector')
    @endif
  
</body>

</html>