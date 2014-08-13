@extends('dashboard.default')
@section('head')
<title>92five app - Delete - Restore Data</title>
@stop
@section('content')
<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <h2><a href="{{url('/dashboard')}}">Dashboard</a> / <a href="{{url('/dashboard/admin')}}">Admin</a> / Delete - Restore for {{$type}}</h2>
        <!-- Button -->
        @if($data != null)
        <div class="restore_sec">
          <a data-toggle="modal" href="#myModal-restoreall" class="restore_btn">Restore All</a>
          <a data-toggle="modal" href="#myModal-deleteall" class="restore_del_btn">Delete All</a>
        </div>
        <!-- Project -->
        <div class="view_proj_sec">
          @foreach($data as $entity)
          <!-- View Project Box -->
          <div class="view_proj_box">
            <div class="view_proj_inner">
              <div class="view_proj_title">
                <span>{{$entity['id']}}</span>
                <div class="view_proj_btn">
                  <a href="#" class="restore_btn2 restorethis" entityid={{$entity['id']}} type={{strtolower($type)}}>Restore</a>
                  <a href="#" class="restore_del_btn2 deletethis" entityid={{$entity['id']}} type={{strtolower($type)}}>Delete</a>
                </div>
              </div>
              <h3>{{$entity['name']}}</h3>
              @if($type == 'Events')
              <span class="eventdate">Date: {{new ExpressiveDate($entity['date'])}}</span>
              @endif
              <div class="projectview_list_sec">
                <div class="projectview_list">
                  <div class="projectview_left">created at:</div>
                  <div class="projectview_right">
                    <p>{{new ExpressiveDate($entity['created_at'])}}</p>
                  </div>
                </div>
                <div class="projectview_list">
                  <div class="projectview_left">updated at:</div>
                  <div class="projectview_right">
                    <p>{{new ExpressiveDate($entity['updated_at'])}}</p>
                  </div>
                </div>
                <div class="projectview_list">
                  <div class="projectview_left">deleted at:</div>
                  <div class="projectview_right">
                    <p>{{new ExpressiveDate($entity['deleted_at'])}}</p>
                  </div>
                </div>
                <div class="projectview_list">
                  <div class="projectview_left">deleted by:</div>
                  <div class="projectview_right">
                    <p>{{$entity['user'][0]['first_name'].' '.$entity['user'][0]['last_name']}}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        @else
        <div class="no_project_main">
          <div class="span12">
            <div class="span12 compeleted proj-main-box">
              <div class="nodatadisplay_main">
                <div class="nodatadisplay">
                  <h2>Sorry. Couldn't find any data to delete / restore.</h2>
                  <div class="nodata_inner">
                    <div class="nodata_left"></div>
                    <div class="nodata_right"></div>
                    <div class="nodata_detail_2"><img src="{{asset('assets/images/dashboard/smile_icon.png')}}" alt=""></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
<!-- Delete All popup  -->
<div id="myModal-deleteall" class="modal cal_light_box hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Really ?</h3>
  </div>
  <div class="modal-body">
    <div class="confirm-delete">Permanently delete the {{$type}}?</div>
    <div class="confirm-button">
    <form method="post" action="{{url('/dashboard/admin/data/deleteall',array(strtolower($type)))}}">   <button class="submit">Yes please.</a></button></form>
  <button class="submit dontdelete" id="dontdelete" >No Thanks.</a></button></div>
</div>
</div>
<!-- End Delete All Popup -->
<!-- Restore All popup  -->
<div id="myModal-restoreall" class="modal cal_light_box hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Really ?</h3>
  </div>
  <div class="modal-body">
    <div class="confirm-delete">Confirm restore the {{$type}}?</div>
    <div class="confirm-button">
    <form method="post" action="{{url('/dashboard/admin/data/restoreall',array(strtolower($type)))}}">   <button class="submit">Yes please.</a></button></form>
  <button class="submit dontdelete" id="dontdelete" >No Thanks.</a></button></div>
</div>
</div>
<!-- End Restore All Popup -->
<!-- Delete popup  -->
<div id="entity-delete" class="modal cal_light_box hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Really ?</h3>
  </div>
  <div class="modal-body">
    <div class="confirm-delete">Confirm delete ?</div>
    <div class="confirm-button">
      <form method="post" action="{{url('/dashboard/admin/data/delete')}}">  <input type="hidden" name="entitytype" id="entitytype" value=""  > <input type="hidden" name="entityid" id="entityid" value=""  ><button class="submit">Yes please.</a></button></form>
    <button class="submit dontdelete" id="dontdelete" >No Thanks.</a></button></div>
  </div>
</div>
<!-- end delete popup -->
<!-- Restore popup  -->
<div id="entity-restore" class="modal cal_light_box hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Really ?</h3>
  </div>
  <div class="modal-body">
    <div class="confirm-delete">Confirm restore ?</div>
    <div class="confirm-button">
      <form method="post" action="{{url('/dashboard/admin/data/restore')}}">  <input type="hidden" name="restoreentitytype" id="restoreentitytype" value=""  > <input type="hidden" name="restoreentityid" id="restoreentityid" value=""  ><button class="submit">Yes please.</a></button></form>
    <button class="submit dontdelete" id="dontdelete" >No Thanks.</a></button></div>
  </div>
</div>
<!-- End restore popup -->
<!-- For Notifications-->
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
<script>
$(document).on("click", ".dontdelete", function(){
  $('#myModal-deleteall').modal('hide');
  $('#entity-delete').modal('hide');
  $('#myModal-restoreall').modal('hide');
  $('#entity-restore').modal('hide');
});
$(document).on("click", ".deletethis", function() {
  var entityid  = $(this).attr('entityid');
  var typpe = $(this).attr('type')
  $('#entityid').val(entityid);
  $('#entitytype').val(typpe);
  $('#entity-delete').modal('show');
});
$(document).on("click", ".restorethis", function() {
  var entityid  = $(this).attr('entityid');
  var typpe = $(this).attr('type')
  $('#restoreentityid').val(entityid);
  $('#restoreentitytype').val(typpe);
  $('#entity-restore').modal('show');
});
</script>
@stop

