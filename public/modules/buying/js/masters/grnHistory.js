console.log('grnHistory.js loadimng');
var Child_url = '/buying/grnHistory_configure?'
var startDate = 0;
var endDate = 0;
$(document).ready(function () {

    //date range pikker callback Function
    $(function () {
        $('#date').daterangepicker({
            opens: 'left',
            // endDate: moment().subtract(5, 'day'),
        }, function (start, end, label) {
            startDate = start.format('YYYY-MM-DD');
            endDate = end.format('YYYY-MM-DD');
            loadGrnHistory();
        });
    });



    var tableGrnHistory = $('#tableGrnHistory').DataTable({
        pageLength: 25,
        scrollX: true,
        scrollCollapse: true,
        colReorder: true,
        // ordering: false,
        // fixedColumns:   {
        //     leftColumns: 1,
        //     rightColumns: 1
        // },


        'columnDefs': [
            {
                "targets": '_all',
                "createdCell": function (td) {
                    $(td).css('padding', '5px')
                }
            },
            // {
            //     "targets": [],
            //     "visible": false,
            // },
            {
                "targets": [0, 1, 2, 3, 4, 6, 7, 8, 9, 10, 11, 12, 13],
                "className": "text-center",

            },
            {
                "targets": [5],
                "className": "text-right",
            },
            {
                "targets": [0, 1, 2, 3, 4, 6, 7, 8, 9, 10, 11, 12, 13],
                "width": "3%",
            }
        ],
        // fixedColumns:   {
        //     left: 1,
        // },
        // fixedColumns:   true,
        "order": [],
        "columns": [
            { "data": "thGrnNo" },
            { "data": "thGRNDate" },
            { "data": "thType" },
            { "data": "thSupplier" },
            { "data": "thTotalQty" },
            { "data": "thTotalWeight" },
            { "data": "thUnprocessedPCs" },
            { "data": "thProcessedPcs" },
            { "data": "thTransferPcs" },
            { "data": "thRejectPcs" },
            { "data": "thReceivingStatus" },
            { "data": "thFinanceStatus" },
            { "data": "thVoucherStatus" },
            { "data": "thGrnNo2" },
            { "data": "thAction" },

        ],
    });
    $('#tableSearch').keyup(function () {
        tableGrnHistory.search($('#tableSearch').val()).draw();
    })

    $('#supplier').change(function () {
        loadGrnHistory();
    });
    $('#boat').change(function () {
        loadGrnHistory();
    });
    loadSuppliers();
    loadBoats();
    loadGrnHistory();
});

function loadGrnHistory() {
    var data = getFilterValues();
    $.ajax({
        type: 'POST',
        url: '/buying/grnHistory/loadGrnHistory',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: data,
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                $.each(response.result, function (i, val) {

                    var view = '<button type="button" class="btn btn-primary btn-floating" onclick="view(' +  val.grnno + ')"><i class="ti-angle-right"></i></button>';

                    // Type Badge Setting
                    var grn_type = '';
                    if (val.grn_type == 1) {
                        grn_type = `<span class="badge badge-primary">Individual</span>`
                    } else if (val.grn_type == 2) {
                        grn_type = `<span class="badge badge-secondary">Bulk</span>`
                    }


                    // Unload Status Badge Setting
                    var unload_status = '';
                    if (val.unload_status == 0) {
                        unload_status = `<span class="badge badge-warning">Pending</span>`
                    } else if (val.unload_status == 1) {
                        unload_status = `<span class="badge badge-danger">Hold</span>`
                    } else if (val.unload_status == 2) {
                        unload_status = `<span class="badge badge-success">Closed</span>`
                    }

                    // Finance Status Badge Setting
                    var finance_status = '';
                    if (val.finance_status == 0) {
                        finance_status = `<span class="badge badge-warning">Pending</span>`
                    } else if (val.finance_status == 1) {
                        finance_status = `<span class="badge badge-success">Priced</span>`
                    }

                    // Voucher Status Badge Setting
                    var voucher_status = '';
                    if (val.voucher_status == 0) {
                        voucher_status = `<span class="badge badge-warning">Not Created</span>`
                    } else if (val.voucher_status == 1) {
                        voucher_status = `<span class="badge badge-success">Created</span>`
                    }


                    data.push({
                        "thGrnNo": val.grnno,
                        "thGRNDate": val.grndate,
                        "thType": grn_type,
                        "thSupplier": val.supplier_name,
                        "thTotalQty": Number(val.totalQty).toFixed(0),
                        "thTotalWeight": Number(val.totFishWeight).toFixed(3) + ' Kg ',
                        "thUnprocessedPCs": Number(val.unprocessedPCs).toFixed(0),
                        "thProcessedPcs": Number(val.processedPcs).toFixed(0),
                        "thTransferPcs": Number(val.transferPcs).toFixed(0),
                        "thRejectPcs": Number(val.rejectPcs).toFixed(0),
                        "thReceivingStatus": unload_status,
                        "thFinanceStatus": finance_status,
                        "thVoucherStatus": voucher_status,
                        "thGrnNo2": val.grnno,
                        "thAction": view,

                    });
                });
                var table = $('#tableGrnHistory').DataTable();
                table.clear();
                table.rows.add(data).draw();
            }
        }, error: function (data) {
            console.log(data)
            console.log('something went wrong');
        }
    });
};

function getFilterValues() {
    var supplier = $('#supplier').val();
    var boat = $('#boat').val();
    var type = $('#type').val();

    return {
        'supplier': supplier,
        'boat': boat,
        'type': type,
        'startDate': startDate,
        'endDate': endDate
    }
}
function loadSuppliers() {
    $.ajax({
        type: 'GET',
        url: '/buying/grnHistory/loadSuppliers',
        // async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.id + '" > ' + value.supplier_name + ' </option>';
                });
                $('#supplier').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function loadBoats() {
    $.ajax({
        type: 'GET',
        url: '/buying/grnHistory/loadBoats',
        // async: false,
        success: function (response) {
            console.log(response)
            if (response.success) {
                var html = "";
                $.each(response.result, function (index, value) {

                    html += '<option value="' + value.BoatRegNo + '" > ' + value.BoatName + ' </option>';
                });
                $('#boat').append(html);


            }
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
function view(id) {
    location.href = Child_url + id;
}

