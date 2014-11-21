<div class="row">
	<div class="col-lg-12">
	    <section class="panel">
		    <header class="panel-heading">
				 distributor Details
			</header>
			
			<div class="panel-body">
				<form class="form-horizontal row-fluid" method="post" action="<?php echo site_url('site/editdistributorsubmit');?>" enctype= "multipart/form-data">
					<div class="form-group">
						<label class="col-sm-2 control-label">Company Name</label>
						<div class="col-sm-4">
						  <input type="hidden" id="normal-field" class="row-fluid" name="id" value="<?php echo $before->id;?>">
						  <input type="text" id="normal-field" class="form-control" name="name" value="<?php echo set_value('name',$before->name);?>">
						</div>
					</div>		
					<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Code</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="code" value="<?php echo set_value('code',$before->code);?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Name</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="componyname" value="<?php echo set_value('componyname',$before->componyname);?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Email</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="email" value="<?php echo set_value('email',$before->email);?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Contact No</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="contactno" value="<?php echo set_value('contactno',$before->contactno);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">DOB</label>
				  <div class="col-sm-4">
					<input type="text" id="dp1" class="form-control" name="dob" value="<?php echo set_value('dob',$before->dob);?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Address1</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="address1" value="<?php echo set_value('address1',$before->address1);?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Address2</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="address2" value="<?php echo set_value('address2',$before->address2);?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Zip Code</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="zipcode" value="<?php echo set_value('zipcode',$before->zipcode);?>">
				  </div>
				</div>
				
					
					<div class="form-group">
						<label class="col-sm-2 control-label">&nbsp;</label>
						<div class="col-sm-4">	
							<button type="submit" class="btn btn-info">Submit</button>
						</div>
					</div>
				</form>
			</div>
		</section>
    </div>
</div>