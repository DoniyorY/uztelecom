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

url = baseUrl + '/site/get-column-chart';

fetch(url)
    .then(response => response.json())
    .then(rawData => {
        var categories = [];
        var menData = [];
        var womenData = [];

        for (var branchName in rawData) {
            if (rawData.hasOwnProperty(branchName)) {
                categories.push(branchName);
                menData.push(rawData[branchName].men);
                womenData.push(rawData[branchName].women);
            }
        }

        var options = {
            series: [
                {
                    name: 'Мужчины',
                    data: menData
                },
                {
                    name: 'Женщины',
                    data: womenData
                }
            ],
            chart: {
                type: 'bar',
                height: 350,
                stacked: true,
                toolbar: {
                    show: true
                },
                zoom: {
                    enabled: true
                }
            },

            responsive: [{
                breakpoint: 480,
                options: {
                    legend: {
                        position: 'bottom',
                        offsetX: -10,
                        offsetY: 0
                    }
                }
            }],
            plotOptions: {
                bar: {
                    horizontal: false,
                    borderRadius: 5,
                    borderRadiusApplication: 'end',
                    borderRadiusWhenStacked: 'last',
                    dataLabels: {
                        total: {
                            enabled: true,
                            style: {
                                fontSize: '13px',
                                fontWeight: 900
                            }
                        }
                    }
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: categories,
                labels: {
                    rotate: -45
                }
            },
            yaxis: {
                title: {
                    text: 'Общее количество'
                }
            },
            legend: {
                position: 'right',
                offsetY: 40
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val;
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#column_chart"), options);
        chart.render();
    })
    .catch(error => {
        console.error('Ошибка при получении данных для графика:', error);
    });