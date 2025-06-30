//  Simple Pie Charts


var options = {
    series: [],
    chart: {
        height: 300,
        type: 'pie',
    },
    labels: ['Женщины', 'Мужчины'],
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
    }
};

var chart = new ApexCharts(document.querySelector("#simple_pie_chart"), options);
chart.render();
var url = 'http://localhost:8080/site/get-pie';
fetch(url)
    .then(response => response.json())
    .then(data => {
        chart.updateSeries([{
            name: 'Sales',
            data: data
        }]);
    })
    .catch(error => console.error('Ошибка при получении данных:', error));


