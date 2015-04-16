@extends('dashboard.default')
@section('head')
<title>92five app - {{trans('92five.changeEmail')}}</title>
@stop
@section('content')
<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <h2><a href="{{url('/dashboard')}}">{{trans('92five.Dashboard')}}</a> / {{$breadCrumb}}</h2>
        <div class="row-fluid change_email">
          <form method='post' id="emailForm"  data-validate="parsley" >
            <h3>{{trans('92five.changeEmailAddress')}}</h3>
            <div class="change_email_inner">
              <div class="email_detail_1">
                <div class="email_detail_2">
                  <div class="span5 email_name">{{trans('92five.currentEmail')}}:</div>
                  <div class="span7">{{$oldEmail}}</div>
                </div>
                <div class="email_detail_2">
                  <div class="span5 email_name">{{trans('92five.newEmail')}}:</div>
                  <div class="span7"><input type="email" id="newEmail" placeholder="New Email" class="span12" name="newEmail" data-required="true"  data-show-errors="true"></div>
                </div>
                @if($showNote == true)
                <p>{{trans('92five.changeEmailNote')}}</p>
                @endif
                <input type="hidden" name="oldemail" id="oldemail" value="{{$oldEmail}}"/>
                <div class="submit_button_main editevent-button">
                  <button class="submit">{{trans('92five.update')}}</button>
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

