<div class=" row" style="padding:1% 0;">
	<div class="col-md-9">
		<div class=" pull-right col-md-1 createbtn" ><a class="btn btn-primary" href="<?php echo site_url('site/exportretailer'); ?>"target="_blank"><i class="icon-plus"></i>Export to CSV </a></div>
	</div>
	<div class="col-md-2">
		<div class=" pull-right col-md-1 createbtn" ><a class="btn btn-primary" href="<?php echo site_url('site/createretailer'); ?>"><i class="icon-plus"></i>Create </a></div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                Retailer Details
            </header>
			<table class="table table-striped table-hover border-top " id="sample_1" cellpadding="0" cellspacing="0" >
			<thead>
				<tr>
					<!--<th>Id</th>-->
					<th>Name</th>
					<th>Number</th>
					<th>Email</th>
					<th>Address</th>
					<th>Lat</th>
					<th>Long</th>
					<th>Area</th>
<!--
					<th>Ownername</th>
					<th>Ownernumber</th>
					<th>Contactname</th>
					<th>Contactnumber</th>
-->
<!--
					<th>Type Of Area</th>
					<th>Sq. Ft.</th>
					<th>Image</th>
-->
					<th> Actions </th>
				</tr>
			</thead>
			<tbody>
			   <?php foreach($table as $row) { ?>
					<tr>
						<!--<td><?php echo $row->id; ?></td>-->
						<td><?php echo $row->name; ?></td>
						<td><?php echo $row->number; ?></td>
						<td><?php echo $row->email; ?></td>
						<td><?php echo $row->address; ?></td>
						<td><?php echo $row->lat; ?></td>
						<td><?php echo $row->long; ?></td>
						<td><?php echo $row->areaname; ?></td>
<!--
						<td><?php echo $row->ownername; ?></td>
						<td><?php echo $row->ownernumber; ?></td>
						<td><?php echo $row->contactname; ?></td>
						<td><?php echo $row->contactnumber; ?></td>
-->
<!--
						<td><?php echo $row->type_of_area; ?></td>
						<td><?php echo $row->sq_feet; ?></td>
						<td><?php echo $row->store_image; ?></td>
-->
						<td> <a class="btn btn-primary btn-xs" href="<?php echo site_url('site/editretailer?id=').$row->id;?>"><i class="icon-pencil"></i></a>
                                      <a class="btn btn-danger btn-xs" href="<?php echo site_url('site/deleteretailer?id=').$row->id; ?>"><i class="icon-trash "></i></a>
									 
					  </td>
					</tr>
					<?php } ?>
			</tbody>
			</table>
		</section>
	</div>
  </div>
