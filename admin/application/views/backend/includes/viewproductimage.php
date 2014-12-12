<div class=" row" style="padding:1% 0;">
	<div class="col-md-12">
	
		<a class="btn btn-primary pull-right"  href="<?php echo site_url('site/createproductimage?id=').$this->input->get('id'); ?>"><i class="icon-plus"></i>Create </a> &nbsp; 
	</div>
	
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                Product Image Details <?php if (!empty($table)) { echo 'Of "<b>'.$table[0]->productname.'</b>"';
}?>
            </header>
			<table class="table table-striped table-hover  fpTable lcnp" cellpadding="0" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>Id</th>
					<th>Product</th>
					<th>Image</th>
					<th>Order</th>
					<th>Views</th>
					<th> Actions </th>
				</tr>
			</thead>
			<tbody>
			   <?php foreach($table as $row) { ?>
					<tr>
						<td><?php echo $row->id;?></td>
						<td><?php echo $row->productname;?></td>
						<td><?php echo $row->image;?></td>
<!--						<td><img src="<?php echo base_url('uploads')."/".$row->image; ?>" width="50px" height="auto"></td>-->
						<td><?php echo $row->order;?></td>
						<td><?php echo $row->views;?></td>
						
						<td>
							<a href="<?php echo site_url('site/editproductimage?id=').$row->product.'&productimageid='.$row->id;?>" class="btn btn-primary btn-xs">
								<i class="icon-pencil"></i>
							</a>
							<a href="<?php echo site_url('site/deleteproductimage?id=').$row->product.'&productimageid='.$row->id; ?>" class="btn btn-danger btn-xs">
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


