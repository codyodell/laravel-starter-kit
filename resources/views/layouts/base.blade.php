<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="ltr">

<head>
  @section('head')
  @yield('head');
  @endsection
</head>

<body>
  <div id="admin">
    @yield('content')
  </div>
</body>

</html>
