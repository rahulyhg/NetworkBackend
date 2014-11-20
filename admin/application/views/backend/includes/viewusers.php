<div class=" row" style="padding:1% 0;">
	<div class="col-md-12">
	
		<a class="btn btn-primary pull-right"  href="<?php echo site_url('site/createuser'); ?>"><i class="icon-plus"></i>Create </a> &nbsp; 
	</div>
	
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                User Details
            </header>
			<table class="table table-striped table-hover" cellpadding="0" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>Id</th>
					<th>Name</th>
					<th>Access Level</th>
					<td>Email</td>
					<td>Mobile</td>
					<td>Zone</td>
					<th> Actions </th>
				</tr>
			</thead>
			<tbody>
			   <?php foreach($table as $row) { ?>
					<tr>
						<td><?php echo $row->id;?></td>
						<td><?php echo $row->name;?></td>
						<td><?php echo $row->accesslevel;?></td>
						<td><?php echo $row->email;?></td>
						<td><?php echo $row->mobile;?></td>
						<td><?php echo $row->zonename;?></td>
						
						<td>
							<a href="<?php echo site_url('site/edituser?id=').$row->id;?>" class="btn btn-primary btn-xs">
								<i class="icon-pencil"></i>
							</a>
							
							<a href="<?php echo site_url('site/deleteuser?id=').$row->id; ?>" class="btn btn-danger btn-xs">
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