console.log('supplierConfigure .js loadimng');
var parent_url = '/buying/supplier_list'
$(document).ready(function () {

    $('#addressAndContactContainer').hide();

    $('#btnSave').on('click', function () {
        var form = $('#frmsupplierConfigure ').get(0);
        var data = new FormData(form);

        if ($('#btnSave').text().trim() == 'Save') {
            save(data);
        }
        else {
            update(data);
        }

    });
    $('#btnNewAddress').click(function () {
        loadAddressForm($('#hiddenId').val())
    });
    $('#btnNewContact').click(function () {
        loadContactForm($('#hiddenId').val())
    });
    $('#btnExistingAddress').click(function () {
        loadAddress();
    });
    $('#btnExistingContact').click(function () {
        loadContacts();
    });
    $('#ModelLink_btn_update').click(function () {
        link($('#hiddenId').val(), $('#linkType').val(), $('#linkInput').val());
    });


    loadCountries();
    loadSupplierGroup();
    loadCurrencies();

    loadSupplier();

});
function save(data) {
    $.ajax({
        type: "POST",
        url: "/buying/supplierConfigure/save",
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
                $('#frmsupplierConfigure ').trigger("reset");
                location.href = parent_url;

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
                    //  el[0].style.border = '1px solid red';

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
        url: "/buying/supplierConfigure/update",
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
                $('#frmsupplierConfigure ').trigger("reset");
                location.href = parent_url;

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
                    //  el[0].style.border = '1px solid red';

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
            $('#btnSave').html('Update')
        }
    });
};

