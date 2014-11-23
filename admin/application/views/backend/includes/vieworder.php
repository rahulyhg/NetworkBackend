<div class=" row" style="padding:1% 0;">
    <!--
    <div class="col-md-11">
            <div class=" pull-right col-md-1 createbtn" ><a class="btn btn-primary" href="<?php echo site_url('site/exportorder'); ?>" target="_blank"><i class="icon-plus"></i>Export to CSV </a></div>
    </div>
-->
</div>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">

            <div class="drawchintantable">
                <?php $this->chintantable->createsearch("Order List");?>

                <table class="table table-striped table-hover" cellpadding="0" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th data-field="id">Id</th>
                            <th data-field="timestamp">Timestamp</th>
                            <th data-field="retailername">Retailer</th>
                            <th data-field="sales">Sales Person</th>
                            <th data-field="amount">Amount</th>
                            <th data-field="salesid">Sales ID</th>
                            <th data-field="quantity">Quantity</th>
                            <th data-field="remark">Remark</th>
                            <th data-field="actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </section>
        <?php $this->chintantable->createpagination();?>

        <script>
            function drawtable(resultrow) {
                if(!resultrow.sales)
                {
                    resultrow.sales="";
                }
                return "<tr><td>" + resultrow.id + "</td><td>" + resultrow.timestamp + "</td><td>" + resultrow.retailername + "</td><td>" + resultrow.sales + "</td><td>" + resultrow.amount + "</td><td>" + resultrow.salesid + "</td><td>" + resultrow.quantity + "</td><td>" + resultrow.remark + "</td><td><a href='<?php echo site_url();?>/site/vieworderproduct?id="+resultrow.id+"' class='btn btn-primary btn-xs'>View Order Products</a></td><tr>";
            }
            generatejquery('<?php echo $base_url;?>');
        </script>
    </div>
</div>