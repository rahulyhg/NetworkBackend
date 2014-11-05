<div class="row">
	<div class="col-lg-12">
	    <section class="panel">
		    <header class="panel-heading">
				 Coupons Details
			</header>
			<div class="panel-body">
				<form class="form-horizontal row-fluid" method="post" action="<?php echo site_url('site/editcouponsubmit');?>" enctype= "multipart/form-data">
					<div class="form-group">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-4">
						  <input type="hidden" id="normal-field" class="row-fluid" name="id" value="<?php echo $before->id;?>">
						  <input type="text" id="normal-field" class="form-control" name="name" value="<?php echo set_value('name',$before->couponname);?>">
						</div>
					</div>
					
					<div class="form-group">
                        <label class="col-sm-2 control-label" for="normal-field">Add Codes</label>
                          <div class="col-sm-4">
                          <?php 
                                        echo form_dropdown('codes[]', $codes,$selectedcodes,'id="select5" class="form-control populate placeholder " multiple="multiple"');

                                    ?>

                          </div>
                          <div class="col-md-4">
                            <input type="checkbox" id="checkbox" >Select All
                          </div>
                    </div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Rules</label>
						<div class="col-sm-4">
						  <input type="text" id="normal-field" class="form-control" name="rules" value="<?php echo set_value('rules',$before->rules);?>">
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
    })
</script>