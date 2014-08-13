var url = window.location.href;
var tempurl = url.split('dashboard')[0];
var UserModel = Backbone.Model.extend({
    urlRoot: function() {
        return tempurl + 'dashboard/admin/users/manage';
    }
});
var UserView = Backbone.View.extend({
    el: $('.viewuser_sec'),
    model: UserModel,
    initialize: function() {
        _.bindAll(this, "postClicked");
        this.model.bind('change', this.render, this);
    },
    events: {
        "click .activated": "activatedClicked",
        "click .suspended": "suspendedClicked",
        "click .banned": "bannedClicked",
    },
    render: function() {},
    postClicked: function() {},
    activatedClicked: function(e) {
        var userId = $(e.target).attr('userid');
        if ($(e.target).siblings('input').attr('checked')) {
            this.model.set('id', userId);
            this.model.set('action', 'deactivate');
            return this.model.save(null, {
                success: function(model, response, options) {
                    iosOverlay({
                        text: "User Deactivated",
                        duration: 5e3,
                        icon: tempurl + 'assets/images/notifications/check.png'
                    });
                    return true;
                },
                error: function(model, xhr, options) {
                    iosOverlay({
                        text: "Something went wrong",
                        duration: 5e3,
                        icon: tempurl + 'assets/images/notifications/cross.png'
                    });
                    return false;
                }
            });
        } else {
            this.model.set('id', userId);
            this.model.set('action', 'activate');
            return this.model.save(null, {
                success: function(model, response, options) {
                    iosOverlay({
                        text: "User Activated",
                        duration: 5e3,
                        icon: tempurl + 'assets/images/notifications/check.png'
                    });
                    return true;
                },
                error: function(model, xhr, options) {
                    iosOverlay({
                        text: "Something went wrong",
                        duration: 5e3,
                        icon: tempurl + 'assets/images/notifications/cross.png'
                    });
                    return false;
                }
            });
        }
    },
    suspendedClicked: function(e) {
        var userId = $(e.target).attr('userid');
        if ($(e.target).siblings('input').attr('checked')) {
            this.model.set('id', userId);
            this.model.set('action', 'unsuspend');
            return this.model.save(null, {
                success: function(model, response, options) {
                    iosOverlay({
                        text: "User Unsuspended",
                        duration: 5e3,
                        icon: tempurl + 'assets/images/notifications/check.png'
                    });
                    return true;
                },
                error: function(model, xhr, options) {
                    iosOverlay({
                        text: "Something went wrong",
                        duration: 5e3,
                        icon: tempurl + 'assets/images/notifications/cross.png'
                    });
                    return false;
                }
            });
        } else {
            this.model.set('id', userId);
            this.model.set('action', 'suspend');
            return this.model.save(null, {
                success: function(model, response, options) {
                    iosOverlay({
                        text: "User Suspended",
                        duration: 5e3,
                        icon: tempurl + 'assets/images/notifications/check.png'
                    });
                    return true;
                },
                error: function(model, xhr, options) {
                    iosOverlay({
                        text: "Something went wrong",
                        duration: 5e3,
                        icon: tempurl + 'assets/images/notifications/cross.png'
                    });
                    return false;
                }
            });
        }
    },
    bannedClicked: function(e) {
        var userId = $(e.target).attr('userid');
        if ($(e.target).siblings('input').attr('checked')) {
            this.model.set('id', userId);
            this.model.set('action', 'unbanned');
            return this.model.save(null, {
                success: function(model, response, options) {
                    iosOverlay({
                        text: "User Unbanned",
                        duration: 5e3,
                        icon: tempurl + 'assets/images/notifications/check.png'
                    });
                    return true;
                },
                error: function(model, xhr, options) {
                    iosOverlay({
                        text: "Something went wrong",
                        duration: 5e3,
                        icon: tempurl + 'assets/images/notifications/cross.png'
                    });
                    return false;
                }
            });
        } else {
            this.model.set('id', userId);
            this.model.set('action', 'ban');
            return this.model.save(null, {
                success: function(model, response, options) {
                    iosOverlay({
                        text: "User Banned",
                        duration: 5e3,
                        icon: tempurl + 'assets/images/notifications/check.png'
                    });
                    return true;
                },
                error: function(model, xhr, options) {
                    iosOverlay({
                        text: "Something went wrong",
                        duration: 5e3,
                        icon: tempurl + 'assets/images/notifications/cross.png'
                    });
                    return false;
                }
            });
        }
    }
});