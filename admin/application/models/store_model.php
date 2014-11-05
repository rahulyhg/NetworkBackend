<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Store_model extends CI_Model
{
    public function createstoreinmall($name,$city,$brand,$mall,$floor,$contactno,$email,$format,$offer,$shopclosedon,$workinghoursfrom,$workinghoursto,$description)
	{
		$data  = array(
			'name' => $name,
			'city' => $city,
			'brand' => $brand,
			'mall' => $mall,
			'floor' => $floor,
			'offer' => $offer,
			'contactno' => $contactno,
			'email' => $email,
			'workinghoursfrom' => $workinghoursfrom,
			'workinghoursto' => $workinghoursto,
			'shopclosedon' => $shopclosedon,
			'description' => $description,
			'format' => $format
		);
		$query=$this->db->insert( 'store', $data );
		
		return  1;
	}
    public function editstoreinmall($id,$name,$city,$brand,$mall,$floor,$contactno,$email,$format,$offer,$shopclosedon,$workinghoursfrom,$workinghoursto,$description)
	{
		$data  = array(
			'name' => $name,
			'city' => $city,
			'brand' => $brand,
			'mall' => $mall,
			'floor' => $floor,
			'offer' => $offer,
			'description' => $description,
			'contactno' => $contactno,
			'email' => $email,
			'workinghoursfrom' => $workinghoursfrom,
			'workinghoursto' => $workinghoursto,
			'shopclosedon' => $shopclosedon,
			'format' => $format
		);
        
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'store', $data );
		
		return  1;
	}
    public function createindividualstore($name,$city,$brand,$address,$location,$latitude,$longitude,$contactno,$email,$format,$offer,$workinghoursfrom,$workinghoursto,$shopclosedon,$description)
	{
        //$branddetails=$this->brand_model->viewonebrand($brand);
            //print_r($branddetails);
       // echo $branddetails->id;
		$data  = array(
			'name' => $name,
			'city' => $city,
			'brand' => $brand,
			'offer' => $offer,
			'workinghoursfrom' => $workinghoursfrom,
			'workinghoursto' => $workinghoursto,
			'shopclosedon' => $shopclosedon,
			'address' => $address,
			'description' => $description,
			'location' => $location,
			'latitude' => $latitude,
			'longitude' => $longitude,
			'contactno' => $contactno,
			'email' => $email,
			'format' => $format
		);
		$query=$this->db->insert( 'store', $data );
		
		return  1;
	}
    public function editindividualstore($id,$name,$city,$brand,$address,$location,$latitude,$longitude,$contactno,$email,$format,$offer,$workinghoursfrom,$workinghoursto,$shopclosedon,$description)
	{
		$data  = array(
			'name' => $name,
			'city' => $city,
			'brand' => $brand,
			'offer' => $offer,
			'workinghoursfrom' => $workinghoursfrom,
			'workinghoursto' => $workinghoursto,
			'shopclosedon' => $shopclosedon,
			'address' => $address,
			'description' => $description,
			'location' => $location,
			'latitude' => $latitude,
			'longitude' => $longitude,
			'contactno' => $contactno,
			'email' => $email,
			'format' => $format
		);
        
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'store', $data );
		
		return  1;
	}
	function viewstoreinmall()
	{
		$query=$this->db->query("SELECT `store`.`id`,`store`. `name`,`store`. `city`,`city`.`name` as `cityname`, `store`.`brand`,`brand`.`name` as `brandname`,`store`. `format`,`store`. `mall`,`mall`.`name` as `mallname`, `store`.`floor`,`floor`.`floorno` AS `floorname`,`mall`. `address`, `mall`.`location`,`location`.`name` AS `locationname`,`mall`. `latitude`, `mall`.`longitude`,`store`.`contactno`, `store`.`email`,`store`.`description`, `brand`.`website`, `brand`.`facebookpage`, `brand`.`twitterpage` FROM `store`
        LEFT OUTER JOIN `city` ON `store`. `city`=`city`.`id`
        LEFT OUTER JOIN `mall` ON `store`. `mall`=`mall`.`id`
        LEFT OUTER JOIN `location` ON `mall`. `location`=`location`.`id`
        LEFT OUTER JOIN `floor` ON `store`. `floor`=`floor`.`id`
        LEFT OUTER JOIN `brand` ON `store`. `brand`=`brand`.`id` WHERE `store`. `format`='1'")->result();
		return $query;
	}
	function viewindividualstore()
	{
		$query=$this->db->query("SELECT `store`.`id`,`store`. `name`,`store`. `city`,`city`.`name` as `cityname`, `store`.`brand`,`brand`.`name` as `brandname`,`store`. `format`,`store`. `mall`,`mall`.`name` as `mallname`, `store`.`floor`,`store`. `address`, `store`.`location`,`location`.`name` as `locationname`,`store`. `latitude`, `store`.`longitude`, `store`.`contactno`, `store`.`email`,`store`.`description`, `brand`.`website`, `brand`.`facebookpage`, `brand`.`twitterpage` FROM `store`
        LEFT OUTER JOIN `city` ON `store`. `city`=`city`.`id`
        LEFT OUTER JOIN `mall` ON `store`. `mall`=`mall`.`id`
        LEFT OUTER JOIN `location` ON `store`. `location`=`location`.`id`
        LEFT OUTER JOIN `brand` ON `store`. `brand`=`brand`.`id` WHERE `store`. `format`='2'")->result();
		return $query;
	}
//	public function beforeeditoffer( $id )
//	{
//		$this->db->where( 'id', $id );
//		$query=$this->db->get( 'offers' )->row();
//		return $query;
//	}
	public function beforeeditstoreinmall( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'store' )->row();
		return $query;
	}
	public function beforeeditindividualstore( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'store' )->row();
		return $query;
	}
    
       
     public function getshopclosedondropdown()
	{
		$query=$this->db->query("SELECT * FROM `shopclosed`  ORDER BY `id` ASC")->result();
		$return=array(
		"" => ""
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->day;
		}
		
		return $return;
	}
       
     public function getstore($id)
	{
		$query="SELECT `id`,`name` FROM `store`  WHERE `brand`=".$id;
		
//    $query="SELECT `id`,`subjectname` FROM `subject` where `courseid`=".$courseid;
	  
	  
		$store=$this->db->query($query)->result();
         if ($store== NULL) {
                return "No Store";
            }
        else
        return $store;
	}
     public function getstorebybrand($id)
	{
		$query="SELECT `id`,`name` FROM `store`  WHERE `brand`=".$id;
		
//    $query="SELECT `id`,`subjectname` FROM `subject` where `courseid`=".$courseid;
	  
	  
		$store=$this->db->query($query)->result();
         if ($store== NULL) {
                return "No Store";
            }
        else
        return $store;
	}
	
