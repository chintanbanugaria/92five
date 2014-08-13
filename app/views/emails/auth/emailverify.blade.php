<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="HandheldFriendly" content="True" />
<title>92fiveapp - Email Verification</title>                                                                                                                                                                                                                                                                                                                                                                                                        
<style type="text/css">
	.ReadMsgBody {width: 100%; background-color: #ffffff;}
	.ExternalClass {width: 100%; background-color: #ffffff;}
	body	 {width: 100%; background-color: #ffffff; margin:0; padding:0; -webkit-font-smoothing: antialiased;}
	html {width: 100%; }
	table {border-collapse: collapse;}
	
	@media only screen and (max-width: 640px)  {
					body[yahoo] .deviceWidth {width:440px!important}	
					body[yahoo] .center {text-align: center!important;}	 
					body[yahoo] .footerLinks { width:32%; margin-bottom:40px}
			}
			
	@media only screen and (max-width: 479px) {
					body[yahoo] .deviceWidth {width:280px!important}	
					body[yahoo] .center {text-align: center!important;}	 
					body[yahoo] .footerLinks { width:32%; margin-bottom:40px}
			}

</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" yahoo="fix">
<!-- Wrapper -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td width="100%" valign="top" bgcolor="#ffffff" style="padding-top:20px">
			<!-- Start Header-->
			<table width="580" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth">
				<tr>
					<td width="100%" bgcolor="#ffffff">
                            <!-- Logo -->
                            <table border="0" cellpadding="0" cellspacing="0" align="left" class="deviceWidth">
                                <tr>
                                    <td style="padding:10px 20px" class="center">
                                        <a href="#"><!-- Insert Logo here  --></a>
                                    </td>
                                </tr>
                            </table><!-- End Logo -->
					</td>
				</tr>
			</table><!-- End Header -->
			
			<!-- One Column -->
			<table width="580"  class="deviceWidth" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td valign="top" style="padding:10px 0">
											
					</td>
				</tr>
                <tr>
                    <td style="font-size: 13px; color: #959595; font-weight: normal; text-align: left; font-family: Helvetica, Arial, sans-serif; line-height: 24px; vertical-align: top; padding:25px 0">
                        <a href="#" style="text-decoration: none; color: #272727; font-size: 18px; color: #272727; font-weight: bold; ">Email Verification.</a><br><br/>
                        Hi {{ $name }}, <br/>
						You have change your email address on 92five App. We need to make sure that you haven't made any typo errors.  Please <b style="color: #5b5b5b;"><a href={{$link}} style="text-decoration:none; color:black;">click here</a></b> to verify your new email. <br/>
						
						Alternatively, you can paste the following link into the browser. <br/>
						Link: {{$link}}

						<br/>
						<br/>
						
						Thanks,
						<br/>
						-92five App Team
						<br/>
						P.S. If you have not cahnged your email, please contact administrator.
						 							
                    </td>
                </tr>              
			</table><!-- End One Column -->

			
		</td>
	</tr>
</table> <!-- End Wrapper -->

</body>
</html>
