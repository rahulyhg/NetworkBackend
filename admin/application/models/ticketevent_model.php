<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Ticketevent_model extends CI_Model
{
	
	public function create($event,$ticket,$tickettype,$amount,$ticketname,$quantity,$description,$ticketmaxallowed,$ticketminallowed,$starttime,$endtime)
	{
		$data  = array(
			'event' => $event,
			'description' => $description,
			'ticket' => $ticket,
			'tickettype' => $tickettype,
			'amount' => $amount,
			'ticketname' => $ticketname,
			'quantity' => $quantity,
			'ticketmaxallowed' => $ticketmaxallowed,
			'ticketminallowed' => $ticketminallowed,
			'starttime' => $starttime,
			'endtime' => $endtime,
		);
		$query=$this->db->insert( 'ticketevent', $data );
		
		if(!$query)
			return  0;
		else
			return  1;
	}
	function viewticketevent()
	{
		$query="SELECT  `ticketevent`.`id` as `id`,`ticketevent`.`ticketname` as `ticketname`,`ticketevent`.`ticket` as `ticket`	,`ticketevent`.`starttime` as `starttime`,`ticketevent`.`endtime` as `endtime`,`event`.`title` as `event`,`ticketevent`.`amount`,`ticketevent`.`quantity`,`tickettype`.`name` as `tickettype`	FROM `ticketevent`
		INNER JOIN `event` ON `event`.`id`=`ticketevent`.`event` 
		INNER JOIN `tickettype` ON `ticketevent`.`tickettype`=`tickettype`.`id` ";
	  
	   $query.=" ORDER BY `ticketevent`.`starttime` ASC";
		$query=$this->db->query($query)->result();
		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'ticketevent' )->row();
		
		return $query;
	}
	
	public function edit($id,$event,$ticket,$tickettype,$amount,$ticketname,$quantity,$description,$ticketmaxallowed,$ticketminallowed,$starttime,$endtime)
	{
		$data  = array(
			'event' => $event,
			'description' => $description,
			'ticket' => $ticket,
			'tickettype' => $tickettype,
			'amount' => $amount,
			'ticketname' => $ticketname,
			'quantity' => $quantity,
			'ticketmaxallowed' => $ticketmaxallowed,
			'ticketminallowed' => $ticketminallowed,
			'starttime' => $starttime,
			'endtime' => $endtime,
		);
		
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'ticketevent', $data );
		return 1;
	}
	function deleteticketevent($id)
	{
		$query=$this->db->query("DELETE FROM `ticketevent` WHERE `id`='$id'");
	}
	
	public function gettickettype()
	{
		$return=array();
		$query=$this->db->query("SELECT * FROM `tickettype` ORDER BY `id` ASC")->result();
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
	
		return $return;
	}
	public function getticketevent()
	{
		$return=array();
		$query=$this->db->query("SELECT * FROM `ticketevent` ORDER BY `id` ASC")->result();
		foreach($query as $row)
		{
			$return[$row->id]=$row->ticketname;
		}
	
		return $return;
	}
	
}
?>