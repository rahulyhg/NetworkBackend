<div class=" row" style="padding:1% 0;">
	<div class="col-md-10">
		<div class=" pull-right col-md-1 createbtn" ><a class="btn btn-primary" href="<?php echo site_url('site/exportretailerfromdashboard'); ?>"target="_blank"><i class="icon-plus"></i>Export to CSV </a></div>
	</div>
</div>
<div class="well">
<b>Total No of Retailers Added Since Yesterday</b>
</div>
<div class="row state-overview"  >
    <div class="col-lg-3 col-sm-3">
        <section class="panel">
            <div class="symbol terques">
                <i class="icon-user"></i>
            </div>
            <a href="<?php echo site_url('site/dashboardzonewise'); ?>">
            <div class="value">
               <p>Total No of Retailers </p>
                <h1><?php  echo ($noofretailers); ?></h1>
                
            </div>
            </a>
        </section>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
    <div class="well">
    <b>Top 10 Products</b>
    </div>
    <table class="table table-striped table-hover" cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Code</th>
                <th>Total Quantiy</th>
            </tr>
        </thead>
        <tbody>
           <?php 
$count=1;
foreach($topproducts as $row) { ?>
                <tr>
                    <td><?php echo $row->name;?></td>
                    <td><?php echo $row->productcode;?></td>
                    <td><?php echo $row->totalquantity;?></td>

                </tr>
                <?php } ?>
        </tbody>
     </table>
                
    
    
    </div>
    <div class="col-md-1">
    </div>
    <div class="col-md-7">
    <div class="well">
    <b>Last Login Status</b>
    </div>
    <table class="table table-striped table-hover" cellpadding="0" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Last Login</th>
                        <th>Todays Daily Sales</th>
                        <th>Todays Amount</th>
                        <th>Monthly Sales Quantity</th>
                        <th>Monthly Amount</th>
                    </tr>
                </thead>
                <tbody>
                   <?php 
    $count=1;
    $totaldailyquantity=0;
    $totaldailyamount=0;
    $totalmonthlyquantity=0;
    $totalmonthlyamount=0;
    foreach($userdetailswithlastlogin as $row) { ?>
                        <tr>
                            <td><?php echo $row->username;?></td>
                            <td><?php echo $row->lastlogin;?></td>
                            <td><?php echo $row->totaldailyquantity;
                                    $totaldailyquantity+=floatval($row->totaldailyquantity);
                                ?></td>
                            <td><?php echo $row->totaldailyamount;
                                $totaldailyamount+=floatval($row->totaldailyamount);
                                ?></td>
                            <td><?php echo $row->totalmonthlyquantity;
                                $totalmonthlyquantity+=floatval($row->totalmonthlyquantity);
                                ?></td>
                            <td><?php echo $row->totalmonthlyamount;
                                $totalmonthlyamount+=floatval($row->totalmonthlyamount);
                                ?></td>

                        </tr>
                        <?php } ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><b>TOTAL</b></td>
                            <td></td>
                            <td><b><?php echo $totaldailyquantity;?></b></td>
                            <td><b><?php echo $totaldailyamount;?></b></td>
                            <td><b><?php echo $totalmonthlyquantity;?></b></td>
                            <td><b><?php echo $totalmonthlyamount;?></b></td>
                        </tr>
                </tbody>
                </table>
    </div>
</div>
<div>
   <div class="well">
<b>Daily Sales Quantity Amount Graph</b>
</div>
    <div class="drawchart">
    
</div>
   <div class="drawpiechart1" style="margin-top:50px;"></div>            

   <script type="text/javascript">
    $(function () {
        var seriesOptions = [],
            seriesCounter = 0,
            names = [{name:"Quantity",color:"#3498db",url:"<?php echo site_url("site/checkchartjson1");?>"},{name:"Amount",color:"#9b59b6",url:"<?php echo site_url("site/checkchartjson2");?>"}],
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
                
                for(var j=0;j<data.length;j++)
                {
                    data[j][0]=parseInt(data[j][0]);
                    data[j][1]=parseFloat(data[j][1]);
                }
                console.log(data);
                seriesOptions[i] = {
                    name: singleline.name,
                    color: singleline.color,
                    data: data
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
<script>
$(document).ready(function() {
    generatepiechart("Sales Person Quantity Pie Diagram for Current Month",".drawpiechart1",<?php echo $values;?>)
});
</script>
</div>