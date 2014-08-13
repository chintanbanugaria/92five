(function() {
    var FileModel = Backbone.Model.extend({});
    var FileView = Backbone.View.extend({
        template: _.template('<li' + '<% if(status === "completed") print(" class=delete-list")%>> <input type=checkbox class="regular-checkbox" name=todoscheckbox id=' + '<%=id%>' + '<% if(status === "completed") print(" checked");%> />' + '<label for="checkbox-1-1"></label><span>' + '<%=text%></span> </li>'),
        events: {
            'click label': 'toggleStatus'
        },
        initialize: function() {
            this.model.on('change', this.render, this);
        },
        toggleStatus: function() {
            this.model.toggleStatus();
        },
        render: function() {
            this.$el.html(this.template(this.model.toJSON()));
            return this;
        }
    });
    var TodoList = Backbone.Collection.extend({
        model: TodoModel,
        url: 'dashboard/todos',
        initialize: function() {
            this.fetch({
                reset: true
            });
        }
    });
    var TodoListView = Backbone.View.extend({
        el: '#todos',
        initialize: function() {
            _.bindAll(this, 'render');
            this.collection.bind('reset', this.render, this);
        },
        render: function() {
            if (this.collection.length === 0) {} else {
                $('#todos').empty();
                this.collection.forEach(this.addOne, this);
            }
        },
        addOne: function(todoItem) {
            var todoView = new TodoView({
                model: todoItem
            });
            this.$el.append(todoView.render().el);
        }
    });
    var todolist = new TodoList();
    var todolistView = new TodoListView({
        collection: todolist
    });
    todolistView.render();
}());