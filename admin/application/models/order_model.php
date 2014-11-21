<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Order_model extends CI_Model
{
	
	function vieworder()
	{
        $maxpage=$this->config->item("per_page");
        $startfrom=$this->uri->segment(3,0);
		$query="SELECT `orders`.`id`, `orders`.`retail`, `orders`.`sales`, `orders`.`timestamp`, `orders`.`amount`, `orders`.`signature`, `orders`.`salesid`, `orders`.`quantity`,`retailer`.`name` AS `retailername` FROM `orders` LEFT OUTER JOIN `retailer` ON `retailer`.`id`=`orders`.`retail` ORDER BY `orders`.`timestamp` DESC LIMIT $startfrom,$maxpage";
        $result=new stdClass();
        $result->query=$this->db->query($query)->result();
        $result->totalcount=$this->db->query("SELECT count(*) as `totalcount` FROM `orders` LEFT OUTER JOIN `retailer` ON `retailer`.`id`=`orders`.`retail`")->row();
        $result->totalcount=$result->totalcount->totalcount;
        return $result;
        
        
//		$query=$this->db->query($query)->result();
//		return $query;
	}
	function vieworderproduct($id)
	{
		$query="SELECT `orderproduct`.`id`, `orderproduct`.`order`, `orderproduct`.`product`, `orderproduct`.`quantity`, `orderproduct`.`amount`,`orderproduct`. `scheme_id`, `orderproduct`.`status`, `orderproduct`.`category`,`product`.`name` AS `productname`,`scheme`.`name` AS `schemename`,`catelog`.`name`AS `categoryname` FROM `orderproduct` 
LEFT OUTER JOIN `product` ON `product`.`id`=`orderproduct`.`product`
LEFT OUTER JOIN `scheme` ON `scheme`.`id`=`orderproduct`.`scheme_id`
LEFT OUTER JOIN `catelog` ON `catelog`.`id`=`orderproduct`.`category` WHERE `orderproduct`.`order`='$id'";
		$query=$this->db->query($query)->result();
		return $query;
	}
//	function vieworderproduct($id)
//	{
//        $maxpage=$this->config->item("per_page");
//        $startfrom=$this->uri->segment(3,0);
//		$query="SELECT `orderproduct`.`id`, `orderproduct`.`order`, `orderproduct`.`product`, `orderproduct`.`quantity`, `orderproduct`.`amount`,`orderproduct`. `scheme_id`, `orderproduct`.`status`, `orderproduct`.`category`,`product`.`name` AS `productname`,`scheme`.`name` AS `schemename`,`catelog`.`name`AS `categoryname` FROM `orderproduct` 
//LEFT OUTER JOIN `product` ON `product`.`id`=`orderproduct`.`product`
//LEFT OUTER JOIN `scheme` ON `scheme`.`id`=`orderproduct`.`scheme_id`
//LEFT OUTER JOIN `catelog` ON `catelog`.`id`=`orderproduct`.`category` WHERE `orderproduct`.`order`='$id' LIMIT $startfrom,$maxpage";
//        $result=new stdClass();
//        $result->query=$this->db->query($query)->result();
//        $result->totalcount=$this->db->query("SELECT count(*) as `totalcount` FROM `orderproduct` 
//LEFT OUTER JOIN `product` ON `product`.`id`=`orderproduct`.`product`
//LEFT OUTER JOIN `scheme` ON `scheme`.`id`=`orderproduct`.`scheme_id`
//LEFT OUTER JOIN `catelog` ON `catelog`.`id`=`orderproduct`.`category` WHERE `orderproduct`.`order`='$id'")->row();
//        $result->totalcount=$result->totalcount->totalcount;
//        return $result;
////		$query=$this->db->query($query)->result();
////		return $query;
//	}
	public function create($name,$alias,$shop,$stock,$ean,$tax,$metatitle,$metadescription,$shopnavigation,$tags,$attribute)
	{
		$data  = array(
			'name' => $name,
			'alias' => $alias,
			'shop' => $shop,
			'stock' => $stock,
			'ean' => $ean,
			'tax' => $tax,
			'metatitle' => $metatitle,
			'metadescription' => $metadescription
		);
		$query=$this->db->insert( 'product', $data );
		$id = $this->db->insert_id();
        
//		if($query)
//		{
//			$this->savelog($id,'Event Created');
//		}
		if(!$query)
			return  0;
		else
			return  $id;
	}
    public function createshopnavigationbyproduct($value,$productid)
	{
		$data  = array(
			'shopnav' =>$value,
			'product' => $productid
		);
		$query=$this->db->insert( 'shopnav_product', $data );
		return  1;
	}
    public function createattributebyproduct($value,$productid)
	{
		$data  = array(
			'attribute' =>$value,
			'product' => $productid
		);
		$query=$this->db->insert( 'product_attribute', $data );
		return  1;
	}
    public function createtagsbyproduct($value,$productid)
	{
		$data  = array(
			'tag' =>$value,
			'product' => $productid
		);
		$query=$this->db->insert( 'product_tag', $data );
		return  1;
	}
    
    public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query['product']=$this->db->get( 'product' )->row();
		return $query;
	}
    
    
	public function edit($id,$name,$alias,$shop,$stock,$ean,$tax,$metatitle,$metadescription,$shopnavigation,$tags,$attribute)
	{
		$data  = array(
			'name' => $name,
			'alias' => $alias,
			'shop' => $shop,
			'stock' => $stock,
			'ean' => $ean,
			'tax' => $tax,
			'metatitle' => $metatitle,
			'metadescription' => $metadescription
		);
		
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'product', $data );
        $querydelete=$this->db->query("DELETE FROM `shopnav_product` WHERE `product`='$id'");
        $querydelete=$this->db->query("DELETE FROM `product_attribute` WHERE `product`='$id'");
        $querydelete=$this->db->query("DELETE FROM `product_tag` WHERE `product`='$id'");
        foreach($shopnavigation AS $key=>$value)
            {
                $this->product_model->createshopnavigationbyproduct($value,$id);
            }
        foreach($tags AS $key=>$value)
            {
                $this->product_model->createtagsbyproduct($value,$id);
            }
        foreach($attribute AS $key=>$value)
            {
                $this->product_model->createattributebyproduct($value,$id);
            }
