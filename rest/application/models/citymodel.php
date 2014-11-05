<?php
class CityModel extends CI_model
{
    function viewall()
      {
         $query= $this->db->get('city');
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
         $query= $this->db->get('city');
        if($query->num_rows > 0)
        {
            return $query->row();
        }
        else 
        {
            return false;
        }
      }
    
    function insertcity()
    {
        $name=$this->input->get('name');
        $state=$this->input->get('state');
        $query=$this->db->query("INSERT INTO `city` (`state`,`name`) VALUES ('{$state}','{$name}')");
        //$query=$this
        return $query;
    }
    
    function updatecity()
    {
        $id=$this->input->get('id');
        $state=$this->input->get('state');
        $name=$this->input->get('name');
        $query=$this->db->query("UPDATE `city` SET `state`='{$state}',`name`='{$name}' WHERE `id`=$id");
        //$query=$this
        return $query;
    }
    function deleteone()
    {
        $id=$this->input->get('id');
        $this->db->where('id', $id);
        $query= $this->db->delete('city');
        return $query;
    }
    function viewallwithstate($state)
    {
    	$query= $this->db->query("SELECT * FROM `city` WHERE `state`='$state'");
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