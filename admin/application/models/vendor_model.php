<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Vendor_model extends CI_Model
{
	
	public function create($name,$shop,$email,$contact,$vat,$tin,$address,$details,$pan,$taxamount)
	{
		$data  = array(
			'name' => $name,
			'shop' => $shop,
			'email' => $email,
			'contact' => $contact,
			'vat' => $vat,
			'tin' => $tin,
			'address' => $address,
			'details' => $details,
			'pan' => $pan,
			'taxamount' => $taxamount
		);
		$query=$this->db->insert( 'vendor', $data );
         $vendorid=$this->db->insert_id();
        
//		if($query)
//		{
//			$this->savelog($id,'Event Created');
//		}
		if(!$query)
			return  0;
		else
			return  $vendorid;
	}
   
	function viewvendor()
	{
		$query="SELECT `vendor`.`id`,`vendor`.`name` AS `vendorname`, `vendor`.`email`, `vendor`.`shop`, `vendor`.`contact`, `vendor`.`vat`, `vendor`.`tin`, `vendor`.`address`, `vendor`.`details`, `vendor`.`pan`, `vendor`.`taxamount`,`shop`.`name` AS `shopname` 
        FROM `vendor` 
        LEFT OUTER JOIN `shop` ON `shop`.`id`=`vendor`.`shop`";
		$query=$this->db->query($query)->result();
		return $query;
	}
    
    public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query['vendor']=$this->db->get( 'vendor' )->row();
		return $query;
	}
    
    
	public function edit($id,$name,$shop,$email,$contact,$vat,$tin,$address,$details,$pan,$taxamount)
	{
		$data  = array(
			'name' => $name,
			'shop' => $shop,
			'email' => $email,
			'contact' => $contact,
			'vat' => $vat,
			'tin' => $tin,
			'address' => $address,
			'details' => $details,
			'pan' => $pan,
			'taxamount' => $taxamount
		);
		
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'vendor', $data );
       
//		if($query)
//		{
//			$this->savelog($id,'Product Edited');
//		}
		return 1;
	}
    
    
	function deletevendor($id)
	{
		$query=$this->db->query("DELETE FROM `vendor` WHERE `id`='$id'");
	}
    
    //-----------------------------------------------------------------------------------------------------------------------------------------
    
}
?>