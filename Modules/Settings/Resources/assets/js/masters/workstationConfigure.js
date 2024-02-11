console.log('workstationConfigure .js loadimng');
var parent_url = '/settings/workstation_list'
$(document).ready(function () {


    $('#btnSave').on('click', function () {
        var form = $('#frmworkstationConfigure');
        var data = new FormData(form.get(0));
        var url = $('#btnSave').text().trim() === 'Save' ? '/settings/workstationConfigure/save' : '/settings/workstationConfigure/update';
        saveOrUpdate(url, data, form);
    });

    var dropdownData = {
        Company: { elementID: '#CompanyID', key: 'companyName' },
        Printer: { elementID: '#default_printer', key: 'printer_name' },
    };
    loadDropDownData('/settings/workstationConfigure/', dropdownData);
    loadWorkstation();

});
function loadWorkstation() {

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
            url: "/settings/workstationConfigure/loadWorkstation/" + id,
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

                    $('#hiddenId').val(data.id);

                    $('#CompanyID').val(data.CompanyID);
                    $('#WorkstationName').val(data.WorkstationName);
                    $('#WorkstationDescription').val(data.WorkstationDescription);
                    $('#default_printer').val(data.default_printer);

                    $('#list_index').val(data.list_index);

                    if (data.is_waste_location) {
                        $("#is_waste_location").prop("checked", true);
                    }
                    if (data.isInternal) {
                        $("#isInternal").prop("checked", true);
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
