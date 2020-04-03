import Chart from 'chart.js';
// import 'chartjs-plugin-crosshair';
import $ from 'jquery';

console.log("passed");


function convertTime(UNIX_timestamp){

    var date = new Date(UNIX_timestamp).toLocaleDateString() + ' '  + new Date(UNIX_timestamp).toLocaleTimeString();

    return date;
}

function requestCurrencyData() {

    const settings = {
        "async": true,
        "crossDomain": true,
        "url": "https://api.coingecko.com/api/v3/coins/bitcoin/market_chart?vs_currency=eur&days=14",
        "method": "GET",
        "headers": {
            "cookie": "__cfduid=d99317ba90e4cc4647427f48646f47dc61585735371"
        }
    };

    $.ajax(settings).done(function (response) {

        let sortedPrices = [];
        let sortedTime = [];
        for( let i=0; i<response.prices.length; i++) {

            sortedPrices[i] = response.prices[i][1];
            sortedTime[i] = convertTime(response.prices[i][0]);
        }
        createCurrencyChart(sortedPrices,sortedTime)
    });
}

function createCurrencyChart(prices,time) {

    let ctx = $('#currency_chart');

    let myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: time,
            datasets: [{

                data: prices,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            // plugins: {
            //     crosshair: {
            //         line: {
            //         color: '#F66',  // crosshair line color
            //         width: 1        // crosshair line width
            //         },
            //         sync: {
            //             enabled: true,            // enable trace line syncing with other charts
            //             group: 1,                 // chart group
            //             suppressTooltips: false   // suppress tooltips when showing a synced tracer
            //         },
            //         zoom: {
            //             enabled: true,                                      // enable zooming
            //             zoomboxBackgroundColor: 'rgba(66,133,244,0.2)',     // background color of zoom box
            //             zoomboxBorderColor: '#48F',                         // border color of zoom box
            //             zoomButtonText: 'Reset Zoom',                       // reset zoom button text
            //             zoomButtonClass: 'reset-zoom',                      // reset zoom button class
            //         },
            //         callbacks: {
            //             beforeZoom: function(start, end) {                  // called before zoom, return false to prevent zoom
            //                 return true;
            //             },
            //             afterZoom: function(start, end) {                   // called after zoom
            //             }
            //         }
            //     }
            // },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false,
                    }
                }],
                xAxes : [{
                    ticks : {
                        autoSkip: true,
                        maxTicksLimit: 20
                    }
                }]
            },
            maintainAspectRatio : true,
        },
    });
}



requestCurrencyData();
