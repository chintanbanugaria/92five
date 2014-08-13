<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" >
<title>92five app - 401 </title>
{{ HTML::style('assets/css/errorpages/style.css') }}
{{ HTML::style('assets/css/errorpages/custom.css') }}
</head>
<body>
<!-- Section -->
<section>

<div class="error_main">
    <div class="error_detail_1"><img src="{{asset('assets/images/errorpages/logo12.png')}}" alt=""/></div>
	<div class="error_detail_1">Oops !</div>
    <div class="error_detail_2">401</div>
   
    	 <div class="error_detail_3_main">
        <div class="error_detail_3">
        <div class="error_detail_3_inner">
            <p> We dont like trespassing. <br/>How about you ?</p>
        </div>
    </div>
    </div>
   <div class="error_detail_3_main">
        <div class="error_detail_3">
        <div class="error_detail_3_inner">
            <p>Dont Worry. It will remain between you and us</p>
        </div>
    </div>
    </div>
    <div class="error_detail_4"><a href="{{url('/dashboard')}}">Go back to Dashboard ?</a></div>
</div>

</section>
  
</body>
</html>
