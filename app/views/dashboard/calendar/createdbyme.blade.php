@extends('dashboard.default')
@section('head')
<title>92five app - Events Created By Me</title>
@stop
@section('content')

<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <h2><a href="{{url('/dashboard')}}">Dashboard</a> / <a href="{{url('/dashboard/calendar')}}">Calendar</a> / Events Created by Me</h2>
        @if($events != null)
        <div class="view_proj_sec">
          @foreach($events as $event)
          <div class="view_proj_box">
            <div class="view_proj_inner">
              <div class="view_proj_title">
                <div class="view_proj_btn">
                  <div class="p-icon-inner createventicon"><a class="p-icon-1" title="Edit Event" href="{{url('/dashboard/calendar/event/edit',array($event['id']))}}"><img alt="" src="{{asset('assets/images/dashboard/p-edit.png')}}"></a><a class="p-icon-1 delevent" title="Delete Event" eventid={{$event['id']}} href="#"><img alt="" class="delevent" eventid={{$event['id']}} src="{{asset('assets/images/dashboard/p-delete.png')}}"></a></div>
                </div>
              </div>
              <h3>{{$event['title']}}</h3>
              <span class="eventdate">Category: {{$event['category']}}</span>
              <div class="projectview_list_sec">
                <div class="projectview_list">
                  <div class="projectview_left">Date:</div>
                  <div class="projectview_right">
                    <p>{{new ExpressiveDate($event['date'])}}</p>
                  </div>
                </div>
                <div class="projectview_list">
                  <div class="projectview_left">Start Time:</div>
                  <div class="projectview_right">
                    <p>{{date('g:iA', strtotime($event['start_time']))}}</p>
                  </div>
                </div>
                <div class="projectview_list">
                  <div class="projectview_left">End Time:</div>
                  <div class="projectview_right">
                    <p>{{date('g:iA', strtotime($event['end_time']))}}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        @else
        <div class="nodatadisplay_main">
          <div class="nodatadisplay">
            <h2> Sorry. Couldn't find any event.</h2>
            <div class="nodata_inner">
              <div class="nodata_left"></div>
              <div class="nodata_right"></div>
              <div class="nodata_detail_2"><img src="{{asset('assets/images/dashboard/smile_icon.png')}}" alt=""></div>
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@if(Session::has('status') and Session::has('message') )
@if(Session::has('status') == 'success')
<script>
$(document).ready( function() {
  var url = window.location.href;
var tempurl = url.split('dashboard')[0];
iosOverlay({
    text: "{{Session::get('message')}}",
    duration: 5e3,
    icon: tempurl+'images/notifications/check.png'
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
    icon: tempurl+'images/notifications/cross.png'
  });
});
</script>
{{Session::forget('status'); Session::forget('message');}}
@endif
@endif

<!-- Delete Event Popup -->
<div id="myModal-item-delete" class="modal cal_light_box hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Really ?</h3>
  </div>
  <div class="modal-body">
    <div class="confirm-delete">Confirm delete the event?</div>
    <div class="confirm-button">
      <form method="post" action="{{url('dashboard/calendar/event/delete')}}">  <input type="hidden" name="deleteEventId" id="deleteEventId" value=  > <button class="submit">Yes please.</a></button></form>
    <button class="submit dontdelete" id="dontdelete" >No Thanks.</a></button></div>
  </div>
</div>
<!-- End Delete Event Popup-->
@stop
@section('endjs')
<script>
 $(document).on("click", ".delevent", function() {
   var entityid = $(this).attr('eventid');
   $('#deleteEventId').val(entityid);
   $('#myModal-item-delete').modal('show');
 });
 $(document).on("click", ".dontdelete", function() {
   $('#myModal-item-delete').modal('hide');
 });
</script>
  @stop

