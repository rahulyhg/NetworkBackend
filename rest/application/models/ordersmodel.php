<?php
class OrdersModel extends CI_model
{
    function viewall()
      {
         $query= $this->db->get('orders');
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
         $query= $this->db->get('orders');

        if($query->num_rows > 0)
        {
        
		$query=$query->row();
		$query->retailer=$this->db->query("SELECT `retailer`.* , `distributor`.`email` as `distributor` FROM `retailer` INNER JOIN `area` ON `area`.`id`=`retailer`.`area` INNER JOIN `distributor` ON `distributor`.`id` = `area`.`distributor` WHERE `retailer`.`id`='$query->retail'")->row();
		$query->orderproduct=$this->db->query("SELECT `orderproduct`.`id`,`orderproduct`.`productcode`,`orderproduct`.`quantity`,`orderproduct`.`amount`,`product`.`name`,`orderproduct`.`category` FROM `orderproduct` INNER JOIN `product` ON `product`.`id`=`orderproduct`.`product`  WHERE `order`='$id' ")->result();
            	return $query;

        }
        else 
        {
            return false;
        }

      }
    
    function insertorders()
    {
        $retail=$this->input->get('retail');
        $sales=$this->input->get('sales');
        $timestamp=$this->input->get('timestamp');
        $amount=$this->input->get('amount');
        $signature=$this->input->get('signature');
        $query=$this->db->query("INSERT INTO `orders` (`retail`, `sales`, `timestamp`, `amount`, `signature`) VALUES ('{$retail}', '{$sales}', '{$timestamp}', '{$amount}', '{$signature}')");
        //$query=$this
        return $query;
    }
    
    function updateorders()
    {
        $id=$this->input->get('id');
        $retail=$this->input->get('retail');
        $sales=$this->input->get('sales');
        $timestamp=$this->input->get('timestamp');
        $amount=$this->input->get('amount');
        $signature=$this->input->get('signature');
        $query=$this->db->query("UPDATE `orders` SET `retail`='{$retail}',`sales`='{$sales}',`timestamp`='{$timestamp}',`amount`='{$amount}',`signature`='{$signature}' WHERE `id`=$id");
        //$query=$this
        return $query;
    }
    function deleteone()
    {
        $id=$this->input->get('id');
        $this->db->where('id', $id);
        $query= $this->db->delete('orders');
        return $query;
    }
    function viewallwithuser($user)
    {
        
        $query= $this->db->query("SELECT `orders`.`id`,`orders`.`amount`,`orders`.`timestamp`,`retailer`.`name` as `retail`  FROM `orders` LEFT OUTER JOIN `retailer` ON `retailer`.`id`=`orders`.`retail` WHERE `salesid`='$user'");
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
    function viewallwithretailer($retailer)
    {
        
        $query= $this->db->query("SELECT `orders`.`id`,`orders`.`amount`,`orders`.`sales`,`orders`.`timestamp`,`retailer`.`name` as `retail`,`orders`.`quantity` as `quantity`  FROM `orders` INNER JOIN `retailer` ON `retailer`.`id`=`orders`.`retail` WHERE `retail`='$retailer' ORDER BY `orders`.`timestamp` DESC LIMIT 0,3");
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
    function getmonthstally($user)
    {
        
        $query= $this->db->query("SELECT count(`id`) as `calls`,sum(`amount`) as `amount`,sum(`quantity`) as `quantity`,MONTH(`timestamp`) as `month` FROM `orders`  WHERE `salesid`='$user' GROUP BY `month`  HAVING `month`=MONTH(CURRENT_TIMESTAMP)");
    	if ($query->num_rows() > 0)
        {
        	$query=$query->row();
        	$query->orders=$this->db->query("SELECT count(`id`) as `orders`, MONTH(`timestamp`) as `month` FROM `orders` WHERE  `orders`.`quantity`> 0 AND  `salesid`='$user'  GROUP BY `month` HAVING `month`=MONTH(CURRENT_TIMESTAMP)")->row();
        	$query->orders=$query->orders->orders;
        	return $query;
        }
        else 
        {
        	$query2=new stdClass();
        	$query2->calls=0;
        	$query2->amount=0;
        	$query2->quantity=0;
        	$query2->month=0;
        	$query2->orders=0;
        	return $query2;
        }
    }
     function gettodaystally($user)
    {
        
        $query= $this->db->query("SELECT count(`id`) as `calls`,sum(`amount`) as `amount`,sum(`quantity`) as `quantity`,DATE(`timestamp`) as `month` FROM `orders`  WHERE `salesid`='$user'   GROUP BY `month`  HAVING `month`=DATE(CURRENT_TIMESTAMP)");
    	if ($query->num_rows() > 0)
        {
        	$query=$query->row();
        	$query->orders=$this->db->query("SELECT count(`id`) as `orders`, DATE(`timestamp`) as `month` FROM `orders` WHERE `orders`.`quantity`> 0 AND `salesid`='$user' GROUP BY `month` HAVING `month`=DATE(CURRENT_TIMESTAMP)")->row();
        	$query->orders=$query->orders->orders;
        	return $query;
        }
        else 
        {
   		$query2=new stdClass();
        	$query2->calls=0;
        	$query2->amount=0;
        	$query2->quantity=0;
        	$query2->month=0;
        	$query2->orders=0;
        	return $query2;
        }
    }
    function getmyordersbydate($user,$date)
    {
        
        $query= $this->db->query("SELECT `orders`.`id`,`orders`.`amount`,`orders`.`sales`,`distributor`.`email`,`orders`.`timestamp`,`retailer`.`name` as `retail`,`orders`.`quantity` as `quantity`  FROM `orders` INNER JOIN `retailer` ON `retailer`.`id`=`orders`.`retail` INNER JOIN `area` ON `area`.`id`=`retailer`.`area` INNER JOIN `distributor` ON `distributor`.`id` = `area`.`distributor` WHERE `salesid`='$user' AND DATE(`orders`.`timestamp`)='$date' ORDER BY `orders`.`timestamp` DESC");
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
    function getmyordersbyretailer($user,$retailer)
    {
        
        
        $query= $this->db->query("SELECT `orders`.`id`,`orders`.`amount`,`distributor`.`email`,`orders`.`sales`,`orders`.`timestamp`,`retailer`.`name` as `retail`,`orders`.`quantity` as `quantity`  FROM `orders` INNER JOIN `retailer` ON `retailer`.`id`=`orders`.`retail` INNER JOIN `area` ON `area`.`id`=`retailer`.`area` INNER JOIN `distributor` ON `distributor`.`id` = `area`.`distributor` WHERE `salesid`='$user' AND `orders`.`retail`='$retailer' ORDER BY `orders`.`timestamp` DESC");
        
        
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