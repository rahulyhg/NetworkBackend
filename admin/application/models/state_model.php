<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class State_model extends CI_Model
{
	//topic
	public function create($name,$zone)
	{
		$data  = array(
			'name' => $name,
            'zone'=>$zone
		);
		$query=$this->db->insert( 'state', $data );
		
		return  1;
	}
	function viewstate()
	{
		$query=$this->db->query("SELECT `state`.`id`,`state`.`name` AS `statename`,`zone`.`name` AS `zonename` FROM `state` LEFT OUTER JOIN `zone` ON `zone`.`id`=`state`.`zone`")->result();
		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'state' )->row();
		return $query;
	}
	
	public function edit( $id,$name,$zone)
	{
		$data = array(
			'name' => $name,
			'zone' => $zone
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'state', $data );
		
		return 1;
	}
	function deletestate($id)
	{
		$query=$this->db->query("DELETE FROM `state` WHERE `id`='$id'");
		
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