console.log('common Features.js is loading')
$(document).ready(function () {
    if ($('body').hasClass('dark')) {
        $('#theamDarkControlerText').text('Light Mode');
        $("#theamDarkControler").prop("checked", true);
    }
    else {
        $('#theamDarkControlerText').text('Dark Mode');
        $("#theamDarkControler").prop("checked", false);
    }

    $('#theamDarkControler').change(function () {
        var darkMood = 0;
        if (this.checked) {
            darkMood = 1
            $('body').addClass('dark')
            $('#theamDarkControlerText').text('Light Mode');
        } else {
            darkMood = 0;
            $('body').removeClass('dark')
            $('#theamDarkControlerText').text('Dark Mode');
        }
        SaveTheme(darkMood)
    })
    // loadTheam();
});
function errorElement(el) {
    el[0].style.border = '1px solid red';
    setTimeout(function () {
        el[0].style.border = '';
    }, 4000);
}
function responseBody(success, name, message, result) {
    body = {
        "success": success,
        "message": message,
        "name": name,
        "result": result
    }
    return body;
}

function SaveTheme(darkMood) {
    $.ajax({
        type: 'POST',
        url: '/SaveTheme',
        data: { 'darkMood': darkMood },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            console.log(response)
            if (response.success) {
                toastr.success('Theme changed');
            }

        }, error: function (data) {
            console.log(data)
            console.log('Something Went Wrong');
        }
    });
}
function createMultipleSelectArray(data) {
    var arr = [];
    data.forEach(element => {
        arr.push(
            element.id,
        );
    });
    console.log()
    return arr;

}

function saveOrUpdate(url, data, form) {
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        processData: false,
        contentType: false,
        cache: false,
        timeout: 800000,
        beforeSend: function () {
            $('#btnSave').html('waiting');
        },
        success: function (response) {
            console.log(response);
            if (response.success) {
                toastr.success(response.message);
                form.trigger('reset');
                location.href = parent_url;
                $('#btnSave').html('Done');
            } else {
                toastr.error(response.message);
            }
        },
        error: function (error) {
            console.log(error);
            if (error.status == 422) {
                console.log(error.responseJSON);
                console.warn(error.responseJSON.errors);
                $.each(error.responseJSON.errors, function (i, error) {
                    var el = $(document).find('[name="' + i + '"]');
                    errorElement(el);
                    toastr.warning(error[0]);
                    console.clear();
                });
            } else {
                toastr.error('Something went wrong');
            }
        },
        complete: function () {
            $('#btnSave').html(url.includes('save') ? 'Save' : 'Update');
        }
    });
}
function loadDropDownData(url, dropdownData) {
    $.ajax({
        type: 'GET',
        url: url + 'loadDropDownData',
        async: false,
        success: function (response) {
            console.log(response);
            if (response.success) {
                $.each(dropdownData, function (dataKey, dataValue) {
                    var options = '';
                    options += '<option value="">-Select-</option>';

                    $.each(response.result[dataKey], function (index, value) {
                        options += '<option value="' + value.id + '">' + value[dataValue.key] + '</option>';
                    });
                    $(dataValue.elementID).html(options);
                });
            }
        },
        error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
