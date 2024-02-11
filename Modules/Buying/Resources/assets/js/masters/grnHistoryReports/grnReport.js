import { grnReport1 } from '../grnHistoryReports/grnReport1.js';

$(document).ready(function () {

    $('#btnReport').click(function () {

        report();
    });
});

function report(){
    $.ajax({
        type: 'GET',
        url: '/buying/grnReport1/report',
        async: false,
        success: function (response) {
            // window.location.href = response.url;
            window.open(response.url, '_blank');
        }, error: function (data) {
            console.log(data);
            console.log('something went wrong');
        }
    });
}
