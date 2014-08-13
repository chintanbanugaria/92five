var url = window.location.href;
var tempurl = url.split('dashboard')[0];
var TimesheetEntryModel = Backbone.Model.extend({});
var TimesheetEntryList = Backbone.Collection.extend({
    model: TimesheetEntryModel,
    initialize: function(models, options) {
        this.selectedDate = options.selectedDate;
        this.fetch({
            'reset': true
        });
    },
    url: function() {
        return tempurl + 'dashboard/timesheet/entry/' + this.selectedDate;
    }
});
var TimesheetEntryView = Backbone.View.extend({
    template: _.template($('#timesheet-entry').html()),
    initialize: function() {
        this.model.on('change', this.render, this);
    },
    events: {
        "click .delevent": "deleteEvent"
    },
    deleteEvent: function(e) {
        var eventid = $(e.target).attr('eventid');
        //alert(eventid);
        $('#entryId').attr('value', eventid);
        $('#myModal-item-delete').modal('show');
    },
    render: function() {
        // console.log(this.model.toJSON());
        this.$el.html(this.template(this.model.toJSON()));
        return this;
    }
});
var TimesheetView = Backbone.View.extend({
    el: '#timesheet-detail',
    initialize: function() {
        _.bindAll(this, "render");
        this.collection.bind('reset', this.render, this);
    },
    render: function() {
        if (this.collection.length == 0) {
            $('#timesheet-detail').empty();
            this.$el.append("<div><div class=nodatadisplay_main><div class=nodatadisplay><h2>Sorry. Couldn't find any entry for this day.</h2><div class=nodata_inner><div class=nodata_left></div><div class=nodata_right></div><div class=nodata_detail_2><img src=" + tempurl + "assets/images/dashboard/smile_icon.png alt=></div></div></div></div></div>");
        } else {
            $('#timesheet-detail').empty();
            this.collection.forEach(this.addOne, this);
        }
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
        var eventsTempView = new TimesheetEntryView({
            model: eventItem
        });
        this.$el.append(eventsTempView.render().el);
    }
});