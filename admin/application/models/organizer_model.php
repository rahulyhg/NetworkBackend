<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Organizer_model extends CI_Model
{
	
	public function create($name,$description,$email,$contact,$info,$website,$user)
	{
		$data  = array(
			'name' => $name,
			'description' => $description,
			'email' => $email,
			'contact' => $contact,
			'info' => $info,
			'website' => $website,
			'user' => $user
		);
		$query=$this->db->insert( 'organizer', $data );
		
		if(!$query)
			return  0;
		else
			return  1;
	}
	function vieworganizers()
	{
		$query="SELECT  `organizer`.`id` as `id`,`organizer`.`name` as `name`,`organizer`.`info` as `info`	,`organizer`.`email` as `email`,`organizer`.`contact` as `contact`,`organizer`.`website` as `website`	FROM `organizer`";
	  
	   $query.=" ORDER BY `organizer`.`name` ASC";
		$query=$this->db->query($query)->result();
		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'organizer' )->row();
		return $query;
	}
	
	public function edit($id,$name,$description,$email,$contact,$info,$website,$user)
	{
		$data  = array(
			'name' => $name,
			'description' => $description,
			'email' => $email,
			'contact' => $contact,
			'info' => $info,
			'website' => $website,
			'user' => $user
		);
		
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'organizer', $data );
		
		return 1;
	}
	function deleteorganizer($id)
	{
		$query=$this->db->query("DELETE FROM `organizer` WHERE `id`='$id'");
	}
	
	public function getorganizer()
	{
		$return=array();
		$query=$this->db->query("SELECT * FROM `organizer` ORDER BY `id` ASC")->result();
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
	
		return $return;
	}
	
}
?>