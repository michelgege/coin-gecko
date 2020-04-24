
import $ from 'jquery';
import Highcharts from 'highcharts';
import data from 'highcharts/modules/data';
data(Highcharts);

let chart;
const currency_name = $('h1').attr("data-id");
let chart_created = false;

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
        if(chart_created === false) {
            createCurrencyChart(response.prices);
            chart_created = true;
        } else {
            chart.series[0].setData(response.prices);
            $('figure').removeClass('hidden')
        }
    });
}

function createCurrencyChart(data) {

       chart = Highcharts.chart('container', {
            chart: {
                zoomType: 'x',
                backgroundColor : null
            },
            title: {
                text: 'Price in EUR over time',
                style : {
                    color : "#fff"
                }
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
                    text: 'Price (EUR)',
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
                name: 'Price',
                data: data
            }]
        });
}

function refreshChartData(){

    $('div.time_buttons div').click((event) => {
        $('div.time_buttons div').removeClass('active');
        $(event.currentTarget).addClass('active');
        $('figure').addClass('hidden');
        let days = $(event.currentTarget).attr("data-time");
        requestCurrencyData(days);
    });
}

requestCurrencyData(14);
refreshChartData();
