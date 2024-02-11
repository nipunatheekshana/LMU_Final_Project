import { getReportValues } from '../grnHistoryReports/grnReport.js'
function piechart() {
    // var canvas = document.createElement('canvas');
    // canvas.width = 500;
    // canvas.height = 400;
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
    var char1 =  $('#chartjs_hidden');
    var data = {
        labels: ['A','B',"c"],
        datasets: [
            {
                lable: 'team',
                data: [11,10,50],
                backgroundColor: [
                    colors.primary,
                    colors.secondary,
                    colors.success,
                    colors.warning,
                    colors.info
                ]
            }
        ]
    }
    var chart1 = new Chart(char1, {
        type: 'pie',
        data: data,
        options: {
            animation:false,
            responsive:false,
        }
    })
     return(chart1.toBase64Image('image/svg', 10));
}
export function grnReport1(GRNno) {
    var report_values = getReportValues('grnReport1', GRNno);
    var headerFontSize = 8;
    var Title = [
        { text: '' }
    ];


    var Header = [
        {
            content: [

                {
                    table: {
                        widths: ['*'],
                        headerRows: 1,
                        body: grnReport1Header()

                    },
                    margin: [0, 0],
                },

            ]
        }
    ];



    var Body = [
        {
            table: {
                widths: ['*', '*', '*', '*', '*', '*', '*', '*', '*'],
                headerRows: 1,
                body: grnReport1Body(report_values),

            },
            margin: [0, 0],
        },
    ];




    var Footer = [
        {
            color: 'red',
            fontSize: 8,
            alignment: 'center',
            margin: [0, 0]
        }
    ];






    var page = new Page();
    page.setPageSize('A4');
    page.setPageOrientation('potrait');
    page.setPageMargin([10, 10, 10, 10]);
    page.setTitle(Title);
    // page.setHeader(Header, Page.EVERY);
    page.setHeader(Header);

    page.setBody(Body);
    page.setFooter(Footer);
    page.preview();
}
// [
//     [ 'First', 'Second', 'Third', 'The last one' ],
//     [ 'Value 1', 'Value 2', 'Value 3', 'Value 4' ],
//     [ { text: 'Bold value', bold: true }, 'Val 2', 'Val 3', 'Val 4' ]
//   ]
function grnReport1Header() {
    var header = [];
    header.push([
        {
            image: piechart(),
            fit: [400, 400],
            margin: [0, 20, 0, 0],
            alignment: 'center',
            border: [false, false, false, false]
        }
    ]);
    return header;
}
function grnReport1Body(data) {
    var body = [];
    body.push([
        { text: 'FishNo', fontSize: 6, bold: true, alignment: 'center', border: [false, false, false, false] },
        { text: 'FishCatagory', fontSize: 6, bold: true, alignment: 'center', border: [false, false, false, false] },
        { text: 'Present', fontSize: 6, bold: true, alignment: 'center', border: [false, false, false, false] },
        { text: 'Grade', fontSize: 6, bold: true, alignment: 'center', border: [false, false, false, false] },
        { text: 'Size', fontSize: 6, bold: true, alignment: 'center', border: [false, false, false, false] },
        { text: 'Weight(KG)', fontSize: 6, bold: true, alignment: 'center', border: [false, false, false, false] },
        { text: 'Boat Tank #', fontSize: 6, bold: true, alignment: 'center', border: [false, false, false, false] },
        { text: 'Tank Temp', fontSize: 6, bold: true, alignment: 'center', border: [false, false, false, false] },
        { text: 'Fish Temp', fontSize: 6, bold: true, alignment: 'center', border: [false, false, false, false] }


    ]);
    $.each(data, function (i, val) {
        var data = replaceNullValues(val)

        body.push([
            { text: data.FishNo, fontSize: 6, bold: true, alignment: 'center', border: [true, true, true, true] },
            { text: data.FishName, fontSize: 6, bold: true, alignment: 'center', border: [true, true, true, true] },
            { text: data.Presentation, fontSize: 6, bold: true, alignment: 'center', border: [true, true, true, true] },
            { text: data.FishGrade, fontSize: 6, bold: true, alignment: 'center', border: [true, true, true, true] },
            { text: data.SizeDescription, fontSize: 6, bold: true, alignment: 'center', border: [true, true, true, true] },
            { text: data.FishWaight, fontSize: 6, bold: true, alignment: 'center', border: [true, true, true, true] },
            { text: data.BoatTankNo, fontSize: 6, bold: true, alignment: 'center', border: [true, true, true, true] },
            { text: data.TankTemp, fontSize: 6, bold: true, alignment: 'center', border: [true, true, true, true] },
            { text: data.FishTemp, fontSize: 6, bold: true, alignment: 'center', border: [true, true, true, true] }
        ]);
    });
    // $.each(data, function (i, val) {
    //    console.log(val.FishNo)
    // });


    // for (i = 0; i < 100; i++) {
    //     body.push([
    //         { text: i, fontSize: 6, bold: true, alignment: 'center', border: [true, true, true, true] },
    //         { text: 'U A S S N Perera', fontSize: 6, bold: true, alignment: 'center', border: [true, true, true, true] }
    //     ]);
    // }

    return body;
}
function replaceNullValues(val) {
    var nill = 'null'
    var FishNo = nill;
    var FishName = nill;
    var Presentation = nill;
    var FishGrade = nill;
    var SizeDescription = nill;
    var FishWaight = nill;
    var BoatTankNo = nill;
    var TankTemp = nill;
    var FishTemp = nill;
    if (val.FishNo != null) {
        FishNo = val.FishNo
    }
    if (val.FishName != null) {
        FishName = val.FishName
    }
    if (val.Presentation != null) {
        Presentation = val.Presentation
    }
    if (val.FishGrade != null) {
        FishGrade = val.FishGrade
    }
    if (val.SizeDescription != null) {
        SizeDescription = val.SizeDescription
    }
    if (val.FishWaight != null) {
        FishWaight = val.FishWaight
    }
    if (val.BoatTankNo != null) {
        BoatTankNo = val.BoatTankNo
    }
    if (val.TankTemp != null) {
        TankTemp = val.TankTemp
    }
    if (val.FishTemp != null) {
        FishTemp = val.FishTemp
    }
    var obj = {
        'FishNo': FishNo,
        'FishName': FishName,
        'Presentation': Presentation,
        'FishGrade': FishGrade,
        'SizeDescription': SizeDescription,
        'FishWaight': FishWaight,
        'BoatTankNo': BoatTankNo,
        'TankTemp': TankTemp,
        'FishTemp': FishTemp,
    }
    return obj;

}

