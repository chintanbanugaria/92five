@extends('dashboard.default')
@section('head')
<title>92five app - Roles</title>
@stop
@section('content')
<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <h2><a href="{{url('/dashboard')}}">Dashboard</a> / Roles</h2>
        <div class="row-fluid roles_detail_main">
          <div class="span3 roles_detail">
            <h2>User</h2>
            <div class="roles_detail_2">
              <ul>
              <li>-Manage(Create, Edit Delete) Tasks</li>   
              <li>-Manage Timesheet </li> 
              <li>- Can manage only those tasks which are assigned to him/her</li> 
              <li>- Can generate their own weekly / monthly reports</li> 
             </ul>
              @if(Sentry::getUser()->inGroup(Sentry::getGroupProvider()->findByName('user')))
              <div class="roles_name">{{Sentry::getUser()->first_name.' '. Sentry::getUser()->last_name}}</div>
              @endif
            </div>
          </div>
          <div class="span3 roles_detail">
            <h2>Leader</h2>
            <div class="roles_detail_2">
               <ul>
              <li> - All User's privileges</li>
                <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ </li>
              <li>- Can manage all the tasks of the project</li> 
              <li>-Can update projects</li>
              <li>- Can generate full project report</li> 
              <li>- Can generate User Project Report</li>

             </ul>
              @if(Sentry::getUser()->inGroup(Sentry::getGroupProvider()->findByName('leader')))
              <div class="roles_name">{{Sentry::getUser()->first_name.' '. Sentry::getUser()->last_name}}</div>
              @endif
            </div>
          </div>
          <div class="span3 roles_detail">
            <h2>Manager</h2>
            <div class="roles_detail_2">
             <ul>
              <li>- All Leader's privileges</li>
                    <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ </li>
              <li>-Can Create Project</li>
             </ul>
              @if(Sentry::getUser()->inGroup(Sentry::getGroupProvider()->findByName('manager')))
              <div class="roles_name">{{Sentry::getUser()->first_name.' '. Sentry::getUser()->last_name}}</div>
              @endif
            </div>
          </div>
          <div class="span3 roles_detail">
            <h2>Admin</h2>
            <div class="roles_detail_2">
                 <ul>
              <li>- All Manager's privileges</li>
                    <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ </li>
              <li>- Manage Users</li>
                     <li>- Delete / Restore Projects, Tasks and Calendar Events </li>
              <li>- Manage Email Settings</li>
                <li>- View Logs</li>
                     

             </ul>
              @if(Sentry::getUser()->inGroup(Sentry::getGroupProvider()->findByName('admin')))
              <div class="roles_name">{{Sentry::getUser()->first_name.' '. Sentry::getUser()->last_name}}</div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop
@section('endjs')

@stop

