@extends('dashboard.default')
@section('head')
<title>92five app - Reports</title>
@stop
@section('content')
<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <h2><a href="{{url('/dashboard')}}">Dashboard</a> / Reports</h2>
        <!-- Reports Section -->
        <div class="row-fluid reports-sec">
          <div class="span3 report-box">
            <h3>My Weekly Report</h3>
            <div class="report-image"><a href="#" ><img id="weeklytoggle" src="{{asset('assets/images/reports/weekly_icon.png')}}" alt=""></a></div>
            <ul  id="weeklytoggledata" class="admin_listing hide">
              <li><a  data-toggle="modal" href="#myModal-weeklyall">Complete Weekly Report</a></li>
              <li><a data-toggle="modal" href="#myModal-weeklytask">Task Weekly Report</a></li>
              <li><a data-toggle="modal" href="#myModal-weeklyproject">Project Weekly Report</a></li>
            </ul>
          </div>
          <div class="span3 report-box">
            <h3>My Monthly Report</h3>
            <div class="report-image"><a href="#"><img id="monthlytoggle" src="{{asset('assets/images/reports/monthly_icon.png')}}" alt=""/></a></div>
            <ul id="monthlytoggledata" class="admin_listing hide">
              <li><a  data-toggle="modal" href="#myModal-monthlyall">Complete Monthly Report</a></li>
              <li><a data-toggle="modal" href="#myModal-monthlytask">Task Monthly Report</a></li>
              <li><a data-toggle="modal" href="#myModal-monthlyproject">Project Monthly Report</a></li>
            </ul>
          </div>
          <div class="span3 report-box">
            <h3>Project Report</h3>
            <div class="report-image"><a  data-toggle="modal" href="#myModal-projectreport"><img src="{{asset('assets/images/reports/project_report_icon.png')}}" alt=""></a></div>
          </div>
          @if(Sentry::getUser()->inGroup(Sentry::getGroupProvider()->findByName('admin')) or Sentry::getUser()->inGroup(Sentry::getGroupProvider()->findByName('manager')) or Sentry::getUser()->inGroup(Sentry::getGroupProvider()->findByName('leader')) )
          <div class="span3 report-box">
            <h3>User Report</h3>
            <div class="report-image"><a  data-toggle="modal" href="#myModal-monthlyuserproject"><img src="{{asset('assets/images/reports/userreport.png')}}" alt=""></a></div>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Start Weekly All template -->
<div id="myModal-weeklyall" class="modal cal_light_box hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Complete Weekly Report</h3>
  </div>
  <div class="modal-body">
    <div class="confirm-button">
      <form method="post" action="{{url('/dashboard/reports/weekly')}}" method='post' data-validate="parsley">
        <div class="modal-body">
          <div class="popup_event">
            <div class="add-proj-form">
              <fieldset>
                <div class="row-fluid">
                  <div class="control-group">
                    <div class="row-fluid">
                      <label class="control-label" for="passwordinput">Select any day of the required week:</label>
                      <input id="date" name="date" type="text" class="span6 pull-left" placeholder="Date" data-required="true" data-trigger="change">
                    </div>
                  </div>
                </fieldset>
              </div>
            </div>
          </div>
        <button class="submit">Submit</a></button>
      </form>
    </div>
  </div>
</div>
 <!-- End Weekly All Tempate -->
<!-- Start Weekly Task template -->
<div id="myModal-weeklytask" class="modal cal_light_box hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Task Weekly Report</h3>
  </div>
  <div class="modal-body">
    <div class="confirm-button">
      <form method="post" action="{{url('/dashboard/reports/weeklytask')}}" method='post' data-validate="parsley">
        <div class="modal-body">
          <div class="popup_event">
            <div class="add-proj-form">
              <fieldset>
                <div class="row-fluid">
                  <div class="control-group">
                    @if($tasks != null)
                    <div class="row-fluid">
                      <label class="control-label" for="passwordinput">Select any day of the required week:</label>
                      <input id="weektaskdate" name="weektaskdate" type="text" class="span6 pull-left" placeholder="Date" data-required="true" data-trigger="change">
                    </div>
                    @else
                    <div class="row-fluid">
                      <label class="control-label" for="passwordinput">Select any day of the required week:</label>
                      <input id="weektaskdate" name="weektaskdate" disabled type="text" class="span6 pull-left" placeholder="Date" data-required="true" data-trigger="change">
                    </div>
                    @endif
                  </div>
                  <div class="row-fluid">
                    <div class="control-group">
                      <div class="row-fluid">
                        <label class="control-label" for="passwordinput">Select Task:</label>
                        <div class="controls">
                          <div class="task_select">
                            @if($tasks != null)
                            <select name="task" id="task" tabindex="1" style="width:270px;">
                              @foreach($tasks as $task)
                              <option  name="" value={{$task['id']}} title="">{{$task['name']}}</option>
                              @endforeach
                            </select>
                            @else
                            <select name="task" id="task" disabled tabindex="1" style="width:270px;">
                              <option  name="" value="others" title="">No Tasks</option>
                            </select>
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                  </fieldset>
                </div>
              </div>
            </div>
            @if($tasks !=null)
            <button class="submit">Submit</button>
            @else
            <button class="submit" disabled>Submit</button>
            @endif
          </form>
        </div>
      </div>
    </div>
