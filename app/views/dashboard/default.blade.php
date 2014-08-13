<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
@section('head')
<title>Dashboard</title>
@show
<!-- CSS -->
{{ HTML::style('assets/css/bootstrap/bootstrap.css') }}
{{ HTML::style('assets/css/bootstrap/bootstrap-responsive.css') }}
{{ HTML::style('assets/css/dashboard/style.css') }}
{{ HTML::style('assets/css/dashboard/custom.css') }}
{{ HTML::style('assets/css/dashboard/jquery.jscrollpane.css') }}
{{ HTML::style('assets/css/dashboard/sidebar.css') }}
{{ HTML::style('assets/css/notifications/iosOverlay.css') }}
{{ HTML::style('assets/css/dashboard/tooltipster.css') }}
<!-- JS -->
{{ HTML::script('assets/js/jquery/jquery-1.9.1.min.js') }}
{{ HTML::script('assets/js/bootstrap/bootstrap.min.js') }}
{{ HTML::script('assets/js/dashboard/underscore.js') }}
{{ HTML::script('assets/js/dashboard/backbone.js') }}
{{ HTML::script('assets/js/jquery/jquery.jscrollpane.min.js') }}
{{ HTML::script('assets/js/jquery/jquery.cookie.min.js') }}
{{ HTML::script('assets/js/jquery/jquery.actual.min.js') }}
{{ HTML::script('assets/js/jquery/jquery.tooltipster.js') }}
{{ HTML::script('assets/js/dashboard/antiscroll.js') }}
{{ HTML::script('assets/js/dashboard/sidebar_common.js') }}
{{ HTML::script('assets/js/notifications/iosOverlay.js') }}
</head>
<body class="project_bg">
<!-- Header -->
@include('dashboard.layouts.header')
<!-- Header -->
<!-- Section -->
<section>
  <!-- main content -->
    @yield('content')
  <!-- sidebar starts -->
  @include('dashboard.layouts.footer')
  @include('dashboard.layouts.sidebar')
  <!-- sidebar ends -->
</section>
<!-- Section -->
@yield('endjs')
{{ HTML::script('js/dashboard/retina.min.js') }}

</body>
</html>