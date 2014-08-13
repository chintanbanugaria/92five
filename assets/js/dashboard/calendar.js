var EventModel = Backbone.Model.extend({
    urlRoot: 'calendar/event'
});
var url = window.location.href;
var tempurl = url.split('dashboard')[0];
var EventView = Backbone.View.extend({
    el: $('.time_listing'),
    model: EventModel,
    initialize: function() {
        _.bindAll(this, "postClicked");
        this.model.bind('change', this.render, this);
    },
    events: {
        "click .cal_event_title": "postClicked",
    },
    render: function() {},
    postClicked: function(e) {
        var eventid = $(e.target).attr('eventid');
        $(e.target).parent().parent().next().slideToggle();
    }
});
var EventListModel = Backbone.Model.extend({});
var EventsList = Backbone.Collection.extend({
    model: EventListModel,
    initialize: function(models, options) {
        this.selectedDate = options.selectedDate;
        this.fetch({
            'reset': true
        });
    },
    url: function() {
        return 'calendar/events/' + this.selectedDate;
    }
});
var EventsView = Backbone.View.extend({
    template: _.template('<div class=row-fluid><div class="span5 time_listing_1" >' + '<%=start_time%>' + ' - ' + '<%=end_time%>' + '</div><div class="span7 time_listing_1" ><a data-toggle=modal class=cal_event_title eventid=' + '<%=id%>' + ' href=#myModal4>' + '<%=title%>' + '</a></div></div>' + '<div class="calender-viewevent hide">' + '<% if (editdelete != "no") { %>' + '<div class="p-icon-inner"><a class="p-icon-1" title="Edit Event" href=calendar/event/edit/' + '<%=id%>' + '><img alt="" src=' + tempurl + 'assets/images/dashboard/p-edit.png></a><a class="p-icon-1" title="Delete Event" href=' + '#' + '><img alt="" class="delevent" eventid=' + '<%=id%>' + ' src=' + tempurl + 'assets/images/dashboard/p-delete.png></a></div>' + '<% } %>' + '<div class="viewevent-detail-inner"><div class="viewevent-left"><div class="viewevent-detail-1">Category:<span class="viewevent-note">' + '<%=category%>' + '</span></div><div class="viewevent-detail-1">Note: <span class="viewevent-note">' + '<%=notes%>' + '</span></div><div class="viewevent-detail-1">Location: <span class="viewevent-note">' + '<%=location%>' + '</span></div></div><div class="viewevent-right"><div class="viewevent-asignee"><label>People:</label><div class="viewevent-asignee-right">' + '<% _.each(users, function(user) { %>' + '<div class="viewevent-detail-3">' + '<%=user.first_name%> <%=user.last_name%>' + '</div>' + '<% }); %>' + '</div></div></div></div></div>'),
    initialize: function() {
        this.model.on('change', this.render, this);
    },
    events: {
        "click .delevent": "deleteEvent"
    },
    deleteEvent: function(e) {
        var eventid = $(e.target).attr('eventid');
        $('#deleteEventId').attr('value', eventid);
        $('#myModal-item-delete').modal('show');
    },
    render: function() {
        this.$el.html(this.template(this.model.toJSON()));
        return this;
    }
});
var EventsListView = Backbone.View.extend({
    el: '#time_listing',
    initialize: function() {
        _.bindAll(this, "render");
        this.collection.bind('reset', this.render, this);
    },
    render: function() {
        $('.cal_date').text(moment(this.collection.selectedDate, "YYYY-MM-DD").format('D'));
        $('#cal_month').text(moment(this.collection.selectedDate, "YYYY-MM-DD").format('MMMM'));
        $('#cal_year').text(moment(this.collection.selectedDate, "YYYY-MM-DD").format('YYYY'));
        $('#time_listing').empty();
        this.collection.forEach(this.addOne, this);
    },
    addOne: function(eventItem) {
        var starttimeformat = moment(eventItem.get('start_time'), 'hh:mm:ss').format('h:mm a');
        var endtimeformat = moment(eventItem.get('end_time'), 'hh:mm:ss').format('h:mm a');
        eventItem.set({
            'start_time': starttimeformat
        });
        eventItem.set({
            'end_time': endtimeformat
        });
        var eventsTempView = new EventsView({
            model: eventItem
        });
        this.$el.append(eventsTempView.render().el);
    }
});