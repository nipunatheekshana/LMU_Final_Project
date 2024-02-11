console.log('createCompany.js loading')

$(document).ready(function () {


    $('#btnSave').on('click', function () {
        var form = $('#frmChildCompany').get(0);
        var data = new FormData(form);

        if ($('#btnSave').text().trim() == 'Save') {
            save(data);
        }
        else {
            update(data);
        }

    });
    $("#companyName").keyup(function () {
        var str = this.value;
        if (str != '') {
            var matches = str.match(/\b(\w)/g); // ['J','S','O','N']
            var acronym = matches.join(''); // JSON
            $('#abbr').val(acronym);
        } else {
            $('#abbr').val('');

        }
    });
    $('#is_group').change(function () {
        if (this.checked) {
            // $('#group_company_id').
            $("#group_company_id").prop('disabled', true);
            $("#group_company_id").val('');

        } else {
            $("#group_company_id").prop('disabled', false);

        }
    });
    loadActivityLog();
    loadGroupCompanies();
    loadCountries();
    loadCurrency();
    loadDomains();
    loadChildCompany();

});

function save(data) {
    $.ajax({
        type: "POST",
        url: "/settings/createCompany/save",
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        processData: false,
        contentType: false,
        cache: false,
        timeout: 800000,
        beforeSend: function () {
            $('#btnSave').html('waiting')

        },
        success: function (response) {
            console.log(response);
            if (response.success) {
                toastr.success(response.message);
                $('#frmChildCompany').trigger("reset");
                $('#btnSave').html('Done')
            }
            else {
                toastr.error(response.message);
            }
        },
        error: function (error) {
            console.log(error);

            if (error.status == 422) { // when status code is 422, it's a validation issue
                console.log(error.responseJSON);
                // you can loop through the errors object and show it to the user
                console.warn(error.responseJSON.errors);
                // display errors on each form field
                $.each(error.responseJSON.errors, function (i, error) {
                    var el = $(document).find('[name="' + i + '"]');
                    errorElement(el);
                    toastr.warning(error[0]);
                    console.clear()
                });
            }
            else {
                toastr.error('Something went wrong');
            }
        },
        complete: function () {
            $('#btnSave').html('Save')
        }
    });
};
function update(data) {
    $.ajax({
        type: "POST",
        url: "/settings/createCompany/update",
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        processData: false,
        contentType: false,
        cache: false,
        timeout: 800000,
        beforeSend: function () {
            $('#btnSave').html('waiting')

        },
        success: function (response) {
            console.log(response);
            if (response.data.success) {
                toastr.success(response.data.message);
                $('#frmChildCompany').trigger("reset");
                // location.href = "/childCompany_List";
                loadActivityLog();
                loadChildCompany()

                location.href = "/settings/Company_List";

            }
            else {
                toastr.error(response.data.message);
            }
        },
        error: function (error) {
            console.log(error);

            if (error.status == 422) { // when status code is 422, it's a validation issue
                console.log(error.responseJSON);
                // you can loop through the errors object and show it to the user
                console.warn(error.responseJSON.errors);
                // display errors on each form field
                $.each(error.responseJSON.errors, function (i, error) {
                    var el = $(document).find('[name="' + i + '"]');
                    errorElement(el);
                    toastr.warning(error[0]);
                    console.clear()
                });
            }
            else {
                toastr.error('Something went wrong');
            }
        },
        complete: function () {

        }
    });
};
function loadChildCompany() {

    if (window.location.search.length > 0) {
        var sPageURL = window.location.search.substring(1);
        var param = sPageURL.split('&');
        var id = param[0];
        if (param.length == 2) {
            console.log('view ')
            $('#btnSave').hide();

        } else {
            console.log('edit ');
            $('#btnSave').text('Update');

        }

    }
    if (id) {
        $.ajax({
            type: "GET",
            url: "/settings/createCompany/loadChildCompany/" + id,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            async: false,
            beforeSend: function () {

            },
            success: function (response) {

                if (response.success) {

                    console.log(response.result);
                    var data = response.result;

                    $('#hiddencompanyid').val(data.id);

                    $('#group_company_id').val(data.group_company_id);
                    $('#companyName').val(data.companyName);
                    $('#abbr').val(data.abbr);
                    // $('#is_group').val(data.is_group);
                    $('#domain_id').val(data.domain_id);
                    $('#country_id').val(data.country_id);
                    $('#company_logo').val(data.company_logo);
                    $('#currency_id').val(data.currency_id);
                    $('#local_currency_id').val(data.local_currency_id);
                    $('#date_of_incorporation').val(data.date_of_incorporation);
                    $('#date_of_commencement').val(data.date_of_commencement);
                    $('#phone_no').val(data.phone_no);
                    $('#fax').val(data.fax);
                    $('#email').val(data.email);
                    $('#website').val(data.website);
                    $('#registration_No').val(data.registration_No);
                    $('#company_description').val(data.company_description);
                    $('#registration_details').val(data.registration_details);
                    $('#list_index').val(data.list_index);

                    $('#currentFishSerialNo').val(data.currentFishSerialNo);
                    $('#minFishSerialNo').val(data.minFishSerialNo);
                    $('#maxFishSerialNo').val(data.maxFishSerialNo);

                    if (data.is_group) {
                        $("#is_group").prop("checked", true);
                    }
                    if (data.enabled) {
                        $("#enabled").prop("checked", true);
                    }
                    else {
                        $("#enabled").prop("checked", false);
                    }

                }

            },
            error: function (error) {
                console.log(error);

            },
            complete: function () {

            }

        });
    }

}
function loadActivityLog() {
    $.ajax({
        type: 'GET',
        url: '/loadActivityLog',
        async: false,
        success: function (response) {
            console.log(response.result)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<li> <b>' + value.userName + '</b> changed <b>' + value.field_name + ' </b> to <b>' + value.new_value + '</b> </li>';
                });
                $('#activityLog').html(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadGroupCompanies() {
    $.ajax({
        type: 'GET',
        url: '/settings/createCompany/loadGroupCompanies',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.companyName + ' </option>';
                });
                $('#group_company_id').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadCountries() {
    $.ajax({
        type: 'GET',
        url: '/settings/createCompany/loadCountries',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.country_name + ' </option>';
                });
                $('#country_id').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadCurrency() {
    $.ajax({
        type: 'GET',
        url: '/settings/createCompany/loadCurrency',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.currency_name + ' </option>';
                });
                $('#currency_id').append(html);
                $('#local_currency_id').append(html);



            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadDomains() {
    $.ajax({
        type: 'GET',
        url: '/settings/createCompany/loadDomains',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.domain_name + ' </option>';
                });
                $('#domain_id').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
