	    <section class="panel">
		    <header class="panel-heading">
				 User Details
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/editusersubmit');?>">
				<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Email</label>
				  <div class="col-sm-4">
					<?php echo $before->email; ?>
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Name</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="firstname" value="<?php echo set_value('firstname',$before->name);?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="description-field">Password</label>
				  <div class="col-sm-4">
					<input type="password" id="description-field" class="form-control" name="password" value="">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="description-field">Confirm Password</label>
				  <div class="col-sm-4">
					<input type="password" id="description-field" class="form-control" name="confirmpassword" value="">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Contact</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="contact" value="<?php echo set_value('contact',$before->mobile);?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label">Select Accesslevel</label>
				  <div class="col-sm-4">
					<?php  	 echo form_dropdown('accesslevel',$accesslevel,set_value('accesslevel',$before->accesslevel),'class="chzn-select form-control" 	data-placeholder="Choose a Accesslevel..."');
					?>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label">Zone</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('zone',$zone,set_value('zone',$before->zone),'class="chzn-select form-control" 	data-placeholder="Choose a Accesslevel..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">&nbsp;</label>
				  <div class="col-sm-4">
				  <button type="submit" class="btn btn-primary">Save</button>
				  <a href="<?php echo site_url('site/viewusers'); ?>" class="btn btn-secondary">Cancel</a>
				</div>
				</div>
			  </form>
			</div>
		</section>
<script>
    $(document).ready(function() { 
//$("#e1").select2();
$("#checkbox").click(function(){
    if($("#checkbox").is(':checked') ){
        $("#select5 > option").prop("selected","selected");
        $("#select5").trigger("change");
    }else{
        $("#select5 > option").removeAttr("selected");
         $("#select5").trigger("change");
     }
});

$("#button").click(function(){
       alert($("#select5").val());
});
   $("#checkbox1").click(function(){
    if($("#checkbox1").is(':checked') ){
        $("#select1 > option").prop("selected","selected");
        $("#select1").trigger("change");
    }else{
        $("#select1 > option").removeAttr("selected");
         $("#select1").trigger("change");
     }
});

$("#button").click(function(){
       alert($("#select1").val());
});
    })
</script>