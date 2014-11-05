<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class distributor_model extends CI_Model
{
	//topic
	public function create($name,$code,$componyname,$email,$contactno,$dob,$address1,$address2,$zipcode)
	{
		$data  = array(
			'name' => $name,
			'code' => $code,
			'componyname' => $componyname,
			'email' => $email,
			'dob' => $dob,
			'contactno' => $contactno,
			'address1' => $address1,
			'address2' => $address2,
			'zipcode' => $zipcode
		);
		$query=$this->db->insert( 'distributor', $data );
		
		return  1;
	}
	function viewdistributor()
	{
		$query=$this->db->query("SELECT `distributor`.`id`, `distributor`.`name` AS `distributorname`, `distributor`.`code`,`distributor`. `componyname`, `distributor`.`email`, `distributor`.`contactno`, `distributor`.`dob`, `distributor`.`address1`, `distributor`.`address2`, `distributor`.`zipcode` FROM `distributor`")->result();
		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'distributor' )->row();
		return $query;
	}
	
	public function edit( $id,$name,$code,$componyname,$email,$contactno,$dob,$address1,$address2,$zipcode)
	{
		$data = array(
			'name' => $name,
			'code' => $code,
			'componyname' => $componyname,
			'email' => $email,
			'dob' => $dob,
			'contactno' => $contactno,
			'address1' => $address1,
			'address2' => $address2,
			'zipcode' => $zipcode
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'distributor', $data );
		
		return 1;
	}
	function deletedistributor($id)
	{
		$query=$this->db->query("DELETE FROM `distributor` WHERE `id`='$id'");
		
	}
    
     public function getstatedropdown()
	{
		$query=$this->db->query("SELECT * FROM `state`  ORDER BY `id` ASC")->result();
		$return=array();
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    
    
     public function gettagsdropdown()
	{
		$query=$this->db->query("SELECT * FROM `tags`  ORDER BY `id` ASC")->result();
		$return=array();
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    
    
     public function getfiltergroupbyattribute($id)
	{
         $return=array();
		$query=$this->db->query("SELECT `id`,`attribute`,`filtergroup` FROM `filtergroup_attribute`  WHERE `filtergroup`='$id'");
        if($query->num_rows() > 0)
        {
            $query=$query->result();
            foreach($query as $row)
            {
                $return[]=$row->attribute;
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
    public function getattributebyproduct($id)
	{
         $return=array();
		$query=$this->db->query("SELECT `id`,`attribute`,`product` FROM `product_attribute`  WHERE `product`='$id'");
        if($query->num_rows() > 0)
        {
            $query=$query->result();
            foreach($query as $row)
            {
                $return[]=$row->attribute;
            }
        }
         return $return;
         
		
	}
    public function gettagsbyproduct($id)
	{
         $return=array();
		$query=$this->db->query("SELECT `id`,`tag`,`product` FROM `product_tag`  WHERE `product`='$id'");
        if($query->num_rows() > 0)
        {
            $query=$query->result();
            foreach($query as $row)
            {
                $return[]=$row->tag;
            }
        }
         return $return;
     }
    function exportdistributor()
	{
		$this->load->dbutil();
		$query=$this->db->query("SELECT `distributor`.`id`, `distributor`.`name` AS `distributorname`, `distributor`.`code`,`distributor`. `componyname`, `distributor`.`email`, `distributor`.`contactno`, `distributor`.`dob`, `distributor`.`address1`, `distributor`.`address2`, `distributor`.`zipcode` FROM `distributor`");

       $content= $this->dbutil->csv_from_result($query);
        //$data = 'Some file data';

        if ( ! write_file('./csvgenerated/distributorfile.csv', $content))
        {
             echo 'Unable to write the file';
        }
        else
        {
            redirect(base_url('csvgenerated/distributorfile.csv'), 'refresh');
             echo 'File written!';
        }
	}
    
}
?>