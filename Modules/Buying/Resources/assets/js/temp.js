$.each(data, function (i, val) {

    if (series.length != 0) {
        $.each(series, function (i, v) {

            if (v.name == val.FishName) {
                console.log(v);
                v.data.push(
                    Number(val.Jan).toFixed(3),
                    Number(val.Feb).toFixed(3),
                    Number(val.Mar).toFixed(3),
                    Number(val.Apr).toFixed(3),
                    Number(val.May).toFixed(3),
                    Number(val.Jun).toFixed(3),
                    Number(val.Jul).toFixed(3),
                    Number(val.Aug).toFixed(3),
                    Number(val.Sep).toFixed(3),
                    Number(val.Oct).toFixed(3),
                    Number(val.Nov).toFixed(3),
                    Number(val.Dec).toFixed(3)
                )
                years.push(
                    new Date(val.GRNYear + '-01-01').toDateString(),
                    new Date(val.GRNYear + '-02-01').toDateString(),
                    new Date(val.GRNYear + '-03-01').toDateString(),
                    new Date(val.GRNYear + '-04-01').toDateString(),
                    new Date(val.GRNYear + '-05-01').toDateString(),
                    new Date(val.GRNYear + '-06-01').toDateString(),
                    new Date(val.GRNYear + '-07-01').toDateString(),
                    new Date(val.GRNYear + '-08-01').toDateString(),
                    new Date(val.GRNYear + '-09-01').toDateString(),
                    new Date(val.GRNYear + '-10-01').toDateString(),
                    new Date(val.GRNYear + '-11-01').toDateString(),
                    new Date(val.GRNYear + '-13-01').toDateString(),

                )
                return false;
            }
             else {
                series.push(
                    {
                        'name': val.FishName,
                        'data': [
                            Number(val.Jan).toFixed(3),
                            Number(val.Feb).toFixed(3),
                            Number(val.Mar).toFixed(3),
                            Number(val.Apr).toFixed(3),
                            Number(val.May).toFixed(3),
                            Number(val.Jun).toFixed(3),
                            Number(val.Jul).toFixed(3),
                            Number(val.Aug).toFixed(3),
                            Number(val.Sep).toFixed(3),
                            Number(val.Oct).toFixed(3),
                            Number(val.Nov).toFixed(3),
                            Number(val.Dec).toFixed(3)
                        ]
                    }
                )
                years.push(
                    new Date(val.GRNYear + '-01-01').toDateString(),
                    new Date(val.GRNYear + '-02-01').toDateString(),
                    new Date(val.GRNYear + '-03-01').toDateString(),
                    new Date(val.GRNYear + '-04-01').toDateString(),
                    new Date(val.GRNYear + '-05-01').toDateString(),
                    new Date(val.GRNYear + '-06-01').toDateString(),
                    new Date(val.GRNYear + '-07-01').toDateString(),
                    new Date(val.GRNYear + '-08-01').toDateString(),
                    new Date(val.GRNYear + '-09-01').toDateString(),
                    new Date(val.GRNYear + '-10-01').toDateString(),
                    new Date(val.GRNYear + '-11-01').toDateString(),
                    new Date(val.GRNYear + '-13-01').toDateString(),

                )
                return false;
            }
        });
    } else {
        series.push(
            {
                'name': val.FishName,
                'data': [
                    Number(val.Jan).toFixed(3),
                    Number(val.Feb).toFixed(3),
                    Number(val.Mar).toFixed(3),
                    Number(val.Apr).toFixed(3),
                    Number(val.May).toFixed(3),
                    Number(val.Jun).toFixed(3),
                    Number(val.Jul).toFixed(3),
                    Number(val.Aug).toFixed(3),
                    Number(val.Sep).toFixed(3),
                    Number(val.Oct).toFixed(3),
                    Number(val.Nov).toFixed(3),
                    Number(val.Dec).toFixed(3)
                ]
            }
        )
        years.push(
            new Date(val.GRNYear + '-01-01').toDateString(),
            new Date(val.GRNYear + '-02-01').toDateString(),
            new Date(val.GRNYear + '-03-01').toDateString(),
            new Date(val.GRNYear + '-04-01').toDateString(),
            new Date(val.GRNYear + '-05-01').toDateString(),
            new Date(val.GRNYear + '-06-01').toDateString(),
            new Date(val.GRNYear + '-07-01').toDateString(),
            new Date(val.GRNYear + '-08-01').toDateString(),
            new Date(val.GRNYear + '-09-01').toDateString(),
            new Date(val.GRNYear + '-10-01').toDateString(),
            new Date(val.GRNYear + '-11-01').toDateString(),
            new Date(val.GRNYear + '-13-01').toDateString(),

        )
    }
    // data.push({
    //     "thYear": val.GRNYear,
    //     "thSupplier": supplier,
    //     "thFishType": val.FishName,
    //     "thPresentation": presentation,
    //     "thPayGrade": supplier_grade,
    //     "thSize": SizeDescription,
    //     "thJan": Number(val.Jan).toFixed(3),
    //     "thFeb": Number(val.Feb).toFixed(3),
    //     "thMar": Number(val.Mar).toFixed(3),
    //     "thApr": Number(val.Apr).toFixed(3),
    //     "thMay": Number(val.May).toFixed(3),
    //     "thJun": Number(val.Jun).toFixed(3),
    //     "thJul": Number(val.Jul).toFixed(3),
    //     "thAug": Number(val.Aug).toFixed(3),
    //     "thSep": Number(val.Sep).toFixed(3),
    //     "thOct": Number(val.Oct).toFixed(3),
    //     "thNov": Number(val.Nov).toFixed(3),
    //     "thDec": Number(val.Dec).toFixed(3),
    // });
});
