<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Shopnavigation_model extends CI_Model
{
	
	public function create($name,$alias,$shop,$order,$status,$metatitle,$metadescription,$banner,$bannerdescription,$isdefault,$type,$sizes,$positiononwebsite,$filtergroup)
	{
		$data  = array(
			'name' => $name,
			'shop' => $shop,
			'alias' => $alias,
			'order' => $order,
			'status' => $status,
			'metatitle' => $metatitle,
			'metadescription' => $metadescription,
			'banner' => $banner,
			'bannerdescription' => $bannerdescription,
			'isdefault' => $isdefault,
			'type' => $type,
			'sizes' => $sizes,
			'positiononwebsite' => $positiononwebsite
		);
		$query=$this->db->insert( 'shopnavigation', $data );
        $shopnavigationid=$this->db->insert_id();
//        print_r($filtergroup);
        foreach($filtergroup AS $key=>$value)
            {
                $this->shopnavigation_model->createshopnavigationbyfiltergroup($value,$shopnavigationid);
            }
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
    
    public function createshopnavigationbyfiltergroup($value,$shopnavigationid)
	{
		$data  = array(
			'shopnavigation' =>$shopnavigationid,
			'filtergroup' => $value
		);
        print_r($data);
		$query=$this->db->insert( 'shopnav_filtergroup', $data );
		return  1;
	}
	function viewshopnavigation()
	{
		$query="SELECT `shopnavigation`.`id`, `shopnavigation`.`name`, `shopnavigation`.`shop`, `shopnavigation`.`order`, `shopnavigation`.`status`, `positiononwebsite`, `shopnavigation`.`type`, `shopnavigation`.`description`, `shopnavigation`.`alias`, `shopnavigation`.`metatitle`, `shopnavigation`.`metadescription`, `shopnavigation`.`banner`, `shopnavigation`.`bannerdescription`, `shopnavigation`.`isdefault`, `shopnavigation`.`sizes`,`shop`.`name` AS `shopname`
        FROM `shopnavigation`
        LEFT OUTER JOIN `shop` ON `shop`.`id`=`shopnavigation`.`shop`";
		$query=$this->db->query($query)->result();
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
	public function getisdefaultdropdown()
	{
		$isdefault= array(
			 "1" => "Yes",
			 "0" => "No",
			);
		return $isdefault;
	}
	public function gettypedropdown()
	{
		$type= array(
			 "1" => "Static",
			 "0" => "Category",
			);
		return $type;
	}
    
	function changeshopnavigationstatus($id)
	{
		$query=$this->db->query("SELECT `status` FROM `shopnavigation` WHERE `id`='$id'")->row();
		$status=$query->status;
		if($status==1)
		{
			$status=0;
		}
		else if($status==0)
		{
			$status=1;
		}
		$data  = array(
			'status' =>$status,
		);
		$this->db->where('id',$id);
		$query=$this->db->update( 'shopnavigation', $data );
		if(!$query)
			return  0;
		else
			return  1;
	}
	function viewonecitylocations($id)
	{
		$query="SELECT `location`.`id`,`location`.`name`,`location`.`pincode`,`location`.`cityid`, `city`.`name` AS `cityname` FROM `location`
        INNER JOIN `city` ON `city`.`id` = `location`.`cityid` WHERE `location`.`cityid`='$id'";
		$query=$this->db->query($query)->result();
		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query['shopnavigation']=$this->db->get( 'shopnavigation' )->row();
		return $query;
	}
    
	public function getbannerbyid($id)
	{
		$query=$this->db->query("SELECT `banner` FROM `shopnavigation` WHERE `id`='$id'")->row();
		return $query;
	}
	public function beforeeditlocation( $id )
	{
		$this->db->where( 'id', $id );
		$query['location']=$this->db->get( 'location' )->row();
//		$query['eventcategory']=array();
//		$eventcategory=$this->db->query("SELECT `category` FROM `eventcategory` WHERE `eventcategory`.`event`='$id'")->result();
//		foreach($eventcategory as $cat)
//		{
//			$query['eventcategory'][]=$cat->category;
//		}
//		$query['eventtopic']=array();
//		$eventtopic=$this->db->query("SELECT `topic` FROM `eventtopic` WHERE `eventtopic`.`event`='$id'")->result();
//		foreach($eventtopic as $top)
//		{
//			$query['eventtopic'][]=$top->topic;
//		}
		return $query;
	}
	
	public function edit($id,$name,$alias,$shop,$order,$status,$metatitle,$metadescription,$banner,$bannerdescription,$isdefault,$type,$sizes,$positiononwebsite,$filtergroup)
	{
		$data  = array(
			'name' => $name,
			'shop' => $shop,
			'alias' => $alias,
			'order' => $order,
			'status' => $status,
			'metatitle' => $metatitle,
			'metadescription' => $metadescription,
			'banner' => $banner,
			'bannerdescription' => $bannerdescription,
			'isdefault' => $isdefault,
			'type' => $type,
			'sizes' => $sizes,
			'positiononwebsite' => $positiononwebsite
		);
		
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'shopnavigation', $data );
        $querydelete=$this->db->query("DELETE FROM `shopnav_filtergroup` WHERE `shopnavigation`='$id'");
        foreach($filtergroup AS $key=>$value)
            {
                $this->shopnavigation_model->createshopnavigationbyfiltergroup($value,$id);
            }
//		if($query)
//		{
//			$this->savelog($id,'Shop Navigation Edited');
//		}
		return 1;
	}
	public function editlocation($id,$cityid,$name,$pincode)
	{
		$data  = array(
			'cityid' => $cityid,
			'pincode' => $pincode,
			'name' => $name
		);
		
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'location', $data );
		if($query)
		{
			$this->savelog($id,'Location Edited');
		}
		return 1;
	}
	function deleteshopnavigation($id)
	{
		$query=$this->db->query("DELETE FROM `shopnavigation` WHERE `id`='$id'");
	}
     public function getshopnavigationdropdown()
	{
		$query=$this->db->query("SELECT * FROM `shopnavigation`  ORDER BY `id` ASC")->result();
		$return=array();
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    
	
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
    public function getcitydropdown()
	{
		$query=$this->db->query("SELECT * FROM `city`  ORDER BY `id` ASC")->result();
		$return=array(
		"" => ""
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    public function getlocationdropdown()
	{
		$query=$this->db->query("SELECT * FROM `location`  ORDER BY `id` ASC")->result();
		$return=array(
		"" => ""
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    //-----------------Changes made avinash
    
     public function getshopnavigationbyproduct($id)
	{
         $return=array();
		$query=$this->db->query("SELECT `id`,`shopnav`,`product` FROM `shopnav_product`  WHERE `product`='$id'");
        if($query->num_rows() > 0)
        {
            $query=$query->result();
            foreach($query as $row)
            {
                $return[]=$row->shopnav;
            }
        }
         return $return;
         
		
	}
    
    //------------------------
}
?>