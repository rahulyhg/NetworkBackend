	    <section class="panel">
		    <header class="panel-heading">
				 vendor Details
			</header>
			
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/editvendorsubmit');?>" enctype= "multipart/form-data">
				<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before['vendor']->id);?>" style="display:none;">
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Name</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="name" value="<?php echo set_value('name',$before['vendor']->name);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Shop</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('shop',$shop,set_value('shop',$before['vendor']->shop),'id="select2" class="form-control populate placeholder select2-offscreen"');
					?>
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Email</label>
				  <div class="col-sm-4">
					<input type="email" id="normal-field" class="form-control" name="email" value="<?php echo set_value('email',$before['vendor']->email);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Contact</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="contact" value="<?php echo set_value('contact',$before['vendor']->contact);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">VAT</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="vat" value="<?php echo set_value('vat',$before['vendor']->vat);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Tin</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="tin" value="<?php echo set_value('tin',$before['vendor']->tin);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Address</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="address" value="<?php echo set_value('address',$before['vendor']->address);?>">
				  </div>
				</div>
				
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Details</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="details" value="<?php echo set_value('details',$before['vendor']->details);?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">PAN</label>
				  <div class="col-sm-4">
<!--				  <textarea name="description" form="usrform"  rows="20" cols="5"><?php echo set_value('description');?></textarea>-->
					<input type="text" id="normal-field" class="form-control" name="pan" value="<?php echo set_value('pan',$before['vendor']->pan);?>">
				  </div>
				</div>

				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Tax Amount</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="taxamount" value="<?php echo set_value('taxamount',$before['vendor']->taxamount);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">&nbsp;</label>
				  <div class="col-sm-4">
				  <button type="submit" class="btn btn-primary">Save</button>
				  <a href="<?php echo site_url('site/viewshop'); ?>" class="btn btn-secondary">Cancel</a>
				</div>
				</div>
			  </form>
			</div>
		</section>
