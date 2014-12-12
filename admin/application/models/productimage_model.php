<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Productimage_model extends CI_Model
{
	//topic
	public function create($product,$image,$order)
	{
		$data  = array(
			'product' => $product,
			'image' => $image,
			'order' => $order
		);
		$query=$this->db->insert( 'productimage', $data );
		
		return  1;
	}
	function viewproductimage()
	{
        $maxpage=$this->config->item("per_page");
        $startfrom=$this->uri->segment(3,0);
		$query="SELECT `productimage`.`id`,`productimage`.`product`, `productimage`.`image`, `productimage`.`order`, `productimage`.`views`,`product`.`name` AS `productname` FROM `productimage` LEFT OUTER JOIN `product` ON `product`.`id`=`productimage`.`product`  LIMIT $startfrom,$maxpage";
        $result=new stdClass();
        $result->query=$this->db->query($query)->result();
        $result->totalcount=$this->db->query("SELECT count(*) as `totalcount` FROM `productimage` LEFT OUTER JOIN `product` ON `product`.`id`=`productimage`.`product`")->row();
        $result->totalcount=$result->totalcount->totalcount;
        return $result;
        
//		return $query;
	}
	function viewproductimagebyproduct($id)
	{
		$query="SELECT `productimage`.`id`,`productimage`.`product`, `productimage`.`image`, `productimage`.`order`, `productimage`.`views`,`product`.`name` AS `productname` FROM `productimage` LEFT OUTER JOIN `product` ON `product`.`id`=`productimage`.`product` WHERE `productimage`.`product`='$id'";
        $result=$this->db->query($query)->result();
        
        return $result;
        
//		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'productimage' )->row();
		return $query;
	}
    
	public function getimagebyid($id)
	{
		$query=$this->db->query("SELECT `image` FROM `productimage` WHERE `id`='$id'")->row();
		return $query;
	}
	
	public function edit( $id,$product,$image,$order)
	{
		$data = array(
			'product' => $product,
			'image' => $image,
			'order' => $order
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'productimage', $data );
		
		return 1;
	}
	function deleteproductimage($id)
	{
		$query=$this->db->query("DELETE FROM `productimage` WHERE `id`='$id'");
		
	}
    
     public function getproductdropdown()
	{
		$query=$this->db->query("SELECT * FROM `product`  ORDER BY `id` ASC")->result();
		$return=array();
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    
    
}
?>