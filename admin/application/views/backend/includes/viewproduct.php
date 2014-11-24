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
            <div class="drawchintantable">
            <?php $this->chintantable->createsearch("Product List");?>
			<table class="table table-striped table-hover" id="" cellpadding="0" cellspacing="0" >
			<thead>
				<tr>
					<th data-field="id">Id</th>
					<th data-field="productname">Product Name</th>
					<th data-field="productcode">Code</th>
					<th data-field="categoryname">Category</th>
					<th data-field="mrp">MRP</th>
					<th data-field="description">Description</th>
					<th data-field="schemename">Scheme</th>
					<th data-field="isnew">Is New</th>
					<th data-field="timestamp">Timestamp</th>
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
                if(!resultrow.schemename)
                {
                    resultrow.schemename="";
                }
                if(!resultrow.isnew)
                {
                    resultrow.isnew="";
                }
                return "<tr><td>" + resultrow.id + "</td><td>" + resultrow.productname + "</td><td>" + resultrow.productcode + "</td><td>" + resultrow.categoryname + "</td><td>" + resultrow.mrp + "</td><td>" + resultrow.description + "</td><td>" + resultrow.schemename + "</td><td>" + resultrow.isnew + "</td><td>" + resultrow.timestamp + "</td><td><a class='btn btn-primary btn-xs' href='<?php echo site_url('site/editproduct?id=');?>"+resultrow.id +"'><i class='icon-pencil'></i></a><a class='btn btn-danger btn-xs' href='<?php echo site_url('site/deleteproduct?id='); ?>"+resultrow.id +"'><i class='icon-trash '></i></a></td><tr>";
            }
            generatejquery('<?php echo $base_url;?>');
        </script>
	</div>
</div>