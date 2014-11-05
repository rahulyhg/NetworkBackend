<div class="row">
	<div class="col-lg-12">
	    <section class="panel">
		    <header class="panel-heading">
				 scheme Details
			</header>
			
			<div class="panel-body">
				<form class="form-horizontal row-fluid" method="post" action="<?php echo site_url('site/editschemesubmit');?>" enctype= "multipart/form-data">
					<div class="form-group">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-4">
						  <input type="hidden" id="normal-field" class="row-fluid" name="id" value="<?php echo $before->id;?>">
						  <input type="text" id="normal-field" class="form-control" name="name" value="<?php echo set_value('name',$before->name);?>">
						</div>
					</div>		
					<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Discount In Percent</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="discount_percent" value="<?php echo set_value('discount_percent',$before->discount_percent);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Start Date</label>
				  <div class="col-sm-4">
					<input type="text" id="dp1" class="form-control" name="date_start" value="<?php echo set_value('date_start',$before->date_start);?>">
				  </div>
				</div>
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">End Date</label>
				  <div class="col-sm-4">
					<input type="text" id="dp2" class="form-control" name="date_end" value="<?php echo set_value('date_end',$before->date_end);?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">MRP</label>
				  <div class="col-sm-4">
					<input type="numeric" id="normal-field" class="form-control" name="mrp" value="<?php echo set_value('mrp',$before->mrp);?>">
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