@extends('dashboard.default')
@section('head')
<title>92five app - View Project</title>
@stop
@section('content')

<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <h2><a href="{{url('/dashboard')}}">Dashboard</a> / <a href="{{url('/dashboard/projects')}}">Projects</a> / {{$project['project_name']}}</h2>
        @if($project['status'] == 'active')
        <div class="row-fluid proj_active">
          @elseif($project['status'] == 'completed')
          <div class="row-fluid proj_active proj_comp">
            @elseif($project['status'] == 'delayed')
            <div class="row-fluid proj_active proj_delayed">
              @endif
              <h3>
              <span>{{$project['project_name']}}</span>
              <div class="p-icon-main">
                @if(Sentry::getUser()->hasAccess('project.update'))
                <a href="{{url('/dashboard/projects/edit',array($project['id']))}}" class="p-icon-1" title="Edit Project"><img src="{{asset('assets/images/dashboard/p-edit.png')}}" alt=""></a>
                @endif
                @if(Sentry::getUser()->hasAccess('project.delete'))
                <a href="#myModal-item-delete" data-toggle="modal"  class="p-icon-1" title="Delete Project"><img src="{{asset('assets/images/dashboard/p-delete.png')}}" alt=""></a>
                @endif
              </div>
              </h3>
              <div class="row-fluid span12 proj_active_detail">
                <div class="row-fluid">
                  <!-- Left Part -->
                  <div class="span6 proj_active_left">
                    <div class="span12 proj_active_progress">
                      <div class="proj_active_image">
                        @if($project['status'] == 'active')
                        <input class="proj_knob" data-width="190" data-min="0" data-bgColor="#F2F2F2" data-fgColor="#ee8e11" data-thickness=".2" data-displayPrevious=true data-readOnly=true value={{$project['percentage']}}>
                        @elseif($project['status'] == 'completed')
                        <input class="proj_knob" data-width="190" data-min="0" data-bgColor="#F2F2F2" data-fgColor="#2a6d1a" data-thickness=".2" data-displayPrevious=true data-readOnly=true value={{$project['percentage']}}>
                        @elseif($project['status'] == 'delayed')
                        <input class="proj_knob" data-width="190" data-min="0" data-bgColor="#F2F2F2" data-fgColor="#ca0505" data-thickness=".2" data-displayPrevious=true data-readOnly=true value={{$project['percentage']}}>
                        @endif
                      </div>
                    </div>
                    <div class="row-fluid span12 start-d-main">
                      @if($project['status'] == 'active')
                      <div class="status_a">Status: Active</div>
                      @elseif($project['status'] == 'delayed')
                      <div class="status_d">Status: Delayed</div>
                      @elseif($project['status'] == 'completed')
                      <div class="status_c">Status: Completed</div>
                      @endif
                      <div class="row-fluid">
                        <div class="span4 start-d-1">Start date: </div>
                        <div class="span8 start-d-2">{{new ExpressiveDate($project['start_date'])}}</div>
                      </div>
                      <div class="row-fluid">
                        <div class="span4 start-d-1">End date: </div>
                        @if($project['status'] == 'delayed')
                        @if($project['end_date'] != null)
                        <div class="span8 start-d-2 delayed_end_date">{{new ExpressiveDate($project['end_date'])}}</div>
                        @else
                        <div class="span8 start-d-2">[ No End Date has been Specified ]</div>
                        @endif
                        @else
                        @if($project['end_date'] != null)
                        <div class="span8 start-d-2">{{new ExpressiveDate($project['end_date'])}}</div>
                        @else
                        <div class="span8 start-d-2">[ No End Date has been Specified ]</div>
                        @endif
                        @endif
                      </div>
                    </div>
                    <div class="row-fluid span12 proj_act_descr">
                      <h4>Description:</h4>
                      @if($project['description'] != null)
                      <p>{{$project['description']}} </p>
                      @else
                      <div class="no_file" > [No Description for this Project ]</div>
                      @endif
                    </div>
                    <div class="row-fluid span12 proj_act_descr">
                      <h4>Note:</h4>
                      <p>@if($project['note'] != null)
                      {{$project['note']}}
                      @else
                      [ No Note for this project ]
                      @endif
                      </p>
                    </div>
                  </div>
                  <!-- Right Part -->
                  <div class="span6 proj_active_right">
                    <div class="row-fluid span12 a_reamining">
                      <h4>Tasks:</h4>
                      @if($project['total_tasks'] != 0)
                      <h4><img src="{{asset('assets/images/dashboard/p_arrow.png')}}" alt=""><a class="projecttaskrem" href="{{url('/dashboard/tasks/project',array($project['id']))}}">{{$project['uncompl_tasks']}} out of {{$project['total_tasks']}} remaining</a></h4>
                      @else
                      <div class="no_file"> [ No Tasks for this Project ]</div>
                      @endif
                    </div>
                    <div class="row-fluid span12 a_reamining">
                      <h4>Files:</h4>
                      @if($files == null)
                      <div class ="no_file" >
                        [ No files are attached with this project ]
                      </div>
                      @else
                      <ul class="files_1">
                        @foreach($files as $file)
                        <li>
                          <a href="{{url('/dashboard/download',array($file['key']))}}">
                            @if(strlen($file['file_name']) > 30)
                            {{substr($file['file_name'],0,30).' ...'}}
                            @else
                            {{$file['file_name']}}
                            @endif
                          </a>
                          <span class="view_proj_filedesc">{{$file['size']}} Uploaded on {{new ExpressiveDate($file['uploaded_date'])}} by {{User::where('id',$file['uploaded_by'])->pluck('first_name')}} {{User::where('id',$file['uploaded_by'])->pluck('last_name')}}</span>
                        </li>
                        @endforeach
                      </ul>
                      @endif
                    </div>
                    <div class="row-fluid span12 a_reamining">
                      <h4>Collaborators:</h4>
                      @if($project['status'] == 'active')
                      <ul class="collaborators">
                        @elseif($project['status'] == 'completed')
                        <ul class="collaborators_comp">
                          @elseif($project['status'] == 'delayed')
                          <ul class="collaborators_delayed">
                            @endif
                            @foreach($users as $user)
                            <li><a href="{{url('/dashboard/user',array($user['id']))}}">{{$user['first_name']." ".$user['last_name']}}</a></li>
                            @endforeach
                          </ul>
                        </div>
                        <div class="row-fluid span12 a_reamining">
                          <h4>Client:</h4>
                          <ul class="reamining_1">
                            @if($project['project_client'] == null or $project['project_client'] == '')
                            <li>[ No Client has been specified ]</li>
                            @else
                            <li>{{$project['project_client']}}</li>
                            @endif
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<!-- Delete popup  -->
<div id="myModal-item-delete" class="modal cal_light_box hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Really ?</h3>
  </div>
  <div class="modal-body">
    <div class="confirm-delete">Confirm delete the Proect?</div>
    <div class="confirm-button">
      <form method="post" action="{{url('/dashboard/projects/delete')}}">  <input type="hidden" name="projectId" id="projectId" value="{{$project['id']}}"  > <button class="submit">Yes please.</a></button></form>
    <button class="submit dontdelete" id="dontdelete" >No Thanks.</a></button></div>
  </div>
</div>
<!-- End Delete Popup -->

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
{{ HTML::script('assets/js/jquery/jquery.knob.js') }}
{{ HTML::script('assets/js/dashboard/taskcompleted.js') }}
<script>
                $(document).on("click", ".dontdelete", function() {

                  $('#myModal-item-delete').modal('hide');
                });
</script>
  @stop

