@extends('dashboard.default')
@section('head')
<title>92five app - Change Password</title>
@stop
@section('content')
	 <!-- main content -->
<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <h2><a href="{{url('/dashboard')}}">Dashboard</a> / {{$breadCrumb}}</h2>
        <div class="row-fluid change_email">
          <h3>Change Password</h3>
          <div class="change_email_inner">
            <div class="row-fluid">
              <form method="post" id="newpassform" name="newpassform" action="">
                <div class="field_main">
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
                </div>
                <input type="hidden" name="userId" id="userId" value="{{$userId}}"/>
                <div class="submit_button_main editevent-button">
                  <button class="submit">Update</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop
@section('endjs')
{{ HTML::script('assets/js/jquery/jquery.complexify.js') }}
{{ HTML::script('assets/js/jquery/jquery.complexify.banlist.js') }}
{{ HTML::script('assets/js/forgotpassword/forgotpassword.js') }}
{{ HTML::script('assets/js/simplelogin/parsley.js') }}
{{ HTML::style('assets/css/simplelogin/parsley.css') }}
@stop

