<div class=" row" style="padding:1% 0;">
	<div class="col-md-12">
	
		<a class="btn btn-primary pull-right"  href="<?php echo site_url('site/createscheme'); ?>"><i class="icon-plus"></i>Create </a> &nbsp; 
	</div>
	
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                Scheme Details
            </header>
            <div class="drawchintantable">
            <?php $this->chintantable->createsearch("Distributor List");?>
			<table class="table table-striped table-hover" id="" cellpadding="0" cellspacing="0" >
			<thead>
				<tr>
					<th data-field="id">Id</th>
					<th data-field="schemename">Scheme Name</th>
					<th data-field="discount_percent">Disecount Percent</th>
					<th data-field="date_start">Start Date</th>
					<th data-field="date_end">End Date</th>
					<th data-field="mrp">MRP</th>
                    <th data-field="action"> Actions </th>
				</tr>
			</thead>
			<tbody>
			  
			</tbody>
			</table>
               <?php $this->chintantable->createpagination();?>
            </div>
		</section>
		<script>
            
            function drawtable(resultrow) {
                return "<tr><td>" + resultrow.id + "</td><td>" + resultrow.schemename + "</td><td>" + resultrow.discount_percent + "</td><td>" + resultrow.date_start + "</td><td>" + resultrow.date_end + "</td><td>" + resultrow.mrp + "</td><td><a class='btn btn-primary btn-xs' href='<?php echo site_url('site/editscheme?id=');?>"+resultrow.id +"'><i class='icon-pencil'></i></a><a class='btn btn-danger btn-xs' href='<?php echo site_url('site/deletescheme?id='); ?>"+resultrow.id +"'><i class='icon-trash '></i></a></td><tr>";
            }
            generatejquery('<?php echo $base_url;?>');
        </script>
<!--
		<div class="">
                    <?php echo $this->pagination->create_links();?>
                </div>
-->
	</div>
</div>