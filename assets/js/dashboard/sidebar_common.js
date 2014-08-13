$(document).ready(function() {
    var lastHeight = $(window).height();
    var lastWidth = $(window).width();
    $(window).on("debouncedresize", function() {
        if ($(window).height() != lastHeight || $(window).width() != lastWidth) {
            lastHeight = $(window).height();
            lastWidth = $(window).width();
            sidebar.update_scroll();
            if (!is_touch_device()) {
                $('.sidebar_switch').qtip('hide');
            }
        }
    });
    sidebar.start();
    sidebar.make_scroll();
    sidebar.update_scroll();
});

sidebar = {
    start: function() {
        if ($(window).width() > 990) {
            if (!$('body').hasClass('sidebar_hidden')) {
                $('.sidebar_switch').toggleClass('on_switch off_switch').attr('title', 'Show Sidebar');
            } else {
                $('.sidebar_switch').toggleClass('on_switch off_switch').attr('title', 'Show Sidebar');
            }
        } else {
            $('body').addClass('sidebar_hidden');
            $('.sidebar_switch').removeClass('on_switch').addClass('off_switch');
        }

        sidebar.info_box();
        //* sidebar visibility switch
        $('.sidebar_switch').click(function() {
            $('.sidebar_switch').removeClass('on_switch off_switch');
            if ($('body').hasClass('sidebar_hidden')) {
                $('body').removeClass('sidebar_hidden');
                $('.sidebar_switch').addClass('on_switch').show();
                $('.sidebar_switch').attr('title', "Hide Sidebar");
            } else {
                $('body').addClass('sidebar_hidden');
                $('.sidebar_switch').addClass('off_switch');
                $('.sidebar_switch').attr('title', "Show Sidebar");
            }
            sidebar.update_scroll();
            $(window).resize();
        });
        $('.sidebar .accordion-toggle').click(function(e) {
            e.preventDefault()
        });
    },
    info_box: function() {
        var s_box = $('.sidebar_info');
        var s_box_height = s_box.actual('height');
        s_box.css({
            'height': s_box_height
        });
        $('.push').height(s_box_height);
        $('.sidebar_inner').css({
            'margin-bottom': '-' + s_box_height + 'px',
            'min-height': '100%'
        });
    },

    make_scroll: function() {
        antiScroll = $('.antiScroll').antiscroll().data('antiscroll');
    },
    update_scroll: function() {
        if ($('.antiScroll').length) {
            if ($(window).width() > 990) {
                $('.antiscroll-inner,.antiscroll-content').height($(window).height() - 40);
            } else {
                $('.antiscroll-inner,.antiscroll-content').height('400px');
            }
            antiScroll.refresh();
        }
    }
};