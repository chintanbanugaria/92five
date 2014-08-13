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
            this.set('id', taskId);
            this.set('status', 'active');
            return this.save(null, {
                success: function(model, response, options) {
                    $(e.target).parent().next().find('a').removeClass('task_link_select');
                    $(e.target).parent().parent().next().find('div').removeClass('task_compete').removeClass('task_link_select').addClass('task_act').html('Active');
                    $(e.target).parent().parent().next().next().find('a').removeClass('task_link_select');
                    $(e.target).parent().parent().parent().removeClass('comp').addClass('act');
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
                    $(e.target).parent().next().find('a').addClass('task_link_select');
                    $(e.target).parent().parent().next().find('div').addClass('task_link_select');
                    $(e.target).parent().parent().next().find('a').addClass('task_link_select');
                    $(e.target).parent().parent().next().next().find('a').addClass('task_link_select');
                    $(e.target).parent().parent().parent().removeClass('act').removeClass('dely').addClass('comp');
                },
                error: function(model, xhr, options) {
                    return null;
                }
            });
        }
    }
});
var TaskView = Backbone.View.extend({
    el: $('.task_section'),
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