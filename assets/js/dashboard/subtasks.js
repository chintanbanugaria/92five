var SubTaskModel = Backbone.Model.extend({
    urlRoot: function() {
        var url = window.location.href;
        var tempurl = url.split('dashboard')[0];
        return tempurl + 'dashboard/task/subtasks';
    },
    toggleStatus: function(e) {
        var subtaskId = $(e.target).attr('subtaskid');
        console.log(subtaskId);
        if ($(e.target).siblings('input').attr('checked')) {
            this.set('id', subtaskId);
            this.set('status', 'active');
            return this.save(null, {
                success: function(model, response, options) {
                    $(e.target).parent().next().find('div').removeClass('task_link_select');
                },
                error: function(model, xhr, options) {
                    //return null;
                }
            });
        } else {
            this.set('id', subtaskId);
            this.set('status', 'completed');
            return this.save(null, {
                success: function(model, response, options) {
                    $(e.target).parent().next().find('div').addClass('task_link_select');
                },
                error: function(model, xhr, options) {
                    // return null;
                }
            });
        }
    }
});
var SubTaskView = Backbone.View.extend({
    el: $('.sub_task_list_main'),
    model: SubTaskModel,
    events: {
        "click .subtasks": "toggleStatus"
    },
    initialize: function() {
        _.bindAll(this, "postClicked");
        this.model.bind('change', this.render, this);
    },
    postClicked: function() {},
    toggleStatus: function(e) {
        var result = this.model.toggleStatus(e);
    },
    render: function() {}
});