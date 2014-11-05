<?php
class AreaModel extends CI_model
{
    function viewall()
      {
         $query= $this->db->get('area');
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
         $query= $this->db->get('area');
        if($query->num_rows > 0)
        {
           return $query->row();
        
        }
        else 
        {
            return false;
        }
      }
    
    function insertarea()
    {
        $city=$this->input->get('city');
        $name=$this->input->get('name');
        $distributor=$this->input->get('distributor');
        $query=$this->db->query("INSERT INTO `area` (`city`,`name`,`distributor`) VALUES ('{$city}','{$name}','{$distributor}')");
        //$query=$this
        return $query;
    }
    
    function updatearea()
    {
        $id=$this->input->get('id');
        $city=$this->input->get('city');
        $name=$this->input->get('name');
        $distributor=$this->input->get('distributor');
        $query=$this->db->query("UPDATE `area` SET `city`='{$city}',`name`='{$name}',`distributor`='{$distributor}' WHERE `id`=$id");
        //$query=$this
        return $query;
    }
    function deleteone()
    {
        $id=$this->input->get('id');
        $this->db->where('id', $id);
        $query= $this->db->delete('area');
        return $query;
    }
    function viewallwithcity($city)
    {
    	$query= $this->db->query("SELECT * FROM `area` WHERE `city`='$city'");
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
}
?>