//		if($query)
//		{
//			$this->savelog($id,'Product Edited');
//		}
		return 1;
	}
    
    
	function deleteproduct($id)
	{
		$query=$this->db->query("DELETE FROM `product` WHERE `id`='$id'");
	}
    
    //-----------------------------------------------------------------------------------------------------------------------------------------
    public function createsubcategory($brandid,$categoryid)
	{
		$data  = array(
			'brandid' => $brandid,
			'categoryid' => $categoryid
		);
       // print_r($data);
        $this->db->where($data);
      
        $q = $this->db->get('brandcategory');
      // echo"</br>";
//         echo "num rows".$q->num_rows();
//        echo"</br>";
        if($q->num_rows()==0)
        { 
          $query=$this->db->insert( 'brandcategory', $data );
        }
        else{
            //echo "not inserted";
        }
        
        //$id = $this->db->insert_id();
//		if($query)
//		{
//			$this->savelog($id,'Event Created');
//		}
//		if(!$query)
//			return  0;
//		else
			return  1;
	}
    public function getcategory()
	{
		$query="SELECT `id`,`name`,`parent` FROM  `category` ";
		$query=$this->db->query($query)->result();
		return $query;

	}
    public function getbrandcategory($id)
	{
		$query="SELECT  `brandcategory`.`id` ,  `brandcategory`.`brandid` ,  `brandcategory`.`categoryid` ,  `category`.`name` as `categoryname`, `category`.`parent`
FROM  `brandcategory` 
LEFT OUTER JOIN  `category` ON  `category`.`id` =  `brandcategory`.`categoryid`  WHERE `brandcategory`.`brandid`='$id'";
		$query=$this->db->query($query)->result();
		return $query;

	}
    public function createlocation($name,$cityid)
	{
		$data  = array(
			'name' => $name,
            'cityid'=> $cityid
		);
		$query=$this->db->insert( 'location', $data );
//		$id = $this->db->insert_id();
//		if($query)
//		{
//			$this->savelog($id,'Event Created');
//		}
		if(!$query)
			return  0;
		else
			return  1;
	}
	function viewonebrand($id)
	{
		$query="SELECT `brand`.`id`, `brand`.`name`, `brand`.`pricerange`,`pricerange`.`range` AS `rangename`, `brand`.`video`, `brand`.`description`, `brand`.`facebookpage`, `brand`.`website`, `brand`.`twitterpage`, `brand`.`logo` FROM `brand` LEFT OUTER JOIN `pricerange` ON `pricerange`.`id`=`brand`.`pricerange` WHERE `brand`.`id`='$id'";
		$query=$this->db->query($query)->row();
		return $query;
	}
	function viewonecitylocations($id)
	{
		$query="SELECT `location`.`id`,`location`.`name`,`location`.`cityid`, `city`.`name` AS `cityname` FROM `location`
        INNER JOIN `city` ON `city`.`id` = `location`.`cityid` WHERE `location`.`cityid`='$id'";
		$query=$this->db->query($query)->result();
		return $query;
	}
