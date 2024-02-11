console.log('itemPriceConfigure .js loadimng');
var parent_url = '/accounting/itemPrice_list'
$(document).ready(function () {


    $('#btnSave').on('click', function () {
        var form = $('#frmitemPriceConfigure ').get(0);
        var data = new FormData(form);

        if ($('#btnSave').text().trim() == 'Save') {
            save(data);
        }
        else {
            update(data);
        }

    });

    $('#price_list').change(function () {
        loadPriceList(this.value);
    });

    var table = $('#tableitemPrice').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 1, 2, 3, 4],
            "className": "text-center",

        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "5%" },
            { "data": "thitem", 'width': "23.75%" },
            { "data": "thUOM", 'width': "23.75%" },
            { "data": "thitemPrice", 'width': "23.75%" },
            { "data": "action", 'width': "23.75%" },
        ],
    });


    loadItems();
    loadPriceLists();
    loadUOMs();
    // loadItemPrice();
    checkUrlParameter();
});
function save(data) {
    $.ajax({
        type: "POST",
        url: "/accounting/itemPriceConfigure/save",
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
                // $('#frmitemPriceConfigure ').trigger("reset");
                $('#item ').val("");
                $('#uom ').val("");
                $('#price ').val("");
                loadPriceList($('#price_list').val());

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
        url: "/accounting/itemPriceConfigure/update",
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
                $('#frmitemPriceConfigure ').trigger("reset");
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

function checkUrlParameter() {
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
        loadItemPrice(id)
    }
}
function loadItemPrice(id) {

    $.ajax({
        type: "GET",
        url: "/accounting/itemPriceConfigure/loadItemPrice/" + id,
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

                loadPriceList(data.price_list)
                $('#item').val(data.item);
                $('#price_list').val(data.price_list);
                $('#uom').val(data.uom);
                $('#price').val(data.price);


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

function loadItems() {
    $.ajax({
        type: 'GET',
        url: '/accounting/itemPriceConfigure/loadItems',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.item_name + ' </option>';
                });
                $('#item').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadPriceLists() {
    $.ajax({
        type: 'GET',
        url: '/accounting/itemPriceConfigure/loadPriceLists',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.price_list_name + ' </option>';
                });
                $('#price_list').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadUOMs() {
    $.ajax({
        type: 'GET',
        url: '/accounting/itemPriceConfigure/loadUOMs',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.UomName + ' </option>';
                });
                $('#uom').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadPriceList(id) {
    $.ajax({
        type: 'GET',
        url: '/accounting/itemPriceConfigure/loadPriceList/' + id,
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var item = response.result[i]['item'];
                    var uom = response.result[i]['uom'];
                    var price = response.result[i]['price'];
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    data.push({
                        "thId": id,
                        "thitem": item,
                        "thUOM": uom,
                        "thitemPrice": price,
                        "action": edit + dele,
                    });
                }

                var table = $('#tableitemPrice').DataTable();
                table.clear();
                table.rows.add(data).draw();
            }
        }, error: function (data) {
            console.log('something went wrong');
        }
    });
}
function _delete(id) {
    $.ajax({
        type: 'DELETE',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: '/accounting/itemPrice/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadPriceList($('#price_list').val());
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};

function edit(id) {
    loadItemPrice(id);
}

