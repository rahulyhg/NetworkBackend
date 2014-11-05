<div class="row" style="padding:1% 0">
	<div class="col-md-12">
		<div class="pull-right">
			<a href="<?php echo site_url('site/viewvendor'); ?>" class="btn btn-primary pull-right"><i class="icon-long-arrow-left"></i>&nbsp;Back</a>
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
				 Vendor Details
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/createvendorsubmit');?>" enctype= "multipart/form-data">
	            
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Name</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="name" value="<?php echo set_value('name');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Shop</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('shop',$shop,set_value('shop'),'id="select2" class="form-control populate placeholder select2-offscreen"');
					?>
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Email</label>
				  <div class="col-sm-4">
					<input type="email" id="normal-field" class="form-control" name="email" value="<?php echo set_value('email');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Contact</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="contact" value="<?php echo set_value('contact');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">VAT</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="vat" value="<?php echo set_value('vat');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Tin</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="tin" value="<?php echo set_value('tin');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Address</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="address" value="<?php echo set_value('address');?>">
				  </div>
				</div>
				
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Details</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="details" value="<?php echo set_value('details');?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">PAN</label>
				  <div class="col-sm-4">
<!--				  <textarea name="description" form="usrform"  rows="20" cols="5"><?php echo set_value('description');?></textarea>-->
					<input type="text" id="normal-field" class="form-control" name="pan" value="<?php echo set_value('pan');?>">
				  </div>
				</div>

				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Tax Amount</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="taxamount" value="<?php echo set_value('taxamount');?>">
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