//	public function beforeedit( $id )
//	{
//		$this->db->where( 'id', $id );
//		$query['brand']=$this->db->get( 'brand' )->row();
//		$query['eventcategory']=array();
//		$eventcategory=$this->db->query("SELECT `category` FROM `eventcategory` WHERE `eventcategory`.`event`='$id'")->result();
//		foreach($eventcategory as $cat)
//		{
//			$query['eventcategory'][]=$cat->category;
//		}
//		$query['eventtopic']=array();
//		$eventtopic=$this->db->query("SELECT `topic` FROM `eventtopic` WHERE `eventtopic`.`event`='$id'")->result();
//		foreach($eventtopic as $top)
//		{
//			$query['eventtopic'][]=$top->topic;
//		}
//		return $query;
//	}
	public function beforeeditlocation( $id )
	{
		$this->db->where( 'id', $id );
		$query['location']=$this->db->get( 'location' )->row();
//		$query['eventcategory']=array();
//		$eventcategory=$this->db->query("SELECT `category` FROM `eventcategory` WHERE `eventcategory`.`event`='$id'")->result();
//		foreach($eventcategory as $cat)
//		{
//			$query['eventcategory'][]=$cat->category;
//		}
//		$query['eventtopic']=array();
//		$eventtopic=$this->db->query("SELECT `topic` FROM `eventtopic` WHERE `eventtopic`.`event`='$id'")->result();
//		foreach($eventtopic as $top)
//		{
//			$query['eventtopic'][]=$top->topic;
//		}
		return $query;
	}
	
    public function editbrand($id,$name,$website,$facebook,$twitter,$pininterest,$googleplus,$instagram,$blog,$description)
	{
		$data  = array(
			'name' => $name,
			'website' => $website,
			'facebookpage' => $facebook,
			'twitterpage' => $twitter,
			'pininterest' => $pininterest,
			'googleplus' => $googleplus,
			'instagram' => $instagram,
			'blog' => $blog,
			'description' => $description,
		);
		
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'brand', $data );
//		if($query)
//		{
//			$this->savelog($id,'Brand Edited');
//		}
		return 1;
	}
	public function editlocation($id,$cityid,$name)
	{
		$data  = array(
			'cityid' => $cityid,
			'name' => $name
		);
		
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'location', $data );
		if($query)
		{
			$this->savelog($id,'Location Edited');
		}
		return 1;
	}
     public function getbranddropdown()
	{
		$query=$this->db->query("SELECT * FROM `brand`  ORDER BY `id` ASC")->result();
		$return=array(
		"" => ""
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
	function deletebrand($id)
	{
		$query=$this->db->query("DELETE FROM `brand` WHERE `id`='$id'");
	}
	function deletesubcategory($id)
	{
		$query=$this->db->query("DELETE FROM `brandcategory` WHERE `brandid`='$id'");
	}
	function deletelocation($id)
	{
		$query=$this->db->query("DELETE FROM `location` WHERE `id`='$id'");
	}
	
	
	function savelog($id,$action)
	{
		$fromuser = $this->session->userdata('id');
		$data2  = array(
			'user' => $id,
			'event' => $id,
			'description' => $action,
		);
		$query2=$this->db->insert( 'eventlog', $data2 );
	}
    //-----------------Changes made avinash
    function filterbrandbycategoryid($id)
    {
        $query=$this->db->query("SELECT `brand`.`id`, `brand`.`name`, `brand`.`pricerange`,`pricerange`.`range`, `brand`.`video`,`category`.`name` FROM `brand`
LEFT OUTER JOIN `brandcategory`ON `brandcategory`.`brandid`=`brand`.`id`
LEFT OUTER JOIN `category`ON `category`.`id`=`brandcategory`.`categoryid`
LEFT OUTER JOIN `pricerange`ON `brand`.`pricerange`=`pricerange`.`id`
WHERE `brandcategory`.`categoryid`='$id'")->result();
         return $query;
    }
    
    //------------------------
    //------------------------
    function exportorder()
	{
		$this->load->dbutil();
		$query=$this->db->query("SELECT `orders`.`id` AS `orderID`, `orders`.`timestamp`,`orderproduct`.`id`,`product`.`name` AS `product`,`catelog`.`name`AS `categoryname`, `orderproduct`.`order`, `orderproduct`.`quantity`, `orderproduct`.`amount`,`orderproduct`. `scheme_id`, `orderproduct`.`status`,`scheme`.`name` AS `schemename`,`orders`.`sales` AS `Sales_Person`,`retailer`.`name` AS `retailer` FROM `orderproduct` 
LEFT OUTER JOIN `product` ON `product`.`id`=`orderproduct`.`product`
LEFT OUTER JOIN `scheme` ON `scheme`.`id`=`orderproduct`.`scheme_id`
LEFT OUTER JOIN `catelog` ON `catelog`.`id`=`orderproduct`.`category`
LEFT OUTER JOIN `orders` ON `orders`.`id`=`orderproduct`.`order`
LEFT OUTER JOIN `retailer` ON `retailer`.`id`=`orders`.`retail`");

       $content= $this->dbutil->csv_from_result($query);
        //$data = 'Some file data';
        $timestamp=new DateTime();
        $timestamp=$timestamp->format('Y-m-d_H.i.s');
		
		file_put_contents("gs://toykraftdealer/orderfile_$timestamp.csv", $content);
		redirect("http://admin.toy-kraft.com/servepublic?name=orderfile_$timestamp.csv", 'refresh');
//        if ( ! write_file('./csvgenerated/orderfile.csv', $content))
//        {
//             echo 'Unable to write the file';
//        }
//        else
//        {
//            
//        redirect(base_url('csvgenerated/orderfile.csv'), 'refresh');
//             echo 'File written!';
//        }
	}
}
?>