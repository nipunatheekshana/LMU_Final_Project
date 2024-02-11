console.log('dashboardSelling .js loadimng');
$(document).ready(function () {
    var tablePackingMaterialReq = $('#tableChangeRequestApproval').DataTable({

        paging: false,
        info: false,
        searching: false,
        'columnDefs': [
            {
                "targets": '_all',
                "createdCell": function (td) {
                    $(td).css('padding', '0px')
                }
            }, {
                "targets": [0, 1, 2, 3],
                "className": "text-center",

            }
        ],
        "order": [],
        "columns": [
            { "data": "thItem" },
            { "data": "thTotalPlanedQty" },
            { "data": "thCompleatedQty" },
            { "data": "thCompleatedWeight" },


        ],
    });

    var table = $('#newOrders').DataTable({
        scrollY: "350px",
        scrollX: true,
        scrollCollapse: true,
        paging: true,
        lengthChange: false,
        "pageLength": 5,
        "columnDefs": [
            {
                "targets": '_all',
                "createdCell": function (td) {
                    $(td).css('padding', '0px')
                }
            }, {
                "targets": 5,
                "orderable": false
            }
        ]
    });

    var tablenewChangeRequests = $('#tablenewChangeRequests').DataTable({
        scrollY: 400,
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        // select: {
        //     style: 'single'
        // },
        'columnDefs': [
            // {
            //     "targets": [],
            //     "visible": false,
            // },
            {
                "targets": '_all',
                "createdCell": function (td) {
                    $(td).css('padding', '0px')
                }
            },
            {
                "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                "className": "text-center",

            }
        ],
        "order": [],
        "columns": [
            { "data": "thRequestNo" },
            { "data": "thDate&Time" },
            { "data": "thOrderNumber" },
            { "data": "thCustomer" },
            { "data": "thNotifyParty" },
            { "data": "thItem" },
            { "data": "thOldQty" },
            { "data": "thNewQty" },
            { "data": "thOldPrice" },
            { "data": "thNewPrice" },
            { "data": "thAction" },
        ],
    });

    $('#btnApproveChangeReq').click(function () {
        changeRequestAction('accept')
    });
    $('#btnRejectChangeReq').click(function () {
        changeRequestAction('reject')
    });

    chartjs_one();
    loadChangeRequests();
});
function chartjs_one() {
    var colors = {
        primary: $('.colors .bg-primary').css('background-color'),
        primaryLight: $('.colors .bg-primary-bright').css('background-color'),
        secondary: $('.colors .bg-secondary').css('background-color'),
        secondaryLight: $('.colors .bg-secondary-bright').css('background-color'),
        info: $('.colors .bg-info').css('background-color'),
        infoLight: $('.colors .bg-info-bright').css('background-color'),
        success: $('.colors .bg-success').css('background-color'),
        successLight: $('.colors .bg-success-bright').css('background-color'),
        danger: $('.colors .bg-danger').css('background-color'),
        dangerLight: $('.colors .bg-danger-bright').css('background-color'),
        warning: $('.colors .bg-warning').css('background-color'),
        warningLight: $('.colors .bg-warning-bright').css('background-color'),
    };

    var element = document.getElementById("chartjs_one");
    element.height = 50;
    new Chart(element, {
        type: 'bar',
        data: {
            labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
            datasets: [
                {
                    label: "Orders",
                    backgroundColor: [
                        colors.primary,
                        colors.secondary,
                        colors.success,
                        colors.warning,
                        colors.info,
                        colors.success,
                        colors.primary

                    ],
                    data: [5, 3, 4, 2, 5, 6, 3]
                }
            ]
        },
        options: {
            legend: { display: false },
            title: {
                display: true,
                text: 'Number of Orders Recieved during previous week'
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }

        }
    });
}
function loadChangeRequests() {
    $.ajax({
        type: 'GET',
        url: '/selling/dashboardSelling/loadChangeRequests',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                $.each(response.result, function (i, val) {

                    var id = val.id;
                    var created_at = val.created_at;
                    var order_number = val.order_number;
                    var CusName = val.CusName;
                    var AddressTitle = val.AddressTitle;
                    var item_name = val.item_name;
                    var old_qty = val.old_qty;
                    var new_qty = val.new_qty;
                    var old_price = val.old_price;
                    var new_price = val.new_price;

                    data.push({
                        "thRequestNo": id,
                        "thDate&Time": created_at,
                        "thOrderNumber": order_number,
                        "thCustomer": CusName,
                        "thNotifyParty": AddressTitle,
                        "thItem": item_name,
                        "thOldQty": Number(old_qty),
                        "thNewQty": Number(new_qty),
                        "thOldPrice": Number(old_price),
                        "thNewPrice": Number(new_price),
                        "thAction": `<div class="dropdown">
                                        <a href="#" data-toggle="dropdown" class="btn btn-floating"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="ti-more-alt"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a onclick="viewOrder(`+ id + `)"class="dropdown-item">View Order</a>
                                            <a onclick="loadApproveModel(`+ id + `)" class="dropdown-item">Action</a>
                                        </div>
                                    </div>`,
                    });
                });


                var table = $('#tablenewChangeRequests').DataTable();
                table.clear();
                table.rows.add(data).draw();
            }
        }, error: function (data) {
            console.log('something went wrong');
        }
    });
}

