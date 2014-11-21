<div class=" row" style="padding:1% 0;">
<!--
    <div class="col-md-11">
            <div class=" pull-right col-md-1 createbtn" ><a class="btn btn-primary" href="<?php echo site_url('site/exportorder'); ?>" target="_blank"><i class="icon-plus"></i>Export to CSV </a></div>
    </div>
-->
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                Order Details
            </header>
            
			<table class="table table-striped table-hover" cellpadding="0" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>Id</th>
					<th>Timestamp</th>
					<th>Retailer</th>
					<th>Sales Person</th>
					<th>Amount</th>
					<th>Sales ID</th>
					<th>Quantity</th>
					<th>Remark</th>
					<th> Actions </th>
				</tr>
			</thead>
			<tbody>
			   <?php foreach($table as $row) { ?>
					<tr>
						<td><?php echo $row->id;?></td>
						<td><?php echo $row->timestamp;?></td>
						<td><?php echo $row->retailername;?></td>
						<td><?php echo $row->sales;?></td>
						<td><?php echo $row->amount;?></td>
						<td><?php echo $row->salesid;?></td>
						<td><?php echo $row->quantity;?></td>
						<td><?php echo $row->remark;?></td>
						
						<td>
							<a href="<?php echo site_url('site/vieworderproduct?id=').$row->id;?>" class="btn btn-primary btn-xs">
								View Order Products
							</a>
<!--
							<a href="<?php echo site_url('site/deleteorder?id=').$row->id; ?>" class="btn btn-danger btn-xs">
								<i class="icon-trash "></i>
							</a> 
-->
							
						</td>
					</tr>
					<?php } ?>
			</tbody>
			</table>
		</section>
		<div class="">
                    <?php echo $this->pagination->create_links();?>
        </div>
	</div>
</div>