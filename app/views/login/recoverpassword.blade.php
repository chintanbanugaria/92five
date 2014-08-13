<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>92five App - Reset Password</title>
<!-- CSS -->
{{ HTML::style('assets/css/auth/bootstrap.css') }}
{{ HTML::style('assets/css/auth/bootstrap-responsive.css') }}
{{ HTML::style('assets/css/auth/style.css') }}
{{ HTML::style('assets/css/auth/custom.css') }}
<!--  JS -->
{{ HTML::script('assets/js/jquery/jquery-1.9.1.min.js') }}
{{ HTML::script('assets/js/bootstrap/bootstrap.min.js') }}
{{ HTML::script('assets/js/jquery/jquery.complexify.js') }}
{{ HTML::script('assets/js/jquery/jquery.complexify.banlist.js') }}
{{ HTML::script('assets/js/forgotpassword/forgotpassword.js') }}
</head>
<body>
<section>
  <div class="content_detail">
    <div class="row-fluid">
      <div class="span12 reset_pass">
        <div class="logo"><img src="{{asset('assets/images/errorpages/logo12.png')}}" alt=""/></div>
        <div class="welcome_text2">Looks like someone had a hard time remembering password !</div>
      </div>
    </div>
    <div class="row-fluid">
      <div class="span12">
        <div class="span12 reset_title">Reset Password</div>
        <div class="reset_form">
          <div class="row-fluid">
          	<div class="reset_text">Please enter your new password. Minimum 9 letters with combination of numbers and alphabets. <br/>Keep typing till the bar turns green !</div>
            <div class="field_main">
              <form method="post" id="newpassform" name="newpassform" action="updatepassword">
              <div class="row-fluid field_data">
                <div class="span3 field_name">E-mail</div>
                <div class="span5 field_name">
                    {{$email}}
                </div>
              </div>
              <div class="row-fluid field_data">
                <div class="span3 field_name">New Password</div>
                <div class="span5">
                  <input type="password" id="password" name="password" class="span12 field_input" placeholder="password">
                </div>
                <div class="span4 progress_data" id="progressbar"><div id="progress"></div></div>
              </div>
              <div class="row-fluid field_data">
                <div class="span3 field_name">Confirm Password</div>
                <div class="span5">
                  <input type="password" id="confirmpass" name="confirmpass" class="span12 field_input" placeholder="confirm password">
                </div>
                <div class="progress_data2" id="confirmtick">
                	<div id="confirmtick_child" name="confirmtick_child"></div>
                </div>
              </div>
              <input type="hidden" name="email" id="email" value={{$email}}>
              <input type="hidden" name="token" id="token" value={{$token}}>
            </div>
            <div class="submit_button_main">
              <input type="submit" class="submit" value="Submit"/>
            </div>
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer">&copy; 2014 92five app </div>
</section>
</body>
</html>
