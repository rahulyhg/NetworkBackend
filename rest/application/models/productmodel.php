<?php
class ProductModel extends CI_model
{
    function viewall()
      {
         $query= $this->db->get('product');
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
    
     function viewone($id,$category)
      {
         $return = 0;
         $this->db->where('id', $id);
         $query= $this->db->get('product');
        if($query->num_rows > 0)
        {
           $return=$query->row();
           $images=$this->db->query("SELECT * FROM `productimage` WHERE `productimage`.`product`='$return->id'");
           if($images->num_rows > 0)
           {
           	$return->images=$images->result();
           }
           
           if($category=="scheme")
           {
           	$scheme=$this->db->query("SELECT * FROM `scheme` WHERE `id`='$return->scheme' AND CURRENT_TIMESTAMP BETWEEN `date_start` AND `date_end`");
           	
           	if($scheme->num_rows > 0)
           	{
           		$scheme=$scheme->row();
           		$return->scheme2=$scheme;
           		//$return->mrp=floatval($return->mrp)-(floatval($return->mrp)*floatval($scheme->discount_percent)/100);
           	}
           }
        }
        else 
        {
            $return=false;
        }
        return $return;
      }
    
    function insertproduct()
    {
        $name=$this->input->get('name');
        $product=$this->input->get('product');
        $encode=$this->input->get('encode');
        $name2=$this->input->get('name2');
        $productcode=$this->input->get('productcode');
        $category=$this->input->get('category');
        $video=$this->input->get('video');
        $mrp=$this->input->get('mrp');
        $description=$this->input->get('description');
        $age=$this->input->get('age');
        $scheme=$this->input->get('scheme');
        $isnew=$this->input->get('isnew');
        $timestamp=$this->input->get('timestamp');
        $query=$this->db->query("INSERT INTO `product`(`name`, `product`, `encode`, `name2`, `productcode`, `category`, `video`, `mrp`, `description`, `age`, `scheme`, `isnew`, `timestamp`) VALUES ('{$name}','{$product}','{$encode}','{$name2}','{$productcode}','{$category}','{$video}','{$mrp}','{$description}',{$age},'{$scheme}',{$isnew},'{$timestamp}')");
        //$query=$this
        return $query;
    }
    
    function updateproduct()
    {
        $id=$this->input->get('id');
        $name=$this->input->get('name');
        $product=$this->input->get('product');
        $encode=$this->input->get('encode');
        $name2=$this->input->get('name2');
        $productcode=$this->input->get('productcode');
        $category=$this->input->get('category');
        $video=$this->input->get('video');
        $mrp=$this->input->get('mrp');
        $description=$this->input->get('description');
        $age=$this->input->get('age');
        $scheme=$this->input->get('scheme');
        $isnew=$this->input->get('isnew');
        $timestamp=$this->input->get('timestamp');
        $query=$this->db->query("UPDATE product SET name='{$name}',product='{$product}',encode='{$encode}',name2='{$name2}',productcode='{$productcode}',category='{$category}',video='{$video}',mrp='{$mrp}',description='{$description}',age='{$age}',scheme='{$scheme}',isnew='{$isnew}',timestamp='{$timestamp}' WHERE id=$id");
        //$query=$this
        return $query;
    }
    function deleteone()
    {
        $id=$this->input->get('id');
        $this->db->where('id', $id);
        $query= $this->db->delete('product');
        return $query;
    }
}