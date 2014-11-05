	    <section class="panel">
		    <header class="panel-heading">
				 Shop Navigation Details
			</header>
			<div class="panel-body">
				 <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/editshopnavigationsubmit');?>" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="normal-field">Name</label>
                        <div class="col-sm-4">
                            <input type="text" id="normal-field" class="form-control" name="name" value="<?php echo set_value('name',$before['shopnavigation']->name);?>">
                            <input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before['shopnavigation']->id);?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="normal-field">Alias</label>
                        <div class="col-sm-4">
                            <input type="text" id="normal-field" class="form-control" name="alias" value="<?php echo set_value('alias',$before['shopnavigation']->alias);?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Shop</label>
                        <div class="col-sm-4">
                            <?php echo form_dropdown( 'shop',$user,set_value( 'shop',$before['shopnavigation']->shop), 'id="select3" class="form-control populate placeholder select2-offscreen"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="normal-field">Order</label>
                        <div class="col-sm-4">
                            <input type="text" id="normal-field" class="form-control" name="order" value="<?php echo set_value('order',$before['shopnavigation']->order);?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="normal-field">Meta Title</label>
                        <div class="col-sm-4">
                            <input type="text" id="normal-field" class="form-control" name="metatitle" value="<?php echo set_value('metatitle',$before['shopnavigation']->metatitle);?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="normal-field">Meta Description</label>
                        <div class="col-sm-4">
                            <!--				  <textarea name="description" form="usrform"  rows="20" cols="5"><?php echo set_value('description');?></textarea>-->
                            <input type="text" id="normal-field" class="form-control" name="metadescription" value="<?php echo set_value('metadescription',$before['shopnavigation']->metadescription);?>">
                        </div>
                    </div>

					 <?php print_r($filtergroup);?>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Add FilterGroup</label>
				  <div class="col-sm-4">
				      <?php 
								echo form_dropdown('filtergroup[]', $filtergroup,$selectedfiltergroup,'id="select5" class="form-control populate placeholder " multiple="multiple"');
								 
							?>
                 
				  </div>
                      <div class="col-md-4">
                            <input type="checkbox" id="checkbox" >Select All
                    </div>
				</div>
                    
                    <div class=" form-group">
                      <label class="col-sm-2 control-label" for="normal-field">Banner</label>
                      <div class="col-sm-4">
                        <input type="file" id="normal-field" class="form-control" name="banner" value="<?php echo set_value('banner',$before['shopnavigation']->banner);?>">
                        <?php if($before['shopnavigation']->banner== "")
                             { }
                             else
                             { ?>
                                <img src="<?php echo base_url('uploads')."/".$before['shopnavigation']->banner; ?>" width="140px" height="140px">
                            <?php }
                        ?>
                      </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="normal-field">Banner Description</label>
                        <div class="col-sm-4">
                            <!--				  <textarea name="description" form="usrform"  rows="20" cols="5"><?php echo set_value('description');?></textarea>-->
                            <input type="text" id="normal-field" class="form-control" name="bannerdescription" value="<?php echo set_value('bannerdescription',$before['shopnavigation']->bannerdescription);?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="normal-field">Position On Website</label>
                        <div class="col-sm-4">
                            <input type="text" id="normal-field" class="form-control" name="positiononwebsite" value="<?php echo set_value('positiononwebsite',$before['shopnavigation']->positiononwebsite);?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="normal-field">Sizes</label>
                        <div class="col-sm-4">
                            <input type="text" id="normal-field" class="form-control" name="sizes" value="<?php echo set_value('sizes',$before['shopnavigation']->sizes);?>">
                        </div>
                    </div>
                    <div class=" form-group">
                        <label class="col-sm-2 control-label">Is Default</label>
                        <div class="col-sm-4">
                            <?php echo form_dropdown( 'isdefault',$isdefault,set_value( 'isdefault',$before['shopnavigation']->isdefault), 'id="select4" class="form-control populate placeholder select2-offscreen"'); ?>
                        </div>
                    </div>
                    <div class=" form-group">
                        <label class="col-sm-2 control-label">Type</label>
                        <div class="col-sm-4">
                            <?php echo form_dropdown( 'type',$type,set_value( 'type',$before['shopnavigation']->type), 'id="select1" class="chzn-select form-control" 	data-placeholder="Choose a Accesslevel..."'); ?>
                        </div>
                    </div>
                    <div class=" form-group">
                        <label class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-4">
                            <?php echo form_dropdown( 'status',$status,set_value( 'status',$before['shopnavigation']->status), 'id="select2" class="chzn-select form-control" 	data-placeholder="Choose a Accesslevel..."'); ?>
                        </div>
                    </div>

                    <div class=" form-group">
                        <label class="col-sm-2 control-label">&nbsp;</label>
                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="<?php echo site_url('site/viewmall'); ?>" class="btn btn-secondary">Cancel</a>
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
    })
</script>