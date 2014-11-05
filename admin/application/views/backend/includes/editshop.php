	    <section class="panel">
		    <header class="panel-heading">
				 Event Details
			</header>
			
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/editshopsubmit');?>" enctype= "multipart/form-data">
				<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before['shop']->id);?>" style="display:none;">
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Name</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="name" value="<?php echo set_value('name',$before['shop']->name);?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Alias</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="alias" value="<?php echo set_value('alias',$before['shop']->alias);?>">
				  </div>
				</div>
				
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Status</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('status',$status,set_value('status',$before['shop']->status),'id="select4" class="chzn-select form-control" 	data-placeholder="Choose a Accesslevel..."');
					?>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Meta Title</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="metatitle" value="<?php echo set_value('metatitle',$before['shop']->metatitle);?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Meta Description</label>
				  <div class="col-sm-4">
<!--				  <textarea name="description" form="usrform"  rows="20" cols="5"><?php echo set_value('description');?></textarea>-->
					<input type="text" id="normal-field" class="form-control" name="metadescription" value="<?php echo set_value('metadescription',$before['shop']->metadescription);?>">
				  </div>
				</div>
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Banner</label>
				  <div class="col-sm-4">
					<input type="file" id="normal-field" class="form-control" name="banner" value="<?php echo set_value('banner',$before['shop']->bannername);?>">
					<?php if($before['shop']->bannername == "")
						 { }
						 else
						 { ?>
							<img src="<?php echo base_url('uploads')."/".$before['shop']->bannername; ?>" width="140px" height="140px">
						<?php }
					?>
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Banner Description</label>
				  <div class="col-sm-4">
<!--				  <textarea name="description" form="usrform"  rows="20" cols="5"><?php echo set_value('description',$before['shop']->bannerdescription);?></textarea>-->
					<input type="text" id="normal-field" class="form-control" name="bannerdescription" value="<?php echo set_value('bannerdescription',$before['shop']->bannerdescription);?>">
				  </div>
				</div>
				
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Default Tax</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="defaulttax" value="<?php echo set_value('defaulttax',$before['shop']->defaulttax);?>">
				  </div>
				</div>
				
            
					<div class="form-group">
						<label class="col-sm-2 control-label">User</label>
						<div class="col-sm-4">
						   <?php 
								echo form_dropdown('user',$user,set_value('user',$before['shop']->user),'id="select3" class="form-control populate placeholder select2-offscreen"');
								 
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
