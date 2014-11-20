<div class=" row" style="padding:1% 0;">
    <div class="col-md-9">
            <div class=" pull-right col-md-1 createbtn" ><a class="btn btn-primary" href="<?php echo site_url('site/exportdistributor'); ?>" target="_blank"><i class="icon-plus"></i>Export to CSV </a></div>
    </div>
	<div class="col-md-2">
	
		<a class="btn btn-primary pull-right"  href="<?php echo site_url('site/createdistributor'); ?>"><i class="icon-plus"></i>Create </a> &nbsp; 
	</div>
	
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                distributor Details
            </header>
			<table class="table table-striped table-hover" cellpadding="0" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>ID</th>
					<th>Distributor Name</th>
					<th>Code</th>
					<th>Company</th>
					<th>Email</th>
					<th>Contact</th>
					<th>DOB</th>
					<th>Address1</th>
					<th>Address2</th>
					<th>Zip Code</th>
					<th> Actions </th>
				</tr>
			</thead>
			<tbody>
			   <?php foreach($table as $row) { ?>
					<tr>
						<td><?php echo $row->id;?></td>
						<td><?php echo $row->distributorname;?></td>
						<td><?php echo $row->code;?></td>
						<td><?php echo $row->componyname;?></td>
						<td><?php echo $row->email;?></td>
						<td><?php echo $row->contactno;?></td>
						<td><?php echo $row->dob;?></td>
						<td><?php echo $row->address1;?></td>
						<td><?php echo $row->address2;?></td>
						<td><?php echo $row->zipcode;?></td>
						
						<td>
							<a href="<?php echo site_url('site/editdistributor?id=').$row->id;?>" class="btn btn-primary btn-xs">
								<i class="icon-pencil"></i>
							</a>
							<a href="<?php echo site_url('site/deletedistributor?id=').$row->id; ?>" class="btn btn-danger btn-xs">
								<i class="icon-trash "></i>
							</a> 
							
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