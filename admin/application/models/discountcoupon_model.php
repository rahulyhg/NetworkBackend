<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class discountcoupon_model extends CI_Model
{
	//discountcoupon
	public function creatediscountcoupon($name,$percent,$amount,$minimumticket,$maximumticket,$ticketevent,$couponcode,$userperuser,$starttime,$endtime)
	{
		$data  = array(
			'name' => $name,
			'percent' => $percent,
			'amount' => $amount,
			'minimumticket' => $minimumticket,
			'maximumticket' => $maximumticket,
			'ticketevent' => $ticketevent,
			'couponcode' => $couponcode,
			'userperuser' => $userperuser,
			'starttime' => $starttime,
			'endtime' => $endtime
		);
		$query=$this->db->insert( 'discountcoupon', $data );
		$id=$this->db->insert_id();
		if(!empty($product))
		{
			foreach($product as $key => $coun)
			{
				$data1  = array(
					'discountcoupon' => $id,
					'product' => $coun,
				);
				$query=$this->db->insert( 'discountproducts', $data1 );
			}
		}
		return  1;
	}
	function viewdiscountcoupon()
	{
		$query=$this->db->query("SELECT `discountcoupon`.`id`,`discountcoupon`.`name` as `name`,`discountcoupon`.`couponcode`,`discountcoupon`.`amount` as `amount`,`discountcoupon`.`percent` as `percent`,`discountcoupon`.`starttime` as `starttime`,`discountcoupon`.`endtime` as `endtime`,`ticketevent`.`ticketname` as `ticketevent` FROM `discountcoupon` 
		INNER JOIN  `ticketevent` ON  `ticketevent`.`id`=`discountcoupon`.`ticketevent`
		ORDER BY `discountcoupon`.`name` ASC")->result();
		return $query;
	}
	public function beforeeditdiscountcoupon( $id )
	{
		$this->db->where( 'id', $id );
		$query['dc']=$this->db->get( 'discountcoupon' )->row();
		
		return $query;
	}
	
	public function editdiscountcoupon( $id,$name,$percent,$amount,$minimumticket,$maximumticket,$ticketevent,$couponcode,$userperuser,$starttime,$endtime)
	{
		$data = array(
			'name' => $name,
			'percent' => $percent,
			'amount' => $amount,
			'minimumticket' => $minimumticket,
			'maximumticket' => $maximumticket,
			'ticketevent' => $ticketevent,
			'couponcode' => $couponcode,
			'userperuser' => $userperuser,
			'starttime' => $starttime,
			'endtime' => $endtime
		);
		$this->db->where( 'id', $id );
		$this->db->update( 'discountcoupon', $data );
		
		
		return 1;
	}
	function deletediscountcoupon($id)
	{
		$query=$this->db->query("DELETE FROM `discountcoupon` WHERE `id`='$id'");
		$this->db->query("DELETE FROM `discountproducts` WHERE `discountcoupon`='$id'");
	}
	public function getdiscountcoupondropdown()
	{
		$query=$this->db->query("SELECT * FROM `discountcoupon`  ORDER BY `id` ASC")->result();
		$return=array(
		"" => ""
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
	
}
?>