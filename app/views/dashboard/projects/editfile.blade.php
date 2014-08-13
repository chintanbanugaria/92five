@extends('dashboard.default')
@section('head')
<title>92five app - Add / Remove File</title>
@stop
@section('content')
<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <h2><a href="{{url('/dashboard')}}">Dashboard<a> / <a href="{{url('/dashboard',array($parentType.'s'))}}">{{$parentType}}</a> / Edit Files </h2>
        <div class="row-fluid proj_create">
          <h3> {{$parentName}}  <div class="p-icon-main">
          </div></h3>
          <div class="row-fluid span12 proj_create_detail">
            <div class="row-fluid">
              <!-- Left Part -->
              <div class="span12 add-proj-form">
                <fieldset>
                  <div class="control-group">
                    <label>Add Files:
                      <p class="help-block">(optional)</p>
                    </label>
                    @if($parentType == 'Task')
                    <form id='dropzone' action='#'class="dropzone" method=post>
                      @elseif($parentType == 'Project')
                      <form id='dropzone' action='add/files' class="dropzone" method=post>
                        @endif
                        <input type="hidden" name="project_id" id="project_id" value={{$project_id}}/>
                        <div class="fallback">
                          <input name="file" type="file" multiple />
                        </div>
                      </form>
                    </div>
                    <div class="control-group">
                      <label>  Attached Files:</label>
                      @if($files == null)
                      <div class='no_file'>   [ No Files are attached with this project ]</div>
                      @else
                      <div class="row-fluid ">
                        @foreach($files as $file)
                        <div class="row-fluid proj_file_edit_list">
                          <div class="span9">
                            <p>{{$file['file_name']}}</p>
                            <span>{{$file['size']}}. Uploaded on {{new ExpressiveDate($file['uploaded_date'])}} by {{User::where('id',$file['uploaded_by'])->pluck('first_name')}} {{User::where('id',$file['uploaded_by'])->pluck('last_name')}}</span>
                          </div>
                          <div class="span3">
                            <input type=button class="removefile" fileid={{$file['id']}} value="Remove" id="removefile">
                          </div>
                        </div>
                        @endforeach
                      </div>
                      @endif
                    </div>
                  </fieldset>
                  <div class="submit_button_main">
                    @if($parentType == 'Task')
                    <a href="{{url('/dashboard/task/edited',array($project_id))}}" class="submit">Done</a>
                    @elseif($parentType == 'Project')
                    <a href="{{url('/dashboard/projects/edit/done',array($project_id))}}" class="submit">Done</a>
                    @endif
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
@stop
@section('endjs')
{{ HTML::style('assets/css/dashboard/dropzone.css') }}
{{ HTML::script('assets/js/dashboard/dropzone.js') }}
<script>
 $(document).on("click", ".removefile", function() {
   var flag;
   var fileid = $(this).attr('fileid');
   $.ajax({
     type: 'GET',
     dataType: 'json',
     url: 'deletefile/' + fileid,
     timeout: 5000,
     success: function(data, textStatus) {
       //console.log('success');
       var url = window.location.href;
       var tempurl = url.split('dashboard')[0];
       iosOverlay({
         text: "File Removed !",
         duration: 5e3,
         icon: tempurl + 'assets/images/notifications/check.png'
       });
       flag = true;
     },
     error: function(xhr, textStatus, errorThrown) {
       var url = window.location.href;
       var tempurl = url.split('dashboard')[0];
       iosOverlay({
         text: "Something Went Wrong !",
         duration: 5e3,
         icon: tempurl + 'assets/images/notifications/cross.png'
       });
       flag = false;
     }
   });
   if (flag = true)
   {
     $(this).parents('div.proj_file_edit_list').remove();
   }
   if (flag = false)
   {
   }

 });
</script>

  @stop

