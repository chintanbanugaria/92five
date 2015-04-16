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
	<div class="error_detail_1">{{trans('92five.oops')}}</div>
    <div class="error_detail_2">404</div>
    <div class="error_detail_3">
    	<div class="error_detail_3_inner">
        	<p>{{trans('92five.errorText5')}}</p>
            <ul>
            	<li>{{trans('92five.errorText6')}}</li>
                <li>{{trans('92five.errorText7')}}</li>
                <li>{{trans('92five.errorText8')}}</li>
                <li>{{trans('92five.errorText9')}}</li>
                <li>{{trans('92five.errorText10')}}</li>
            </ul>
        </div>
        
    </div>
    <div class="error_detail_4"><a href="{{url('/dashboard')}}">{{trans('92five.errorText4')}}</a></div>
</div>

</section>
  
</body>
</html>
