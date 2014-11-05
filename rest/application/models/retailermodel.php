<?php
class RetailerModel extends CI_model
{
    function viewall()
      {
         $query= $this->db->get('retailer');
        if($query->num_rows > 0)
        {
            foreach($query->result() as $row)
            {
            $data[]=$row;
            }
        
        }
        else 
        {
            return false;
        }
        return $data;
         
      }
    
     function viewone()
     {
        $id=$this->input->get('id');
        $this->db->where('id', $id);
        $query= $this->db->get('retailer');
        if($query->num_rows > 0)
        {
        	
           $query=$query->row();
           $query->distributor=$this->db->query("SELECT `distributor`.`email` FROM `distributor` INNER JOIN `area` ON `distributor`.`id`=`area`.`distributor` AND `area`.`id`='$query->area'")->row();
           $query->distributor=$query->distributor->email;
           return $query;
        }
        else 
        {
            return false;
        }
     }
    
    function insertretailer()
    {
        $lat=$this->input->get('lat');
        $long=$this->input->get('long');
        $area=$this->input->get('area');
        $dob=$this->input->get('dob');
        $type_of_area=$this->input->get('type_of_area');
        $sq_feet=$this->input->get('sq_feet');
        $name=$this->input->get('name');

        $number=$this->input->get('number');
        $email=$this->input->get('email');
        $address=$this->input->get('address');
        $ownername=$this->input->get('ownername');
        $ownernumber=$this->input->get('ownernumber');
        $contactname=$this->input->get('contactname');
        $contactnumber=$this->input->get('contactnumber');
        $store_image=$this->input->get('store_image');
if($name=="")
{
return 0;
}
        $query=$this->db->query("INSERT INTO `retailer` (`id`, `lat`, `long`, `area`, `dob`, `type_of_area`, `sq_feet`, `store_image`, `name`, `number`, `email`, `address`, `ownername`, `ownernumber`, `contactname`, `contactnumber`) VALUES (NULL, '$lat', '$long', '$area', '$dob', '$type_of_area', '$sq_feet','$store_image' ,'$name', '$number', '$email', '$address', '$ownername', '$ownernumber', '$contactname', '$contactnumber');");
        //$query=$this
        return $query;
    }
    
    function updateretailer()
    {
        $id=$this->input->get('id');
        $name=$this->input->get('name');
        $code=$this->input->get('code');
        $compony_name=$this->input->get('compony_name');
        $email=$this->input->get('email');
        $contactno=$this->input->get('contactno');
        $address=$this->input->get('address');
        $contactperson=$this->input->get('contactperson');
        $lat=$this->input->get('lat');
        $long=$this->input->get('long');
        $area=$this->input->get('area');
        $dob=$this->input->get('dob');
        $type_of_area=$this->input->get('type_of_area');
        $sq_feet=$this->input->get('sq_feet');
        $store_image=$this->input->get('store_image');
        $query=$this->db->query("UPDATE `retailer` SET `name`='{$name}',`code`='{$code}',`compony_name`='{$compony_name}',`email`='{$email}',`contactno`='{$contactno}',`address`='{$address}',`contactperson`='{$contactperson}',`lat`='{$lat}',`long`='{$long}',`area`='{$area}',`dob`='{$dob}',`type_of_area`='{$type_of_area}',`sq_feet`='{$sq_feet}',`store_image`='{$store_image}' WHERE id=$id");
        //$query=$this
        return $query;
    }
    function deleteone()
    {
        $id=$this->input->get('id');
        $this->db->where('id', $id);
        $query= $this->db->delete('retailer');
        return $query;
    }
    function viewallwitharea($area)
    {
    	$query= $this->db->query("SELECT * FROM `retailer` WHERE `area`='$area'");
    	if ($query->num_rows() > 0)
        {
        	$query=$query->result();
        	return $query;
        }
        else 
        {
        	return false;
        }
    }
    function contactedit()
    {
    	$id=$this->input->get('id');
        $email=$this->input->get('email');
        $contactname=$this->input->get('contactname');
        $contactnumber=$this->input->get('contactnumber');
        $ownername=$this->input->get('ownername');
        $ownernumber=$this->input->get('ownernumber');
	$query=$this->db->query("UPDATE `retailer` SET `email`='$email',`contactname`='$contactname',`contactnumber`='$contactnumber',`ownername`='$ownername',`ownernumber`='$ownernumber' WHERE id='$id'");
        return $query;
    }
}
?>