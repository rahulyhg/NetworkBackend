<?php
class AccesslevelModel extends CI_model
{
    function viewall()
      {
         $query= $this->db->get('accesslevel');
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
         $query= $this->db->get('accesslevel');
        if($query->num_rows > 0)
        {
            return $query->row();
        }
        else 
        {
            return false;
        }
        
      }
    
    function insertaccesslevel()
    {
        $name=$this->input->get('name');
        $accesslevel=$this->input->get('accesslevel');
        $query=$this->db->query("INSERT INTO `accesslevel` (`name`, `accesslevel`) VALUES ('{$name}','{$accesslevel}')");
        //$query=$this
        return $query;
    }
    
    function updateaccesslevel()
    {
        $id=$this->input->get('id');
        $accesslevel=$this->input->get('accesslevel');
        $name=$this->input->get('name');
        $query=$this->db->query("UPDATE `accesslevel` SET `accesslevel`='{$accesslevel}',`name`='{$name}' WHERE `id`=$id");
        //$query=$this
        return $query;
    }
    function deleteone()
    {
        $id=$this->input->get('id');
        $this->db->where('id', $id);
        $query= $this->db->delete('accesslevel');
        return $query;
    }
}
?>