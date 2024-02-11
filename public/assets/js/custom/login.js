var redirect = null;

$(document).ready(function () {

    redirect = getUrlParameter('redirect');
    if (user != '' && redirect != '') {
        location.href = redirect;
    }

    toastr.options = {
        timeOut: 4000,
        progressBar: true,
        showMethod: "slideDown",
        hideMethod: "slideUp",
        showDuration: 200,
        hideDuration: 200
    };


    //


    $('#btnLogIn').on('click', function (event) {
        event.preventDefault();
        var data = $('#loginForm').serialize();
        // var data = new FormData(form);

        $.ajax({
            type: "POST",
            url: "/login",
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                $('#btnLogIn').html('verifying ...')
            },
            success: function (response) {

                $('#btnLogIn').html('Success')
                console.log(response);

                if (response.success) {

                    if (response.result == 'MISLuser') {
                        location.href = '/dashbord-Misl';
                    }
                    if (response.result == 'PCuser') {
                        location.href = '/dashbord-Parent';
                    }
                    if (response.result == 'CCuser') {
                        location.href = '/main_panel-Child';
                    }else {
                        toastr.error('User level not defined');
                    }

                }
                else {
                    toastr.error(response.message);
                    $('#btnLogIn').html('Sign in')

                }
            },
            error: function (error) {
                console.log(error);

            },
            complete: function () {

            }

        });

    });

});


function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
};
