<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Product_model extends CI_Model
{
	
	public function create($name,$productcode,$category,$mrp,$description,$scheme,$isnew)
	{
		$data  = array(
			'name' => $name,
			'productcode' => $productcode,
			'category' => $category,
			'mrp' => $mrp,
			'description' => $description,
			'scheme' => $scheme,
			'isnew' => $isnew
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
   
	function viewproduct()
	{
        $maxpage=$this->config->item("per_page");
        $startfrom=$this->uri->segment(3,0);
		$query="SELECT `product`.`id`, `product`.`name` AS `productname`, `product`.`product`, `product`.`encode`, `product`.`name2`, `product`.`productcode`,`product`. `category`,`product`. `video`,`product`. `mrp`,`product`. `description`,`product`. `age`,`product`. `scheme`,`product`.`isnew`,`product`. `timestamp`,`catelog`.`name` AS `categoryname`,`scheme`.`name` AS `schemename`
FROM `product`
LEFT OUTER JOIN `catelog` ON `catelog`.`id`=`product`.`category`
LEFT OUTER JOIN `scheme` ON `scheme`.`id`=`product`.`scheme` LIMIT $startfrom,$maxpage";
        $result=new stdClass();
        $result->query=$this->db->query($query)->result();
        $result->totalcount=$this->db->query("SELECT count(*) as `totalcount` FROM `product`
LEFT OUTER JOIN `catelog` ON `catelog`.`id`=`product`.`category`
LEFT OUTER JOIN `scheme` ON `scheme`.`id`=`product`.`scheme`")->row();
        $result->totalcount=$result->totalcount->totalcount;
        return $result;
        
//		$query=$this->db->query($query)->result();
//		return $query;
	}
    
	public function getisnewdropdown()
	{
		$status= array(
			 "1" => "YES",
			 "0" => "NO",
			);
		return $status;
	}
    
    public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query['product']=$this->db->get( 'product' )->row();
		return $query;
	}
    
    
	public function edit($id,$name,$productcode,$category,$mrp,$description,$scheme,$isnew)
	{
		$data  = array(
			'name' => $name,
			'productcode' => $productcode,
			'category' => $category,
			'mrp' => $mrp,
			'description' => $description,
			'scheme' => $scheme,
			'isnew' => $isnew
		);
		
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'product', $data );
       
//		if($query)
//		{
//			$this->savelog($id,'Product Edited');
//		}
		return 1;
	}
    
    
	function deleteproduct($id)
	{
		$query=$this->db->query("DELETE FROM `product` WHERE `id`='$id'");
        $deleteproductimages=$this->db->query("DELETE FROM  `productimage` WHERE  `product` ='$id'");
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
    function exportproduct()
	{
		$this->load->dbutil();
		$query=$this->db->query("SELECT `product`.`id`, `product`.`name` AS `productname`, `product`.`product`, `product`.`encode`, `product`.`name2`, `product`.`productcode`,`product`. `category`,`product`. `video`,`product`. `mrp`,`product`. `description`,`product`. `age`,`product`. `scheme`,`product`.`isnew`,`product`. `timestamp`,`catelog`.`name` AS `categoryname`,`scheme`.`name` AS `schemename`
FROM `product`
LEFT OUTER JOIN `catelog` ON `catelog`.`id`=`product`.`category`
LEFT OUTER JOIN `scheme` ON `scheme`.`id`=`product`.`scheme`");

       $content= $this->dbutil->csv_from_result($query);
        //$data = 'Some file data';
        $timestamp=new DateTime();
        $timestamp=$timestamp->format('Y-m-d_H.i.s');
		
		file_put_contents("gs://toykraftdealer/productfile_$timestamp.csv", $content);
		redirect("http://admin.toy-kraft.com/servepublic?name=productfile_$timestamp.csv", 'refresh');

//        if ( ! write_file('./csvgenerated/productfile.csv', $content))
//        {
//             echo 'Unable to write the file';
//        }
//        else
//        {
//            redirect(base_url('csvgenerated/productfile.csv'), 'refresh');
//             echo 'File written!';
//        }
	}
}
?>