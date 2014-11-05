	    <section class="panel">
		    <header class="panel-heading">
				 Retailer Details
			</header>
			
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/editretailersubmit');?>" enctype= "multipart/form-data">
				<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
				
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">lat</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="lat" value="<?php echo set_value('lat',$before->lat);?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">long</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="long" value="<?php echo set_value('long',$before->long);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">area</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('area',$area,set_value('area',$before->area),'id="select4" class="chzn-select form-control"');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">DOB</label>
				  <div class="col-sm-4">
					<input type="text" id="dp1" class="form-control" name="dob" value="<?php echo set_value('dob',$before->dob);?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Sq. Feet</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="sq_feet" value="<?php echo set_value('sq_feet',$before->sq_feet);?>">
				  </div>
				</div>
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">image</label>
				  <div class="col-sm-4">
					<input type="file" id="normal-field" class="form-control" name="store_image" value="<?php echo set_value('store_image',$before->store_image);?>">
					<?php if($before->store_image == "")
						 { }
						 else
						 { ?>
							<img src="<?php echo base_url('uploads')."/".$before->store_image; ?>" width="140px" height="140px">
						<?php }
					?>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Name</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="name" value="<?php echo set_value('name',$before->name);?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Number</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="number" value="<?php echo set_value('number',$before->number);?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Email</label>
				  <div class="col-sm-4">
					<input type="email" id="normal-field" class="form-control" name="email" value="<?php echo set_value('email',$before->email);?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Address</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="address" value="<?php echo set_value('address',$before->address);?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Owner Name</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="ownername" value="<?php echo set_value('ownername',$before->ownername);?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Owner Number</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="ownernumber" value="<?php echo set_value('ownernumber',$before->ownernumber);?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Contact Name</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="contactname" value="<?php echo set_value('contactname',$before->contactname);?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Contact Number</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="contactnumber" value="<?php echo set_value('contactnumber',$before->contactnumber);?>">
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
