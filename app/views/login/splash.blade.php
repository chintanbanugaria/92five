<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>92fiveapp - Authenticating</title>
<!-- Loading -->
{{ HTML::style('assets/css/authenticate/style.css') }}
</head>
<body>

<div class="loading_main">
    <div id="loading">
    	<div class="loading_detail">Authenticating....</div>
    	<div id="loading_inner">
        	<div id="loadbar">&nbsp;</div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
// by - coursesweb.net

var ldsec = 2.75;           // define the number of secconds till the progress bar reaches 100%
var ldpercent = 4;         // percentage for loading progress bar
var ldspeed = ldsec * 1000 / (100/ldpercent);         // set the speed for progress bar

// data to be displayed in loading bar, when reaches 100%
// a tag that close the block with the content with the loading bar
//var ldtxt = '<u style="cursor:pointer;" onclick="document.getElementById(\'loading\').style.display=\'none\'">Close</u>';      

// define a recursive function to set and add the progress bar
function simLoad(div) {
  // get the object with the ID from "div", the tag which represents the progress bar
  var dvload = document.getElementById(div);
  ldpercent += 5;           // increments the percentage
  if(ldpercent>100) ldpercent = 100;       // ensure that percentages do not exceed 100

  // change the width of the progress bar, and display the percentage
  dvload.style.width = ldpercent+ '%';
  

  // if the percentage is less than 100, auto-calls this function
  // else, calls the function finLoad()
  if(ldpercent<100) setTimeout("simLoad('"+div+"')", ldspeed);
  else finLoad(dvload);
}

// function that can be executed when the progress bar is completed
// receives the object which contains the tag with the loading bar
function finLoad(divobj) {
  /** Here you can add JavaScript instructions to be executed when the progress bar reaches 100% **/
  window.location.href='{{URL::to('dashboard');}}';

  // adds a close button in the loading bar, to close that block
  
}
  simLoad('loadbar');     // to display the loading bar once the page is loaded
--></script>
</body>


</html>


