var TaskModel = Backbone.Model.extend({
    urlRoot: function() {
        var url = window.location.href;
        var tempurl = url.split('dashboard')[0];
        return tempurl + 'dashboard/task/update';
    },
    defaults: {
        status: 'active',
        id: ''
    },
    toggleStatus: function(e) {
        var taskId = $(e.target).attr('for');
        if ($(e.target).siblings('input').attr('checked')) {
            //alert(taskId);
            this.set('id', taskId);
            this.set('status', 'active');
            return this.save(null, {
                success: function(model, response, options) {
                    $(e.target).parent().next().removeClass('task_link_select');
                    $('.view_comp_deleyed').find('div').removeClass('task_compete').removeClass('task_link_select').addClass('task_no_inner').html('Active');
                    $('.add_new_task_right').unblock();
                },
                error: function(model, xhr, options) {
                    return null;
                }
            });
        } else {
            this.set('id', taskId);
            this.set('status', 'completed');
            return this.save(null, {
                success: function(model, response, options) {
                    $(e.target).parent().next().addClass('task_link_select');
                    $('.view_comp_deleyed').find('div').addClass('task_link_select');
                    $('.add_new_task_right').block({
                        message: 'Done !'
                    });
                },
                error: function(model, xhr, options) {
                    return null;
                }
            });
        }
    }
});
var TaskView = Backbone.View.extend({
    el: $('.view_task_left'),
    model: TaskModel,
    initialize: function() {
        _.bindAll(this, "postClicked");
        this.model.bind('change', this.render, this);
    },
    events: {
        "click .taskCheck": "postClicked"
    },
    render: function() {},
    postClicked: function(e) {
        var result = this.model.toggleStatus(e);
    }
});