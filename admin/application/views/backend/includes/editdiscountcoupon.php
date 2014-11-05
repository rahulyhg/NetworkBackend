<div class="row">
	<div class="col-lg-12">
	    <section class="panel">
		    <header class="panel-heading">
				 Discount Coupon Details
			</header>
			<div class="panel-body">
				<form class="form-horizontal row-fluid" method="post" action="<?php echo site_url('site/editdiscountcouponsubmit');?>" >
					<div class="form-row control-group row-fluid" style="display:none;">
						<label class="control-label span3" for="normal-field">ID</label>
						<div class="controls span9">
						  <input type="hidden" id="normal-field" class="row-fluid hidden" name="id" value="<?php echo $before['dc']->id;?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-4">
						  <input type="text" id="normal-field" class="form-control" name="name" value="<?php echo set_value('name',$before['dc']->name);?>">
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-2 control-label">Discount Percent</label>
						<div class="col-sm-4">
						  <input type="text" id="normal-field" class="form-control" name="percent" value="<?php echo set_value('percent',$before['dc']->percent);?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Discount Amount</label>
						<div class="col-sm-4">
						  <input type="text" id="normal-field" class="form-control" name="amount" value="<?php echo set_value('amount',$before['dc']->amount);?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Minimum Ticket</label>
						<div class="col-sm-4">
						  <input type="text" id="normal-field" class="form-control" name="minimumticket" value="<?php echo set_value('minimumticket',$before['dc']->minimumticket);?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Maximum Ticket</label>
						<div class="col-sm-4">
						  <input type="text" id="normal-field" class="form-control" name="maximumticket" value="<?php echo set_value('maximumticket',$before['dc']->maximumticket);?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Start Time</label>
						<div class="col-sm-4">
						  <input type="time" id="normal-field" class="form-control" name="starttime" value="<?php echo set_value('starttime',date("H:i",strtotime($before['dc']->starttime)));?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">End Time</label>
						<div class="col-sm-4">
						  <input type="time" id="normal-field" class="form-control" name="endtime" value="<?php echo set_value('endtime',date("H:i",strtotime($before['dc']->endtime)));?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">User Per User</label>
						<div class="col-sm-4">
						  <input type="text" id="normal-field" class="form-control" name="userperuser" value="<?php echo set_value('userperuser',$before['dc']->userperuser);?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Ticket Event</label>
						<div class="col-sm-4">
						   <?php 
								echo form_dropdown('ticketevent',$ticketevent,set_value('ticketevent',$before['dc']->ticketevent),'id="select1" class="form-control populate placeholder select2-offscreen"');
								 
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Coupon Code</label>
						<div class="col-sm-4">
						  <input type="text" id="normal-field" class="form-control" name="couponcode" value="<?php echo set_value('couponcode',$before['dc']->couponcode);?>">
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