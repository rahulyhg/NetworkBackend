<?php
class CatelogModel extends CI_model
{
    function viewall()
      {
         $query= $this->db->get('catelog');
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
         $query= $this->db->get('catelog');
        if($query->num_rows > 0)
        {
            return $query->row();
        }
        else 
        {
            return false;
        }
      }
    
    function insertcatelog()
    {
        $name=$this->input->get('name');
        $order=$this->input->get('order');
        $parent=$this->input->get('parent');
        $query=$this->db->query("INSERT INTO `catelog`(`name`, `order`, `parent`) VALUES ('{$name}','{$order}','{$parent}')");
        //$query=$this
        return $query;
    }
    
    function updatecatelog()
    {
        $id=$this->input->get('id');
        $name=$this->input->get('name');
        $order=$this->input->get('order');
        $parent=$this->input->get('parent');
        $query=$this->db->query("UPDATE catelog SET `name`='{$name}',`order`='{$order}',`parent`='{$parent}' WHERE `id`=$id");
        //$query=$this
        return $query;
    }
    function deleteone()
    {
        $id=$this->input->get('id');
        $this->db->where('id', $id);
        $query= $this->db->delete('catelog');
        return $query;
    }
    function getcatelog()
    {
    	$return=$this->db->query("SELECT * FROM `catelog` WHERE `catelog`.`parent`='1' ORDER BY `catelog`.`order`");
    	if ($return->num_rows() > 0)
    	{
    		$return=$return->result();
    		foreach($return as $catelog)
    		{
    			$query=$this->db->query("SELECT * FROM `catelog` WHERE `parent`='$catelog->id' ORDER BY `catelog`.`order`");
    			if ($query->num_rows() > 0)
    			{
    				$catelog->subcategory=$query->result();
    			}
    		}
    	}
    	else 
    	{
    		$return= false;
    	}
    	return $return;
    }
}
?>