@extends('dashboard.default')
@section('head')
<title>92five app - {{trans('92five.add')}} {{trans('92five.files')}}</title>
@stop
@section('content')
<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <h2><a href="{{url('/dashboard')}}">{{trans('92five.Dashboard')}}</a> / <a href="{{url('/dashboard',array($parentType.'s'))}}">{{$parentType}}</a> / {{trans('92five.add')}} {{trans('92five.files')}}</h2>
        <div class="row-fluid proj_create">
          <h3> {{$parentName}}  <div class="p-icon-main">
          </div></h3>
          <div class="row-fluid span12 proj_create_detail">
            <div class="row-fluid">
              <!-- Left Part -->
              <div class="span12 add-proj-form">
                <fieldset>
                  <div class="control-group">
                    <label>{{trans('92five.add')}} {{trans('92five.files')}}:
                      <p class="help-block">({{trans('92five.optional')}})</p>
                    </label>
                    @if($parentType == 'Task')
                    <form id='dropzone' action='#'class="dropzone" method=post>
                      @elseif($parentType == 'Project')
                      <form id='dropzone' action='add/files' class="dropzone" method=post>
                        @endif
                        <input type="hidden" name="project_id" id="project_id" value={{$parentId}}/>
                        <div class="fallback">
                          <input name="file" type="file" multiple />
                        </div>
                      </form>
                    </div>
                  </fieldset>
                  <div class="submit_button_main">
                    @if($parentType == 'Task')
                    <a href="{{url('/dashboard/task/added')}}" class="submit">{{trans('92five.done')}}</a>
                    @elseif($parentType == 'Project')
                    <a href="{{url('/dashboard/projects/add/done')}}" class="submit">{{trans('92five.done')}}</a>
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
@stop

