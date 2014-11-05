<?php
class SchemeModel extends CI_model
{
    function viewall()
      {
         $query= $this->db->get('scheme');
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
         $query= $this->db->get('scheme');
        if($query->num_rows > 0)
        {
            return $query->row();
        }
        else 
        {
            return false;
        }
      }
    
    function insertscheme()
    {
        $name=$this->input->get('name');
        $discount_percent=$this->input->get('discount_percent');
        $date_start=$this->input->get('date_start');
        $date_end=$this->input->get('date_end');
        $mrp=$this->input->get('mrp');
        $query=$this->db->query("INSERT INTO `scheme` (`name`, `discount_percent`, `date_start`, `date_end`, `mrp`) VALUES ('{$name}', '{$discount_percent}', '{$date_start}', '{$date_end}', '{$mrp}')");
        //$query=$this
        return $query;
    }
    
    function updatescheme()
    {
        $id=$this->input->get('id');
        $name=$this->input->get('name');
        $discount_percent=$this->input->get('discount_percent');
        $date_start=$this->input->get('date_start');
        $date_end=$this->input->get('date_end');
        $mrp=$this->input->get('mrp');
        $query=$this->db->query("UPDATE `scheme` SET `name`='{$name}',`discount_percent`='{$discount_percent}',`date_start`='{$date_start}',`date_end`='{$date_end}',`mrp`='{$mrp}' WHERE `id`=$id");
        //$query=$this
        return $query;
    }
    function deleteone()
    {
        $id=$this->input->get('id');
        $this->db->where('id', $id);
        $query= $this->db->delete('scheme');
        return $query;
    }
}
?>