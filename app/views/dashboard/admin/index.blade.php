@extends('dashboard.default')
@section('head')
<title>92five app - Admin</title>
@stop
@section('content')
 <div id="contentwrapper">
    <div class="main_content">
      <div class="row-fluid">
        <div class="span12 project_detail">
          <h2><a href="{{url('/dashboard')}}">Dashboard</a> / Admin</h2>
            <!-- Reports Section -->
            <div class="row-fluid reports-sec">
              <div class="span3 report-box">
                <h3>Users</h3>
                <div class="report-image"><a href="{{url('dashboard/admin/users')}}"><img src="{{asset('assets/images/dashboard/adminuser.png')}}" alt=""></a></div>
              </div>
              <div class="span3 report-box">
                <h3>Email Settings</h3>
                <div class="report-image"><a href="{{url('dashboard/admin/settings')}}"><img src="{{asset('assets/images/dashboard/emailsettingsicon.png')}}" alt=""/></a></div>
              </div>
              <div class="span3 report-box">
                <h3>Delete / Restore Data </h3>
                <div class="report-image"><a  data-toggle="modal" href="#myModal-deleterestore"><img src="{{asset('assets/images/dashboard/deleterestoreicon.png')}}" alt=""/></a></div>
              </div>
              <div class="span3 report-box">
                <h3>Logs</h3>
                <div class="report-image"><a   href="{{url('dashboard/admin/logs')}}"><img src="{{asset('assets/images/dashboard/logs.png')}}" alt=""/></a></div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
<!-- Delete Restore Template -->
<div id="myModal-deleterestore" class="modal cal_light_box hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Delete / Restore</h3>
  </div>
  <div class="modal-body">
    <div class="confirm-button">
      <form method="post" action="{{url('/dashboard/admin/deleterestore')}}" method='post' data-validate="parsley"> 
        <div class="modal-body">
          <div class="popup_event">
            <div class="add-proj-form">
              <fieldset>
                <div class="row-fluid">
                  <div class="row-fluid">
                    <div class="control-group">
                      <div class="row-fluid">
                        <label class="control-label" for="passwordinput">What do you want to delete / restore :</label>
                          <div class="controls">
                            <div class="task_select">
                              <select name="entity" id="entity" tabindex="1" style="width:270px;">
                                  <option  name="" value="projects" title="">Projects</option>
                                  <option  name="" value="tasks" title="">Tasks</option>
                                  <option  name="" value="events" title="">Calendar Events</option>                      
                              </select>      
                            </div>
                          </div>
                      </div>                                                                             
                    </div>
                  </div>
                </div>
              </fieldset>
            </div>            
          </div> 
        </div>
        <button class="submit">Submit</button>
      </form>
    </div>
  </div>
</div>
<!-- End Delete Restore Template -->
@if(Session::has('status') and Session::has('message') )
@if(Session::has('status') == 'success')
<script>
$(document).ready( function() {
  var url = window.location.href;
  var tempurl = url.split('dashboard')[0];
  iosOverlay({
      text: "{{Session::get('message')}}",
      duration: 5e3,
      icon: tempurl+'assets/images/notifications/check.png'
  });
});
</script>
{{Session::forget('status'); Session::forget('message');}}
@elseif(Session::has('status') == 'error')
<script>
$(document).ready( function() {
  var url = window.location.href;
  var tempurl = url.split('dashboard')[0];
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

