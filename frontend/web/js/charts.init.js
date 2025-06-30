// Simple Pie Charts

var options = {
    series: [], // начально пусто
    chart: {
        height: 300,
        type: 'pie',
    },
    labels: ['Женщины', 'Мужчины'], // важно: порядок должен соответствовать данным
    legend: {
        position: 'bottom'
    },
    dataLabels: {
        dropShadow: {
            enabled: false,
        }
    },
    colors: ['#f06548', '#299cdb'],
    noData: {
        text: 'Загрузка...'
    },
};

var chart = new ApexCharts(document.querySelector("#simple_pie_chart"), options);
chart.render();

var baseUrl = window.location.origin;
var url = baseUrl + '/site/get-pie';

fetch(url)
    .then(response => response.json())
    .then(data => {
        // Убедись, что на бэке JSON возвращает { men: число, women: число }
        chart.updateSeries([data.women, data.men]); // порядок соответствует labels
    })
    .catch(error => console.error('Ошибка при получении данных:', error));


// Simple Column Charts
var columnOptions = {
    series: [{
        name: 'Мужчины',
        data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
    }, {
        name: 'Женщины',
        data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
    }],
    chart: {
        type: 'bar',
        height: 350
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '55%',
            borderRadius: 5,
            borderRadiusApplication: 'end'
        },
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    xaxis: {
        categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
    },
    yaxis: {
        title: {
            text: 'Количество'
        }
    },
    fill: {
        opacity: 1
    },
    tooltip: {
        y: {
            formatter: function (val) {
                return val
            }
        }
    }
};

var columnChart = new ApexCharts(document.querySelector("#column_chart"), columnOptions);
columnChart.render();