<?php
class RetailerlogModel extends CI_model
{
    function viewall()
      {
         $query= $this->db->get('retailerlog');
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
         $query= $this->db->get('retailerlog');
        if($query->num_rows > 0)
        {
            return $query->row();
        }
        else 
        {
            return false;
        }
      }
    
    function insertretailerlog()
    {
        $name=$this->input->get('name');
        $salesperson=$this->input->get('salesperson');
        $image=$this->input->get('image');
        $retailer=$this->input->get('retailer');
        $query=$this->db->query("INSERT INTO `retailerlog` (`name`, `image`, `salesperson`, `retailer`) VALUES ('{$name}', '{$image}', '{$salesperson}', '{$retailer}')");
        //$query=$this
        return $query;
    }
    
    function updateretailerlog()
    {
        $id=$this->input->get('id');
        $name=$this->input->get('name');
        $salesperson=$this->input->get('salesperson');
        $image=$this->input->get('image');
        $retailer=$this->input->get('retailer');
        $query=$this->db->query("UPDATE `retailerlog` SET `name`='{$name}',`salesperson`='{$salesperson}',`image`='{$image}',`retailer`='{$retailer}' WHERE `id`=$id");
        //$query=$this
        return $query;
    }
    function deleteone()
    {
        $id=$this->input->get('id');
        $this->db->where('id', $id);
        $query= $this->db->delete('retailerlog');
        return $query;
    }
}
?>