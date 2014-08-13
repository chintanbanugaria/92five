<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>92five App - Login</title>
{{ HTML::style('assets/css/bootstrap/bootstrap.css') }}
{{ HTML::style('assets/css/bootstrap/bootstrap-responsive.css') }}
{{ HTML::style('assets/css/simplelogin/style.css') }}
{{ HTML::style('assets/css/simplelogin/custom.css') }}
{{ HTML::style('assets/css/simplelogin/parsley.css') }}
{{ HTML::style('assets/css/notifications/notify.css') }}
        <!--[if lte IE 8]>
            <link rel="stylesheet" href="css/ie.css" />
        <![endif]-->
        
        <!--[if lt IE 9]>
            <script src="js/html5.js"></script>
            <script src="js/respond.min.js"></script>
            <script src="js/excanvas.min.js"></script>
        <![endif]-->  
<!--script strt here-->
{{ HTML::script('assets/js/jquery/jquery-1.9.1.min.js') }}
{{ HTML::script('assets/js/bootstrap/bootstrap.min.js') }}
{{ HTML::script('assets/js/simplelogin/parsley.js') }}
</head>
<body>
<div class="login_detail">
     <div class="error_detail_1"><img src="{{asset('assets/images/errorpages/logo12.png')}}" alt=""/></div>
	<h2 class="sign_title">Sign In, please!</h2>
    <div class="login_form">
        <div class="row-fluid">
            <form method="post" id="newpassform" name="newpassform" action="auth/login" data-validate="parsley">
                <input type="text" name="loginEmail" id="loginEmail" class="span12" placeholder="Email" data-trigger="change" data-required="true" data-type="email">
                <input type="password" name="loginPass" id="loginPass" class="span12" placeholder="Password" data-trigger="change" data-required="true"  data-minlength="9" >
                <div class="sign_button_main">
                	<button class="sign_in_button">Sign In</button>
                </div>
                <div class="forgot_link">Forgot password? <a href="forgotpassword">Click here to restore</a></div>
            </form>              
        </div>
    </div>
</div>
<div class="footer">&copy; 2014 92five app </div>
{{ HTML::script('assets/js/notifications/notify.js') }}

    @if (Session::get('message') == 'error101')
            {{Session::flush();}}
        <script>$.notify.error('Invalid Email/Password. Sure you had coffee this morning ?',{close:true});</script>
    @elseif (Session::get('message') == 'error102')
        {{Session::flush();}}
        <script>$.notify.error('There is something wrong with your account and its not YOU. Please contact Admin.',{close:true});</script>
    @elseif (Session::get('message') == 'error103')
        {{Session::flush();}}
        <script>$.notify.error('Your account does not seems to be activated. Please contact Admin.',{close:true});</script>
    @elseif (Session::get('message') == 'error104')
        {{Session::flush();}}
        <script>$.notify.error('Are you sure you are on the right planet ? In our system you dont exists ! ',{close:true});</script>
    @elseif (Session::get('message') == 'error105')
        {{Session::flush();}}
        <script>$.notify.error('You are trying your luck very hard. Be calm for 10 minutes and then try again. ',{close:true});</script>
    @elseif (Session::get('message') == 'success101')
        {{Session::flush();}}
        <script>$.notify.success('Email sent. Please check your email.',{close:true});</script>
 @elseif (Session::get('message') == 'success102')
        {{Session::flush();}}
        <script>$.notify.success('Email Verified. Please login',{close:true});</script>
    @elseif (Session::get('message') == 'success103')
        {{Session::flush();}}
        <script>$.notify.success('Account Created. Please login',{close:true});</script>
    @elseif (Session::get('message') == 'success104')
        {{Session::flush();}}
        <script>$.notify.success('Password Updated. Please login',{close:true});</script>
    @endif
</body>
</html>
