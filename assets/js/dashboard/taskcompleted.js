$(function() {
    $('.knob').each(function() {
        var $this = $(this);
        var myVal = $this.attr("value");
        // alert(myVal);
        $this.knob({});
        $({
            value: 0
        }).animate({
            value: myVal
        }, {
            duration: 2000,
            easing: 'swing',
            step: function() {
                $this.val(Math.ceil(this.value)).trigger('change');
            }
        })
    });
    $('.proj_knob').each(function() {
        var $this = $(this);
        var myVal = $this.attr("value");
        // alert(myVal);
        $this.knob({});
        $({
            value: 0
        }).animate({
            value: myVal
        }, {
            duration: 2000,
            easing: 'swing',
            step: function() {
                $this.val(Math.ceil(this.value)).trigger('change');
                $this.val($this.val() + '%');
            }
        })
    });
});