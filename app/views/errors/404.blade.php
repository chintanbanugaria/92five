<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" >
<title>92five app - 404 </title>
{{ HTML::style('assets/css/errorpages/style.css') }}
{{ HTML::style('assets/css/errorpages/custom.css') }}


</head>
<body>
<!-- Section -->
<section>

<div class="error_main">
    <div class="error_detail_1"><img src="{{asset('assets/images/errorpages/logo12.png')}}" alt=""/></div>
	<div class="error_detail_1">Oops !</div>
    <div class="error_detail_2">404</div>
    <div class="error_detail_3">
    	<div class="error_detail_3_inner">
        	<p>The reason you are seeing this page could be...</p>
            <ul>
            	<li>Monday morning</li>
                <li>Didn’t had coffee in the morning</li>
                <li>Typo in the URL. Please check the URL</li>
                <li>Page does not exists</li>
                <li>Page has been removed</li>
            </ul>
        </div>
        
    </div>
    <div class="error_detail_4"><a href="{{url('/dashboard')}}">Go back to Dashboard ?</a></div>
</div>

</section>
  
</body>
</html>
