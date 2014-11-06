<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Report_model extends CI_Model
{
    
    
	public function getmonthlyreporttypes()
	{
		$reporttype= array(
			 "1" => "Item Wise",
			 "2" => "Distributor Wise Top 10 Retailers",
			 "3" => "Zero Distributor Retailors",
			 "4" => "New Products Placement Report",
			 "5" => "Scheme Products Placement Report"
			);
		return $reporttype;
	}
    function exportdailysalesdayreport($zone,$date)
	{
		$this->load->dbutil();
		$query=$this->db->query("SELECT `users`.`id` as `userid`,`users`.`name` as `salesman`,`area`.`name` as `area`,`city`.`name` as `city`,SUM(`orders`.`quantity`) as `quantity`,SUM(`orders`.`amount`) as `amount` FROM `orderproduct` 
        INNER JOIN `orders` ON `orders`.`id`=`orderproduct`.`order` 
        INNER JOIN `retailer` ON `retailer`.`id`=`orders`.`retail` 
        INNER JOIN `users` ON `users`.`id`=`orders`.`salesid` 
        INNER JOIN `area` ON `area`.`id`=`retailer`.`area` 
        INNER JOIN `city` ON `city`.`id`=`area`.`city` 
        INNER JOIN `state` ON `state`.`id`=`city`.`state` 
        WHERE `state`.`zone`= '$zone' AND `orders`.`timestamp` BETWEEN '$date 00:00:00' AND '$date 23:59:59' 
        GROUP BY `users`.`id`,`area`.`id`");
        $timestamp=new DateTime();
        $timestamp=$timestamp->format('Y-m-d_H.i.s');
       $content= $this->dbutil->csv_from_result($query);
        //$data = 'Some file data';

        if ( ! write_file("./csvgenerated/dailysalesdayreport_$timestamp.csv", $content))
        {
             echo 'Unable to write the file';
        }
        else
        {
            redirect(base_url("csvgenerated/dailysalesdayreport_$timestamp.csv"), 'refresh');
        }
	}
    
    function exportdailyitemwisereport($date)
	{
		$this->load->dbutil();
		$query=$this->db->query("SELECT `product`.`id` as `id`,`product`.`encode` as `code`,`product`.`name` as `name`,`product`.`mrp` as `mrp`,SUM(`orderproduct`.`quantity`) as `quantity`, SUM(`orderproduct`.`amount`) as `amount` 
        FROM `orderproduct` 
        INNER JOIN `orders` ON `orders`.`id`=`orderproduct`.`order` 
        INNER JOIN `product` ON `product`.`id`=`orderproduct`.`product` 
        WHERE `orders`.`timestamp` BETWEEN '$date 00:00:00' AND '$date 23:59:59' 
        GROUP BY `product`.`id`");
        $timestamp=new DateTime();
        $timestamp=$timestamp->format('Y-m-d_H.i.s');
		$content= $this->dbutil->csv_from_result($query);
        //$data = 'Some file data';
		file_put_contents("gs://toykraftdealer/dailyitemwisereport_$timestamp.csv", $content);
		redirect("http://admin.toy-kraft.com/servepublic?name=dailyitemwisereport_$timestamp.csv", 'refresh');
        
	}
    
    function exportdailyordersummaryreport($distributor,$date)
	{
		$this->load->dbutil();
		$query=$this->db->query("SELECT `area`.`name` as `area`,`retailer`.`name`,`orders`.`id`,SUM(`orders`.`quantity`) as `quantity`,SUM(`orders`.`amount`) as `amount` 
        FROM `orderproduct` 
        INNER JOIN `orders` ON `orders`.`id`=`orderproduct`.`order` 
        INNER JOIN `retailer` ON `retailer`.`id`=`orders`.`retail` 
        INNER JOIN `users` ON `users`.`id`=`orders`.`salesid` 
        INNER JOIN `area` ON `area`.`id`=`retailer`.`area`  
        WHERE `area`.`distributor`='$distributor' AND `orders`.`timestamp` BETWEEN '$date 00:00:00' AND '$date 23:59:59' 
        GROUP BY `retailer`.`id`,`area`.`id`");
        $timestamp=new DateTime();
        $timestamp=$timestamp->format('Y-m-d_H.i.s');
        $content= $this->dbutil->csv_from_result($query);
        //$data = 'Some file data';
        //echo $timestamp;
        
        if ( ! write_file("./csvgenerated/dailyordersummaryreport_$timestamp.csv", $content))
        {
             echo "Unable to write the file";
        }
        else
        {
            //echo $timestamp;
            redirect(base_url("csvgenerated/dailyordersummaryreport_$timestamp.csv"), 'refresh');
        }
	}
    
    function exportweeklyitemwisereport($date)
	{
		$this->load->dbutil();
		$query=$this->db->query("SELECT `product`.`id` as `id`,`product`.`encode` as `code`,`product`.`name` as `name`,`product`.`mrp` as `mrp`,SUM(`orderproduct`.`quantity`) as `quantity`, SUM(`orderproduct`.`amount`) as `amount` 
        FROM `orderproduct` 
        INNER JOIN `orders` ON `orders`.`id`=`orderproduct`.`order` 
        INNER JOIN `product` ON `product`.`id`=`orderproduct`.`product` 
        WHERE WEEK(`orders`.`timestamp`)=WEEK('$date 00:00:00') AND YEAR('$date 00:00:00')=YEAR(`orders`.`timestamp`) 
        GROUP BY `product`.`id` ");
        $timestamp=new DateTime();
        $timestamp=$timestamp->format('Y-m-d_H.i.s');
        $content= $this->dbutil->csv_from_result($query);
        //$data = 'Some file data';
        //echo $timestamp;
        
        if ( ! write_file("./csvgenerated/weeklyitemwisereport_$timestamp.csv", $content))
        {
             echo "Unable to write the file";
        }
        else
        {
            //echo $timestamp;
            redirect(base_url("csvgenerated/weeklyitemwisereport_$timestamp.csv"), 'refresh');
        }
	}
    
    function exportweeklydistributorsalesreport($date,$zone)
	{
		$this->load->dbutil();
		$query=$this->db->query("SELECT `distributor`.`name` as `distributor`,`area`.`name` as `area`,`city`.`name` as `city`,SUM(`orders`.`quantity`) as `quantity`,SUM(`orders`.`amount`) as `amount` 
        FROM `orderproduct` 
        INNER JOIN `orders` ON `orders`.`id`=`orderproduct`.`order` 
        INNER JOIN `retailer` ON `retailer`.`id`=`orders`.`retail` 
        INNER JOIN `users` ON `users`.`id`=`orders`.`salesid` 
        INNER JOIN `area` ON `area`.`id`=`retailer`.`area` 
        INNER JOIN `distributor` ON `distributor`.`id`=`area`.`distributor` 
        INNER JOIN `city` ON `city`.`id`=`area`.`city` 
        INNER JOIN `state` ON `state`.`id`=`city`.`state` 
        WHERE `state`.`zone`='$zone'  AND WEEK(`orders`.`timestamp`)=WEEK('$date 00:00:00') AND YEAR('$date 00:00:00')=YEAR(`orders`.`timestamp`) 
        GROUP BY `distributor`.`id`,`area`.`id`");
        $timestamp=new DateTime();
        $timestamp=$timestamp->format('Y-m-d_H.i.s');
        $content= $this->dbutil->csv_from_result($query);
        //$data = 'Some file data';
        //echo $timestamp;
        
        if ( ! write_file("./csvgenerated/weeklydistributorsalesreport_$timestamp.csv", $content))
        {
             echo "Unable to write the file";
        }
        else
        {
            //echo $timestamp;
            redirect(base_url("csvgenerated/weeklydistributorsalesreport_$timestamp.csv"), 'refresh');
        }
	}
    
    function exportmonthlyitemwisesalesreport($reporttype,$fromdate,$todate)
	{
		$this->load->dbutil();
		$query=$this->db->query("SELECT `product`.`id` as `id`,`product`.`encode` as `code`,`product`.`name` as `name`,`product`.`mrp` as `mrp`,SUM(`orderproduct`.`quantity`) as `quantity`, SUM(`orderproduct`.`amount`) as `amount` 
        FROM `orderproduct` 
        INNER JOIN `orders` ON `orders`.`id`=`orderproduct`.`order` 
        INNER JOIN `product` ON `product`.`id`=`orderproduct`.`product` 
        WHERE `orders`.`timestamp` BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59' 
        GROUP BY `product`.`id`");
        $timestamp=new DateTime();
        $timestamp=$timestamp->format('Y-m-d_H.i.s');
        $content= $this->dbutil->csv_from_result($query);
        //$data = 'Some file data';
        //echo $timestamp;
        
        if ( ! write_file("./csvgenerated/monthlyitemwisesalesreport_$timestamp.csv", $content))
        {
             echo "Unable to write the file";
        }
        else
        {
            //echo $timestamp;
            redirect(base_url("csvgenerated/monthlyitemwisesalesreport_$timestamp.csv"), 'refresh');
        }
	}
    
    function exportmonthlydistributorreport($reporttype,$fromdate,$todate)
	{
		$this->load->dbutil();
		$query=$this->db->query("SELECT `distributor`.`name` as `distributor`,`retailer`.`name`,`area`.`name` as `area`,`city`.`name` as `city`,SUM(`orders`.`quantity`) as `quantity`,SUM(`orders`.`amount`) as `amount` 
        FROM `orderproduct` 
        INNER JOIN `orders` ON `orders`.`id`=`orderproduct`.`order` 
        INNER JOIN `retailer` ON `retailer`.`id`=`orders`.`retail` 
        INNER JOIN `users` ON `users`.`id`=`orders`.`salesid` 
        INNER JOIN `area` ON `area`.`id`=`retailer`.`area` 
        INNER JOIN `distributor` ON `distributor`.`id`=`area`.`distributor` 
        INNER JOIN `city` ON `city`.`id`=`area`.`city` 
        INNER JOIN `state` ON `state`.`id`=`city`.`state` 
        WHERE `orders`.`timestamp` BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59' 
        GROUP BY `distributor`.`id`,`retailer`.`id`  
        ORDER BY `distributor`.`id`,`retailer`.`id`,`quantity`");
        $timestamp=new DateTime();
        $timestamp=$timestamp->format('Y-m-d_H.i.s');
        $content= $this->dbutil->csv_from_result($query);
        //$data = 'Some file data';
        //echo $timestamp;
        
        if ( ! write_file("./csvgenerated/monthlydistributorreport_$timestamp.csv", $content))
        {
             echo "Unable to write the file";
        }
        else
        {
            //echo $timestamp;
            redirect(base_url("csvgenerated/monthlydistributorreport_$timestamp.csv"), 'refresh');
        }
	}
    
    function exportmonthlyzerodistributorretailerreport($reporttype,$fromdate,$todate)
	{
		$this->load->dbutil();
		$query=$this->db->query("SELECT `orders`.`timestamp`,`distributor`.`name` as `distributor`,`retailer`.`name`,`area`.`name` as `area`,`city`.`name` as `city`,SUM(`orders`.`quantity`) as `quantity`,SUM(`orders`.`amount`) as `amount` 
        FROM `retailer` 
        INNER JOIN `area` ON `area`.`id`=`retailer`.`area` 
        INNER JOIN `distributor` ON `distributor`.`id`=`area`.`distributor` 
        INNER JOIN `city` ON `city`.`id`=`area`.`city` 
        INNER JOIN `state` ON `state`.`id`=`city`.`state` 
        LEFT OUTER JOIN `orders` ON `retailer`.`id`=`orders`.`retail` AND `orders`.`timestamp` BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59' 
        LEFT OUTER JOIN `orderproduct` ON `orders`.`id`=`orderproduct`.`order` 
        INNER JOIN `users` ON `users`.`id`=`orders`.`salesid` 
        GROUP BY `distributor`.`id`,`retailer`.`id` HAVING `quantity`=0 
        ORDER BY `distributor`.`id`,`retailer`.`id`,`quantity`");
        $timestamp=new DateTime();
        $timestamp=$timestamp->format('Y-m-d_H.i.s');
        $content= $this->dbutil->csv_from_result($query);
        //$data = 'Some file data';
        //echo $timestamp;
        
        if ( ! write_file("./csvgenerated/monthlyzerodistributorretailerreport_$timestamp.csv", $content))
        {
             echo "Unable to write the file";
        }
        else
        {
            //echo $timestamp;
            redirect(base_url("csvgenerated/monthlyzerodistributorretailerreport_$timestamp.csv"), 'refresh');
        }
	}
    
    function exportmonthlynewproductplacementreport($reporttype,$fromdate,$todate)
	{
		$this->load->dbutil();
		$query=$this->db->query("SELECT `product`.`name` as `product`,`product`.`encode` as `encode`,`product`.`mrp` as `mrp`,`distributor`.`name` as `distributor`,`city`.`name` as `city`,`area`.`name` as `area` ,IFNULL(SUM(`orderproduct`.`quantity`),0) as `quantity` 
        FROM `product` 
        LEFT OUTER JOIN `orders` ON `orders`.`timestamp` BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59' 
        LEFT OUTER JOIN `orderproduct` ON `orders`.`id`=`orderproduct`.`order` AND `orderproduct`.`product`=`product`.`id` 
        LEFT OUTER JOIN `retailer` ON `retailer`.`id`=`orders`.`retail` 
        LEFT OUTER JOIN `area` ON `area`.`id`=`retailer`.`area` 
        INNER JOIN `distributor` ON `distributor`.`id`=`area`.`distributor` 
        LEFT OUTER JOIN `city` ON `city`.`id`=`area`.`city` 
        WHERE  NOT ISNULL(`product`.`scheme`) GROUP BY `product`.`id`,`distributor`.`id` 
        ORDER BY `product`.`id`,`distributor`.`id`");
        $timestamp=new DateTime();
        $timestamp=$timestamp->format('Y-m-d_H.i.s');
        $content= $this->dbutil->csv_from_result($query);
        //$data = 'Some file data';
        //echo $timestamp;
        
        if ( ! write_file("./csvgenerated/monthlynewproductplacementreport_$timestamp.csv", $content))
        {
             echo "Unable to write the file";
        }
        else
        {
            //echo $timestamp;
            redirect(base_url("csvgenerated/monthlynewproductplacementreport_$timestamp.csv"), 'refresh');
        }
	}
    
    function exportmonthlyschemeproductplacement($reporttype,$fromdate,$todate)
	{
		$this->load->dbutil();
		$query=$this->db->query("SELECT `product`.`name` as `product`,`product`.`encode` as `encode`,`product`.`mrp` as `mrp`,`distributor`.`name` as `distributor`,`city`.`name` as `city`,`area`.`name` as `area` ,IFNULL(SUM(`orderproduct`.`quantity`),0) as `quantity` 
        FROM `product` 
        LEFT OUTER JOIN `orders` ON `orders`.`timestamp` BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59' 
        LEFT OUTER JOIN `orderproduct` ON `orders`.`id`=`orderproduct`.`order` AND `orderproduct`.`product`=`product`.`id` 
        LEFT OUTER JOIN `retailer` ON `retailer`.`id`=`orders`.`retail` 
        LEFT OUTER JOIN `area` ON `area`.`id`=`retailer`.`area` 
        INNER JOIN `distributor` ON `distributor`.`id`=`area`.`distributor` 
        LEFT OUTER JOIN `city` ON `city`.`id`=`area`.`city` WHERE  `product`.`scheme`='1' GROUP BY `product`.`id`,`distributor`.`id` 
        ORDER BY `product`.`id`,`distributor`.`id`");
        $timestamp=new DateTime();
        $timestamp=$timestamp->format('Y-m-d_H.i.s');
        $content= $this->dbutil->csv_from_result($query);
        //$data = 'Some file data';
        //echo $timestamp;
        
        if ( ! write_file("./csvgenerated/monthlyschemeproductplacement_$timestamp.csv", $content))
        {
             echo "Unable to write the file";
        }
        else
        {
            //echo $timestamp;
            redirect(base_url("csvgenerated/monthlyschemeproductplacement_$timestamp.csv"), 'refresh');
        }
	}
}
?>