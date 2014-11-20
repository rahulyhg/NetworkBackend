<!--
<div class=" row" style="padding:1% 0;">
	<div class="col-md-12">
	
		<a class="btn btn-primary pull-right"  href="<?php echo site_url('site/createorder'); ?>"><i class="icon-plus"></i>Create </a> &nbsp; 
	</div>
	
</div>
-->
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                Order Products Details
            </header>
            
			<table class="table table-striped table-hover fpTable lcnp" cellpadding="0" cellspacing="0" width="100%">
			<thead>
				<tr>
					<!--<th>Id</th>-->
					<th>Product Name</th>
					<th>Quantity</th>
					<th>Amount</th>
					<th>Scheme</th>
					<th>Status</th>
					<th>Category</th>
<!--					<th> Actions </th>-->
				</tr>
			</thead>
			<tbody>
			   <?php foreach($table as $row) { ?>
					<tr>
						<!--<td><?php echo $row->id;?></td>-->
						<td><?php echo $row->productname;?></td>
						<td><?php echo $row->quantity;?></td>
						<td><?php echo $row->amount;?></td>
						<td><?php echo $row->schemename;?></td>
						<td><?php echo $row->status;?></td>
						<td><?php echo $row->categoryname;?></td>
						
<!--
						<td>
							<a href="<?php echo site_url('site/vieworderproduct?id=').$row->id;?>" class="btn btn-primary btn-xs">
								View Order Products
							</a>
							<a href="<?php echo site_url('site/deleteorder?id=').$row->id; ?>" class="btn btn-danger btn-xs">
								<i class="icon-trash "></i>
							</a> 
							
						</td>
-->
					</tr>
					<?php } ?>
			</tbody>
			</table>
		</section>
		
<!--
		<div class="">
                    <?php echo $this->pagination->create_links();?>
        </div>
-->
	</div>
</div>