function loadApproveModel(reqId) {
    $.ajax({
        type: 'GET',
        url: '/selling/dashboardSelling/loadApproveModel/' + reqId,
        success: function (response) {
            console.log(response.result)
            if (response.success) {
                var result = response.result;
                $('#OrderNum').html(result.order_number);
                $('#Customer').html(result.CusName);
                $('#Notify').html(result.AddressTitle);
                $('#Item').html(result.item_name);
                $('#oldQty').html(result.old_qty);
                $('#newQty').html(result.new_qty);
                $('#oldPrice').html(result.old_price);
                $('#newPrice').html(result.new_price);
                $('#requestId').val(result.id);
                loadChangeRequestRequirements(result.order_number, result.ItemId, result.notifyId)
                $('#ModelChangeRequestApproval').modal('toggle');
            }
        }, error: function (data) {
            console.log('something went wrong');
        }
    });
}
function viewOrder(reqId) {
    console.log(reqId);
}
function changeRequestAction(action) {

    var form = $('#frmChangeRequestAction ').get(0);
    var data = new FormData(form);

    if (action == 'accept') {
        data.append('accept', true);
    }
    $.ajax({
        type: 'POST',
        url: '/selling/dashboardSelling/changeRequestAction',
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        processData: false,
        contentType: false,
        cache: false,
        timeout: 800000,
        success: function (response) {
            console.log(response.result)
            if (response.success) {
                toastr.success(response.message);

            } else {
                toastr.error(response.message);
            }
            loadChangeRequests();
            $('#ModelChangeRequestApproval').modal('toggle');

        }, error: function (data) {
            console.log('something went wrong');
        }
    });
}
function loadChangeRequestRequirements(orderNum, itemId, notify) {
    $.ajax({
        type: 'GET',
        url: '/selling/dashboardSelling/loadChangeRequestRequirements/' + orderNum + '/' + itemId + '/' + notify,
        success: function (response) {
            console.log(response.result)
            if (response.success) {
                var data = [];
                // $.each(response.result, function (i, val) {
                data.push({
                    "thItem": response.result.item_name,
                    "thTotalPlanedQty": response.result.plannedQty,
                    "thCompleatedQty": response.result.completedQty,
                    "thCompleatedWeight": response.result.completedWeight,
                });
                // });


                var table = $('#tableChangeRequestApproval').DataTable();
                table.clear();
                table.rows.add(data).draw();

            }
        }, error: function (data) {
            console.log(data)
            console.log('something went wrong');
        }
    });
}
