<?php 
//print_r($retailer); 
?>

   <?php
$zonecounteast=0;
$zonecountwest=0;
$zonecountsouth=0;
$zonecountnorth=0;
foreach ($retailer as $row) 
{
    if(($row->zoneid)==1)
    {
        $zonecountnorth++;
    }
    else if(($row->zoneid)==2)
    {
        $zonecountsouth++;
    }
    else if(($row->zoneid)==3)
    {
        $zonecounteast++;
    }
    else if(($row->zoneid)==4)
    {
        $zonecountwest++;
    }
}
?>
<div class="well">
<b>Zone Wise</b>
</div>
<div class="row state-overview">
   
    <div class="col-lg-9 col-sm-8">
        <section class="panel">
            <div class="symbol terques">
                <i class="icon-user"></i>
            </div>
            <a href="<?php echo site_url('site/dashboardstatewise?zoneid=1');?>">
            <div class="value">
               <p>Total No of Retailers Added In North Zone</p>
                <h1><?php  echo $zonecountnorth; ?></h1>
                
            </div>
            </a>
        </section>
    </div>
</div>
<div class="row state-overview">
    <div class="col-lg-9 col-sm-8">
        <section class="panel">
            <div class="symbol terques">
                <i class="icon-user"></i>
            </div>
            <a href="<?php echo site_url('site/dashboardstatewise?zoneid=2');?>">
            <div class="value">
               <p>Total No of Retailers Added In South Zone</p>
                <h1><?php  echo $zonecountsouth; ?></h1>
                
            </div>
            </a>
        </section>
    </div>
</div>
<div class="row state-overview">
    <div class="col-lg-9 col-sm-8">
        <section class="panel">
            <div class="symbol terques">
                <i class="icon-user"></i>
            </div>
            <a href="<?php echo site_url('site/dashboardstatewise?zoneid=3');?>">
            <div class="value">
               <p>Total No of Retailers Added In East Zone</p>
                <h1><?php  echo $zonecounteast; ?></h1>
                
            </div>
            </a>
        </section>
    </div>
</div>
<div class="row state-overview">
    <div class="col-lg-9 col-sm-8">
        <section class="panel">
            <div class="symbol terques">
                <i class="icon-user"></i>
            </div>
            <a href="<?php echo site_url('site/dashboardstatewise?zoneid=4');?>">
            <div class="value">
               <p>Total No of Retailers Added In West Zone</p>
                <h1><?php  echo $zonecountwest; ?></h1>
                
            </div>
            </a>
        </section>
    </div>
</div>