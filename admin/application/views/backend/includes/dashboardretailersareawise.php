
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
					<th>Zone</th>
					<th>State</th>
					<th>City</th>
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
<!--					<th> Actions </th>-->
				</tr>
			</thead>
			<tbody>
			   <?php foreach($retailer as $row) { ?>
					<tr>
						<!--<td><?php echo $row->id; ?></td>-->
						<td><?php echo $row->name; ?></td>
						<td><?php echo $row->number; ?></td>
						<td><?php echo $row->email; ?></td>
						<td><?php echo $row->address; ?></td>
						<td><?php echo $row->zonename; ?></td>
						<td><?php echo $row->statename; ?></td>
						<td><?php echo $row->cityname; ?></td>
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
					</tr>
					<?php } ?>
			</tbody>
			</table>
		</section>
	</div>
  </div>
