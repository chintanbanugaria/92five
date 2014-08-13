<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>92five App - System Check Requirements</title>
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
        <div class="welcome_text2 syscheckhead">Installation</div>
      </div>
    </div>

    <div class="row-fluid">
      <div class="span12">
        <div class="span12 reset_title">Minimum Requirements</div>
        <div class="reset_form">
        <div class="syscheckmain">
          <?php $flag= true; ?>
        <ul>
          <li>
          @if(version_compare(phpversion(),"5.4",">="))
          <img src="{{asset('assets/images/forgotpassword/right.png')}}"/>  PHP Version Compatible
          @else
          <?php $flag = false; ?>
          <img src="{{asset('assets/images/forgotpassword/wrong.png')}}"/>PHP Version Not Compatible
          @endif
          </li>

          
          <li>
          @if(extension_loaded('pdo'))
          <img src="{{asset('assets/images/forgotpassword/right.png')}}"/>  PDO Enabled
          @else
          <?php $flag = false; ?>
          <img src="{{asset('assets/images/forgotpassword/wrong.png')}}"/>PDO Disabled
          @endif
        </li>
        <li>
          @if(extension_loaded('mcrypt'))
          <img src="{{asset('assets/images/forgotpassword/right.png')}}"/>  Mcrypt Extension Enabled
          @else
           <?php $flag = false; ?>
          <img src="{{asset('assets/images/forgotpassword/wrong.png')}}"/>Mcrypt Extension Disabled
          @endif
        </li>

        <li>
          @if(extension_loaded('gd'))
          <img src="{{asset('assets/images/forgotpassword/right.png')}}"/> GD Extension Enabled
          @else
          <?php $flag = false; ?>
          <img src="{{asset('assets/images/forgotpassword/wrong.png')}}"/>GD Extension Disabled
          @endif
        </li>
        <li>
          @if(is_writable(public_path().'/assets/uploads'))
          <img src="{{asset('assets/images/forgotpassword/right.png')}}"/> assets/uploads folder is Writable
          @else
          <?php $flag = false; ?>
          <img src="{{asset('assets/images/forgotpassword/wrong.png')}}"/>assets/uploads folder is not Writable
          @endif
        </li>
        <li>
          @if(is_writable(public_path().'/assets/images/profilepics'))
          <img src="{{asset('assets/images/forgotpassword/right.png')}}"/> assets/images/profilepics is folder is Writable
          @else
          <?php $flag = false; ?>
          <img src="{{asset('assets/images/forgotpassword/wrong.png')}}"/>assets/images/profilepics folder is not Writable
          @endif
        </li>
        <li>
          @if(is_writable(public_path().'/app/storage/logs'))
          <img src="{{asset('assets/images/forgotpassword/right.png')}}"/> app/storage/logs is folder is Writable
          @else
          <?php $flag = false; ?>
          <img src="{{asset('assets/images/forgotpassword/wrong.png')}}"/>app/storage/logs folder is not Writable
          @endif
        </li>
        <li>
          @if(is_writable(public_path().'/app/storage/views'))
          <img src="{{asset('assets/images/forgotpassword/right.png')}}"/> app/storage/views is folder is Writable
          @else
          <?php $flag = false; ?>
          <img src="{{asset('assets/images/forgotpassword/wrong.png')}}"/>app/storage/views folder is not Writable
          @endif
        </li>
        </ul>
            
            <?php if($flag == false){?>
            <div class="submit_button_main hide">
              <input type="submit" class="submit checkagain" onClick="location.reload(true)" value="Try Again !"/>
            </div>
          <?php }else{ ?>
            <div class="submit_button_main hide">
              <a href="{{url('install/database')}}"> Let's Begin ! </a>
            </div>
          <?php } ?>
          
        </div>
      </div>
      </div>
    </div>
  </div>
  <div class="footer">&copy; 2014 92five app </div>
</section>
<script>
$(document).ready(function() {
           fade_in_next();
        });
var i = 0;
function fade_in_next() {
  $("ul li:hidden:first").fadeIn("slow", function() {
    i=i+1;
    var result = setTimeout(fade_in_next, 500);
    if(i==8)
    {
      $('.submit_button_main').removeClass('hide');
    }    
  });
}

</script>
</script>
</body>
</html>
