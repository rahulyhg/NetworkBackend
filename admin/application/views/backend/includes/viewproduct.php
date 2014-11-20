<div class=" row" style="padding:1% 0;">
    <div class="col-md-9">
            <div class=" pull-right col-md-1 createbtn" ><a class="btn btn-primary" href="<?php echo site_url('site/exportproduct'); ?>"target="_blank"><i class="icon-plus"></i>Export to CSV </a></div>
    </div>
	<div class="col-md-12">
	
		<a class="btn btn-primary pull-right"  href="<?php echo site_url('site/createproduct'); ?>"><i class="icon-plus"></i>Create </a> &nbsp; 
	</div>
	
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                Product Details
            </header>
            <?php 
//print_r($table);
            ?>
			<table class="table table-striped table-hover" cellpadding="0" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>Id</th>
					<th>Product Name</th>
					<th>Code</th>
					<th>category</th>
					<th>MRP</th>
					<th>Description</th>
					<th>scheme</th>
					<th>Is New</th>
					<th>Timestamp</th>
					<th> Actions </th>
				</tr>
			</thead>
			<tbody>
			   <?php foreach($table as $row) { ?>
					<tr>
						<td><?php echo $row->id;?></td>
						<td><?php echo $row->productname;?></td>
						<td><?php echo $row->productcode;?></td>
						<td><?php echo $row->categoryname;?></td>
						<td><?php echo $row->mrp;?></td>
						<td><?php echo $row->description;?></td>
						<td><?php echo $row->schemename;?></td>
						<td><?php echo $row->isnew;?></td>
						<td><?php echo $row->timestamp;?></td>
						
						<td>
							<a href="<?php echo site_url('site/editproduct?id=').$row->id;?>" class="btn btn-primary btn-xs">
								<i class="icon-pencil"></i>
							</a>
							<a href="<?php echo site_url('site/deleteproduct?id=').$row->id; ?>" class="btn btn-danger btn-xs">
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