@extends('dashboard.default')
@section('head')
<title>92five app -  {{trans('92five.Roles')}}</title>
@stop
@section('content')
<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <h2><a href="{{url('/dashboard')}}">{{trans('92five.Dashboard')}}</a> / {{trans('92five.Roles')}}</h2>
        <div class="row-fluid roles_detail_main">
          <div class="span3 roles_detail">
            <h2> {{trans('92five.user')}}</h2>
            <div class="roles_detail_2">
              <ul>
              <li>- {{trans('92five.userRole1')}}</li>   
              <li>- {{trans('92five.userRole2')}} </li> 
              <li>- {{trans('92five.userRole3')}}</li> 
              <li>- {{trans('92five.userRole4')}}</li> 
             </ul>
              @if(Sentry::getUser()->inGroup(Sentry::getGroupProvider()->findByName('user')))
              <div class="roles_name">{{Sentry::getUser()->first_name.' '. Sentry::getUser()->last_name}}</div>
              @endif
            </div>
          </div>
          <div class="span3 roles_detail">
            <h2>{{trans('92five.leader')}}</h2>
            <div class="roles_detail_2">
              <ul>
              <li>- {{trans('92five.leaderRole1')}}</li>
              <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ </li>
              <li>- {{trans('92five.leaderRole2')}}</li> 
              <li>- {{trans('92five.leaderRole3')}}</li>
              <li>- {{trans('92five.leaderRole4')}}</li> 
              <li>- {{trans('92five.leaderRole5')}}</li>
             </ul>
              @if(Sentry::getUser()->inGroup(Sentry::getGroupProvider()->findByName('leader')))
              <div class="roles_name">{{Sentry::getUser()->first_name.' '. Sentry::getUser()->last_name}}</div>
              @endif
            </div>
          </div>
          <div class="span3 roles_detail">
            <h2>{{trans('92five.manager')}}</h2>
            <div class="roles_detail_2">
             <ul>
              <li>- {{trans('92five.managerRole1')}}</li>
                    <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ </li>
              <li>- {{trans('92five.managerRole2')}}</li>
             </ul>
              @if(Sentry::getUser()->inGroup(Sentry::getGroupProvider()->findByName('manager')))
              <div class="roles_name">{{Sentry::getUser()->first_name.' '. Sentry::getUser()->last_name}}</div>
              @endif
            </div>
          </div>
          <div class="span3 roles_detail">
            <h2>{{trans('92five.admin')}}</h2>
            <div class="roles_detail_2">
              <ul>
              <li>- {{trans('92five.adminRole1')}}</li>
              <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ </li>
              <li>- {{trans('92five.adminRole2')}}</li>
              <li>- {{trans('92five.adminRole3')}}</li>
              <li>- {{trans('92five.adminRole4')}}</li>
              <li>- {{trans('92five.adminRole5')}}</li>
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

