<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Filtergroup_model extends CI_Model
{
	//topic
	public function create($name,$attribute)
	{
		$data  = array(
			'name' => $name
		);
		$query=$this->db->insert( 'filtergroup', $data );
		 $filtergroupid=$this->db->insert_id();
//        print_r($filtergroup);
        foreach($attribute AS $key=>$value)
            {
                $this->filtergroup_model->createattributebyfiltergroup($value,$filtergroupid);
            }
		return  1;
	}
    
    public function createattributebyfiltergroup($value,$filtergroupid)
	{
		$data  = array(
			'attribute' =>$value,
			'filtergroup' => $filtergroupid
		);
        print_r($data);
		$query=$this->db->insert( 'filtergroup_attribute', $data );
		return  1;
	}
	function viewfiltergroup()
	{
		$query=$this->db->query("SELECT * FROM `filtergroup` ")->result();
		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'filtergroup' )->row();
		return $query;
	}
	
	public function edit( $id,$name,$attribute)
	{
		$data = array(
			'name' => $name
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'filtergroup', $data );
		$querydelete=$this->db->query("DELETE FROM `filtergroup_attribute` WHERE `filtergroup`='$id'");
        foreach($attribute AS $key=>$value)
            {
                $this->filtergroup_model->createattributebyfiltergroup($value,$id);
            }
		return 1;
	}
	function delete($id)
	{
		$query=$this->db->query("DELETE FROM `filtergroup` WHERE `id`='$id'");
		
	}
    
     public function getfiltergroupdropdown()
	{
		$query=$this->db->query("SELECT * FROM `filtergroup`  ORDER BY `id` ASC")->result();
		$return=array();
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    
     public function getshopnavbyfiltergroup($id)
	{
         $return=array();
		$query=$this->db->query("SELECT `id`,`shopnavigation`,`filtergroup` FROM `shopnav_filtergroup`  WHERE `shopnavigation`='$id'");
        if($query->num_rows() > 0)
        {
            $query=$query->result();
            foreach($query as $row)
            {
                $return[]=$row->filtergroup;
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
}
?>