<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Imagegallery_model extends CI_Model
{
	//topic
	public function create($image,$description,$brand,$storeid)
	{
		$data  = array(
			'image' => $image,
			'description' => $description,
			'brandid' => $brand,
			'storeid' => $storeid
		);
		$query=$this->db->insert( 'imagegallery', $data );
		
		return  1;
	}
	public function createnewin($image,$description)
	{
		$data  = array(
			'image' => $image,
			'description' => $description
		);
		$query=$this->db->insert( 'newin', $data );
		
		return  1;
	}
	function viewgallery()
	{
		$query=$this->db->query("SELECT `imagegallery`.`id`, `imagegallery`.`image`, `imagegallery`.`description`, `imagegallery`.`brandid`, `imagegallery`.`storeid`, `imagegallery`.`like`,`brand`.`name` AS `brandname`,`store`.`name` AS `storename` FROM `imagegallery`
        LEFT OUTER JOIN `brand` ON `brand`.`id`=`imagegallery`.`brandid`
        LEFT OUTER JOIN `store` ON `store`.`id`=`imagegallery`.`storeid`")->result();
		return $query;
	}
	function viewnewin()
	{
		$query=$this->db->query("SELECT `id`, `image`, `description`, `like` FROM `newin` ")->result();
		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'imagegallery' )->row();
		return $query;
	}
	public function beforeeditnewin( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'newin' )->row();
		return $query;
	}
	
	public function edit($id,$image,$description,$brand,$storeid)
	{
		$data = array(
			'image' => $image,
			'description' => $description,
			'brandid' => $brand,
			'storeid' => $storeid
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'imagegallery', $data );
		
		return 1;
	}
	
	public function editnewin($id,$image,$description)
	{
		$data = array(
			'image' => $image,
			'description' => $description
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'newin', $data );
		
		return 1;
	}
	function deletegallery($id)
	{
		$query=$this->db->query("DELETE FROM `imagegallery` WHERE `id`='$id'");
		
	}
	function deletenewin($id)
	{
		$query=$this->db->query("DELETE FROM `newin` WHERE `id`='$id'");
		
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
	public function getimagebyid($id)
	{
		$query=$this->db->query("SELECT `image` FROM `imagegallery` WHERE `id`='$id'")->row();
		
		
		return $query;
	}
	public function getnewinimagebyid($id)
	{
		$query=$this->db->query("SELECT `image` FROM `newin` WHERE `id`='$id'")->row();
		
		
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