<!-- End Weekly Task Tempate -->
<!-- Weekly Project template -->
<div id="myModal-weeklyproject" class="modal cal_light_box hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Project Weekly Report</h3>
  </div>
  <div class="modal-body">
    <div class="confirm-button">
      <form method="post" action="{{url('/dashboard/reports/weeklyproject')}}" method='post' data-validate="parsley">
        <div class="modal-body">
          <div class="popup_event">
            <div class="add-proj-form">
              <fieldset>
                <div class="row-fluid">
                  <div class="control-group">
                    @if($projects != null)
                    <div class="row-fluid">
                      <label class="control-label" for="passwordinput">Select any day of the required week:</label>
                      <input id="weekprojectdate" name="weekprojectdate" type="text" class="span6 pull-left" placeholder="Date" data-required="true" data-trigger="change">
                    </div>
                    @else
                    <div class="row-fluid">
                      <label class="control-label" for="passwordinput">Select any day of the required week:</label>
                      <input id="weekprojectdate" name="weekprojectdate" disabled type="text" class="span6 pull-left" placeholder="Date" data-required="true" data-trigger="change">
                    </div>
                    @endif
                  </div>
                  <div class="row-fluid">
                    <div class="control-group">
                      <div class="row-fluid">
                        <label class="control-label" for="passwordinput">Select Project:</label>
                        <div class="controls">
                          <div class="task_select">
                            @if($projects != null)
                            <select name="project" id="project" tabindex="1" style="width:270px;">
                              @foreach($projects as $project)
                              <option  name="" value={{$project['id']}} title="">{{$project['project_name']}}</option>
                              @endforeach
                            </select>
                            @else
                            <select name="project" id="project" disabled tabindex="1" style="width:270px;">
                              <option  name="" value="others" title="">No Projects</option>
                            </select>
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                  </fieldset>
                </div>
              </div>
            </div>
            @if($projects != null)
          <button class="submit">Submit</a></button>
          @else
          <button class="submit" disabled>Submit</button>
          @endif
        </form>
      </div>
    </div>
  </div>
<!-- End Weekly Project Template -->
<!-- Monthly All template -->
<div id="myModal-monthlyall" class="modal cal_light_box hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Complete Monthly Report</h3>
  </div>
  <div class="modal-body">
    <div class="confirm-button">
      <form method="post" action="{{url('/dashboard/reports/monthly')}}" method='post' data-validate="parsley">
        <div class="modal-body">
          <div class="popup_event">
            <div class="add-proj-form">
              <fieldset>
                <div class="row-fluid">
                  <div class="control-group">
                    <div class="row-fluid">
                      <label class="control-label" for="passwordinput">Select month:</label>
                      <input id="monthall" name="monthall" type="text" class="span6 pull-left" placeholder="Date" data-required="true" data-trigger="change">
                    </div>
                  </div>
                </fieldset>
              </div>
            </div>
          </div>
        <button class="submit">Submit</a></button>
      </form>
    </div>
  </div>
