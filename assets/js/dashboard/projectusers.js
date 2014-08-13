var UserModel = Backbone.Model.extend({
    name: function() {
        return this.get("first_name") + " " + this.get("last_name");
    },
    email: function() {
        return this.get("email");
    },
    userid: function() {
        return this.get("id");
    }
});
var UserCollection = Backbone.Collection.extend({
    model: UserModel,
    url: '/dashboard/users',
});
var UserView = Backbone.View.extend({
    el: $('#myModal-monthlyuserproject'),
    model: UserCollection,
    events: {
        "change #projectmonth": "userChange"
    },
    initialize: function() {
        this.model.on('add', this.addOne, this);
    },
    userChange: function() {
        if (($('#projectmonth').val() == 'null') || ($('#projectmonth').val() == 'others') || ($('#projectmonth').val() == '')) {
            $("#userprojectreportid").empty();
            $("#userprojectreportid").prop("disabled", true);
        } else {
            $("#userprojectreportid").prop("disabled", false);
            $("#userprojectreportid").empty();
            var url = window.location.href;
            var tempurl = url.split('dashboard')[0];
            this.model.reset();
            this.model.url = tempurl + 'dashboard/users/project/' + $('#projectmonth').val();
            this.model.fetch({
                update: true
            });
        }
    },
    addOne: function(model) {
        $('#userprojectreportid').append($("<option></option>").attr("value", model.userid()).text(model.name()));
    }
});