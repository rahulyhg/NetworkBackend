<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
    public function create()
	{
        $this->load->model('productmodel');
        $data['json']=$this->productmodel->insertproduct();
		$this->load->view('json',$data);
	}
    public function update()
	{
        $this->load->model('productmodel');
        $data['json']=$this->productmodel->updateproduct();
		$this->load->view('json',$data);
	}
	public function find()
	{
		$this->load->model('productmodel');
        $data['json']=$this->productmodel->viewall();
		$this->load->view('json',$data);
	}
    public function findone()
	{
        //$id=$this->input->get('id');
        $id=$this->input->get('id');
        $this->load->model('productmodel');
        $data['json']=$this->productmodel->viewone($id,"");
		$this->load->view('json',$data);
	}
    public function delete()
	{
        $this->load->model('productmodel');
        $data['json']=$this->productmodel->deleteone();
		$this->load->view('json',$data);
	}
	
	
	
	public function getnextproduct()
	{
		$id=$this->input->get_post("id");
		$category=$this->input->get_post("category");
		
		$checksearch=substr($category,0,1);
		
		$next=$this->input->get_post("next");
		$new=$this->input->get_post("new");
		$sign=">";
		$orderby="ASC";
		if($next=="0")
		{
			$sign="<";
			$orderby="DESC";
		}
		
		
		if($checksearch=="f") 
		{
			$searchstring=substr($category,1);
			$query=$this->db->query("SELECT `id` FROM `product` WHERE `id`$sign'$id' AND (`product`.`productcode` LIKE '%$searchstring%' OR `product`.`name` LIKE '%$searchstring%') ORDER BY `id` $orderby  LIMIT 0,1");
		}
		else if($category=='scheme')
		{
			$query=$this->db->query("SELECT `id` FROM `product` WHERE `id`$sign'$id' AND `product`.`scheme`>='1' ORDER BY `id` $orderby  LIMIT 0,1");
		}
		else if($category=='new')
		{
			$query=$this->db->query("SELECT `id` FROM `product` WHERE `id`$sign'$id' AND `product`.`isnew`='1' ORDER BY `id` $orderby  LIMIT 0,1");
		}
		else 
		{
			$query=$this->db->query("SELECT `id` FROM `product` WHERE `id`$sign'$id' AND `product`.`category`='$category' ORDER BY `id` $orderby  LIMIT 0,1");
		}
		
		
		if ($query->num_rows() > 0)
        	{
        		$query=$query->row();
        		//return $query;
        	}
        	else 
        	{
        		if($checksearch=="f") 
			{
				$searchstring=substr($category,1);
				$query2=$this->db->query("SELECT `id` FROM `product` WHERE `product`.`productcode` LIKE '%$searchstring%' OR `product`.`name` LIKE '%$searchstring%' ORDER BY `id` $orderby  LIMIT 0,1");
			}
        		else if($category=='scheme')
			{
				$query2=$this->db->query("SELECT `id` FROM `product` WHERE `product`.`scheme`>='1' ORDER BY `id` $orderby  LIMIT 0,1");
			}
			else if($category=='new')
			{
				$query2=$this->db->query("SELECT `id` FROM `product` WHERE `product`.`isnew`='1' ORDER BY `id` $orderby LIMIT 0,1");
			}
			else 
			{
				$query2=$this->db->query("SELECT `id` FROM `product` WHERE `product`.`category`='$category' ORDER BY `id` $orderby LIMIT 0,1");
			}
        		
        		//$query2=$this->db->query("SELECT `id` FROM `product` WHERE `product`.`category`='$category' ORDER BY `id` ASC LIMIT 0,1");
        		if ($query2->num_rows() > 0)
        		{
        			$query=$query2->row();
        		}
        		else
        		{
        			$data['json']=false;
        		}
        		//return false;
        	}
        	if($query)
        	{
        	$id=$query->id;
	       $this->load->model('productmodel');
	        $data['json']=$this->productmodel->viewone($id,$category);
	        }
	        else
	        {
	         $data['json']=false;
	        }
        	
        	$this->load->view('json',$data);
	}
	public function gettoptenproducts()
	{
		$query=$this->db->query("SELECT `orderproduct`.`product`,`product`.`name`,`product`.`productcode`,SUM(`orderproduct`.`quantity`) as `totalquantity` FROM `orderproduct` INNER JOIN `product` ON `orderproduct`.`product`=`product`.`id` INNER JOIN `orders` ON `orders`.`id`=`orderproduct`.`order` WHERE MONTH(`orders`.`timestamp`)=MONTH(CURRENT_TIMESTAMP) GROUP BY `orderproduct`.`product`  ORDER BY `totalquantity` DESC LIMIT 0,10");
		if ($query->num_rows() > 0)
        	{
        		$query=$query->result();
        	}
        	else 
        	{
        		$query=0;
        	}
        	$data['json']=$query;
        	$this->load->view('json',$data);
	}
}

                            
                            
                            