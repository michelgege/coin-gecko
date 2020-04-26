
import $ from 'jquery';
import Highcharts from 'highcharts';
import data from 'highcharts/modules/data';
data(Highcharts);

let chart;
const currency_name = $('h1').attr("data-id");
let chart_created = false;
let chart_data;
let data_type = "prices";

function convertTime(UNIX_timestamp){

    var date = new Date(UNIX_timestamp).toLocaleDateString() + ' '  + new Date(UNIX_timestamp).toLocaleTimeString();

    return date;
}

function requestCurrencyData(days) {

    $('div.time_buttons div[data-time="'+days+'"]').addClass('active');
    const settings = {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        "url": "/chart/" + currency_name + "/" + days,
        "method": "GET",
    };

    $.ajax(settings).done(function (response) {
        chart_data = response;
        if(chart_created === false) {
            createCurrencyChart(chart_data[data_type]);
            chart_created = true;
        } else {
            chart.series[0].setData(chart_data[data_type]);
            $('figure').removeClass('hidden')
        }
        console.log(data_type);
        console.log(chart_data);
        changeChartDataType();
    });
}

function createCurrencyChart(data) {

       chart = Highcharts.chart('container', {
            chart: {
                zoomType: 'x',
                backgroundColor : null
            },
            title: {
                text: null,

            },
            subtitle: {
                text: document.ontouchstart === undefined ?
                    'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
            },
            xAxis: {
                type: 'datetime',
                title: {
                    style : {
                        color : "#fff"
                    }
                },
                labels : {
                    style : {
                        color :"#fff"
                    }
                }
            },
            yAxis: {
                title: {
                    style : {
                        color : "#fff"
                    }
                },
                labels : {
                    style : {
                        color :"#fff"
                    }
                }
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    marker: {
                        radius: 2
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },
            credits: {
                enabled: false
            },

            series: [{
                data: data
            }]
        });

       let title = $('div.data_type_buttons div.active').attr("data-title");
       chart.yAxis[0].setTitle({ text: title });
       chart.series[0].name = title;
}

function refreshChartData() {

    $('div.time_buttons div').click((event) => {

        if ($(event.currentTarget).hasClass('active') === false) {

            $('div.time_buttons div').removeClass('active');
            $(event.currentTarget).addClass('active');
            $('figure').addClass('hidden');
            let days = $(event.currentTarget).attr("data-time");
            requestCurrencyData(days);
        }
    });
}

function changeChartDataType() {

    $('div.data_type_buttons div').click(function (event) {

        $('div.data_type_buttons div').removeClass('active');
        $(event.currentTarget).addClass('active');
        data_type = $(event.currentTarget).attr("data-type");
        let title = $(event.currentTarget).attr("data-title");
        chart.series[0].setData(chart_data[data_type],true,true,false);
        chart.series[0].name = title;
        chart.yAxis[0].setTitle({ text: title });

    });
}

requestCurrencyData(7);
refreshChartData();

