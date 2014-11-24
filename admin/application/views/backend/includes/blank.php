<div class="drawchart2">

</div>


<script type="text/javascript">
    $(function () {
        var salesman=<?php echo json_encode($userdetailswithlastlogin); ?>;
            console.log(salesman);
        var salesmans=[];
        for(var i=0;i<salesman.length;i++)
        {
            salesmans.push({name:salesman[i].name,url:"<?php echo site_url("site/getsalesmandailyjson?id=");?>"+salesman[i].id});
        }
        
        var seriesOptions = [],
            seriesCounter = 0,
            names = salesmans,
            // create the chart when all data is loaded
            createChart = function () {
                console.log(names);
                $('.drawchart2').highcharts('StockChart', {

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
                            compare: 'percent'
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
                if(singleline.color)
                {
                    seriesOptions[i] = {
                        name: singleline.name,
                        color: singleline.color,
                        data: data
                    };
                }
                else
                {
                    seriesOptions[i] = {
                        name: singleline.name,
                        data: data
                    };
                }

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