</div>
<!-- End Monthly All Tempate -->
<!-- Monthly Task Template -->
<div id="myModal-monthlytask" class="modal cal_light_box hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Task Monthly Report</h3>
  </div>
  <div class="modal-body">
    <div class="confirm-button">
      <form method="post" action="{{url('/dashboard/reports/monthlytask')}}" method='post' data-validate="parsley">
        <div class="modal-body">
          <div class="popup_event">
            <div class="add-proj-form">
              <fieldset>
                <div class="row-fluid">
                  <div class="control-group">
                    @if($tasks != null)
                    <div class="row-fluid">
                      <label class="control-label" for="passwordinput">Select any day of the required month:</label>
                      <input id="monthtaskdate" name="monthtaskdate" type="text" class="span6 pull-left" placeholder="Date" data-required="true" data-trigger="change">
                    </div>
                    @else
                    <div class="row-fluid">
                      <label class="control-label" for="passwordinput">Select any day of the required month:</label>
                      <input id="monthtaskdate" name="monthtaskdate" disabled type="text" class="span6 pull-left" placeholder="Date" data-required="true" data-trigger="change">
                    </div>
                    @endif
                  </div>
                  <div class="row-fluid">
                    <div class="control-group">
                      <div class="row-fluid">
                        <label class="control-label" for="passwordinput">Select Task:</label>
                        <div class="controls">
                          <div class="task_select">
                            @if($tasks != null)
                            <select name="monthtask" id="monthtask" tabindex="1" style="width:270px;">
                              @foreach($tasks as $task)
                              <option  name="" value={{$task['id']}} title="">{{$task['name']}}</option>
                              @endforeach
                            </select>
                            @else
                            <select name="monthtask" id="monthtask" disabled tabindex="1" style="width:270px;">
                              <option  name="" value="others" title="">No Projects</option>
                            </select>
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                  </fieldset>
                </div>
              </div>
            </div>
            @if($tasks != null)
            <button class="submit">Submit</button>
            @else
            <button class="submit" disabled>Submit</button>
            @endif
          </form>
        </div>
      </div>
    </div>
<!-- End Monthly Task Template -->
<!-- Monthly Project Template -->
<div id="myModal-monthlyproject" class="modal cal_light_box hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Project Monthly Report</h3>
  </div>
  <div class="modal-body">
    <div class="confirm-button">
      <form method="post" action="{{url('/dashboard/reports/monthlyproject')}}" method='post' data-validate="parsley">
        <div class="modal-body">
          <div class="popup_event">
            <div class="add-proj-form">
              <fieldset>
                <div class="row-fluid">
                  <div class="control-group">
                    @if($projects != null)
                    <div class="row-fluid">
                      <label class="control-label" for="passwordinput">Select any day of the month:</label>
                      <input id="monthprojectdate" name="monthprojectdate" type="text" class="span6 pull-left" placeholder="Date" data-required="true" data-trigger="change">
                    </div>
                    @else
                    <div class="row-fluid">
                      <label class="control-label" for="passwordinput">Select any day of the month:</label>
                      <input id="monthprojectdate"  disabled name="monthprojectdate" type="text" class="span6 pull-left" placeholder="Date" data-required="true" data-trigger="change">
                    </div>
                    @endif
                  </div>
                  <div class="row-fluid">
                    <div class="control-group">
                      <div class="row-fluid">
                        <label class="control-label" for="passwordinput">Select Project:</label>
                        <div class="controls">
                          <div class="task_select">
                            @if($projects != null)
                            <select name="monthproject" id="monthproject" tabindex="1" style="width:270px;">
                              @foreach($projects as $project)
                              <option  name="" value={{$project['id']}} title="">{{$project['project_name']}}</option>
                              @endforeach
                            </select>
                            @else
                            <select name="monthproject" id="monthproject" disabled tabindex="1" style="width:270px;">
                              <option  name="" value="others" title="">No Projects</option>
                            </select>
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                  </fieldset>
                </div>
              </div>
            </div>
            @if($projects != null)
          <button class="submit">Submit</a></button>
          @else
        <button class="submit" disabled>Submit</a></button>
        @endif
      </form>
    </div>
  </div>
</div>
<!-- End Monthly Project Template -->
<!-- Project Report Template -->
<div id="myModal-projectreport" class="modal cal_light_box hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Project Report</h3>
  </div>
  <div class="modal-body">
    <div class="confirm-button">
      <form method="post" action="{{url('/dashboard/reports/projectreport')}}" method='post' data-validate="parsley">
        <div class="modal-body">
          <div class="popup_event">
            <div class="add-proj-form">
              <fieldset>
                <div class="row-fluid">
                  <div class="row-fluid">
                    <div class="control-group">
                      <div class="row-fluid">
                        <label class="control-label" for="passwordinput">Select Project:</label>
                        <div class="controls">
                          <div class="task_select">
                            @if($projects != null)
                            <select name="projectid" id="projectid" tabindex="1" style="width:270px;">
                              @foreach($projects as $project)
                              <option  name="" value={{$project['id']}} title="">{{$project['project_name']}}</option>
                              @endforeach
                            </select>
                            @else
                            <select name="projectid" disabled id="projectid" tabindex="1" style="width:270px;">
                              <option  name="" value="others" title="">No Projects</option>
                            </select>
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                  </fieldset>
                </div>
              </div>
            </div>
            @if($projects != null)
            <button class="submit">Submit</button>
            @else
            <button class="submit" disabled>Submit</button>
            @endif
          </form>
        </div>
      </div>
    </div>
