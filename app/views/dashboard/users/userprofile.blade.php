@extends('dashboard.default')
@section('head')
<title>92five app - User</title>
@stop
@section('content')
<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <h2><a href="{{url('/dashboard')}}">Dashboard</a> / User - {{$data['mainData']['first_name'].' '.$data['mainData']['last_name']}}</h2>
        <div class="row-fluid roles_detail_main">
          <div class="add_project_main">
            <div class="user_btn_sec">
              @if(Sentry::getUser()->id == $data['mainData']['id'])
              <a class="add_project" href="{{url('dashboard/me/editmydetails')}}">Edit Details</a>
              <a class="add_project" href="{{url('dashboard/me/changemyemail')}}">Change Email</a>
              <a class="add_project" href="{{url('dashboard/me/changemypassword')}}">Change Password</a>
              @endif
            </div>
          </div>
          <div class="user_profile_main">
            <div class="user_profile">
              <div class="profile_detail_1"><img src="{{asset('assets/images/dashboard/user_title.png')}}" alt=""></div>
              <div class="user_profile_inner">
                <div class="user_detail_2">
                  <div class="user_detail_image"><img src="{{url('assets/images/profilepics/')}}/{{$data['mainData']['id']}}.png" alt=""></div>
                  <div class="user_detail_left">
                    <h3>{{$data['mainData']['first_name'].' '.$data['mainData']['last_name']}}</h3>
                    <!--  <span>Gender</span> -->
                  </div>
                </div>
                <div class="user_detail_3">
                  @if($data['profile'] != null and $data['profile']['about'] != null)
                  <p> {{$data['profile']['about']}} </p>
                  @else
                  <p> [Not filled yet]</p>
                  @endif
                </div>
                <div class="user_detail_3">
                  <p><a href="mailto:{{$data['mainData']['email']}}">{{$data['mainData']['email']}}</a></p>
                  @if($data['profile'] != null and $data['profile']['website'] != null)
                  <p><a href="http://{{$data['profile']['website']}}">{{$data['profile']['website']}}</a> </p>
                  @else
                  <p> [No Website yet]</p>
                  @endif
                  @if($data['profile'] != null and $data['profile']['phone'] != null)
                  <p><a href="tel:{{$data['profile']['phone']}}">{{$data['profile']['phone']}}</a></p>
                  @else
                  <p> [No Phone yet]</p>
                  @endif
                </div>
                @if($data['profile'] != null)
                <div class="user_social_sec">
                  <ul>
                    @if($data['profile']['facebook'] != null)
                    <li><a href="http://www.facebook.com/{{$data['profile']['facebook']}}"><img src="{{asset('assets/images/dashboard/user_social_1.png')}}" alt=""></a></li>
                    @else
                    @endif
                    @if($data['profile']['twitter'] != null)
                    <li><a href="http://www.twitter.com/{{$data['profile']['twitter']}}"><img src="{{asset('assets/images/dashboard/user_social_2.png')}}" alt=""></a></li>
                    @else
                    @endif
                    @if($data['profile']['googleplus'] != null)
                    <li><a href="http://plus.google.com/{{$data['profile']['googleplus']}}"><img src="{{asset('assets/images/dashboard/user_social_3.png')}}" alt=""></a></li>
                    @else
                    @endif
                  </ul>
                </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@if(Session::has('status') and Session::has('message') )
@if(Session::has('status') == 'success')
<script>
var url = window.location.href;
var tempurl = url.split('dashboard')[0];
$(document).ready( function() {
iosOverlay({
    text: "{{Session::get('message')}}",
    duration: 5e3,
    icon: tempurl+'assets/images/notifications/check.png'
  });

});
</script>
{{Session::forget('status'); Session::forget('message'); }}
@elseif(Session::has('status') == 'error')
<script>
$(document).ready( function() {
  iosOverlay({
    text: "{{Session::get('message')}}",
    duration: 5e3,
    icon: tempurl+'assets/images/notifications/cross.png'
  });
});
</script>
{{Session::forget('status'); Session::forget('message');}}
@endif
@endif
@stop
@section('endjs')
@stop

