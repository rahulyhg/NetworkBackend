<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Scheme_model extends CI_Model
{
	//topic
	public function create($name,$discount_percent,$date_start,$date_end,$mrp)
	{
		$data  = array(
			'name' => $name,
			'discount_percent' => $discount_percent,
			'date_start' => $date_start,
			'date_end' => $date_end,
			'mrp' => $mrp
		);
		$query=$this->db->insert( 'scheme', $data );
		
		return  1;
	}
	function viewscheme()
	{
        $maxpage=$this->config->item("per_page");
        $startfrom=$this->uri->segment(3,0);
		$query="SELECT `scheme`.`id`, `scheme`.`name` AS `schemename`, `scheme`.`discount_percent`, `scheme`.`date_start`, `scheme`.`date_end`, `scheme`.`mrp` FROM `scheme` LIMIT $startfrom,$maxpage";
        $result=new stdClass();
        $result->query=$this->db->query($query)->result();
        $result->totalcount=$this->db->query("SELECT count(*) as `totalcount` FROM `scheme`")->row();
        $result->totalcount=$result->totalcount->totalcount;
        return $result;
//		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'scheme' )->row();
		return $query;
	}
	
	public function edit( $id,$name,$discount_percent,$date_start,$date_end,$mrp)
	{
		$data = array(
			'name' => $name,
			'discount_percent' => $discount_percent,
			'date_start' => $date_start,
			'date_end' => $date_end,
			'mrp' => $mrp
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'scheme', $data );
		
		return 1;
	}
	function deletescheme($id)
	{
		$query=$this->db->query("DELETE FROM `scheme` WHERE `id`='$id'");
		
	}
    
     public function getschemedropdown()
	{
		$query=$this->db->query("SELECT * FROM `scheme`  ORDER BY `id` ASC")->result();
		$return=array(
        ""=>""
        );
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    
    
}
?>