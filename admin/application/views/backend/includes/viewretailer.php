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
            <div class="drawchintantable">
            <?php $this->chintantable->createsearch("Retailer List");?>
			<table class="table table-striped table-hover" id="" cellpadding="0" cellspacing="0" >
			<thead>
				<tr>
					<th data-field="id">Id</th>
					<th data-field="name">Name</th>
					<th data-field="number">Number</th>
					<th data-field="email">Email</th>
					<th data-field="address">Address</th>
					<th data-field="areaname">Area</th>
                    <th data-field="action"> Actions </th>
				</tr>
			</thead>
			<tbody>
			   <?php foreach($table as $row) { ?>
					<tr>
						<td><?php echo $row->id; ?></td>
						<td><?php echo $row->name; ?></td>
						<td><?php echo $row->number; ?></td>
						<td><?php echo $row->email; ?></td>
						<td><?php echo $row->address; ?></td>
						<td><?php echo $row->areaname; ?></td>
                        <td> <a class="btn btn-primary btn-xs" href="<?php echo site_url('site/editretailer?id=').$row->id;?>"><i class="icon-pencil"></i></a>
                                      <a class="btn btn-danger btn-xs" href="<?php echo site_url('site/deleteretailer?id=').$row->id; ?>"><i class="icon-trash "></i></a>
									 
					  </td>
					</tr>
					<?php } ?>
			</tbody>
			</table>
               <?php $this->chintantable->createpagination();?>
            </div>
		</section>
		<script>
            function drawtable(resultrow) {
                if(!resultrow.sales)
                {
                    resultrow.sales="";
                }
                return "<tr><td>" + resultrow.id + "</td><td>" + resultrow.name + "</td><td>" + resultrow.number + "</td><td>" + resultrow.email + "</td><td>" + resultrow.address + "</td><td>" + resultrow.areaname + "</td><td><a class='btn btn-primary btn-xs' href='<?php echo site_url('site/editretailer?id=');?>"+resultrow.id +"'><i class='icon-pencil'></i></a><a class='btn btn-danger btn-xs' href='<?php echo site_url('site/deleteretailer?id='); ?>"+resultrow.id +"'><i class='icon-trash '></i></a></td><tr>";
            }
            generatejquery('<?php echo $base_url;?>');
        </script>
	</div>
  </div>
