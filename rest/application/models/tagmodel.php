<?php
class TagModel extends CI_model
{
    function viewall()
      {
         $query= $this->db->get('tags');
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
         $query= $this->db->get('tags');
        if($query->num_rows > 0)
        {
            return $query->row();
        }
        else 
        {
            return false;
        }
      }
    
    function inserttag()
    {
        $name=$this->input->get('name');
        $query=$this->db->query("INSERT INTO `tags`(`name`) VALUES ('{$name}')");
        //$query=$this
        return $query;
    }
    
    function updatetag()
    {
        $id=$this->input->get('id');
        $name=$this->input->get('name');
        $query=$this->db->query("UPDATE tags SET `name`='{$name}' WHERE `id`=$id");
        //$query=$this
        return $query;
    }
    function deleteone()
    {
        $id=$this->input->get('id');
        $this->db->where('id', $id);
        $query= $this->db->delete('tags');
        return $query;
    }
}
?>