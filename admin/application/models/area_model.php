<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Area_model extends CI_Model
{
	
	public function create($name,$city,$distributor)
	{
		$data  = array(
			'name' => $name,
			'city' => $city,
			'distributor' => $distributor
		);
		$query=$this->db->insert( 'area', $data );
//		$id = $this->db->insert_id();
//		if($query)
//		{
//			$this->savelog($id,'Event Created');
//		}
		if(!$query)
			return  0;
		else
			return  1;
	}
	function viewarea()
	{
		$query="SELECT `area`.`id`, `area`.`name` AS `areaname`,`city`.`name` AS `cityname`,`distributor`.`name` AS `distributorname` FROM `area` LEFT OUTER JOIN `city` ON `area`.`city`=`city`.`id`  LEFT OUTER JOIN `distributor` ON `area`.`distributor`=`distributor`.`id` ";
		$query=$this->db->query($query)->result();
		return $query;
	}
    
	
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query['area']=$this->db->get( 'area' )->row();
		return $query;
	}
	
	public function edit($id,$name,$city,$distributor)
	{
		$data  = array(
			'name' => $name,
			'city' => $city,
			'distributor' => $distributor
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'area', $data );
//		if($query)
//		{
//			$this->savelog($id,'Shop Edited');
//		}
		return 1;
	}
    
	public function getbannerbyid($id)
	{
		$query=$this->db->query("SELECT `bannername` FROM `shop` WHERE `id`='$id'")->row();
		
		
		return $query;
	}
    
     public function getcitydropdown()
	{
		$query=$this->db->query("SELECT * FROM `city`  ORDER BY `id` ASC")->result();
		$return=array();
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
     public function getdistributordropdown()
	{
		$query=$this->db->query("SELECT * FROM `distributor`  ORDER BY `id` ASC")->result();
		$return=array();
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    
     public function createshopbyuser($value,$id)
	{
		$data  = array(
			'shop' =>$value,
			'user' => $id
		);
       // print_r($data);
		$query=$this->db->insert( 'usershop', $data );
		return  1;
	}
    public function getshopsbyuser($id)
	{
         $return=array();
		$query=$this->db->query("SELECT `id`,`shop`,`user` FROM `usershop`  WHERE `user`='$id'");
        if($query->num_rows() > 0)
        {
            $query=$query->result();
            foreach($query as $row)
            {
                $return[]=$row->shop;
            }
        }
         return $return;
         
		
	}
    
	function deletearea($id)
	{
		$query=$this->db->query("DELETE FROM `area` WHERE `id`='$id'");
	}
     public function getmalldropdown()
	{
		$query=$this->db->query("SELECT * FROM `mall`  ORDER BY `id` ASC")->result();
		$return=array(
		"" => ""
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
     public function getfloordropdown()
	{
		$query=$this->db->query("SELECT * FROM `floor`  ORDER BY `id` ASC")->result();
		$return=array(
		"" => ""
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->floorno;
		}
		
		return $return;
	}
    
	//
	public function getevent()
	{
		$return=array();
		$query=$this->db->query("SELECT * FROM `event` ORDER BY `id` ASC")->result();
		foreach($query as $row)
		{
			$return[$row->id]=$row->title;
		}
	
		return $return;
	}
	public function getlistingtype()
	{
		$return=array();
		$return = array(
			"1" => "Private",
			"2" => "Public"
		);
		return $return;
	}
	public function getremainingticket()
	{
		$return=array();
		$return = array(
			"1" => "Yes",
			"0" => "No"
		);
		return $return;
	}
	function editeventcategorytopic($id,$category,$topic)
	{
		$this->db->query("DELETE FROM `eventcategory` WHERE `event`='$id'");
		$this->db->query("DELETE FROM `eventtopic` WHERE `event`='$id'");
		if(!empty($category))
		{
			foreach($category as $key => $cat)
			{
				$data  = array(
					'event' => $id,
					'category' => $cat,
				);
				$query=$this->db->insert( 'eventcategory', $data );
			}
		}
		if(!empty($topic))
		{
			foreach($topic as $key => $top)
			{
				$data2  = array(
					'event' => $id,
					'topic' => $top,
				);
				$query=$this->db->insert( 'eventtopic', $data2 );
			}
		}
		{
			$this->savelog($id,"Event Category ,Topic updated");
		}
		return 1;
	}
	function savelog($id,$action)
	{
		$fromuser = $this->session->userdata('id');
		$data2  = array(
			'user' => $id,
			'event' => $id,
			'description' => $action,
		);
		$query2=$this->db->insert( 'eventlog', $data2 );
	}
    //-----------------Changes made avinash
    function showalleventsbyuserid($id)
    {
        $event=$this->db->query("SELECT `event`.`id`, `event`.`title`, `event`.`locationlat`, `event`.`locationlon`, `event`.`venue`, `event`.`startdate`, `event`.`enddate`, `event`.`description`,`event`.`location`,`event`.`starttime`,`event`.`endtime`, `event`.`organizer` AS `organizerid`,`user`.`firstname` AS `organizername`,`event`.`alias`, `event`.`listingtype`, `event`.`showremainingticket`, `event`.`logo` ,`user`.`lastname`,`user`.`email`,`user`.`website`,`user`.`description`,`user`.`eventinfo`,`user`.`contact`,`user`.`address`,`user`.`city`,`user`.`pincode`,`user`.`dob`,`user`.`accesslevel` AS `accesslevelid`,`accesslevel`.`name`
FROM  `event` 
INNER JOIN  `user` ON  `event`.`organizer` =  `user`.`id` INNER JOIN `accesslevel` ON `user`.`accesslevel` = `accesslevel`.`id` AND `event`.`organizer`='$id'")->result();
         //$event->category=$this->db->query("SELECT `eventcategory`.`category` FROM `eventcategory` WHERE `eventcategory`.`event`='$id'")->result();
         //$event->topic=$this->db->query("SELECT `eventtopic`.`topic` FROM `eventtopic` WHERE `eventtopic`.`event`='$id'")->result();
         return $event;
    }
    
    function viewone($id)
      {
         //$this->db->where('id', $id);
         $event=$this->db->query("SELECT `event`.`id`, `event`.`title`, `event`.`locationlat`, `event`.`locationlon`, `event`.`venue`, `event`.`startdate`, `event`.`enddate`, `event`.`description`,`event`.`location`, `event`.`starttime`,`event`.`endtime`,`event`.`organizer` AS `organizerid`,`user`.`firstname` AS `organizername`,`event`.`alias`, `event`.`listingtype`, `event`.`showremainingticket`, `event`.`logo` ,`user`.`lastname`,`user`.`email`,`user`.`website`,`user`.`description`,`user`.`eventinfo`,`user`.`contact`,`user`.`address`,`user`.`city`,`user`.`pincode`,`user`.`dob`,`user`.`accesslevel` AS `accesslevelid`,`accesslevel`.`name` AS `accesslevelname`,`eventsponsor`.`amountsponsor`,`eventsponsor`.`image`.`eventsponsor`.`starttime`,`endtime`
FROM  `event` 
INNER JOIN  `user` ON  `event`.`organizer` =  `user`.`id` INNER JOIN  `eventsponsor` ON  `eventsponsor`.`event` =  `event`.`id` INNER JOIN `accesslevel` ON `user`.`accesslevel` = `accesslevel`.`id` WHERE `event`.`id`='$id'")->row();
         $eventcategory=$this->db->query("SELECT `eventcategory`.`category` FROM `eventcategory` WHERE `eventcategory`.`event`='$id'")->result();
         $eventcategoryarray=Array();
         foreach($eventcategory as $eventcat)
         {
             //$eventcategoryarray.push($eventcat->category);
             array_push($eventcategoryarray,$eventcat->category);
         }
            $event->category=$eventcategoryarray;
          $eventtopic=$this->db->query("SELECT `eventtopic`.`topic` FROM `eventtopic` WHERE `eventtopic`.`event`='$id'")->result();
         $eventtopicarray=Array();
         foreach($eventtopic as $eventtop)
         {
            // $eventtopicarray.push($eventcat->category);
             array_push($eventtopicarray,$eventtop->topic);
         }
            $event->topic=$eventtopicarray;
         return $event;
         
      }
    
    //------------------------
}
?>