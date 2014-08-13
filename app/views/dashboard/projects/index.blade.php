@extends('dashboard.default')
@section('head')
<title>92five app - Projects</title>
@stop
@section('content')
<div id="contentwrapper">
  <div class="main_content" id = "Grid">
    <div class="row-fluid" >
      <div class="span12 project_detail">
        <h2><a href="{{url('/dashboard')}}">Dashboard</a> / Projects</h2>
        <div class="add_project_main">
          @if($data != null)
          <a href="#" data-filter="all" class="add_project filter active pull-left" >All</a>
          <a href="#" data-filter="p_active" class="add_project activeproject filter pull-left" >Active</a>
          <a href="#" data-filter="compeleted" class="add_project complproject filter pull-left" >Completed</a>
          <a href="#" data-filter="delayed" class="add_project delayedproject filter pull-left" >Delayed</a>
          @endif
          @if(Sentry::getUser()->hasAccess('project.create'))
          <a href="{{url('/dashboard/projects/add')}}" class="add_project add-last"> + Add new Project</a>
          @endif
        </div>
        <div class="project_box" >
          @if($data == null)
          <div class="nodatadisplay_main">
            <div class="nodatadisplay">
              <h2>Sorry. Couldn't find any project for you.</h2>
              <div class="nodata_inner">
                <div class="nodata_left"></div>
                <div class="nodata_right"></div>
                <div class="nodata_detail_2"><img src="{{asset('assets/images/dashboard/smile_icon.png')}}" alt=""></div>
              </div>
            </div>
          </div>
          @else
          @foreach($data as $project)
          @if($project['status']=='active')
          <!-- active Box -->
          <div class="span4 mix p_active proj-main-box">
            <h4><span class="p-proj-title"><a href="{{url('/dashboard/projects',array($project['id']))}}">{{$project['project_name']}}</a></span>
            </h4>
            <div class="row-fluid">
              <div class="span12 a_detail_main">
                <div class="row-fluid">
                  <div class="span12 status_a">Status: Active</div>
                </div>
              </div>
            </div>
            <div class="row-fluid">
              <div class="span12 a_detail_main">
                <div class="row-fluid">
                  <div class="span6 project_manager">Start Date: <span>{{new ExpressiveDate($project['start_date'])}}</span></div>
                  <div class="span6 project_manager a_end_date">End Date:
                  <span>{{new ExpressiveDate($project['end_date'])}}</span></div>
                </div>
              </div>
            </div>
            <div class="complete_image"><input class="proj_knob" data-width="190" data-min="0" data-bgColor="#F2F2F2" data-fgColor="#ee8e11" data-thickness=".2" data-displayPrevious=true data-readOnly=true value={{$project['percentage']}}></div>
            <div class="row-fluid assign_list">
              <h5>Assigned to me:</h5>
              <ul>
                <li><a href="{{url('dashboard/tasks')}}">{{$project['my_rem_task']}} of {{$project['my_total_task']}} tasks remaining </a></li>
              </ul>
            </div>
            <div class="row-fluid assign_list">
              <h5>Overall :</h5>
              <ul>
                <li><a href="{{url('dashboard/tasks/project',array($project['id']))}}">{{$project['overall_rem_task']}} of {{$project['overall_task']}} tasks remaining </a></li>
              </ul>
            </div>
          </div>
          @elseif($project['status'] =='completed')
          <div class="span4 mix compeleted proj-main-box">
            <h4><span class="p-proj-title"><a href={{url('/dashboard/projects',array($project['id']))}}>{{$project['project_name']}}</a></span>
            </h4>
            <div class="row-fluid">
              <div class="span12 a_detail_main">
                <div class="row-fluid">
                  <div class="span12 status_c">Status: Completed</div>
                </div>
              </div>
            </div>
            <div class="complete_image c_image"><input class="proj_knob" data-width="190" data-min="0" data-bgColor="#F2F2F2" data-fgColor="#2a6d1a" data-thickness=".2" data-displayPrevious=true data-readOnly=true value={{$project['percentage']}}></div>
            <div class="complete_task">Completed on <br> {{new ExpressiveDate($project['completed_on'])}}</div>
          </div>
          @elseif($project['status'] == 'delayed')
          <div class="span4 mix delayed proj-main-box">
            <h4><span class="p-proj-title"><a href={{url('/dashboard/projects',array($project['id']))}}>{{$project['project_name']}}</a></span>
            </h4>
            <div class="row-fluid">
              <div class="span12 a_detail_main">
                <div class="row-fluid">
                  <div class="span12 status_d">Status: Delayed</div>
                </div>
              </div>
            </div>
            <div class="row-fluid">
              <div class="span12 a_detail_main">
                <div class="row-fluid">
                  <div class="span6 project_manager">Start Date: <span>{{new ExpressiveDate($project['start_date'])}}</span></div>
                  <div class="span6 project_manager a_end_date">End Date: <span>{{new ExpressiveDate($project['end_date'])}}</span></div>
                </div>
              </div>
            </div>
            <div class="complete_image"><input class="proj_knob" data-width="190" data-min="0" data-bgColor="#F2F2F2" data-fgColor="#ca0505" data-thickness=".2" data-displayPrevious=true data-readOnly=true value={{$project['percentage']}}></div>
            <div class="row-fluid assign_list">
              <h5>Assigned to me:</h5>
              <ul>
                <li><a href="{{url('dashboard/tasks')}}">{{$project['my_rem_task']}} of {{$project['my_total_task']}} tasks remaining  </a></li>
              </ul>
            </div>
            <div class="row-fluid assign_list">
              <h5>Overall :</h5>
              <ul>
                <li><a href="{{url('dashboard/tasks/project',array($project['id']))}}">{{$project['overall_rem_task']}} of {{$project['overall_task']}} tasks remaining </a></li>
              </ul>
            </div>
          </div>
          @endif
          @endforeach
          @endif
        </div>
      </div>
    </div>
  </div>
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
@stop
@section('endjs')
{{ HTML::script('assets/js/jquery/jquery.blockUI.js') }}
{{ HTML::script('assets/js/jquery/jquery.knob.js') }}
{{ HTML::script('assets/js/dashboard/taskcompleted.js') }}
{{ HTML::script('assets/js/jquery/jquery.mixitup.js') }}
<script>
$(function() {

  $('.project_box').mixitup({
    effects: ['fade']
  });

});
</script>
@stop

