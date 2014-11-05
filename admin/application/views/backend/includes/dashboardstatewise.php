<div class="well">
<b>Total No of Retailers Added Since Yesterday In States</b>
</div>
<?php
//print_r($retailer);
foreach ($retailer as $row) 
{
    ?>
<div class="row state-overview">
    <div class="col-lg-9 col-sm-8">
        <section class="panel">
            <div class="symbol terques">
                <i class="icon-user"></i>
            </div>
            <a href="<?php echo site_url('site/dashboardcitywise?stateid=').$row->stateid;?>">
            <div class="value">
               <p>Total No of Retailers Added In <?php echo $row->statename;?> State</p>
                <h1><?php  echo $row->statecount; ?></h1>
                
            </div>
            </a>
        </section>
    </div>
</div>
<?php
}
?>
