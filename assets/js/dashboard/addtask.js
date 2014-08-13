var url = window.location.href;
var tempurl = url.split('dashboard')[0];
var AddTaskModel = Backbone.Model.extend({
    urlRoot: 'add'
});
var AddSubTaskModel = Backbone.Model.extend({
    urlRoot: 'subtask'
});
var AddTaskView = Backbone.View.extend({
    el: $('.project_detail'),
    model: AddTaskModel,
    initialize: function() {
        _.bindAll(this, "postClicked");
        this.model.bind('change', this.render, this);
    },
    events: {
        "change #projectlist": "postClicked",
        "submit #newtaskform": "postData",
        "submit #newsubtaskform": "postSubTask",
        "click .removethis": "deleteSubTask"
    },
    render: function() {},
    postClicked: function(e) {
        $('#list').empty();
        $('#tagsinput').val('');
    },
    postData: function(e) {
        e.preventDefault();
        if ($("#tagsinput").val() == '') {
            alert('Atleast add one Asignee');
        } else {
            this.model.set({
                'task_name': $('#task_name').val(),
                'startdate': $('#startdate').val(),
                'enddate': $('#enddate').val(),
                'project': $('#projectlist').val(),
                'note': $('#note').val(),
                'users': $('#tagsinput').val()
            });
            this.model.save(null, {
                success: function(model, response, options) {
                    $('#add_new_task_left').block({
                        message: 'Good to go !'
                    });
                    $('#add_new_task_right').unblock();
                    $('#taskId').val(response.id);
                    $('#subtasks').focus();
                    $('#taskfiles').attr("href", 'add/files/' + response.id);
                },
                error: function(model, xhr, options) {}
            });
        }
    },
    postSubTask: function(e) {
        e.preventDefault();
        var addsubtaskmodel = new AddSubTaskModel();
        addsubtaskmodel.set({
            'taskId': $('#taskId').val(),
            'subtask': $('#subtasks').val()
        });
        addsubtaskmodel.save(null, {
            success: function(model, response, options) {
                $("#subtasklist").append('<li id="userlist" class="userlist" subtaskid=' + response.id + ' ><img src=' + tempurl + 'assets/images/dashboard/circle_1.png alt=""> ' + $('#subtasks').val() + '<a class="removethis" id="removethis" href="#">X</a></li>');
                $('#subtasks').val('');
            },
            error: function(model, xhr, options) {}
        });
    },
    deleteSubTask: function(e) {
        var subtaskid = $(e.target).parent('li').attr('subtaskid');
        var addsubtaskmodel = new AddSubTaskModel();
        addsubtaskmodel.set({
            'id': subtaskid
        });
        addsubtaskmodel.destroy({
            success: function(model, response, options) {
                $(e.target).parent().remove();
            },
            error: function(model, xhr, options) {}
        });
    }
});