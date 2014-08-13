<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>92five App - Installation Database</title>
<!-- CSS -->
{{ HTML::style('assets/css/auth/bootstrap.css') }}
{{ HTML::style('assets/css/auth/bootstrap-responsive.css') }}
{{ HTML::style('assets/css/auth/style.css') }}
{{ HTML::style('assets/css/auth/custom.css') }}
<!--  JS -->
{{ HTML::script('assets/js/jquery/jquery-1.9.1.min.js') }}
{{ HTML::script('assets/js/bootstrap/bootstrap.min.js') }}
</head>
<body>
<section>
  <div class="content_detail">
    <div class="row-fluid">
      <div class="span12 reset_pass">
        <div class="logo"><img src="{{asset('assets/images/errorpages/logo12.png')}}" alt=""/></div>
        <div class="welcome_text2 syscheckhead">Installation</div>
      </div>
    </div>
    <div class="row-fluid">
      <div class="span12">
        <div class="span12 reset_title">Database Details</div>
        <div class="reset_form installdb">
          <div class="row-fluid">
          	<div class="reset_text">Please enter the Database Credentials</div>
            <div class="field_main">
              <form method="post" id="newpassform" name="newpassform" action="" data-validate="parsley">
              <div class="row-fluid field_data">
                <div class="span3 field_name">Host</div>
                <div class="span5">
                  <input type="text" id="host" name="host" class="span12 field_input" placeholder="host" data-required="true"  data-show-errors="true">
                </div>
               
              </div>
              <div class="row-fluid field_data">
                <div class="span3 field_name">Database</div>
                <div class="span5">
                  <input type="text" id="database" name="database" class="span12 field_input" placeholder="database" data-required="true"  data-show-errors="true">
                </div>
                
              </div>
               <div class="row-fluid field_data">
                <div class="span3 field_name">Username</div>
                <div class="span5">
                  <input type="text" id="username" name="username" class="span12 field_input" placeholder="username" data-required="true"  data-show-errors="true">
                </div>
                
              </div>
               <div class="row-fluid field_data">
                <div class="span3 field_name">Password</div>
                <div class="span5">
                  <input type="text" id="password" name="password" class="span12 field_input" placeholder="password" data-required="true"  data-show-errors="true">
                </div>
              </div>
              
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
{{ HTML::script('assets/js/simplelogin/parsley.js') }}
  {{ HTML::style('assets/css/simplelogin/parsley.css') }}
</body>
</html>
