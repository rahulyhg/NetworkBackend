<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Category_model extends CI_Model
{
	//category
	public function createcategory($name,$parent,$status)
	{
		$data  = array(
			'name' => $name,
			'parent' => $parent,
			'order' => $status,
		);
		$query=$this->db->insert( 'catelog', $data );
		
		return  1;
	}
    function viewcategory()
	{
        $maxpage=$this->config->item("per_page");
        $startfrom=$this->uri->segment(3,0);
		$query="SELECT `catelog`.`id`,`catelog`.`name`,`tab2`.`name` as `parent`,`catelog`.`order` FROM `catelog` 
		LEFT JOIN `catelog` as `tab2` ON `tab2`.`id`=`catelog`.`parent`
		ORDER BY `catelog`.`id` ASC LIMIT $startfrom,$maxpage";
        $result=new stdClass();
        $result->query=$this->db->query($query)->result();
        $result->totalcount=$this->db->query("SELECT count(*) as `totalcount` FROM `catelog` 
		LEFT JOIN `catelog` as `tab2` ON `tab2`.`id`=`catelog`.`parent`
		ORDER BY `catelog`.`id`")->row();
        $result->totalcount=$result->totalcount->totalcount;
        return $result;
//		return $query;
	}
    
	public function getstatusdropdown()
	{
		$status= array(
			 "1" => "Has Types",
			 "0" => "No Types",
			);
		return $status;
	}
    function viewmaincategory()
	{
		$query=$this->db->query("SELECT `catelog`.`id`,`catelog`.`name`,`catelog`.`order` AS `ordername`,`tab2`.`name` as `parent` FROM `catelog` 
		LEFT JOIN `catelog` as `tab2` ON `tab2`.`id`=`catelog`.`parent` WHERE `catelog`.`parent`='0'
		ORDER BY `catelog`.`id` ASC")->result();
		return $query;
	}
    function viewcategorytypes()
	{
		$query=$this->db->query("SELECT `catelog`.`id`,`catelog`.`name`,`tab2`.`name` as `parent` FROM `catelog` 
		LEFT JOIN `catelog` as `tab2` ON `tab2`.`id`=`catelog`.`parent` WHERE `catelog`.`status`='0'
		ORDER BY `catelog`.`id` ASC")->result();
		return $query;
	}
	public function beforeeditcategory( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'catelog' )->row();
		return $query;
	}
	
	public function editcategory( $id,$name,$parent,$status)
	{
		$data = array(
			'name' => $name,
			'parent' => $parent,
			'order' => $status,
		
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'catelog', $data );
		
		return 1;
	}
	function deletecategory($id)
	{
		$query=$this->db->query("DELETE FROM `catelog` WHERE `id`='$id'");
		
	}
	public function getcategorydropdown()
	{
		$query=$this->db->query("SELECT * FROM `catelog`  ORDER BY `id` ASC")->result();
		$return=array(
		"" => ""
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
	public function getmaincategorydropdown()
	{
		$query=$this->db->query("SELECT * FROM `catelog` WHERE `parent`='0'  ORDER BY `id` ASC")->result();
		$return=array(
		"" => ""
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
	public function getcategory()
	{
		$query=$this->db->query("SELECT * FROM `catelog`  ORDER BY `name` ASC")->result();
		
		
		return $query;
	}
//	public function getstatusdropdown()
//	{
//		$status= array(
//			 "1" => "Enabled",
//			 "0" => "Disabled",
//			);
//		return $status;
//	}
    public function selectedcategory($brandid,$categoryid)
    {
        $subcategory=array();
//        $query3=$this->db->query("SELECT `id` FROM `brandcategory` where `brandid`='$brandid' and `categoryid`='$categoryid'")->row();
//       echo $query3->id;
        $qry="SELECT `subcategoryid` FROM `categorysubcategory` WHERE `brandcategoryid` IN (SELECT `id` FROM `brandcategory` where `brandid`='$brandid' and `categoryid`='$categoryid')";
      //  echo $qry;
    $query=$this->db->query($qry)->result();
       $query2=$this->db->query("SELECT `id`,`name` FROM `subcategory`")->result();
//		print_r($query);
//        echo "<br><br>";
//		print_r($query2);
//        echo "<br><br>";
        foreach($query2 as $row)
		{
        $flag="";
                    foreach($query as $row2)
                {
                        if($row->id==$row2->subcategoryid)
                        {
                        $flag="checked";
                        break;
                        }
                        
                }
            array_push($subcategory,$row->name,$row->id,$flag);
            
		}
		//print_r($subcategory);
        return $subcategory;
//		return $query;
    
    
    }
    public function getbrandcategoryid($brandid,$categoryid)
    {
    $query3=$this->db->query("SELECT `id` FROM `brandcategory` where `brandid`='$brandid' and `categoryid`='$categoryid'")->row();
       return $query3->id;
    }
    public function editsubcategorysubmit($brandcategoryid,$subcategoryid)
    {
        $data  = array(
			'brandcategoryid' => $brandcategoryid,
			'subcategoryid' => $subcategoryid
		);
        $querya=$this->db->query("SELECT * FROM `categorysubcategory` WHERE `brandcategoryid`='$brandcategoryid' AND `subcategoryid`='$subcategoryid'")->result();
        if( $this->db->affected_rows() == 0)
        {
		$query=$this->db->insert( 'categorysubcategory', $data );
        }
		
    }
    public function deletesubcategorysubmit($brandcategoryid,$subcategoryid)
    {
        $sql="DELETE FROM `categorysubcategory` WHERE `brandcategoryid`='$brandcategoryid' AND `subcategoryid`='$subcategoryid'";
        echo $sql;
		$query=$this->db->query($sql);
		
    }
    
}
?>