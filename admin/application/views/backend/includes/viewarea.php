<div class=" row" style="padding:1% 0;">
	<div class="col-md-12">
	
		<a class="btn btn-primary pull-right"  href="<?php echo site_url('site/createarea'); ?>"><i class="icon-plus"></i>Create </a> &nbsp; 
	</div>
	
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                Area Details
            </header>
            <div class="drawchintantable">
                <?php $this->chintantable->createsearch("Area List");?>
                <table class="table table-striped table-hover" id="" cellpadding="0" cellspacing="0" >
                <thead>
                    <tr>
                        <th data-field="id">Id</th>
                        <th data-field="areaname">Area</th>
                        <th data-field="citynane">City</th>
                        <th data-field="distributorname">Distributor</th>
                        <th data-field="action"> Actions </th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
                </table>
                   <?php $this->chintantable->createpagination();?>
            </div>
		</section>
		<script>
            function drawtable(resultrow) {
//                if(!resultrow.sales)
//                {
//                    resultrow.sales="";
//                }
                return "<tr><td>" + resultrow.id + "</td><td>" + resultrow.areaname + "</td><td>" + resultrow.cityname + "</td><td>" + resultrow.distributorname + "</td><td><a class='btn btn-primary btn-xs' href='<?php echo site_url('site/editarea?id=');?>"+resultrow.id +"'><i class='icon-pencil'></i></a><a class='btn btn-danger btn-xs' href='<?php echo site_url('site/deletearea?id='); ?>"+resultrow.id +"'><i class='icon-trash '></i></a></td><tr>";
            }
            generatejquery('<?php echo $base_url;?>');
        </script>
	</div>
</div>