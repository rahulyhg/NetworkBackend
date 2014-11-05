<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Newsletter_model extends CI_Model
{
	
	//newsletter
	public function createnewsletter($title,$subject)
	{
		$data  = array(
			'title' => $title,
			'subject' => $subject,
		);
		$query=$this->db->insert( 'newsletter', $data );
		
		return  1;
	}
	function viewnewsletter()
	{
		$query=$this->db->query("SELECT `newsletter`.`id`,`newsletter`.`title`,`newsletter`.`subject` as `subject` FROM `newsletter` 
		ORDER BY `newsletter`.`title` ASC")->result();
		return $query;
	}
	public function beforeeditnewsletter( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'newsletter' )->row();
		return $query;
	}
	
	public function editnewsletter( $id,$title,$subject)
	{
		$data = array(
			'title' => $title,
			'subject' => $subject,
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'newsletter', $data );
		
		return 1;
	}
	function deletenewsletter($id)
	{
		$query=$this->db->query("DELETE FROM `newsletter` WHERE `id`='$id'");
	}
	
	
}
?>