<div class=" row" style="padding:1% 0;">
	<div class="col-md-12">
	
		<a class="btn btn-primary pull-right"  href="<?php echo site_url('site/createshopnavigation'); ?>"><i class="icon-plus"></i>Create </a> &nbsp; 
	</div>
	
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                Shopnavigation Details
            </header>
			<table class="table table-striped table-hover fpTable lcnp" cellpadding="0" cellspacing="0" width="100%">
			<thead>
				<tr>
					<!--<th>Id</th>-->
					<th>Name</th>
					<th>Alias</th>
					<th>Shop</th>
					<th>Order</th>
					<th>Meta Title</th>
					<th>Meta Description</th>
					<th>Banner</th>
					<th>Banner Description</th>
					<th>Position On Website</th>
					<th>Is Default</th>
					<th>Type</th>
					<th>Sizes</th>
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
						<td><?php echo $row->shopname;?></td>
						<td><?php echo $row->order;?></td>
						<td><?php echo $row->metatitle;?></td>
						<td><?php echo $row->metadescription;?></td>
						<td><img src="<?php echo base_url('uploads')."/".$row->banner; ?>" width="50px" height="auto"></td>
						<td><?php echo $row->bannerdescription;?></td>
						<td><?php echo $row->positiononwebsite;?></td>
						<td><?php if($row->isdefault==1) { ?>
							Yes
						<?php } else { ?>
							No
						<?php } ?>
						</td>
						<td><?php if($row->type==1) { ?>
							Static
						<?php } else { ?>
							Category
						<?php } ?>
						</td>
<!--						<td><?php echo $row->type;?></td>-->
						<td><?php echo $row->sizes;?></td>
						<td><?php if($row->status==1) { ?>
							<a href="<?php echo site_url('site/changeshopnavigationstatus?id=').$row->id; ?>" class="label label-success label-mini">Enable</a>
						<?php } else { ?>
							<a href="<?php echo site_url('site/changeshopnavigationstatus?id=').$row->id; ?>" class="label label-danger label-mini">Disable</a>
						<?php } ?>
						</td>
						<td>
							<a href="<?php echo site_url('site/editshopnavigation?id=').$row->id;?>" class="btn btn-primary btn-xs">
								<i class="icon-pencil"></i>
							</a>
							<a href="<?php echo site_url('site/deleteshopnavigation?id=').$row->id; ?>" class="btn btn-danger btn-xs">
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