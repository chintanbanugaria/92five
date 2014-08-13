var AutoCompleteItemView = Backbone.View.extend({
    tagName: "li",
    template: _.template('<a href="#"><%= label %><br/><%= email %></a>'),
    events: {
        "click": "select"
    },
    render: function() {
        this.$el.html(this.template({
            "label": this.model.label(),
            "email": this.model.email()
        }));
        return this;
    },
    select: function() {
        this.options.parent.hide().select(this.model);
        return false;
    }
});
var AutoCompleteView = Backbone.View.extend({
    tagName: "ul",
    className: "autocomplete",
    wait: 300,
    queryParameter: "query",
    minKeywordLength: 1,
    currentText: "",
    itemView: AutoCompleteItemView,
    events: {
        //'change input': 'toggleStatus'
        'click .userlist a': 'rmUser'
    },
    initialize: function(options) {
        _.extend(this, options);
        this.filter = _.debounce(this.filter, this.wait);
    },
    render: function() {
        // disable the native auto complete functionality
        this.input.attr("autocomplete", "off");
        this.$el.width(this.input.outerWidth());
        this.input.keyup(_.bind(this.keyup, this)).keydown(_.bind(this.keydown, this)).after(this.$el);
        return this;
    },
    keydown: function(event) {
        if (event.keyCode == 38) return this.move(-1);
        if (event.keyCode == 40) return this.move(+1);
        if (event.keyCode == 13) return this.onEnter();
        if (event.keyCode == 27) return this.hide();
    },
    filter: function(keyword) {
        var keyword = keyword.toLowerCase();
        this.loadResult(this.model.filter(function(model) {
            return model.label().toLowerCase().indexOf(keyword) !== -1
        }), keyword);
    },
    isValid: function(keyword) {
        return keyword.length > this.minKeywordLength
    },
    isChanged: function(keyword) {
        return this.currentText != keyword;
    },
    move: function(position) {
        var current = this.$el.children(".active"),
            siblings = this.$el.children(),
            index = current.index() + position;
        if (siblings.eq(index).length) {
            current.removeClass("active");
            siblings.eq(index).addClass("active");
        }
        return false;
    },
    onEnter: function() {
        this.$el.children(".active").click();
        return false;
    },
    loadResult: function(model, keyword) {
        this.currentText = keyword;
        this.show().reset();
        if (model.length) {
            _.forEach(model, this.addItem, this);
            this.show();
        } else {
            this.hide();
        }
    },
    addItem: function(model) {
        this.$el.append(new this.itemView({
            model: model,
            parent: this
        }).render().$el);
    },
    select: function(model) {
        var label = model.label();
        this.input.val('');
        this.currentText = label;
        this.onSelect(model);
    },
    reset: function() {
        this.$el.empty();
        return this;
    },
    hide: function() {
        this.$el.hide();
        return this;
    },
    show: function() {
        this.$el.show();
        return this;
    },
    // callback definitions
    onSelect: function() {},
    rmUser: function() {
        alert('alert called');
    },
});