console.log('newRequirementConfigure.js loadimng');
var parent_url = '/mnu/productionPlan_configure?'

$(document).ready(function () {

    var table = $('#tablenewRequirementConfigure').DataTable({
        scrollY: 600,
        scrollX: true,
        scrollY: true,
        scrollCollapse: true,

        'columnDefs': [
            {
                "targets": [6],
                "visible": false,
            }, {
                "targets": [0, 1, 2, 3, 4, 5],
                "className": "text-center",

            }
        ],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "10%" },
            { "data": "thItemCode", 'width': "18.75%" },
            { "data": "thItem", 'width': "18.75%" },
            { "data": "thRequiredQuantity", 'width': "18.75%" },
            { "data": "thRequiredWeight", 'width': "18.75%" },
            { "data": "action", 'width': "5%" },
            { "data": "UnitWeight" },

        ],
    });

    var ItemTable = $('#tableItem').DataTable({
        scrollY: 600,
        scrollX: true,
        scrollY: true,
        scrollCollapse: true,
        'columnDefs': [{
            "targets": [0, 1],
            "className": "text-center",
        }],
        "order": [],
        "columns": [
            { "data": "thId", 'width': "20%" },
            { "data": "thItem", 'width': "80%" },
        ],
    });
    //RAW on click event
    $('#tableItem tbody').on('click', 'tr', function () {
        var data = ItemTable.row(this).data();
        addItem(data.thId);
    });
    $('#btnAddItem').click(function () {
        loadItems();
        // $('#ItemModel').modal('toggle');
    });
    $('#btnSaveQuantity').click(function () {
        setReqWeight();
    });
    $('#btnSave').on('click', function () {
        var form = $('#frmNewRequirements ').get(0);
        var data = new FormData(form);
        var DetailArr = InitiateDetailArry();

        for (var i = 0; i < DetailArr.length; i++) {
            data.append('arr[]', JSON.stringify(DetailArr[i]));
        }

        if ($('#btnSave').text().trim() == 'Save') {
            save(data);
        }
        // else {
        //     update(data);
        // }

    });

    //save model with Enter key
    $("#qty").keyup(function (event) {
        if (event.keyCode === 13) {
            $("#btnSaveQuantity").click();
        }
    });

    loadToday();
});


function save(data) {
    $.ajax({
        type: "POST",
        url: "/mnu/newRequirementConfigure/save",
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
                $('#frmNewRequirements ').trigger("reset");
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

function loadItems() {

    $.ajax({
        type: 'GET',
        url: '/mnu/newRequirementConfigure/loadItems',
        success: function (response) {
            console.log(response.result)
            if (response.success) {
                var data = [];
                for (i = 0; i < response.result.length; i++) {
                    var id = response.result[i]['id'];
                    var item_name = response.result[i]['item_name'];
                    data.push({
                        "thId": id,
                        "thItem": item_name,
                    });
                }

                var table = $('#tableItem').DataTable();
                table.clear();
                table.rows.add(data).draw();

                $('#ItemModel').modal('toggle');
            }
        }, error: function (data) {
            console.log('something went wrong');
        }
    });

}
function addItem(itemId) {
    $.ajax({
        type: 'GET',
        url: '/mnu/newRequirementConfigure/getItem/' + itemId,
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var data = response.result
                var id = data.id;
                var Item_Code = data.Item_Code;
                var item_name = data.item_name;
                var avg_weight_per_unit = data.avg_weight_per_unit;

                var dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                var input = ' <input type="number" id="Qty_' + id + '" onclick="EditQty(' + avg_weight_per_unit + ',' + id + ')" >'
                arr = [];
                arr.push({
                    "thId": id,
                    "thItemCode": Item_Code,
                    "thItem": item_name,
                    "thRequiredQuantity": input,
                    "thRequiredWeight": `<input type="number" id="weight_` + id + `" value="` + avg_weight_per_unit + `" readonly>`,
                    "action": dele,
                    'UnitWeight': avg_weight_per_unit


                });
                var table = $('#tablenewRequirementConfigure').DataTable();
                table.rows.add(arr).draw();

                $('#ItemModel').modal('toggle');
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadToday() {
    $.ajax({
        type: 'GET',
        url: '/mnu/newRequirementConfigure/loadToday',
        async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                // console.log(response.result)
                $('#date').val(response.result);
            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function InitiateDetailArry() {

    var table = $('#tablenewRequirementConfigure').DataTable();

    var arr = [];

    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();

        arr.push({
            'item': data.thId,
            'itemCode': data.thItemCode,
            'itemName': data.thItem,
            'rqWeight': this.cell(rowIdx, 4).nodes().to$().find('input').val(),
            'rqQty': this.cell(rowIdx, 3).nodes().to$().find('input').val(),
        });
    });
    console.log(arr)

    return arr

}
function _delete(id) {
    $.ajax({
        type: 'DELETE',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: '/mnu/newRequirementConfigure/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadnewRequirementConfigures();
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};
function EditQty(weight, itemId) {
    $('#itemId').val(itemId)
    $('#avgWeight').val(weight)
    $('#QuantityModel').modal('toggle');
    $('#qty').focus();
}
function setReqWeight() {
    var Qty = $('#qty').val();
    var Weight = $('#avgWeight').val();
    var Item = $('#itemId').val();
    var ReqWeight = Number(Qty) * Number(Weight);
    $('#Qty_' + Item).val(Qty)
    $('#weight_' + Item).val(ReqWeight)
    $('#QuantityModel').modal('toggle');

    $('#qty').val('');
    $('#avgWeight').val('');
    $('#itemId').val('');
}


