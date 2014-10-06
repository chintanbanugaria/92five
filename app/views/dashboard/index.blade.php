@extends('dashboard.default')
@section('head')
<title>{{trans('92five.Dashboard')}}</title>
@stop
@section('content')
<div id="contentwrapper">
    <div class="main_content">
      <div class="row-fluid">
        <div class="span12 right_part">
          <div class="row-fluid">
            <div class="span12">
              <div class="row-fluid">
                <div class="span8">
                  <div class="row-fluid">
                    <div class="span6 detail_box">
                      <h3>{{trans('92five.Tasks')}}</h3>
                      <div class="task_pending">
                        <div class="task_detail">
                          <div class="span3 task_left">{{$tasks['pendingTasks']}}</div>
                          <div class="span9 task_right">{{trans('92five.taskPending')}}</div>
                        </div>
                        <div class="task_detail">
                          <div class="span3 task_left2">{{$tasks['completedTasks']}}</div>
                          <div class="span9 task_right">{{trans('92five.taskCompleted')}}</div>
                        </div>
                        <div class="task_detail2">
                          <div class="span3 task_left3">{{$tasks['totalTasks']}}</div>
                          <div class="span9 task_right">{{trans('92five.taskAssigned')}}</div>
                        </div>
                      </div>
                    </div>
                    <div class="span6 detail_box">
                      <h3>{{trans('92five.Projects')}}</h3>
                      <div class="scroll_container proj_set_detail">
                          @if(count($projects) != 0)
                            @foreach($projects as $project)
                            <div class="row-fluid detail_proje">
                          <div class="span12 scroll_detail">
                            <h4><a href={{url('/dashboard/projects',array($project['id']))}}>{{$project['project_name']}}</a></h4>
                            <div class="row-fluid"> 
                               @if($project['total_task'] != 0)
                                <span class="span6 p_detail_3">({{$project['remainingTasks']}} {{trans('92five.tasksRemaining')}})</span>
                                <span class="span6 p_detail_4">
                                   <div class="progress">
                                         <div class="bar " style="width: {{$project['percentage']}}%;"></div>
                                   </div>
                                </span>
                                @else
                                 <span class="span12 p_detail_3">{{trans('92five.noTaskProjectText')}}</span>
                                @endif
                             </div>
                          </div>
                         </div>
                            @endforeach
                         @else
                         <div class="row-fluid ">
                          <div class="span12 noproj_scroll_detail">
                          {{trans('92five.noProjectFoundText')}} !
                          <br/>
                          @if(Sentry::getUser()->hasAccess('project.create'))
                <a href="{{url('/dashboard/projects/add')}}"> {{trans('92five.createOne')}}</a>
                          @endif
                          </div>
                         </div>
                          @endif
                      </div>
                    </div>
                  </div>
                  <div class="row-fluid">
                    <div class="span6">
                      <div class=" span12 tasks">
                          <div class="tasks_inner">
                        <input class="knob animate" data-width="190" data-min="0" data-bgColor="#F2F2F2" data-fgColor="#14b9d6" data-thickness=".2" data-displayPrevious=true data-readOnly=true value={{$tasks['percentage']}}>
                          </div>

                      </div>
                    </div>
                    <div class="span6 detail_box">
                      <h3>
                        <span class="add_task_icon"></span>
                          {{trans('92five.todoList')}}                       
					             </h3>
                    <div class="scroll_container">
                      <div class="my-list">
                        <div class="content_3" id="todoslist" name="todos">
                          <ul id='todos' name="todos">
                          <li class="no_todolist_item">
                        {{trans('92five.noToDoText')}} !                       
                          </li>  
                          </ul>
                        </div>
                      </div>
                    </div>
                    </div>
                  </div>
                </div>
                <div class="span4 detail_box">
                  <h3>  {{trans('92five.todaysAgenda')}} </h3>
                  <div class="agenda">
                    <div class="today-agenda">
                        @if($events != null)
                        @foreach($events as $event)
                      <div class="blue-disc from-{{$event['fromClass']}} to-{{$event['toClass']}}">{{date('g:ia', strtotime($event['start_time']))}} - {{date('g:ia', strtotime($event['end_time']))}} <br/><a href="{{url('dashboard/calendar')}}"> {{$event['title']}}</a> </div> 
                        @endforeach
                        @endif
                      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="today-agenda-box">
                        <tr>
                          <td width="48">7AM</td>
                          <td class="agenda-content" valign="top" align="left">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>8AM</td>
                          <td class="agenda-content" valign="top" align="left">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>9AM</td>
                          <td class="agenda-content" valign="top" align="left">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>10AM</td>
                          <td class="agenda-content" valign="top" align="left">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>11AM</td>
                          <td class="agenda-content" valign="top" align="left">&nbsp;</td>
                        </tr>
                        <tr>
                          <td><img src="{{asset('assets/images/dashboard/agenda-bullet.png')}}" width="28" height="28" style="width:28px; height:28px; margin:0 0 0 2px;" alt="agenda-bullet"></td>
                          <td class="agenda-content" valign="top" align="left">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>1PM</td>
                          <td class="agenda-content" valign="top" align="left">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>2PM</td>
                          <td class="agenda-content" valign="top" align="left">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>3PM</td>
                          <td class="agenda-content" valign="top" align="left">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>4PM</td>
                          <td class="agenda-content" valign="top" align="left">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>5PM</td>
                          <td class="agenda-content" valign="top" align="left">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>6PM</td>
                          <td class="agenda-content" valign="top" align="left">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>7PM</td>
                          <td class="agenda-content" valign="top" align="left">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>8PM</td>
                          <td class="agenda-content" valign="top" align="left">&nbsp;</td>
                        </tr>
                        <tr class="last">
                          <td>9PM</td>
                          <td class="agenda-content" valign="top" align="left">&nbsp;</td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row-fluid">
            <div class="span12">
              <div class="row-fluid">
                <div class="span12 quick_note">
                  <div class="quicknote">
                    <div class="span1"></div>
                    <div class="notetext span11">
                      <div class="heading">
                        <h2> {{trans('92five.quickNote')}}</h2> 
                      </div>
                      <div class="span11" id='notediv' name='notediv'>
                        <textarea id="note" name="note" ></textarea>
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
  {{ HTML::script('assets/js/jquery/jquery.knob.js') }}
{{ HTML::script('assets/js/dashboard/todo.js') }}
{{ HTML::script('assets/js/dashboard/quicknote.js') }}
{{ HTML::script('assets/js/dashboard/taskcompleted.js') }}
  @stop

