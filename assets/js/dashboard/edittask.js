var url = window.location.href;
var tempurl = url.split('dashboard')[0];
var EditTaskModel = Backbone.Model.extend({
    urlRoot: 'update'
});
var EditSubTaskModel = Backbone.Model.extend({
    urlRoot: 'subtask'
});
var EditTaskView = Backbone.View.extend({
    el: $('.project_detail'),
    model: EditTaskModel,
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
        if ($("#tagsinput").val() == "") {
            alert('Atleast add one Asignee');
        } else {
            this.model.set({
                'task_name': $('#task_name').val(),
                'startdate': $('#startdate').val(),
                'enddate': $('#enddate').val(),
                'project': $('#projectlist').val(),
                'note': $('#note').val(),
                'taskId': $('#taskId').val(),
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
        var addsubtaskmodel = new EditSubTaskModel();
        addsubtaskmodel.set({
            'taskId': $('#taskId').val(),
            'subtask': $('#subtasks').val()
        });
        addsubtaskmodel.save(null, {
            success: function(model, response, options) {
                console.log('sub task entered');
                $("#subtasklist").append('<li id="userlist" class="userlist" subtaskid=' + response.id + ' ><span><img src=' + tempurl + 'assets/images/dashboard/circle_1.png alt=""> ' + $('#subtasks').val() + '</span><a class="removethis" id="removethis" href="#">X</a></li>');
                $('#subtasks').val('');
            },
            error: function(model, xhr, options) {}
        });
    },
    deleteSubTask: function(e) {
        var subtaskid = $(e.target).parent('li').attr('subtaskid');
        var addsubtaskmodel = new EditSubTaskModel();
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