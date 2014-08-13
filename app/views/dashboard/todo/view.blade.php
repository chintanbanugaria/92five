@extends('dashboard.default')
@section('head')
<title>92five app - Todos</title>
@stop
@section('content')
<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid project_detail">
      <h2><a href="{{url('/dashboard')}}">Dashboard</a> / Todo</h2>
      <div class="span1"> </div>
      <div class="span10">
        <section id="todo">
          <a data-toggle="modal" href="{{url('/dashboard/mytodos/markallcompleted')}}" class="add_project">Mark all completed</a>
          <a data-toggle="modal" href="{{url('/dashboard/mytodos/deletecompleted')}}" class="add_project">Delete Completed</a>
          <a data-toggle="modal" href="{{url('/dashboard/mytodos/deleteall')}}" class="add_project">Delete All</a>
          <div class="row-fluid">
            <div class="span12 todo-detail-1"><input type="text" id="new-todo"   class="proj_create_in2 new-todo" name=""placeholder="What has to be done ?"></div>
          </div>
          <div class="row-fluid todo-detail-3">
            <ul id="todolist">
            </ul>
          </div>
        </section>
      </div>
      <div class="span1"> </div>
    </div>
  </div>
</div>
  <script type="text/template" id="todo-template">
      <% if(status === "completed") {%>
             <li>
                      <div class="span9 todo-list-1">
                          <input type="checkbox" id=<%=id%> class="regular-checkbox checked" checked /><label for="checkbox-1-8"></label>
                            <span class="todo-line"><%=text%></span>
            </div>

                        <div class="span3">
                          <div class="todo-list-3">

                                <a href="#" class="todo-delete p-icon-1" title="Delete To-do"><img todoid=<%=id%> class="del-todo" src="{{asset('assets/images/dashboard/p-delete.png')}}" alt=""></a>
                            </div>
                        </div>
                    </li>
        <% }
       else {%>
      <li>
                      <div class="span9 todo-list-1">
                          <input type="checkbox" id=<%=id%> class="regular-checkbox checked" /><label for="checkbox-1-1"></label>
                            <span><%=text%></span>
            </div>

                        <div class="span3">
                          <div class="todo-list-3">

                                <a href="#" class="todo-delete p-icon-1" title="Delete To-do"><img todoid=<%=id%> class="del-todo" src="{{asset('assets/images/dashboard/p-delete.png')}}" alt=""></a>
                            </div>
                        </div>
                    </li>
          <% } %>
</script>
@stop
@section('endjs')
{{ HTML::script('assets/js/dashboard/todos.js') }}
@stop

