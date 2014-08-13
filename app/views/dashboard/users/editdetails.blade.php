@extends('dashboard.default')
@section('head')
<title>92five app - Edit Profile</title>
@stop
@section('content')
<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <h2><a href="{{url('/dashboard')}}">Dashboard</a> / <a href="{{url('/dashboard/me')}}">Me</a> / Edit My Details</h2>
        <form class="form-horizontal" method="post"  data-validate="parsley" >
          <div class="row-fluid change_email edit_user_sec">
            <h3>
            <div class="span6"><input type="text" name="first_name" class="edit_user_input" placeholder="First Name" data-required="true"  data-show-errors="false" value="{{$data['mainData']['first_name']}}"></div>
            <div class="span6"><input type="text" name="last_name" class="edit_user_input" placeholder="Last Name" data-required="true"  data-show-errors="false" value="{{$data['mainData']['last_name']}}"></div>
            </h3>
            <div class="change_email_inner">
              <div class="row-fluid">
                <div class="span6 edit_user_left">
                  <fieldset>
                    <div class="control-group">
                      @if(sizeof($data['profile'] != 0 && $data['profile']['about'] != null))
                      <textarea class="add-proj-form-t" name="about" placeholder="About me">{{$data['profile']['about']}}</textarea>
                      @else
                      <textarea class="add-proj-form-t" name="about" placeholder="About me"></textarea>
                      @endif
                    </div>
                    <div class="control-group">
                      @if(sizeof($data['profile'] != 0 && $data['profile']['website'] != null))
                      <input id="passwordinput" name="website" type="text" class="span12 pull-left" placeholder="Blog" value="{{$data['profile']['website']}}">
                      @else
                      <input id="passwordinput" name="website" type="text" class="span12 pull-left" placeholder="Blog">
                      @endif
                    </div>
                    <div class="control-group">
                      @if(sizeof($data['profile'] != 0 && $data['profile']['phone'] != null))
                      <input id="passwordinput" name="phone" type="text" class="span12 pull-left" placeholder="Mobile" value="{{$data['profile']['phone']}}">
                      @else
                      <input id="passwordinput" name="phone" type="text" class="span12 pull-left" placeholder="Mobile">
                      @endif
                    </div>
                  </fieldset>
                </div>
                <div class="span6 edit_user_right">
                  <fieldset>
                    <div class="edituser_detail_1">
                      <div class="edituser_social"><img src="{{asset('assets/images/dashboard/social_1.png')}}" alt=""></div>
                      <div class="edituser_detail_right">
                        <div class="control-group">
                          @if(sizeof($data['profile'] != 0 && $data['profile']['facebook'] != null))
                          <input id="passwordinput" name="facebook" type="text" class="span12 pull-left" placeholder="Facebook" value="{{ $data['profile']['facebook']}}">
                          @else
                          <input id="passwordinput" name="facebook" type="text" class="span12 pull-left" placeholder="Facebook">
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="edituser_detail_1">
                      <div class="edituser_social"><img src="{{asset('assets/images/dashboard/social_2.png')}}" alt=""></div>
                      <div class="edituser_detail_right">
                        <div class="control-group">
                          @if(sizeof($data['profile'] != 0 && $data['profile']['twitter'] != null))
                          <input id="passwordinput" name="twitter" type="text" class="span12 pull-left" placeholder="Twitter" value="{{$data['profile']['twitter']}}" >
                          @else
                          <input id="passwordinput" name="twitter" type="text" class="span12 pull-left" placeholder="Twitter">
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="edituser_detail_1">
                      <div class="edituser_social"><img src="{{asset('assets/images/dashboard/social_3.png')}}" alt=""></div>
                      <div class="edituser_detail_right">
                        <div class="control-group">
                          @if(sizeof($data['profile'] != 0 && $data['profile']['googleplus'] != null))
                          <input id="passwordinput" name="googleplus" type="text" class="span12 pull-left" placeholder="Google +" value="{{ $data['profile']['googleplus']}}">
                          @else
                          <input id="passwordinput" name="googleplus" type="text" class="span12 pull-left" placeholder="Google +">
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="submit_button_main editevent-button">
                      <button class="submit">Update</button>
                    </div>
                  </fieldset>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop
@section('endjs')
{{ HTML::style('assets/css/simplelogin/parsley.css') }}
{{ HTML::script('assets/js/simplelogin/parsley.js') }}
@stop

