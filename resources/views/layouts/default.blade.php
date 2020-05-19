<!doctype html>
<html>
<head>
   @include('includes.head')
</head>
<body>
   <header class="row header">
       @include('includes.header')
   </header>
   <div id="main">
           @yield('content')
   </div>
   <footer>
       @include('includes.footer')
   </footer>
</body>
</html>