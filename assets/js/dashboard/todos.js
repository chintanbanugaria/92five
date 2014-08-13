(function() {
    var ENTER_KEY = 13;
    var ESC_KEY = 27;
    var TodoModel = Backbone.Model.extend({
        urlRoot: 'todo',
        toggleStatus: function() {
            if (this.get('status') === 'completed') {
                this.set({
                    'status': 'incomplete'
                });
            } else {
                this.set({
                    'status': 'completed'
                });
            }
            this.save();
        }
    });
    var TodoView = Backbone.View.extend({
        template: _.template($('#todo-template').html()),
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
        url: 'todo',
        initialize: function() {
            this.fetch({
                reset: true
            });
        }
    });
    var TodoListView = Backbone.View.extend({
        el: '#todo',
        events: {
            'keypress .new-todo': 'createOnEnter',
            'click .del-todo': 'deleteOne'
        },
        initialize: function() {
            _.bindAll(this, 'render');
            this.collection.bind('reset', this.render, this);
        },
        render: function() {
            if (this.collection.length === 0) {} else {
                this.collection.forEach(this.addOne, this);
            }
        },
        addOne: function(todoItem) {
            var todoView = new TodoView({
                model: todoItem
            });
            this.$('#todolist').append(todoView.render().el);
        },
        createOnEnter: function(e) {
            if (e.which === ENTER_KEY && this.$('#new-todo').val().trim()) {
                var todoModel = new TodoList();
                todoModel.create({
                    'text': this.$('#new-todo').val().trim()
                }, {
                    success: function(model, response, options) {
                        var todoView = new TodoView({
                            model: response
                        });
                        this.$('#todolist').prepend(todoView.render().el);
                        this.$('#new-todo').val('');
                    },
                    error: function(model, xhr, options) {
                        console.log('error');
                    }
                });
            }
        },
        deleteOne: function(e) {
            var todoId = $(e.target).attr('todoid');
            var todoModel = new TodoModel();
            todoModel.set({
                'id': todoId
            });
            todoModel.destroy({
                success: function(model, response, options) {
                    $(e.target).parent().parent().parent().parent().remove();
                },
                error: function(model, xhr, options) {
                    console.log('error');
                }
            });
        }
    });
    var todolist = new TodoList();
    var todolistView = new TodoListView({
        collection: todolist
    });
    todolistView.render();
}());