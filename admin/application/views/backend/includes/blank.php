<div class="drawchart">

</div>

<script type="text/javascript">
    $(function () {
        var seriesOptions = [],
            seriesCounter = 0,
            names = [{
                name: "Quantity",
                color: "#3498db",
                url: "<?php echo site_url('site/checkchartjson1');?>"
            }, {
                name: "Amount",
                color: "#9b59b6",
                url: "<?php echo site_url('site/checkchartjson2');?>"
            }],
            // create the chart when all data is loaded
            createChart = function () {

                $('.drawchart').highcharts('StockChart', {
                   
                    rangeSelector: {
                        inputEnabled: $('.drawchart').width() > 480,
                        selected: 4
                    },

                    yAxis: {
                        labels: {
                            formatter: function () {
                                return (this.value > 0 ? ' + ' : '') + this.value + '%';
                            }
                        },
                        plotLines: [{
                            value: 0,
                            width: 2,
                            color: 'red'
                    }]
                    },

                    plotOptions: {
                        series: {
                            
                        }
                    },

                    tooltip: {
                        pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.change}%)<br/>',
                        valueDecimals: 2
                    },

                    series: seriesOptions
                });
            };

        $.each(names, function (i, singleline) {
            console.log(names);
            $.getJSON(singleline.url, function (data) {

                for (var j = 0; j < data.length; j++) {
                    data[j][0] = parseInt(data[j][0]);
                    data[j][1] = parseFloat(data[j][1]);
                }
                console.log(data);
                seriesOptions[i] = {
                    type: 'column',
                    name: singleline.name,
                    color: singleline.color,
                    data: data,
                    dataGrouping: {
                        units: [[
                        'week', // unit name
                        [1] // allowed multiples
                    ], [
                        'month',
                        [1, 2, 3, 4, 6]
                    ]]
                    }
                };

                // As we're loading the data asynchronously, we don't know what order it will arrive. So
                // we keep a counter and create the chart when all the data is loaded.
                seriesCounter += 1;

                if (seriesCounter === names.length) {
                    createChart();
                }
            });
        });
    });
</script>