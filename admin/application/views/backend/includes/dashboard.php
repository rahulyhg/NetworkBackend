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
    <div class="col-md-6">
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
    <div class="col-md-5">
    <div class="well">
    <b>Last Login Status</b>
    </div>
    <table class="table table-striped table-hover" cellpadding="0" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Last Login</th>
                    </tr>
                </thead>
                <tbody>
                   <?php 
    $count=1;
    foreach($users as $row) { ?>
                        <tr>
                            <td><?php echo $row->name;?></td>
                            <td><?php echo $row->lastlogin;?></td>

                        </tr>
                        <?php } ?>
                </tbody>
                </table>
    </div>