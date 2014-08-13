@extends('dashboard.default')
@section('head')
<title>92five app - Add User</title>
@stop
@section('content')
<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <h2><a href="{{url('/dashboard')}}">Dashboard</a>/ <a href="{{url('/dashboard/admin')}}">Admin</a> / <a href="{{url('/dashboard/admin/users')}}">Users</a> / Add</h2>
        <div class="row-fluid change_email">
          <form class="form-horizontal" method="post" data-validate="parsley">
            <div class="adduser_sec">
              <p>Just enter the email address of the user you wish to add and we will do the rest !</p>
              <div class="email_detail_2">
                <div class="span6"><input type="text" placeholder="email" class="span12" name="email"data-required="true"  data-show-errors="true"></div>
                <div class="task_select span4">
                  <select name="role" class="global_select" id="role" tabindex="1">
                    <option  name="" value="user" title="">User</option>
                    <option  name="" value="leader" title="">Leader</option>
                    <option  name="" value="manager" title="" >Manager</option>
                  </select>
                </div>
                <div class="span2">
                  <button class="submit pull-left">Add</button>
                </div>
                <div class="adduserwithdetails"><a href="{{url('dashboard/admin/users/add/withdetails')}}">Add user with details</a></div>
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

