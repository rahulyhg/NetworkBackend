<?php
class OrderproductModel extends CI_model
{
    function viewall()
      {
         $query= $this->db->get('orderproduct');
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
         $query= $this->db->get('orderproduct');
        if($query->num_rows > 0)
        {
            return $query->row();
        }
        else 
        {
            return false;
        }
      }
    
    function insertorderproduct()
    {
        $order=$this->input->get('order');
        $product=$this->input->get('product');
        $quantity=$this->input->get('quantity');
        $amount=$this->input->get('amount');
        $scheme_id=$this->input->get('scheme_id');
        $status=$this->input->get('status');
        $query=$this->db->query("INSERT INTO `orderproduct` (`order`, `product`, `quantity`, `amount`, `scheme_id`, `status`) VALUES ('{$order}', '{$product}', '{$quantity}', '{$amount}', '{$scheme_id}','{$status}')");
        //$query=$this
        return $query;
    }
    
    function updateorderproduct()
    {
        $id=$this->input->get('id');
        $order=$this->input->get('order');
        $product=$this->input->get('product');
        $quantity=$this->input->get('quantity');
        $amount=$this->input->get('amount');
        $scheme_id=$this->input->get('scheme_id');
        $status=$this->input->get('status');
        $query=$this->db->query("UPDATE `orderproduct` SET `order`='{$order}',`product`='{$product}',`quantity`='{$quantity}',`amount`='{$amount}',`scheme_id`='{$scheme_id}' WHERE `id`=$id");
        //$query=$this
        return $query;
    }
    function deleteone()
    {
        $id=$this->input->get('id');
        $this->db->where('id', $id);
        $query= $this->db->delete('orderproduct');
        return $query;
    }
}
?>