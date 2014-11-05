<div class=" row" style="padding:1% 0;">
	<div class="col-md-12">
	
		<a class="btn btn-primary pull-right"  href="<?php echo site_url('site/createshop'); ?>"><i class="icon-plus"></i>Create </a> &nbsp; 
	</div>
	
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                Shop Details
            </header>
			<table class="table table-striped table-hover fpTable lcnp" cellpadding="0" cellspacing="0" width="100%">
			<thead>
				<tr>
					<!--<th>Id</th>-->
					<th>Name</th>
					<th>Alias</th>
					<th>User</th>
					<th>Meta Title</th>
					<th>Meta Description</th>
					<th>Banner</th>
					<th>Banner Description</th>
					<th>Default Tax</th>
					<th>Status</th>
					<th> Actions </th>
				</tr>
			</thead>
			<tbody>
			   <?php foreach($table as $row) { ?>
					<tr>
						<!--<td><?php echo $row->id;?></td>-->
						<td><?php echo $row->name;?></td>
						<td><?php echo $row->alias;?></td>
						<td><?php echo $row->firstname." ".$row->lastname;?></td>
						<td><?php echo $row->metatitle;?></td>
						<td><?php echo $row->metadescription;?></td>
						<td><img src="<?php echo base_url('uploads')."/".$row->bannername; ?>" width="50px" height="auto"></td>
						<td><?php echo $row->bannerdescription;?></td>
						<td><?php echo $row->defaulttax;?></td>
						<td><?php if($row->status==1) { ?>
							<a href="<?php echo site_url('site/changeshopstatus?id=').$row->id; ?>" class="label label-success label-mini">Enable</a>
						<?php } else { ?>
							<a href="<?php echo site_url('site/changeshopstatus?id=').$row->id; ?>" class="label label-danger label-mini">Disable</a>
						<?php } ?>
						</td>
						<td>
							<a href="<?php echo site_url('site/editshop?id=').$row->id;?>" class="btn btn-primary btn-xs">
								<i class="icon-pencil"></i>
							</a>
							<a href="<?php echo site_url('site/deleteshop?id=').$row->id; ?>" class="btn btn-danger btn-xs">
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