function loadSupplier() {

    if (window.location.search.length > 0) {
        var sPageURL = window.location.search.substring(1);
        var param = sPageURL.split('&');
        var id = param[0];
        if (param.length == 2) {
            console.log('view ')
            $('#btnSave').hide();
            $('#addressAndContactContainer').show();


        } else {
            console.log('edit ');
            $('#btnSave').text('Update');
            $('#addressAndContactContainer').show();


        }

    }
    if (id) {
        $.ajax({
            type: "GET",
            url: "/buying/supplierConfigure/loadSupplier/" + id,
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

                    $('#supplier_name').val(data.supplier_name);
                    $('#country').val(data.country);
                    $('#default_bank_account').val(data.default_bank_account);
                    $('#tax_id').val(data.tax_id);
                    $('#tax_category').val(data.tax_category);
                    $('#tax_withholding_category').val(data.tax_withholding_category);
                    $('#represents_company').val(data.represents_company);
                    $('#supplier_group').val(data.supplier_group);
                    $('#pan').val(data.pan);
                    $('#language').val(data.language);
                    $('#default_currency').val(data.default_currency);
                    $('#default_price_list').val(data.default_price_list);
                    $('#payment_terms').val(data.payment_terms);
                    $('#hold_type').val(data.hold_type);
                    $('#release_date').val(data.release_date);
                    $('#website').val(data.website);
                    $('#supplier_details').val(data.supplier_details);
                    $('#_comments').val(data._comments);
                    $('#list_index').val(data.list_index);

                    if (data.is_transporter) {
                        $("#is_transporter").prop("checked", true);
                    }
                    if (data.is_internal_supplier) {
                        $("#is_internal_supplier").prop("checked", true);
                    }
                    if (data.allow_purchase_invoice_creation_without_purchase_order) {
                        $("#allow_purchase_invoice_creation_without_purchase_order").prop("checked", true);
                    }
                    if (data.allow_purchase_invoice_creation_without_purchase_receipt) {
                        $("#allow_purchase_invoice_creation_without_purchase_receipt").prop("checked", true);
                    }
                    if (data.on_hold) {
                        $("#on_hold").prop("checked", true);
                    }
                    if (data.enabled) {
                        $("#enabled").prop("checked", true);
                    }
                    else {
                        $("#enabled").prop("checked", false);
                    }
                    loadSupplierAddress(data.id);
                    loadSupplierContact(data.id);
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

function loadCountries() {
    $.ajax({
        type: 'GET',
        url: '/buying/supplierConfigure/loadCountries',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.country_name + ' </option>';
                });
                $('#country').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}

function loadSupplierGroup() {
    $.ajax({
        type: 'GET',
        url: '/buying/supplierConfigure/loadSupplierGroup',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.SupGroupName + ' </option>';
                });
                $('#supplier_group').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}

function loadCurrencies() {
    $.ajax({
        type: 'GET',
        url: '/buying/supplierConfigure/loadCurrencies',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.currency_name + ' </option>';
                });
                $('#default_currency').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}

function loadAddressForm(id) {
    $.ajax({
        type: 'GET',
        url: '/buying/supplierConfigure/SetSessionAndReturnUrl/' + id,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                location.href = '/crm/addres_configure/'
            }
        }, error: function (data) {
            console.log(data);
            toastr.error(response.message);
            console.log('something went wrong');
        }
    });
}

function loadSupplierAddress(id) {
    $.ajax({
        type: 'GET',
        url: '/buying/supplierConfigure/loadSupplierAddress/' + id,
        async: false,
        success: function (response) {
            console.log(response)

            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {
                    var data = value[0]
                    html += `<div class="col-md-6 mb-2 ">
                                <div class="card">
                                    <div class="card-body ">
                                        <button type="button" style="float: right" onclick="loadEditAddress(`+ data.id + `)" class="btn btn-dark btn-sm">Edit</button>
                                        <div style="float: left">
                                            <h6>`+ data.AddressTitle + `(` + data.typeName + `)</h6>
                                            `+ data.Addressline1 + `</br>
                                            `+ data.Addressline2 + `</br>
                                            `+ data.CityTown + `</br>
                                            `+ data.country_name + `</br>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                });
                $('#addressContainer').html(html);
            }
        }, error: function (data) {
            console.log(data);
            toastr.error(response.message);
            console.log('something went wrong');
        }
    });
}
function loadEditAddress(addressID) {
    var cusid = $('#hiddenId').val();
    $.ajax({
        type: 'GET',
        url: '/buying/supplierConfigure/SetSessionAndReturnUrl/' + cusid,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                location.href = '/crm/addres_configure?' + addressID
            }
        }, error: function (data) {
            console.log(data);
            toastr.error(response.message);
            console.log('something went wrong');
        }
    });
}

function loadContactForm(id) {
    $.ajax({
        type: 'GET',
        url: '/buying/supplierConfigure/SetSessionAndReturnUrl/' + id,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                location.href = '/crm/contact_configure/'
            }
        }, error: function (data) {
            console.log(data);
            toastr.error(response.message);
            console.log('something went wrong');
        }
    });
}
function loadSupplierContact(id) {
    $.ajax({
        type: 'GET',
        url: '/buying/supplierConfigure/loadSupplierContact/' + id,
        async: false,
        success: function (response) {
            console.log(response)

            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {
                    var data = value[0]
                    html += `<div class="col-md-6 mb-2 ">
                                <div class="card">
                                    <div class="card-body ">
                                        <button type="button" style="float: right" onclick="loadEditContact(`+ data.id + `)" class="btn btn-dark btn-sm">Edit</button>
                                        <div style="float: left">
                                            <h5>`+ data.FirstName + `

                                       `
                    if (data.LastName != null) {
                        html += `` + data.LastName + `</h5>`
                    }
                    else {
                        `</h5>`
                    }
                    if (data.Designation != null) {
                        html += `<h5><em>` + data.Designation + `</em></h5>`

                    }

                    html += ` </div>
                                    </div>
                                </div>
                            </div>`;
                });
                $('#contactsContainer').html(html);
            }
        }, error: function (data) {
            console.log(data);
            toastr.error(response.message);
            console.log('something went wrong');
        }
    });
}
function loadEditContact(contactId) {
    var cusid = $('#hiddenId').val();
    $.ajax({
        type: 'GET',
        url: '/buying/supplierConfigure/SetSessionAndReturnUrl/' + cusid,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                location.href = '/crm/contact_configure?' + contactId
            }
        }, error: function (data) {
            console.log(data);
            toastr.error(response.message);
            console.log('something went wrong');
        }
    });
}
function loadAddress() {
    $.ajax({
        type: 'GET',
        url: '/buying/supplierConfigure/loadAddress',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.AddressTitle + ' | ' + value.typeName + ' </option>';
                });
                $('#linkInput').html(html);
                $('#linkType').val('Address')
                $('#linkAttrir').text('Addess')
                $('#ModelLink').modal('toggle');

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadContacts() {
    $.ajax({
        type: 'GET',
        url: '/buying/supplierConfigure/loadContacts',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.FirstName + ' ' + value.LastName + ' </option>';
                });
                $('#linkInput').html(html);
                $('#linkType').val('contact')
                $('#linkAttrir').text('Contacts')
                $('#ModelLink').modal('toggle');

            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function link(SupoId, type, linkId) {
    $.ajax({
        type: "POST",
        url: "/buying/supplierConfigure/link",
        data: {
            'SupoId': SupoId,
            'type': type,
            'linkId': linkId
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            console.log(response);
            $('#linkInput').html('');
            $('#linkType').val('');
            $('#linkAttrir').text('');
            $('#ModelLink').modal('toggle');
            switch (type) {
                case 'Address':
                    loadSupplierAddress(SupoId);
                    break;
                case 'contact':
                    loadSupplierContact(SupoId);
                    break;
                default:
                    loadSupplierAddress(SupoId);
                    loadSupplierContact(SupoId);
                    break;
            }
        },
        error: function (error) {
            console.log(error);

            if (error.status == 422) { // when status code is 422, it's a validation issue

                $.each(error.responseJSON.errors, function (i, error) {
                    var el = $('#linkInput');
                    errorElement(el);
                    toastr.warning(error[0]);
                });
            }
            else {
                toastr.error('Something went wrong');
            }
        }
    });
}
