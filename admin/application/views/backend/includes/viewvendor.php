<div class=" row" style="padding:1% 0;">
	<div class="col-md-12">
	
		<a class="btn btn-primary pull-right"  href="<?php echo site_url('site/createvendor'); ?>"><i class="icon-plus"></i>Create </a> &nbsp; 
	</div>
	
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                Vendor Details
            </header>
            
			<table class="table table-striped table-hover fpTable lcnp" cellpadding="0" cellspacing="0" width="100%">
			<thead>
				<tr>
					<!--<th>Id</th>-->
					<th>vendor Name</th>
					<th>Shop Name</th>
					<th>Email</th>
					<th>Contact</th>
					<th>Vat</th>
					<th>Tin</th>
					<th>Address</th>
					<th>Details</th>
					<th>PAN</th>
					<th>Tax Amount</th>
					<th> Actions </th>
				</tr>
			</thead>
			<tbody>
			   <?php foreach($table as $row) { ?>
					<tr>
						<!--<td><?php echo $row->id;?></td>-->
						<td><?php echo $row->vendorname;?></td>
						<td><?php echo $row->shopname;?></td>
						<td><?php echo $row->email;?></td>
						<td><?php echo $row->contact;?></td>
						<td><?php echo $row->vat;?></td>
						<td><?php echo $row->tin;?></td>
						<td><?php echo $row->address;?></td>
						<td><?php echo $row->details;?></td>
						<td><?php echo $row->pan;?></td>
						<td><?php echo $row->taxamount;?></td>
						
						<td>
							<a href="<?php echo site_url('site/editvendor?id=').$row->id;?>" class="btn btn-primary btn-xs">
								<i class="icon-pencil"></i>
							</a>
							<a href="<?php echo site_url('site/deletevendor?id=').$row->id; ?>" class="btn btn-danger btn-xs">
								<i class="icon-trash "></i>
							</a> 
							
						</td>
					</tr>
					<?php } ?>
			</tbody>
			</table>
		</section>
	</div>
</div>