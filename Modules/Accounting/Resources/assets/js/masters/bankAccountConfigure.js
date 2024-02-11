console.log('bankAccountConfigure .js loadimng');
var parent_url = '/accounting/bankAccount_list'
$(document).ready(function () {

    $('#btnSave').on('click', function() {
        var form = $('#frmbankAccountConfigure');
        var data = new FormData(form.get(0));
        var url = $('#btnSave').text().trim() === 'Save' ? '/accounting/bankAccountConfigure/save' : '/accounting/bankAccountConfigure/update';
        saveOrUpdate(url, data,form);
      });

      var dropdownData = {
        Company: { elementID: '#company', key: 'companyName' },
        BankAccountType: { elementID: '#account_type', key: 'account_type_name' },
        Bank: { elementID: '#bank', key: 'bank_name' },
        Currency: { elementID: '#default_currency', key: 'currency_name' },

    };
    loadDropDownData( '/accounting/bankAccountConfigure/',dropdownData);
    loadBankAccount();

});


function loadBankAccount() {

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
            url: "/accounting/bankAccountConfigure/loadBankAccount/" + id,
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

                    $('#company').val(data.company);
                    $('#account_title').val(data.account_title);
                    $('#account_type').val(data.account_type);
                    $('#bank').val(data.bank);
                    $('#bank_code').val(data.bank_code);
                    $('#branch').val(data.branch);
                    $('#branch_code').val(data.branch_code);
                    $('#account_name').val(data.account_name);
                    $('#account_number').val(data.account_number);
                    $('#default_currency').val(data.default_currency);
                    $('#swift_code').val(data.swift_code);

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

