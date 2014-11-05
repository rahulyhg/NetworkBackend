<?php
class StateModel extends CI_model
{
    function viewall()
      {
         $query= $this->db->get('state');
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
         $query= $this->db->get('state');
        if($query->num_rows > 0)
        {
            return $query->row();
        }
        else 
        {
            return false;
        }
      }
    
    function insertstate()
    {
        $name=$this->input->get('name');
        $zone=$this->input->get('zone');
        $query=$this->db->query("INSERT INTO `state` (`zone`,`name`) VALUES ('{$zone}','{$name}')");
        //$query=$this
        return $query;
    }
    
    function updatestate()
    {
        $id=$this->input->get('id');
        $zone=$this->input->get('zone');
        $name=$this->input->get('name');
        $query=$this->db->query("UPDATE `state` SET `zone`='{$zone}',`name`='{$name}' WHERE `id`=$id");
        //$query=$this
        return $query;
    }
    function deleteone()
    {
        $id=$this->input->get('id');
        $this->db->where('id', $id);
        $query= $this->db->delete('state');
        return $query;
    }
    function viewallwithzone($zone)
    {
    	$query= $this->db->query("SELECT * FROM `state` WHERE `zone`='$zone'");
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