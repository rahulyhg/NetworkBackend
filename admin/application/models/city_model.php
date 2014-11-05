<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class City_model extends CI_Model
{
	//topic
	public function create($name,$state)
	{
		$data  = array(
			'name' => $name,
            'state'=>$state
		);
		$query=$this->db->insert( 'city', $data );
		
		return  1;
	}
	function viewcity()
	{
		$query=$this->db->query("SELECT `city`.`id`,`city`.`name` AS `cityname`,`state`.`name` AS `statename` FROM `city` LEFT OUTER JOIN `state` ON `state`.`id`=`city`.`state`")->result();
		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'city' )->row();
		return $query;
	}
	
	public function edit( $id,$name,$state)
	{
		$data = array(
			'name' => $name,
			'state' => $state
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'city', $data );
		
		return 1;
	}
	function deletecity($id)
	{
		$query=$this->db->query("DELETE FROM `city` WHERE `id`='$id'");
		
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
}
?>