@extends('dashboard.default')
@section('head')
<title>92five app - Change User Role</title>
@stop
@section('content')
<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <h2><a href="{{url('/dashboard')}}">Dashboard</a>/ <a href="{{url('/dashboard/admin')}}">Admin</a>/ <a href="{{url('/dashboard/admin/users')}}">Users</a>/ Edit Role</h2>
        <div class="row-fluid change_email">
          <form class="form-horizontal" method="post" action="{{url('/dashboard/admin/users/roles')}}" data-validate="parsley">
            <div class="adduser_sec">
              <p> Change role for {{$user['first_name']}} {{$user['last_name']}} from {{$user['role']}} to </p>
              <div class="email_detail_2">
                <div class="span3"></div>
                <input type="hidden" name="userid" id="userid" value="{{$user['id']}}"/>
                <input type="hidden" name="oldrole" id="oldrole" value="{{$user['role']}}"/>
                <div class="task_select span4">
                  <select name="newrole" class="global_select" id="newrole" tabindex="1">
                    <option  name="" value="user" title="">User</option>
                    <option  name="" value="leader" title="">Leader</option>
                    <option  name="" value="manager" title="" >Manager</option>
                    <option  name="" value="admin" title="">Admin</option>
                  </select>
                </div>
                <div class="span4">
                  <button class="submit pull-left">Update</button>
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

