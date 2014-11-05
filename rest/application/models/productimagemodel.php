<?php
class ProductimageModel extends CI_model
{
    function viewall()
      {
         $query= $this->db->get('productimage');
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
         $product=$this->input->get('product');
         $this->db->where('product', $product);
         $query= $this->db->get('productimage');
        if($query->num_rows > 0)
        {
            return $query->row();
        }
        else 
        {
            return false;
        }
      }
    
    function insertproductimage()
    {
        $product=$this->input->get('product');
        $image=$this->input->get('image');
        $order=$this->input->get('order');
        $views=$this->input->get('views');
        $query=$this->db->query("INSERT INTO `productimage` (`product`, `image`, `order`, `views`) VALUES ('{$product}', '{$image}', '{$order}', '{$views}')");
        //$query=$this
        return $query;
    }
    
    function updateproductimage()
    {
        $product=$this->input->get('product');
        $image=$this->input->get('image');
        $order=$this->input->get('order');
        $views=$this->input->get('views');
        $query=$this->db->query("UPDATE `productimage` SET `image`='{$image}',`order`='{$order}',`views`='{$views}' WHERE `product`=$product");
        //$query=$this
        return $query;
    }
    function deleteone()
    {
        $product=$this->input->get('product');
        $this->db->where('product', $product);
        $query= $this->db->delete('productimage');
        return $query;
    }
}
?>