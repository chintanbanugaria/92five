$(function() {
    var newpass = $('#password'),
        confirmpass = $('#confirmpass')
        form = $('#newpassform');
    form.on('submit', function(e) {
        if ($('#progress').hasClass('progressbarValid') && newpass.val() == confirmpass.val()) {} else {
            e.preventDefault();
        }
    });
    $("#password").complexify({
        minimumChars: 9,
        strengthScaleFactor: 0.6
    }, function(valid, complexity) {
        if (!valid) {
            $('#progress').css({
                'width': complexity + '%'
            }).removeClass('progressbarValid').addClass('progressbarInvalid');
        } else {
            $('#progress').css({
                'width': complexity + '%'
            }).removeClass('progressbarInvalid').addClass('progressbarValid');
        }
    });
    confirmpass.on('keydown input', function() {
        if (newpass.val() == confirmpass.val()) {
            $('#confirmtick').removeClass('fail1').addClass('pass1');
        } else {
            $('#confirmtick').removeClass('pass1').addClass('fail1');
        }
    });
    confirmpass.on('focus input', function() {
        if (confirmpass.val() == '') {
            $('#confirmtick').removeClass('pass1').addClass('fail1');
        }
    });
});