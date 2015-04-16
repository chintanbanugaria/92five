@extends('dashboard.default')
@section('head')
<title>92five app - {{trans('92five.changeUserRoleTitle')}}</title>
@stop
@section('content')
<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <h2><a href="{{url('/dashboard')}}">{{trans('92five.Dashboard')}}</a>/ <a href="{{url('/dashboard/admin')}}">{{trans('92five.Admin')}}</a>/ <a href="{{url('/dashboard/admin/users')}}">{{trans('92five.users')}}</a>/ {{trans('92five.editRole')}}</h2>
        <div class="row-fluid change_email">
          <form class="form-horizontal" method="post" action="{{url('/dashboard/admin/users/roles')}}" data-validate="parsley">
            <div class="adduser_sec">
              <p> {{trans('92five.changeRoleFor')}} {{$user['first_name']}} {{$user['last_name']}} {{trans('92five.from')}} {{$user['role']}} {{trans('92five.to')}} </p>
              <div class="email_detail_2">
                <div class="span3"></div>
                <input type="hidden" name="userid" id="userid" value="{{$user['id']}}"/>
                <input type="hidden" name="oldrole" id="oldrole" value="{{$user['role']}}"/>
                <div class="task_select span4">
                  <select name="newrole" class="global_select" id="newrole" tabindex="1">
                    <option  name="" value="user" title="">{{trans('92five.user')}}</option>
                    <option  name="" value="leader" title="">{{trans('92five.leader')}}</option>
                    <option  name="" value="manager" title="" >{{trans('92five.manager')}}</option>
                    <option  name="" value="admin" title="">{{trans('92five.Admin')}}</option>
                  </select>
                </div>
                <div class="span4">
                  <button class="submit pull-left">{{trans('92five.update')}}</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
  @stop

  @section('endjs')
   {{ HTML::script('assets/js/simplelogin/parsley.js') }}
  {{ HTML::style('assets/css/simplelogin/parsley.css') }}

  @stop

