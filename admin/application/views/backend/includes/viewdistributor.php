<div class=" row" style="padding:1% 0;">
    <div class="col-md-9">
            <div class=" pull-right col-md-1 createbtn" ><a class="btn btn-primary" href="<?php echo site_url('site/exportdistributor'); ?>" target="_blank"><i class="icon-plus"></i>Export to CSV </a></div>
    </div>
	<div class="col-md-2">
	
		<a class="btn btn-primary pull-right"  href="<?php echo site_url('site/createdistributor'); ?>"><i class="icon-plus"></i>Create </a> &nbsp; 
	</div>
	
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                Distributor Details
            </header>
            <div class="drawchintantable">
            <?php $this->chintantable->createsearch("Product List");?>
			<table class="table table-striped table-hover" id="" cellpadding="0" cellspacing="0" >
			<thead>
				<tr>
					<th data-field="id">Id</th>
					<th data-field="distributorname">Distributor Name</th>
					<th data-field="code">Code</th>
					<th data-field="companyname">Company</th>
					<th data-field="email">Email</th>
					<th data-field="contactno">Contact</th>
					<th data-field="dob">DOB</th>
					<th data-field="address1">Address1</th>
					<th data-field="address2">Address2</th>
					<th data-field="zipcode">Zip Code</th>
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
                if(!resultrow.code)
                {
                    resultrow.code="";
                }
                if(!resultrow.dob)
                {
                    resultrow.dob="";
                }
                if(!resultrow.address1)
                {
                    resultrow.address1="";
                }
                if(!resultrow.address2)
                {
                    resultrow.address2="";
                }
                if(!resultrow.zipcode)
                {
                    resultrow.zipcode="";
                }
                return "<tr><td>" + resultrow.id + "</td><td>" + resultrow.distributorname + "</td><td>" + resultrow.code + "</td><td>" + resultrow.companyname + "</td><td>" + resultrow.email + "</td><td>" + resultrow.contactno + "</td><td>" + resultrow.dob + "</td><td>" + resultrow.address1 + "</td><td>" + resultrow.address2 + "</td><td>" + resultrow.zipcode + "</td><td><a class='btn btn-primary btn-xs' href='<?php echo site_url('site/editdistributor?id=');?>"+resultrow.id +"'><i class='icon-pencil'></i></a><a class='btn btn-danger btn-xs' href='<?php echo site_url('site/deletedistributor?id='); ?>"+resultrow.id +"'><i class='icon-trash '></i></a></td><tr>";
            }
            generatejquery('<?php echo $base_url;?>');
        </script>
	</div>
</div>