<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Retailer_model extends CI_Model
{
	//topic
	public function create($lat,$long,$area,$dob,$sq_feet,$name,$number,$email,$address,$ownername,$ownernumber,$contactname,$contactnumber,$image)
	{
		$data  = array(
			'lat' => $lat,
			'long' => $long,
			'area' => $area,
			'dob' => $dob,
			'sq_feet' => $sq_feet,
			'name' => $name,
			'number' => $number,
			'email' => $email,
			'address' => $address,
			'ownername' => $ownername,
			'ownernumber' => $ownernumber,
			'contactname' => $contactname,
			'contactnumber' => $contactnumber,
			'store_image' => $image
		);
		$query=$this->db->insert( 'retailer', $data );
		
		return  1;
	}
	function viewretailer()
	{
		$query=$this->db->query("SELECT  `retailer`.`id`, `retailer`.`lat`, `retailer`.`long`, `retailer`.`area`, `retailer`.`dob`, `retailer`.`type_of_area`, `retailer`.`sq_feet`, `retailer`.`store_image`, `retailer`.`name`, `retailer`.`number`, `retailer`.`email`, `retailer`.`address`,`retailer`. `ownername`, `retailer`.`ownernumber`, `retailer`.`contactname`,`retailer`. `contactnumber`,`area`.`name` AS `areaname` FROM `retailer` LEFT OUTER JOIN `area` ON `area`.`id`=`retailer`.`area`")->result();
		return $query;
	}
    public function getimagebyid($id)
	{
		$query=$this->db->query("SELECT `store_image` FROM `retailer` WHERE `id`='$id'")->row();
		return $query;
	}
	
     public function getareadropdown()
	{
		$query=$this->db->query("SELECT * FROM `area`  ORDER BY `id` ASC")->result();
		$return=array();
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'retailer' )->row();
		return $query;
	}
	
	public function edit($id,$lat,$long,$area,$dob,$sq_feet,$name,$number,$email,$address,$ownername,$ownernumber,$contactname,$contactnumber,$image)
	{
		$data = array(
			'lat' => $lat,
			'long' => $long,
			'area' => $area,
			'dob' => $dob,
			'sq_feet' => $sq_feet,
			'name' => $name,
			'number' => $number,
			'email' => $email,
			'address' => $address,
			'ownername' => $ownername,
			'ownernumber' => $ownernumber,
			'contactname' => $contactname,
			'contactnumber' => $contactnumber,
			'store_image' => $image
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'retailer', $data );
		
		return 1;
	}
	function deleteretailer($id)
	{
		$query=$this->db->query("DELETE FROM `retailer` WHERE `id`='$id'");
		
	}
    
     public function getstatedropdown()
	{
		$query=$this->db->query("SELECT * FROM `state`  ORDER BY `id` ASC")->result();
		$return=array();
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    
    
     public function gettagsdropdown()
	{
		$query=$this->db->query("SELECT * FROM `tags`  ORDER BY `id` ASC")->result();
		$return=array();
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    
    
     public function getfiltergroupbyattribute($id)
	{
         $return=array();
		$query=$this->db->query("SELECT `id`,`attribute`,`filtergroup` FROM `filtergroup_attribute`  WHERE `filtergroup`='$id'");
        if($query->num_rows() > 0)
        {
            $query=$query->result();
            foreach($query as $row)
            {
                $return[]=$row->attribute;
            }
        }
         return $return;
         
		
	}
	public function getofferdropdown()
	{
		$query=$this->db->query("SELECT * FROM `offers`  ORDER BY `id` ASC")->result();
		$return=array(
		"" => ""
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->header;
		}
		
		return $return;
	}
	public function getoffer()
	{
		$query=$this->db->query("SELECT * FROM `offers`  ORDER BY `header` ASC")->result();
		
		
		return $query;
	}
	public function getstatusdropdown()
	{
		$status= array(
			 "1" => "Enabled",
			 "0" => "Disabled",
			);
		return $status;
	}
    public function getattributebyproduct($id)
	{
         $return=array();
		$query=$this->db->query("SELECT `id`,`attribute`,`product` FROM `product_attribute`  WHERE `product`='$id'");
        if($query->num_rows() > 0)
        {
            $query=$query->result();
            foreach($query as $row)
            {
                $return[]=$row->attribute;
            }
        }
         return $return;
         
		
	}
    public function gettagsbyproduct($id)
	{
         $return=array();
		$query=$this->db->query("SELECT `id`,`tag`,`product` FROM `product_tag`  WHERE `product`='$id'");
        if($query->num_rows() > 0)
        {
            $query=$query->result();
            foreach($query as $row)
            {
                $return[]=$row->tag;
            }
        }
         return $return;
         
		
	}
    function exportretailer()
	{
		$this->load->dbutil();
		$query=$this->db->query("SELECT  `retailer`.`id`,`retailer`.`name`,`retailer`.`number`, `retailer`.`email`, `retailer`.`address`,`retailer`.`lat`, `retailer`.`long`, `area`.`name` AS `area`, `retailer`.`dob`,  `retailer`.`sq_feet`, `retailer`.`store_image`,  `retailer`. `ownername`, `retailer`.`ownernumber`, `retailer`.`contactname`,`retailer`. `contactnumber` FROM `retailer` LEFT OUTER JOIN `area` ON `area`.`id`=`retailer`.`area`");

       $content= $this->dbutil->csv_from_result($query);
        //$data = 'Some file data';

        if ( ! write_file('./csvgenerated/retailerfile.csv', $content))
        {
             echo 'Unable to write the file';
        }
        else
        {
            redirect(base_url('csvgenerated/retailerfile.csv'), 'refresh');
             echo 'File written!';
        }
	}
    
	function getretailersinceyesterday()
	{
		$query=$this->db->query("SELECT  `retailer`.`id`, `retailer`.`lat`, `retailer`.`long`, `retailer`.`area`, `retailer`.`dob`, `retailer`.`type_of_area`, `retailer`.`sq_feet`, `retailer`.`store_image`, `retailer`.`name`, `retailer`.`number`, `retailer`.`email`, `retailer`.`address`,`retailer`. `ownername`, `retailer`.`ownernumber`, `retailer`.`contactname`,`retailer`. `contactnumber`,`area`.`name` AS `areaname` ,`retailer`.`timestamp`
        FROM `retailer` 
        LEFT OUTER JOIN `area` ON `area`.`id`=`retailer`.`area` ")->result();
		return $query;
	}
	function getretailersinceyesterdaywithzone()
	{
		$query=$this->db->query("SELECT `retailer`.`id`,  `retailer`.`name`, `retailer`.`timestamp` ,`area`.`name` AS `areaname`,`city`.`name` AS `cityname`,`state`.`name` AS `statename`,`zone`.`id`AS `zoneid`,`zone`.`name` AS `zonename`,`area`.`id` AS `areaid`
FROM `retailer` 
LEFT OUTER JOIN `area` ON `area`.`id`= `retailer`.`area`
LEFT OUTER JOIN `city` ON `area`.`city`= `city`.`id`
LEFT OUTER JOIN `state` ON `state`.`id`= `city`.`state`
LEFT OUTER JOIN `zone` ON `zone`.`id`= `state`.`zone`")->result();
		return $query;
	}
	function getretailersinceyesterdaywithstate($zoneid)
	{
		$query=$this->db->query("SELECT `retailer`.`id`,  `retailer`.`name`, `retailer`.`timestamp` ,`area`.`name` AS `areaname`,`city`.`name` AS `cityname`,`state`.`name` AS `statename`,`zone`.`name` AS `zonename`,`zone`.`id`AS `zoneid`,`area`.`id` AS `areaid`,COUNT(`state`.`id`) AS `statecount`,`state`.`id` AS `stateid`
FROM `retailer` 
LEFT OUTER JOIN `area` ON `area`.`id`= `retailer`.`area`
LEFT OUTER JOIN `city` ON `area`.`city`= `city`.`id`
LEFT OUTER JOIN `state` ON `state`.`id`= `city`.`state`
LEFT OUTER JOIN `zone` ON `zone`.`id`= `state`.`zone`
        WHERE  `zone`.`id`='$zoneid'
        GROUP BY `state`.`id`")->result();
		return $query;
	}
	function getretailersinceyesterdaywithcity($stateid)
	{
		$query=$this->db->query("SELECT `retailer`.`id`,  `retailer`.`name`, `retailer`.`timestamp` ,`area`.`name` AS `areaname`,`city`.`name` AS `cityname`,`state`.`name` AS `statename`,`zone`.`name` AS `zonename`,`zone`.`id`AS `zoneid`,`area`.`id` AS `areaid`,COUNT(`city`.`id`) AS `citycount`,`state`.`id` AS `stateid`,`city`.`id` AS `cityid`
FROM `retailer` 
LEFT OUTER JOIN `area` ON `area`.`id`= `retailer`.`area`
LEFT OUTER JOIN `city` ON `area`.`city`= `city`.`id`
LEFT OUTER JOIN `state` ON `state`.`id`= `city`.`state`
LEFT OUTER JOIN `zone` ON `zone`.`id`= `state`.`zone`
        WHERE `state`.`id`='$stateid'
        GROUP BY `city`.`id`")->result();
		return $query;
	}
	function getretailersinceyesterdaywitharea($cityid)
	{
		$query=$this->db->query("SELECT `retailer`.`id`,  `retailer`.`name`, `retailer`.`timestamp` ,`area`.`name` AS `areaname`,`city`.`name` AS `cityname`,`state`.`name` AS `statename`,`zone`.`name` AS `zonename`,`zone`.`id`AS `zoneid`,`area`.`id` AS `areaid`,COUNT(`area`.`id`) AS `areacount`,`city`.`id` AS `cityid`,`area`.`id` AS `areaid`
FROM `retailer` 
LEFT OUTER JOIN `area` ON `area`.`id`= `retailer`.`area`
LEFT OUTER JOIN `city` ON `area`.`city`= `city`.`id`
LEFT OUTER JOIN `state` ON `state`.`id`= `city`.`state`
LEFT OUTER JOIN `zone` ON `zone`.`id`= `state`.`zone`
        WHERE  `city`.`id`='$cityid'
        GROUP BY `area`.`id`")->result();
		return $query;
	}
	function dashboardretailersareawise($areaid)
	{
		$query=$this->db->query("SELECT  `retailer`.`id`, `retailer`.`lat`, `retailer`.`long`, `retailer`.`area`, `retailer`.`dob`, `retailer`.`type_of_area`, `retailer`.`sq_feet`, `retailer`.`store_image`, `retailer`.`name`, `retailer`.`number`, `retailer`.`email`, `retailer`.`address`,`retailer`. `ownername`, `retailer`.`ownernumber`, `retailer`.`contactname`,`retailer`. `contactnumber`,`area`.`name` AS `areaname` ,`state`.`name`AS `statename`,`city`.`name` AS `cityname`,`zone`.`name` AS `zonename`
        FROM `retailer` 
        LEFT OUTER JOIN `area` ON `area`.`id`=`retailer`.`area`
        LEFT OUTER JOIN `city` ON `area`.`city`= `city`.`id`
        LEFT OUTER JOIN `state` ON `state`.`id`= `city`.`state`
        LEFT OUTER JOIN `zone` ON `zone`.`id`= `state`.`zone`
        WHERE  `retailer`.`area`='$areaid'")->result();
		return $query;
	}
	function gettopproducts()
	{
		$query=$this->db->query("SELECT `orderproduct`.`product`,`product`.`name`,`product`.`productcode`,SUM(`orderproduct`.`quantity`) as `totalquantity` FROM `orderproduct` INNER JOIN `product` ON `orderproduct`.`product`=`product`.`id` INNER JOIN `orders` ON `orders`.`id`=`orderproduct`.`order` WHERE MONTH(`orders`.`timestamp`)=MONTH(CURRENT_TIMESTAMP) GROUP BY `orderproduct`.`product`  ORDER BY `totalquantity` DESC LIMIT 0,10")->result();
		return $query;
	}
    
    function exportretailerfromdashboard($date)
	{
		$this->load->dbutil();
		$query=$this->db->query("SELECT  `retailer`.`id`, `retailer`.`lat`, `retailer`.`long`, `retailer`.`area`, `retailer`.`dob`, `retailer`.`type_of_area`, `retailer`.`sq_feet`, `retailer`.`store_image`, `retailer`.`name`, `retailer`.`number`, `retailer`.`email`, `retailer`.`address`,`retailer`. `ownername`, `retailer`.`ownernumber`, `retailer`.`contactname`,`retailer`. `contactnumber`,`area`.`name` AS `areaname` ,`state`.`name`AS `statename`,`city`.`name` AS `cityname`,`zone`.`name` AS `zonename`
        FROM `retailer` 
        LEFT OUTER JOIN `area` ON `area`.`id`=`retailer`.`area`
        LEFT OUTER JOIN `city` ON `area`.`city`= `city`.`id`
        LEFT OUTER JOIN `state` ON `state`.`id`= `city`.`state`
        LEFT OUTER JOIN `zone` ON `zone`.`id`= `state`.`zone`");

       $content= $this->dbutil->csv_from_result($query);
        //$data = 'Some file data';

        if ( ! write_file('./csvgenerated/retailerfilefromdashboard.csv', $content))
        {
             echo 'Unable to write the file';
        }
        else
        {
            redirect(base_url('csvgenerated/retailerfilefromdashboard.csv'), 'refresh');
             echo 'File written!';
        }
	}
//	function dashboardretailersareawise($date,$areaid)
//	{
//		$query=$this->db->query("SELECT `retailer`.`id`,  `retailer`.`name`, `retailer`.`timestamp` ,`area`.`name` AS `areaname`,`city`.`name` AS `cityname`,`state`.`name` AS `statename`,`zone`.`name` AS `zonename`,`zone`.`id`AS `zoneid`,`area`.`id` AS `areaid`,COUNT(`area`.`id`) AS `areacount`,`city`.`id` AS `cityid`,`area`.`id` AS `areaid`
//FROM `retailer` 
//LEFT OUTER JOIN `area` ON `area`.`id`= `retailer`.`area`
//LEFT OUTER JOIN `city` ON `area`.`city`= `city`.`id`
//LEFT OUTER JOIN `state` ON `state`.`id`= `city`.`state`
//LEFT OUTER JOIN `zone` ON `zone`.`id`= `state`.`zone`
//        WHERE `retailer`.`timestamp` = '$date' AND `area`.`id`='$cityid'
//        GROUP BY `area`.`id`")->result();
//		return $query;
//	}
       
}
?>