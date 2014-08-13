@extends('dashboard.default')
@section('head')
<title>92five app - Change Email</title>
@stop
@section('content')
<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <h2><a href="{{url('/dashboard')}}">Dashboard</a> / {{$breadCrumb}}</h2>
        <div class="row-fluid change_email">
          <form method='post' id="emailForm"  data-validate="parsley" >
            <h3>Change email address</h3>
            <div class="change_email_inner">
              <div class="email_detail_1">
                <div class="email_detail_2">
                  <div class="span5 email_name">Current email:</div>
                  <div class="span7">{{$oldEmail}}</div>
                </div>
                <div class="email_detail_2">
                  <div class="span5 email_name">New email:</div>
                  <div class="span7"><input type="email" id="newEmail" placeholder="New Email" class="span12" name="newEmail" data-required="true"  data-show-errors="true"></div>
                </div>
                @if($showNote == true)
                <p>Please note that a link will be sent to verify your new email address.  Only after verifying the new  email, your account will be activated again.</p>
                @endif
                <input type="hidden" name="oldemail" id="oldemail" value="{{$oldEmail}}"/>
                <div class="submit_button_main editevent-button">
                  <button class="submit">Update</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@stop
@section('endjs')
{{ HTML::script('assets/js/simplelogin/parsley.js') }}
{{ HTML::style('assets/css/simplelogin/parsley.css') }}
@stop

