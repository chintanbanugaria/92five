$(function() {

    var newpass = $('#password'),
        confirmpass = $('#confirmpassword')
        form = $('#signupForm'),
        first_name = $('#first_name'),
        last_name = $('#last_name');

    form.on('submit', function(e) {

        if ($('#progress').hasClass('progressbarValid') && newpass.val() == confirmpass.val() && first_name.val() != '' && last_name.val() != '') {

        } else {
            e.preventDefault();

            if (confirmpass.val() == '') {
                $('#confirmtick').removeClass('pass1').addClass('fail1');
            }
            if (newpass.val() != confirmpass.val()) {
                $('#confirmtick').removeClass('pass1').addClass('fail1');
            }
            if (first_name.val() == '') {
                $('#confirmtick1').removeClass('pass1').addClass('fail1');
            }
            if (last_name.val() == '') {
                $('#confirmtick1').removeClass('pass1').addClass('fail1');
            }

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

    first_name.on('focusout input', function() {

        if (first_name.val() == '') {
            $('#confirmtick1').removeClass('pass1').addClass('fail1');
        } else if (first_name.val() != '' && last_name.val() == '') {
            $('#confirmtick1').removeClass('pass1').addClass('fail1');
        } else {
            $('#confirmtick1').removeClass('fail1').addClass('pass1');
        }

    });
    last_name.on('focusout input', function() {

        if (last_name.val() == '') {
            $('#confirmtick1').removeClass('pass1').addClass('fail1');
        } else if (last_name.val() != '' && first_name.val() == '') {
            $('#confirmtick1').removeClass('pass1').addClass('fail1');
        } else {
            $('#confirmtick1').removeClass('fail1').addClass('pass1');
        }

    });

});