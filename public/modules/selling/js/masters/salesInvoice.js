console.log('salesInvoice.js loadimng');
var Child_url = '/selling/salesinvoice_configure?'
var startDate = 0;
var endDate = 0;

$(document).ready(function () {
    var table = $('#sales_invoices').DataTable({
        paging: true,
        ordering: true,
        info: true,
        scrollX: true,
        'columnDefs': [
            {
                "orderable": true,
                "targets": [0, 7]
            }
        ],
        'order': [1, 'desc'],
        'pageLength': 20,
        'dom': 'rtip',

        "columns": [
            { "data": "thInvNothNo", 'width': "5%" },
            { "data": "thInvDate", 'width': "15%" },
            { "data": "thCustomer", 'width': "25%" },
            { "data": "thNotify", 'width': "10%" },
            { "data": "thPLNo", 'width': "10%" },
            { "data": "thShipmentNo", 'width': "10%" },
            { "data": "thCusOrdNo", 'width': "10%" },
            { "data": "thAWBNo", 'width': "10%" },
            { "data": "thFlightNo", 'width': "15%" },
            { "data": "thGrossValue", 'width': "5%" },
            { "data": "thFreight", 'width': "15%" },
            { "data": "thDiscount", 'width': "25%" },
            { "data": "thNetValue", 'width': "10%" },
            { "data": "thProcessStatus", 'width': "10%" },
            { "data": "thPMChargesStatus", 'width': "10%" },
            { "data": "thOtherCharges", 'width': "10%" },
            { "data": "thDisbursementStatus", 'width': "10%" },
            { "data": "Actions", 'width': "15%" }

        ],
    });
    $('#myInputTextField').keyup(function () {
        table.search($(this).val()).draw();
    })

    $('#btnCreateNew').text('Create New Sales Invoice')

    $(function () {
        $('#daterangepicker').daterangepicker({
            opens: 'left'
        }, function (start, end, label) {
            startDate = start.format('YYYY-MM-DD');
            endDate = end.format('YYYY-MM-DD');
            loadRequirements();
        });
    });

    $('#customer-select').select2();
    $('#process-status-select').select2();
    $('#notify-select').select2();

    $('#btnCreateNew').on('click', function () {
        location.href = "/selling/salesinvoice_configure";
    });


    loadInvoices() ;


});

function loadInvoices() {
    $.ajax({
        type: 'GET',
        url: '/selling/salesInvoice/loadInvoices',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                $.each(response.result, function (i, val) {
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + val.id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + val.id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    var inv_click = '<a onclick="edit(' + val.id + ')"><span class="badge bg-secondary-bright text-secondary">'+ val.inv_no+'</span></a>';

                    data.push({
                        "thInvNothNo": inv_click,
                        "thInvDate": val.inv_date,
                        "thCustomer": val.consignee_name,
                        "thNotify": val.notify_name,
                        "thPLNo": val.pl_number,
                        "thShipmentNo": val.shipment_number,
                        "thCusOrdNo": val.order_number,
                        "thAWBNo": val.awb_no,
                        "thFlightNo": val.flight_numbers,
                        "thGrossValue": val.inv_gross_value,
                        "thFreight": val.freight_value,
                        "thDiscount": val.discount_amount,
                        "thNetValue": val.net_value,
                        "thProcessStatus": val.is_processed,
                        "thPMChargesStatus": '',
                        "thOtherCharges": val.tot_other_cost,
                        "thDisbursementStatus": val.is_disburment_processed,
                        "Actions": edit + dele,
                    });
                });

                var table = $('#sales_invoices').DataTable();
                table.clear();
                table.rows.add(data).draw();
            }
        }, error: function (data) {
            console.log('something went wrong');
        }
    });
};
function _delete(id) {
    $.ajax({
        type: 'DELETE',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: '/selling/salesInvoice/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadInvoices();
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};
function edit(id) {
    location.href = Child_url + id;
}

