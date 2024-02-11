console.log('exchangeRate.js Loading');
var Child_url = '/accounting/exchange_rate_configure?'

$(document).ready(function () {

    $('#btnCreateNew').text('Create New Exchange Rate')
    $('#btnCreateNew').on('click', function () {
        location.href = "/accounting/exchange_rate_configure";
    });

    var table = $('#tableExchangeRate').DataTable({
        responsive: true,
        'columnDefs': [{
            "targets": [0, 3, 4],
            "className": "text-center",

        },
        {
            "targets": [1],
            "className": "text-left",

        },
        {
            "targets": [2],
            "className": "text-right",

        }],
        "order": [],
        "columns": [
            { "data": "thDate", 'width': "25%" },
            { "data": "thCurrency", 'width': "25%" },
            { "data": "thRate", 'width': "15%" },
            { "data": "thType", 'width': "20%" },
            { "data": "action", 'width': "15%" },
        ],
    });

    loadExchangeRates();
});

function loadExchangeRates() {
    $.ajax({
        type: 'GET',
        url: '/accounting/exchangeRate/loadExchangeRates',
        success: function (response) {
            console.log(response.result)
            if (response.success) {

                var data = [];
                $.each(response.result, function (i, val) {
                    var id = response.result[i]['id'];
                    var date = response.result[i]['date'];
                    var currency = '<span class="badge badge-success">'+ response.result[i]['currency_code'] +'</span>' +' ' + response.result[i]['currency_name'] ;
                    var exchange_rate = response.result[i]['exchange_rate'];
                    // var type = 'Buying : ' + response.result[i]['for_buying'] +' | Selling : ' + response.result[i]['for_selling'] ;
                    var edit = '<button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    var dele = '<button class="btn btn-danger mr-1" onclick="_delete(' + id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    // var view = '<button class="btn btn-success mr-1" onclick="view(' + id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>';

                    var type = '';
                    if (val.for_buying == 1 && val.for_selling == 1) {
                        type = `<span class="badge badge-primary">Buying</span> <span class="badge badge-secondary">Selling</span>`
                    } else if (val.for_buying == 1 && val.for_selling == 0) {
                        type = `<span class="badge badge-primary">Buying</span>`
                    } else if (val.for_buying == 0 && val.for_selling == 1) {
                        type = `<span class="badge badge-secondary">Selling</span>`
                    } else if (val.for_buying == 0 && val.for_selling == 0) {
                        type = `<span class="badge badge-dark">Type Not Set</span>`
                    }


                    data.push({
                        // "thId": id,
                        "thDate": date,
                        "thCurrency": currency,
                        "thRate": exchange_rate.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'),
                        "thType": type,
                        "action": edit + dele,
                    });
                });

                var table = $('#tableExchangeRate').DataTable();
                table.clear();
                table.rows.add(data).draw();
            }
        }, error: function (data) {
            console.log('Something Went Wrong');
        }
    });
};
function _delete(id) {
    $.ajax({
        type: 'DELETE',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: '/accounting/exchangeRate/delete/' + id,
        success: function (response) {
            console.log(response);

            if (response.success) {
                toastr.success(response.message);
                loadExchangeRates();
            }
        }, error: function (data) {
            console.log(data);
        }
    });
};

function edit(id) {
    location.href = Child_url + id;
}

