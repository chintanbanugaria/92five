$(function() {
    var Plugin = Backbone.Model.extend({
        label: function() {
            return this.get("first_name") + " " + this.get("last_name");
        },
        email: function() {
            return this.get("email");
        }
    });
    var PluginCollection = Backbone.Collection.extend({
        model: Plugin,
        url: function() {
            var url = window.location.href;
            var tempurl = url.split('dashboard')[0];
            return tempurl + 'dashboard/users';
        }
    });
    var plugins = new PluginCollection();
    plugins.fetch({
        reset: true
    });
    new AutoCompleteView({
        input: $("#plugin"),
        model: plugins,
        keyup: function() {
            var keyword = this.input.val();
            if (this.isChanged(keyword)) {
                if (this.isValid(keyword)) {
                    this.filter(keyword);
                } else {
                    this.hide()
                }
            }
        },
        onSelect: function(model) {
            var name = model.label();
            var email = model.email();
            var collablist = new Array();
            var arr = new Array();
            $('#list li').parent().children().each(function() {
                arr.push(this.innerHTML);
            })
            var flag = true;
            for (var j = 0; j < arr.length; j++) {
                if (arr[j].match(name)) flag = false;
            }
            if (flag == true) {
                var tmpemaillist = $('#tagsinput').val();
                $("#list").append('<li id="userlist" class="userlist" email=' + email + ' >' + name + '<a class="removeme" id="removeme" href="#">X</a></li>');
                if ($('#tagsinput').val() === "") {
                    $('#tagsinput').val(email);
                } else {
                    var tempstring = ',' + email;
                    var emaillist = tmpemaillist.concat(tempstring);
                    $('#tagsinput').val(emaillist);
                }
            } else {
                //Do nothing
            }
        },
    }).render();
});