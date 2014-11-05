<!--
<div class="row" style="padding:1% 0">
	<div class="col-md-12">
		<div class="pull-right">
			<a href="<?php echo site_url('site/viewretailer'); ?>" class="btn btn-primary pull-right"><i class="icon-long-arrow-left"></i>&nbsp;Back</a>
		</div>
	</div>
</div>
-->
<div class="row">
	<div class="col-lg-12">
	    <section class="panel">
		    <header class="panel-heading">
				 Reports
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" >
			  
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">From Date</label>
				  <div class="col-sm-4">
					<input type="date" class="form-control fromdate" name="fromdate" value="<?php echo set_value('fromdate');?>">
				  </div>
				</div>
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">To Date</label>
				  <div class="col-sm-4">
					<input type="date" class="form-control todate" name="todate" value="<?php echo set_value('todate');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select Report Type</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('reporttype',$reporttype,set_value('reporttype'),'class="chzn-select form-control reporttype" 	data-placeholder="Choose a Accesslevel..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">&nbsp;</label>
				  <div class="col-sm-4">
				  <button  class="btn btn-primary myformsubmit">Save</button>
				  <a href="<?php echo site_url('site/viewretailer'); ?>" class="btn btn-secondary">Cancel</a>
				</div>
				</div>
			  </form>
                <script>
                    $(document).ready(function() {
                        $(".myformsubmit").click( function() {
                            var fromdate=$(".fromdate").val();
                            var todate=$(".todate").val();
                            var reporttype=$(".reporttype").val();
                            window.open("<?php echo site_url('report/submitmonthlysalesreport');?>?fromdate="+fromdate+"&todate="+todate+"&reporttype="+reporttype,'_blank');
                            return false;
                        });
                    });
                </script>
			</div>
		</section>
	</div>
</div>
