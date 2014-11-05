<div class="row" style="padding:1% 0">
	<div class="col-md-12">
		<div class="pull-right">
			<a href="<?php echo site_url('site/viewproduct'); ?>" class="btn btn-primary pull-right"><i class="icon-long-arrow-left"></i>&nbsp;Back</a>
		</div>
	</div>
</div>
<?php    // print_r($user);
//echo $user[1];
?>
<div class="row">
	<div class="col-lg-12">
	    <section class="panel">
		    <header class="panel-heading">
				 Product Details
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/createproductsubmit');?>" enctype= "multipart/form-data">
	            
				
				
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Name</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="name" value="<?php echo set_value('name');?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Product Code</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="productcode" value="<?php echo set_value('productcode');?>">
				  </div>
				</div>
				
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">category</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('category',$category,set_value('category'),'id="select4" class="chzn-select form-control"');
					?>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">MRP</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="mrp" value="<?php echo set_value('mrp');?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">description</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="description" value="<?php echo set_value('description');?>">
				  </div>
				</div>
				<div class=" form-group">
				  <label class="col-sm-2 control-label">scheme</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('scheme',$scheme,set_value('scheme'),'id="select1" class="chzn-select form-control"');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">isnew</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('isnew',$isnew,set_value('isnew'),'id="select2" class="chzn-select form-control"');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">&nbsp;</label>
				  <div class="col-sm-4">
				  <button type="submit" class="btn btn-primary">Save</button>
				  <a href="<?php echo site_url('site/viewmall'); ?>" class="btn btn-secondary">Cancel</a>
				</div>
				</div>
			  </form>
			</div>
		</section>
	</div>
</div>
