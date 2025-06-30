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
        console.log('Ответ от сервера:', data);
        // Убедись, что на бэке JSON возвращает { men: число, women: число }
        chart.updateSeries([data.women, data.men]); // порядок соответствует labels
    })
    .catch(error => console.error('Ошибка при получении данных:', error));
