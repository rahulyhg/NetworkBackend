	    <section class="panel">
		    <header class="panel-heading">
				 Product Details
			</header>
			
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/editproductsubmit');?>" enctype= "multipart/form-data">
				<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before['product']->id);?>" style="display:none;">
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Name</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="name" value="<?php echo set_value('name',$before['product']->name);?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Product Code</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="productcode" value="<?php echo set_value('productcode',$before['product']->productcode);?>">
				  </div>
				</div>
				
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">category</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('category',$category,set_value('category',$before['product']->category),'id="select4" class="chzn-select form-control"');
					?>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">MRP</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="mrp" value="<?php echo set_value('mrp',$before['product']->mrp);?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">description</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="description" value="<?php echo set_value('description',$before['product']->description);?>">
				  </div>
				</div>
				<div class=" form-group">
				  <label class="col-sm-2 control-label">scheme</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('scheme',$scheme,set_value('scheme',$before['product']->scheme),'id="select1" class="chzn-select form-control"');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">isnew</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('isnew',$isnew,set_value('isnew',$before['product']->isnew),'id="select2" class="chzn-select form-control"');
					?>
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