//	public function editoffer( $id,$header,$description,$from,$to)
//	{
//		$data = array(
//			'header' => $header,
//			'description' => $description,
//			'from' => $from,
//			'to' => $to
//		);
//		$this->db->where( 'id', $id );
//		$query=$this->db->update( 'offers', $data );
//		
//		return 1;
//	}
	function deletestoreinmall($id)
	{
		$query=$this->db->query("DELETE FROM `store` WHERE `id`='$id'");
		
	}
	function deleteindividualstore($id)
	{
		$query=$this->db->query("DELETE FROM `store` WHERE `id`='$id'");
		
	}
//	public function getofferdropdown()
//	{
//		$query=$this->db->query("SELECT * FROM `offers`  ORDER BY `id` ASC")->result();
//		$return=array(
//		"" => ""
//		);
//		foreach($query as $row)
//		{
//			$return[$row->id]=$row->header;
//		}
//		
//		return $return;
//	}
//	public function getoffer()
//	{
//		$query=$this->db->query("SELECT * FROM `offers`  ORDER BY `header` ASC")->result();
//		
//		
//		return $query;
//	}
    
    public function filterstorebyofferid($id)
	{
		$query=$this->db->query("SELECT * FROM `store` WHERE `offer`='$id'")->result();
		
		
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