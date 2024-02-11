console.log('customerMasterconfigure.js loadimng');
var parent_url = '/selling/customer_master'
$(document).ready(function () {

    $('#addressAndContactContainer').hide();
    $('#PrimaryContactAddress').hide();
    $('#PrimaryContactPerson').hide();



    $('#btnSave').on('click', function () {
        var form = $('#frmcustomerMasterconfigure').get(0);
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
    $('#btnNewNotify').click(function () {
        loadNotifyForm($('#hiddenId').val())
    });
    $('#btnExistingAddress').click(function () {
        loadAddress();
    });
    $('#btnExistingNotify').click(function () {
        loadNotify();
    });
    $('#btnExistingContact').click(function () {
        loadContacts();
    });
    $('#ModelLink_btn_update').click(function () {
        link($('#hiddenId').val(), $('#linkType').val(), $('#linkInput').val());
    });


    loadCustomerTypes();
    loadCustomerGroups();
    loadCountries();
    loadCurrency();
    loadLanguage();
    loadPriceList()
    loadCustomer();


});
function save(data) {
    $.ajax({
        type: "POST",
        url: "/selling/customerMasterconfigure/save",
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
                $('#frmcustomerMasterconfigure').trigger("reset");
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
        url: "/selling/customerMasterconfigure/update",
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
                $('#frmcustomerMasterconfigure').trigger("reset");
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
function loadCustomer() {

    if (window.location.search.length > 0) {
        var sPageURL = window.location.search.substring(1);
        var param = sPageURL.split('&');
        var id = param[0];
        if (param.length == 2) {
            console.log('view ')
            $('#btnSave').hide();
            $('#addressAndContactContainer').show();
            $('#PrimaryContactAddress').show();
            $('#PrimaryContactPerson').show();
        } else {
            console.log('edit ');
            $('#btnSave').text('Update');
            $('#addressAndContactContainer').show();
            $('#PrimaryContactAddress').show();
            $('#PrimaryContactPerson').show();
        }

    }
    if (id) {
        $.ajax({
            type: "GET",
            url: "/selling/customerMasterconfigure/loadCustomer/" + id,
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
                    loadContactAddress(data.id);
                    loadContactPerson(data.id);

                    $('#CusCode').val(data.CusCode);
                    $('#CusName').val(data.CusName);
                    $('#CusRegNo').val(data.CusRegNo);
                    $('#CusType').val(data.CusType);
                    $('#CusGroup').val(data.CusGroup);
                    $('#CusCountry').val(data.CusCountry);
                    $('#BillingCurrency').val(data.BillingCurrency);
                    $('#DefltLanguage').val(data.DefltLanguage);
                    $('#PrimaryContactPerson').val(data.PrimaryContactPerson);
                    $('#PrimaryContactAddress').val(data.PrimaryContactAddress);
                    $('#MobileNo').val(data.MobileNo);
                    $('#emailAddress').val(data.emailAddress);
                    $('#LicenceNo').val(data.LicenceNo);
                    $('#PriceList').val(data.PriceList);
                    $('#PrimaryBankAccount').val(data.PrimaryBankAccount);
                    $('#max_fish_age').val(data.max_fish_age);
                    $('#list_index').val(data.list_index);
                    if (data.is_internal_customer) {
                        $("#is_internal_customer").prop("checked", true);
                    }
                    if (data.enabled) {
                        $("#enabled").prop("checked", true);
                    }
                    else {
                        $("#enabled").prop("checked", false);
                    }

                    loadCustomerAddress(data.id);
                    loadCustomerContact(data.id);
                    loadCustomerNotify(data.id);

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
function loadCustomerTypes() {
    $.ajax({
        type: 'GET',
        url: '/selling/customerMasterconfigure/loadCustomerTypes',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.customer_type + ' </option>';
                });
                $('#CusType').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadCustomerGroups() {
    $.ajax({
        type: 'GET',
        url: '/selling/customerMasterconfigure/loadCustomerGroups',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.CusGroupName + ' </option>';
                });
                $('#CusGroup').append(html);


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
        url: '/selling/customerMasterconfigure/loadCountries',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.country_name + ' </option>';
                });
                $('#CusCountry').append(html);


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
        url: '/selling/customerMasterconfigure/loadCurrency',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.currency_name + ' </option>';
                });
                $('#BillingCurrency').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadContactPerson(cusId) {
    $.ajax({
        type: 'GET',
        url: '/selling/customerMasterconfigure/loadContactPerson/' + cusId,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {
                    var name = '';
                    if (value.saluwation_name != null) {
                        name = name + value.saluwation_name;
                    }
                    if (value.FirstName != null) {
                        name = name + value.FirstName;
                    }
                    if (value.LastName != null) {
                        name = name + value.LastName;
                    }
                    if (value.Designation != null) {
                        name = name + ' | ' + value.Designation;
                    }
                    html += '<option value="' + value.id + '" > ' + name + ' </option>';
                });
                $('#PrimaryContactPerson').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadContactAddress(cusId) {
    $.ajax({
        type: 'GET',
        url: '/selling/customerMasterconfigure/loadContactAddress/' + cusId,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.AddressTitle + ' </option>';
                });
                $('#PrimaryContactAddress').append(html);


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
        url: '/selling/customerMasterconfigure/SetSessionAndReturnUrl/' + id,
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
function loadCustomerAddress(id) {
    $.ajax({
        type: 'GET',
        url: '/selling/customerMasterconfigure/loadCustomerAddress/' + id,
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
        url: '/selling/customerMasterconfigure/SetSessionAndReturnUrl/' + cusid,
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
        url: '/selling/customerMasterconfigure/SetSessionAndReturnUrl/' + id,
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
function loadCustomerContact(id) {
    $.ajax({
        type: 'GET',
        url: '/selling/customerMasterconfigure/loadCustomerContact/' + id,
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
        url: '/selling/customerMasterconfigure/SetSessionAndReturnUrl/' + cusid,
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
function loadLanguage() {
    $.ajax({
        type: 'GET',
        url: '/selling/customerMasterconfigure/loadLanguage',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.name + ' | ' + value.nativeName + ' | ' + value.langcode + ' </option>';
                });
                $('#DefltLanguage').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadPriceList() {
    $.ajax({
        type: 'GET',
        url: '/selling/customerMasterconfigure/loadPriceList',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.price_list_name + ' </option>';
                });
                $('#PriceList').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadNotifyForm(id) {
    $.ajax({
        type: 'GET',
        url: '/selling/customerMasterconfigure/SetSessionAndReturnUrl/' + id,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                location.href = '/selling/notifyparty_configure/'
            }
        }, error: function (data) {
            console.log(data);
            toastr.error(response.message);
            console.log('something went wrong');
        }
    });
}
function loadCustomerNotify(id) {
    $.ajax({
        type: 'GET',
        url: '/selling/customerMasterconfigure/loadCustomerNotify/' + id,
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
                                        <button type="button" style="float: right" onclick="loadEditNOtify(`+ data.id + `)" class="btn btn-dark btn-sm">Edit</button>
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
                $('#NotifyPartyContainer').html(html);
            }
        }, error: function (data) {
            console.log(data);
            toastr.error(response.message);
            console.log('something went wrong');
        }
    });
}
function loadEditNOtify(addressID) {
    var cusid = $('#hiddenId').val();
    $.ajax({
        type: 'GET',
        url: '/selling/customerMasterconfigure/SetSessionAndReturnUrl/' + cusid,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                location.href = '/selling/notifyparty_configure?' + addressID
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
        url: '/selling/customerMasterconfigure/loadAddress',
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
function loadNotify() {
    $.ajax({
        type: 'GET',
        url: '/selling/customerMasterconfigure/loadNotify',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.AddressTitle + ' </option>';
                });
                $('#linkInput').html(html);
                $('#linkType').val('notify')
                $('#linkAttrir').text('Notify')
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
        url: '/selling/customerMasterconfigure/loadContacts',
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
function link(cusId, type, linkId) {
    $.ajax({
        type: "POST",
        url: "/selling/customerMasterconfigure/link",
        data: {
            'cusId': cusId,
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
                    loadCustomerAddress(cusId);
                    break;
                case 'notify':
                    loadCustomerNotify(cusId);
                    break;
                case 'contact':
                    loadCustomerContact(cusId);
                    break;
                default:
                    loadCustomerAddress(cusId);
                    loadCustomerNotify(cusId);
                    loadCustomerContact(cusId);
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
