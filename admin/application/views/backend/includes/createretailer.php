<div class="row" style="padding:1% 0">
	<div class="col-md-12">
		<div class="pull-right">
			<a href="<?php echo site_url('site/viewretailer'); ?>" class="btn btn-primary pull-right"><i class="icon-long-arrow-left"></i>&nbsp;Back</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
	    <section class="panel">
		    <header class="panel-heading">
				 Retailer Details
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/createretailersubmit');?>">
			  
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">lat</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="lat" value="<?php echo set_value('lat');?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">long</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="long" value="<?php echo set_value('long');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">area</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('area',$area,set_value('area'),'id="select4" class="chzn-select form-control"');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">DOB</label>
				  <div class="col-sm-4">
					<input type="text" id="dp1" class="form-control" name="dob" value="<?php echo set_value('dob');?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Sq. Feet</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="sq_feet" value="<?php echo set_value('sq_feet');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Image</label>
				  <div class="col-sm-4">
					<input type="file" id="normal-field" class="form-control" name="store_image" value="<?php echo set_value('store_image');?>">
				  </div>
				</div>
				
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Name</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="name" value="<?php echo set_value('name');?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Number</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="number" value="<?php echo set_value('number');?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Email</label>
				  <div class="col-sm-4">
					<input type="email" id="normal-field" class="form-control" name="email" value="<?php echo set_value('email');?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Address</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="address" value="<?php echo set_value('address');?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Owner Name</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="ownername" value="<?php echo set_value('ownername');?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Owner Number</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="ownernumber" value="<?php echo set_value('ownernumber');?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Contact Name</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="contactname" value="<?php echo set_value('contactname');?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Contact Number</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="contactnumber" value="<?php echo set_value('contactnumber');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">&nbsp;</label>
				  <div class="col-sm-4">
				  <button type="submit" class="btn btn-primary">Save</button>
				  <a href="<?php echo site_url('site/viewretailer'); ?>" class="btn btn-secondary">Cancel</a>
				</div>
				</div>
			  </form>
			</div>
		</section>
	</div>
</div>
