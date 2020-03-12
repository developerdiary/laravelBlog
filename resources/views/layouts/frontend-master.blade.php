<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>@yield('title', 'Blog Laravel') &mdash; {{ env('APP_NAME') }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <base href="<?= url('/'); ?>">
  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

   <!-- Template CSS -->
   <link href="{{ asset('assets/frontend/css/clean-blog.min.css') }}" rel="stylesheet"> 

</head>

<body>
  <div id="web">
    
    <!-- Navigation -->
    @include('frontend.partials.topnav')

    <!-- Page Header -->
    @include('frontend.partials.header')

    <!-- Main Content -->
    <div class="main-content">
      @yield('content')
    </div>    

    <hr>

    <!-- Footer -->
    <footer>
      @include('frontend.partials.footer')      
    </footer>

  </div>

  <script src="{{ route('js.dynamic') }}"></script>
  <script src="{{ asset('js/web.js') }}?{{ uniqid() }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>  
  <script src="{{ asset('assets/frontend/js/clean-blog.min.js') }}"></script>
  @yield('scripts')
</body>
</html>
