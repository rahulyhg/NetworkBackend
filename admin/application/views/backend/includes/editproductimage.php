<div class="row">
	<div class="col-lg-12">
	    <section class="panel">
		    <header class="panel-heading">
				 productimage Details
			</header>
			
			<div class="panel-body">
				<form class="form-horizontal row-fluid" method="post" action="<?php echo site_url('site/editproductimagesubmit');?>" enctype= "multipart/form-data">
				
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select Product</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('product',$product,set_value('product',$before->product),'id="select4" class="chzn-select form-control" 	data-placeholder="Choose a Accesslevel..."');
					?>
				  </div>
				</div>
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">image</label>
				  <div class="col-sm-4">
					<input type="file" id="normal-field" class="form-control" name="image" value="<?php echo set_value('image',$before->image);?>">
					<?php if($before->image == "")
						 { }
						 else
						 { ?>
							<img src="<?php echo base_url('uploads')."/".$before->image; ?>" width="140px" height="140px">
						<?php }
					?>
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">order</label>
				  <div class="col-sm-4">
				  <input type="hidden" id="normal-field" class="row-fluid" name="id" value="<?php echo $before->id;?>">
					<input type="text" id="normal-field" class="form-control" name="order" value="<?php echo set_value('order',$before->order);?>">
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