<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Coupon_model extends CI_Model
{
	//topic
	public function create($name,$rules,$codes)
	{
		$data  = array(
			'couponname' => $name,
			'rules' => $rules
		);
		$query=$this->db->insert( 'coupon', $data );
		$couponid=$this->db->insert_id();
        foreach($codes AS $key=>$value)
        {
            $this->coupon_model->createcodebycoupon($value,$couponid);
        }
		return  1;
	}
    public function createcodebycoupon($value,$couponid)
	{
		$data  = array(
			'coupon' =>$couponid,
			'code' => $value
		);
        //print_r($data);
		$query=$this->db->insert( 'coupon_code', $data );
		return  1;
	}
	function viewcoupon()
	{
		$query=$this->db->query("SELECT * FROM `coupon` ")->result();
		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'coupon' )->row();
		return $query;
	}
	
	public function edit( $id,$name,$rules,$codes)
	{
		$data = array(
			'couponname' => $name,
			'rules' => $rules
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'coupon', $data );
		$querydelete=$this->db->query("DELETE FROM `coupon_code` WHERE `coupon`='$id'");
        foreach($codes AS $key=>$value)
        {
            $this->coupon_model->createcodebycoupon($value,$id);
        }
		return 1;
	}
	function delete($id)
	{
		$query=$this->db->query("DELETE FROM `coupon` WHERE `id`='$id'");
		
	}
    
     public function getcodesdropdown()
	{
		$query=$this->db->query("SELECT * FROM `codes`  ORDER BY `id` ASC")->result();
		$return=array();
		foreach($query as $row)
		{
			$return[$row->id]=$row->code;
		}
		
		return $return;
	}
    
     public function getcodesbycoupon($id)
	{
         $return=array();
		$query=$this->db->query("SELECT `id`,`coupon`,`code` FROM `coupon_code`  WHERE `coupon`='$id'");
        if($query->num_rows() > 0)
        {
            $query=$query->result();
            foreach($query as $row)
            {
                $return[]=$row->code;
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