<!-- End Project Report Template -->
<!-- Monthly User Project Template -->
<div id="myModal-monthlyuserproject" class="modal cal_light_box hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Project User Monthly Report</h3>
  </div>
  <div class="modal-body">
    <div class="confirm-button">
      <form method="post" action="{{url('/dashboard/reports/usermonthlyproject')}}" method='post' data-validate="parsley">
        <div class="modal-body">
          <div class="popup_event">
            <div class="add-proj-form">
              <fieldset>
                <div class="row-fluid">
                  <div class="control-group">
                    <div class="row-fluid">
                      <label class="control-label" for="passwordinput">Select any day of the month:</label>
                      <input id="userprojectdate" name="userprojectdate" type="text" class="span6 pull-left" placeholder="Date" data-required="true" data-trigger="change">
                    </div>
                  </div>
                  <div class="row-fluid">
                    <div class="control-group">
                      <div class="row-fluid">
                        <label class="control-label" for="passwordinput">Select Project:</label>
                        <div class="controls">
                          <div class="task_select">
                            @if($projects != null)
                            <select name="projectmonth" id="projectmonth" tabindex="1" style="width:270px;" data-required="true" data-trigger="change">
                              <option  name="" value="" title="" selected>select project</option>
                              @foreach($projects as $project)
                              <option  name="" value={{$project['id']}} title="">{{$project['project_name']}}</option>
                              @endforeach
                            </select>
                            @else
                            <select name="projectmonth" disabled id="projectmonth" tabindex="1" style="width:270px;" data-required="true" data-trigger="change">
                              <option  name="" value="others" title="">No Projects</option>
                            </select>
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="control-group">
                      <div class="row-fluid">
                        <label class="control-label" for="passwordinput">Select User:</label>
                        <div class="controls">
                          <div class="task_select">
                            <select name="userprojectreportid" id="userprojectreportid" tabindex="1" data-required="true" data-trigger="change" disabled style="width:270px;">
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </fieldset>
                </div>
              </div>
            </div>
            @if($projects != null)
          <button class="submit">Submit</a></button>
          @else
        <button class="submit" disabled>Submit</a></button>
        @endif
      </form>
    </div>
  </div>
</div>
<!--  End Monthly User Project Template -->
@stop
@section('endjs')
{{ HTML::style('assets/css/dashboard/pickadate.css') }}
{{ HTML::style('assets/css/dashboard/pickadate.date.css') }}
{{ HTML::style('assets/css/simplelogin/parsley.css') }}
{{ HTML::script('assets/js/dashboard/legacy.js') }}
{{ HTML::script('assets/js/dashboard/picker.js') }}
{{ HTML::script('assets/js/dashboard/picker.date.js') }}
{{ HTML::script('assets/js/simplelogin/parsley.js') }}
{{ HTML::script('assets/js/dashboard/projectusers.js') }}
<script>
$(function() {
  var userCollection = new UserCollection();
  var userView = new UserView({
    model: userCollection
  });
});
$('#date').pickadate({
  formatSubmit: 'yyyy-mm-dd'
});
$('#weektaskdate').pickadate({
  formatSubmit: 'yyyy-mm-dd'
});
$('#weekprojectdate').pickadate({
  formatSubmit: 'yyyy-mm-dd'
});
$('#monthall').pickadate({
  format: 'mmmm, yyyy',
  formatSubmit: 'yyyy-mm'
});
$('#monthtaskdate').pickadate({
  format: 'mmmm, yyyy',
  formatSubmit: 'yyyy-mm'
});
$('#monthprojectdate').pickadate({
  format: 'mmmm, yyyy',
  formatSubmit: 'yyyy-mm'
});
$('#userprojectdate').pickadate({
  format: 'mmmm, yyyy',
  formatSubmit: 'yyyy-mm'
});
$(document).ready(function() {
  $('#weeklytoggle').click(function() {
    $("#weeklytoggledata").slideToggle();
  });
  $('#monthlytoggle').click(function() {
    $("#monthlytoggledata").slideToggle();
  });
});
</script>
@stop

