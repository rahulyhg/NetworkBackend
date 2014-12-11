<div class=" row" style="padding:1% 0;">
    
	<div class="col-md-12">
	
		<a class="btn btn-primary pull-right"  href="<?php echo site_url('site/createproductimage'); ?>"><i class="icon-plus"></i>Create </a> &nbsp; 
	</div>
	
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                Product Image Details
            </header>
            <div class="drawchintantable">
            <?php $this->chintantable->createsearch("Product Image List");?>
			<table class="table table-striped table-hover" id="" cellpadding="0" cellspacing="0" >
			<thead>
				<tr>
					<th data-field="id">Id</th>
					<th data-field="productname">Product Name</th>
					<th data-field="image">Image</th>
					<th data-field="order">Order</th>
					<th data-field="views">Views</th>
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
                
                return "<tr><td>" + resultrow.id + "</td><td>" + resultrow.productname + "</td><td>" + resultrow.image + "</td><td>" + resultrow.order + "</td><td>" + resultrow.views + "</td><td><a class='btn btn-primary btn-xs' href='<?php echo site_url('site/editproductimage?id=');?>"+resultrow.id +"'><i class='icon-pencil'></i></a><a class='btn btn-danger btn-xs' href='<?php echo site_url('site/deleteproductimage?id='); ?>"+resultrow.id +"'><i class='icon-trash '></i></a></td><tr>";
            }
            generatejquery('<?php echo $base_url;?>');
        </script>
	</div>
</div>
