(function() {
    var QnoteModel = Backbone.Model.extend({
        url: 'dashboard/quicknote',
        initialize: function() {
            this.fetch({
                reset: true
            });
        }
    });
    var QnoteListView = Backbone.View.extend({
        el: '#notediv',
        textarea: '#note',
        template: _.template('<%=text%>'),
        events: {
            'focusout textarea': 'keyDownStatus',
            'keydown textarea': 'localSave'
        },
        initialize: function() {
            _.bindAll(this, 'render');
            this.model.bind('reset', this.render, this);
            this.model.bind('change', this.render, this);
        },
        render: function() {
            var textarea = $('#note');
            textarea.html(this.template(this.model.toJSON()));
        },
        addOne: function(todoItem) {},
        keyDownStatus: function() {
            this.model.set({
                text: $('#note').val()
            });
            this.model.save();
        },
        localSave: function() {}
    });
    var qnotemodel = new QnoteModel();
    var qnotelistView = new QnoteListView({
        model: qnotemodel
    });
    qnotelistView.render();
}());