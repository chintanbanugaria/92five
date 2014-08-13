var from_$input = $('#startdate').pickadate({
    onOpen: function() {
        scrollIntoView(this.$node);
    }
});
var from_picker = from_$input.pickadate('picker');

var to_$input = $('#enddate').pickadate();
var to_picker = to_$input.pickadate('picker');

// Check if there’s a “from” or “to” date to start with.
if (from_picker.get('value')) {
    to_picker.set('min', from_picker.get('select'));
}
if (to_picker.get('value')) {
    from_picker.set('max', to_picker.get('select'));
}

// When something is selected, update the “from” and “to” limits.
from_picker.on('set', function(event) {
    if (event.select) {
        to_picker.set('min', from_picker.get('select'));
    } else if ('clear' in event) {
        to_picker.set('min', false);
    }
});
to_picker.on('set', function(event) {
    if (event.select) {
        from_picker.set('max', to_picker.get('select'));
    } else if ('clear' in event) {
        from_picker.set('max', false);
    }
});

function scrollIntoView($node) {
    $('html,body').animate({
        scrollTop: ~~$node.offset().top - 60
    });
}