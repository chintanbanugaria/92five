@extends('dashboard.default')
@section('head')
<title>92five app - {{trans('92five.addUserTitle')}}</title>
@stop
@section('content')
<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <h2><a href="{{url('/dashboard')}}">{{trans('92five.Dashboard')}}</a>/ <a href="{{url('/dashboard/admin')}}">{{trans('92five.Admin')}}</a> / <a href="{{url('/dashboard/admin/users')}}">{{trans('92five.users')}}</a> / {{trans('92five.add')}}</h2>
        <div class="row-fluid change_email">
          <form class="form-horizontal" method="post" data-validate="parsley">
            <div class="adduser_sec">
              <p>{{trans('92five.addUserTitle')}}</p>
              <div class="email_detail_2">
                <div class="span6"><input type="text" placeholder="email" class="span12" name="email"data-required="true"  data-show-errors="true"></div>
                <div class="task_select span4">
                  <select name="role" class="global_select" id="role" tabindex="1">
                    <option  name="" value="user" title="">{{trans('92five.user')}}</option>
                    <option  name="" value="leader" title="">{{trans('92five.leader')}}</option>
                    <option  name="" value="manager" title="" >{{trans('92five.manager')}}</option>
                  </select>
                </div>
                <div class="span2">
                  <button class="submit pull-left">{{trans('92five.add')}}</button>
                </div>
                <div class="adduserwithdetails"><a href="{{url('dashboard/admin/users/add/withdetails')}}">{{trans('92five.addUserWithDetails')}}</a></div>
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

