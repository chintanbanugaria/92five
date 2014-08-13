<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>92five App - Registration</title>
<!-- Bootstrap -->
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/bootstrap-responsive.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<link href="css/custom.css" rel="stylesheet">
<script src="js/jquery-1.7.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.complexify.js"></script>
<script src="js/jquery.complexify.banlist.js"></script>
<script src="js/registration.js"></script>
<!-- CSS -->
{{ HTML::style('assets/css/bootstrap/bootstrap.css') }}
{{ HTML::style('assets/css/bootstrap /bootstrap-responsive.css') }}
{{ HTML::style('assets/css/registration/style.css') }}
{{ HTML::style('assets/css/registration/custom.css') }}
{{ HTML::style('assets/css/dashboard/tooltipster.css') }}

<!--  JS -->
{{ HTML::script('assets/js/jquery/jquery-1.9.1.min.js') }}
{{ HTML::script('assets/js/bootstrap/bootstrap.min.js') }}
{{ HTML::script('assets/js/jquery/jquery.complexify.js') }}
{{ HTML::script('assets/js/jquery/jquery.complexify.banlist.js') }}
{{ HTML::script('assets/js/registration/registration.js') }}
{{ HTML::script('assets/js/jquery/jquery.tooltipster.js') }}
</head>
<body>
<section>
  <div class="content_detail">
    <div class="row-fluid">
      <div class="span12 reset_pass">
        <div class="logo"><img src="{{asset('assets/images/errorpages/logo12.png')}}" alt=""/></div>
        <div class="welcome_text">Welcome! </div>
        <div class="welcome_text2">Please fill in the following details to get you started.</div>
      </div>
    </div>
    <div class="row-fluid">
      <div class="span12">
        <div class="reset_form step_inner">
            <form method="post" id="signupForm" action="createuser">
	            <div class="row-fluid">
                    <div class="widgard-content">
                    <!-- Step 1 -->
                    
                   <div class="span12 reset_title">Registration</div>
						<div class="field_main">
                        <div class="row-fluid field_data">
                        <div class="span3 field_name">E-mail:</div>
                        <div class="span5 field_name">
                          {{$email}}
                        </div>
                       
                        </div>
                    
                        <div class="row-fluid field_data">
                        <div class="span3 field_name">Password:<span class="tooltipster-icon" title="Minimum 9 letters with combination of numbers and alphabets. Keep on typing till the bar turns green !">(?)</span></div>
                        <div class="span5">
                          <input type="password" id="password" name="password" class="span12" placeholder="Password">
                        </div>
                        <div class="span4 progress_data" id="progressbar"><div id="progress"> </div></div>
                        </div>
                        
                        <div class="row-fluid field_data">
                        <div class="span3 field_name">Confirm Password:</div>
                        <div class="span5">
                          <input type="password" id="confirmpassword" name="confirmpassword" class="span12" placeholder="Confirm Password">
                        </div>
                        <div class="progress_data2" id="confirmtick">
                            <div></div>
                        </div>
                        </div>

                         <div class="row-fluid field_data">
                        <div class="span3 field_name">Name:</div>
                        <div class="span5">
                          <input type="text" id="first_name" name="first_name" class="span6" placeholder="First Name">
                          <input type="text" id="last_name" name="last_name" class="span6" placeholder="Last Name">
                        </div>
                        <div class="progress_data2" id="confirmtick1">
                            <div></div>
                        </div>
                        </div>

                          <input type="hidden" name="email" id="email" value={{$email}}>
                          <input type="hidden" name="token" id="token" value={{$token}}>
                    </div>    
                    <div class="submit_button_main">
                        <button class="submit">Create my Account</button>
                        </div>                                
                    </div>
            	</div>
            </form>
        </div>
      </div>
    </div>
  </div>
  <div class="footer">&copy; 2014 92five app </div>
</section>
<script>
$(document).ready(function() {
            $('.tooltipster-icon').tooltipster();
        });
</script>
</body>
</html>
