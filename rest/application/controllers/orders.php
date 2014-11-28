<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders extends CI_Controller {

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
        $this->load->model('ordersmodel');
        $data['json']=$this->ordersmodel->insertorders();
		$this->load->view('json',$data);
	}
    public function sendorderemail()
        {
        	$id=$this->input->get('id');
        	$retail=$this->input->get('retail');
        	$amount=$this->input->get('amount');
            if($amount=="0")
            {
                return false;
            }
        	$user=$this->input->get('user');
        	$datetime=$this->input->get('datetime');
        	$quantity=$this->input->get('quantity');
        	$remark=$this->input->get('remark');
            $cart=$this->db->query("SELECT `orderproduct`.`id`,`orderproduct`.`order`,`orderproduct`.`quantity`,`orderproduct`.`amount`,`orderproduct`.`category`,`orderproduct`.`productcode`,`product`.`name`,`product`.`mrp`,`orderproduct`.`scheme_id`,`scheme`.`name` AS `scheme` 
            FROM `orderproduct` 
            INNER JOIN `product` ON `orderproduct`.`product`=`product`.`id` 
            LEFT OUTER JOIN `scheme` ON `orderproduct`.`scheme_id`=`scheme`.`id` 
            WHERE `orderproduct`.`order`='$id'")->result();
		
        	$retailerdistributor=$this->db->query("SELECT `retailer`.`id`,`retailer`.`name`,`retailer`.`address`,`retailer`.`area`,`retailer`.`email`,`retailer`.`number`,`area`.`id`,`area`.`distributor`,`distributor`.`id`,`distributor`.`contactno`,`distributor`.`email` as `disemail` FROM `retailer` INNER JOIN `area` ON `retailer`.`area`=`area`.`id` INNER JOIN `distributor` ON `area`.`distributor`=`distributor`.`id` WHERE `retailer`.`id`='$retail'")->row();
		$email=$retailerdistributor->email;
		$distributor=$retailerdistributor->disemail;
		//$emaildata="<table><tr> <th> Sr.no. </th> <th> Product Code </th> <th> Name </th> <th> Quantity </th> <th> MRP </th> <th> Amount </th> <th> Scheme </th> </tr>";
		$emaildata="<p>Dear Distributor / Retailer,<br>Our sales executive ".$user." has booked an order with details as below:</p><p><strong>Order id: </strong>".$id." </p> <p><strong>Order placed on: </strong>".$datetime." </p> <p><strong>".$retailerdistributor->name."</strong></p> <p><strong>".$retailerdistributor->address."</strong></p> <table style='width:100%; '><thead style='text-align:center'> <tr> <th> Sr.no. </th> <th> Product Code </th> <th> Name </th> <th> Quantity </th> <th> MRP </th> <th> Amount </th> <th> Scheme </th> </tr></thead><tbody style='text-align:center;'>";
		$index=1;
		foreach($cart as $cartitem)
		{
			$emaildata.="<tr>";
			$emaildata.="<td>".$index."</td>";
			$index++;
			$emaildata.="<td>".$cartitem->productcode."</td>";
			$emaildata.="<td>".$cartitem->name."</td>";
			$emaildata.="<td>".$cartitem->quantity."</td>";
			$emaildata.="<td>".$cartitem->mrp."</td>";
			$emaildata.="<td>".$cartitem->amount."</td>";
			$emaildata.="<td>".$cartitem->scheme."</td>";
//			if($cartitem->category=="scheme"){
//				$emaildata.="<td>Yes</td>";
//			}else{
//				$emaildata.="<td>No</td>";
//			}
			$emaildata.="</tr>";
		}
		$emaildata.="<tr>";
		$emaildata.="<td></td>";
		$emaildata.="<td></td>";
		$emaildata.="<td><strong>Total :</strong></td>";
		$emaildata.="<td><strong>".$quantity."</strong></td>";
		$emaildata.="<td></td>";
		$emaildata.="<td><strong>".$amount."</strong></td>";
		$emaildata.="<td></td>";
		$emaildata.="</tr>";
		$emaildata.="</tbody></table>";
		$emaildata.="<strong>Remark : </strong>".$remark;
		
            $this->load->library('email');
	        $this->email->from('noreply@toy-kraft.com', 'Toy Kraft');
	        $this->email->to($email);
                $this->email->cc($distributor);
	        $this->email->subject('ToyKraft Order No. '.$id);
	        $this->email->message($emaildata);
	        $this->email->send();
	        $data['json']=$this->email->print_debugger();
		$this->load->view('json',$data);
}
    public function update()
	{
        $this->load->model('ordersmodel');
        $data['json']=$this->ordersmodel->updateorders();
		$this->load->view('json',$data);
	}
	public function find()
	{
		$this->load->model('ordersmodel');
        $data['json']=$this->ordersmodel->viewall();
		$this->load->view('json',$data);
	}
    public function findone()
	{
        //$id=$this->input->get('id');
        $this->load->model('ordersmodel');
        $data['json']=$this->ordersmodel->viewone();
		$this->load->view('json',$data);
	}
    public function delete()
	{
        $this->load->model('ordersmodel');
        $data['json']=$this->ordersmodel->deleteone();
		$this->load->view('json',$data);
	}
	function makeorder() 
	{
        $this->db->query("SET time_zone='+05:30'");
		$order=json_decode(file_get_contents('php://input'));
		$cart=$order->cart;
		$user=$order->user;
		$retailer=$order->retailer;
		$total=0;
		$totalquantity=0;
			
		if($user->id<1)
		{
			$order=false;
		}
		else {
		foreach($cart as $product)
		{
			$total+=floatval($product->totalprice);
			$totalquantity+=floatval($product->quantity);
		}
		
		/*
		$retailerdistributor=$this->db->query("SELECT `retailer`.`id`,`retailer`.`area`,`retailer`.`email`,`retailer`.`number`,`area`.`id`,`area`.`distributor`,`distributor`.`id`,`distributor`.`contactno` FROM `retailer` INNER JOIN `area` ON `retailer`.`area`=`area`.`id` INNER JOIN `distributor` ON `area`.`distributor`=`distributor`.`id` WHERE `retailer`.`id`='$retailer->id'")->row();
		$email=$retailerdistributor->email;
                 echo "hello";
                echo $email;
	        $this->load->library('email');
	        $this->email->from('toycraft@toycraft.co.uk', 'toycraft');
	        $this->email->to($email);
	        $this->email->subject('Order');
	        $this->email->message('email send');
	        $this->email->send();
		$data['json']= $this->email->print_debugger();
		*/
		
		
		$this->db->query("INSERT INTO `orders` (`id`, `retail`, `sales`, `timestamp`, `amount`,`quantity`, `signature`, `salesid`,`remark`) VALUES (NULL, '$retailer->id', '$user->name', CURRENT_TIMESTAMP, '$total','$totalquantity', '1', '$user->id','$retailer->remark')");
		
		$orderid=$this->db->insert_id();
		
		foreach($cart as $product)
		{
			$this->db->query("INSERT INTO `orderproduct` (`id`, `order`,`productcode`, `product`, `quantity`, `amount`, `scheme_id`, `status`,`category`) VALUES (NULL, '$orderid', '$product->productcode','$product->id', '$product->quantity', '$product->totalprice', '0', '1','$product->category')");
		}
		}
		$data['json']= $this->db->query("SELECT * FROM `orders` WHERE `id`='$orderid'")->row();
		$data['json']= $this->db->query("SELECT * FROM `orders` WHERE `id`='$orderid'")->row();
		
		$this->load->view('json',$data);
	}
	public function findbyuser()
	{
        $this->load->model('ordersmodel');
        $user=$this->input->get("user");
        $data['json']=$this->ordersmodel->viewallwithuser($user);
		$this->load->view('json',$data);
	}
	public function findbyretailer()
	{
	        $this->load->model('ordersmodel');
	        $retailer=$this->input->get("retailer");
	        $data['json']=$this->ordersmodel->viewallwithretailer($retailer);
		$this->load->view('json',$data);
	}
	public function getmonthstally()
	{
	        $this->load->model('ordersmodel');
	        $user=$this->input->get("user");
	        $data['json']=$this->ordersmodel->getmonthstally($user);
		$this->load->view('json',$data);
	}
	public function gettodaystally()
	{
	        $this->load->model('ordersmodel');
	        $user=$this->input->get("user");
	        $data['json']=$this->ordersmodel->gettodaystally($user);
		$this->load->view('json',$data);
	}
	
	public function getmyordersbydate()
	{
	        $this->load->model('ordersmodel');
	        $user=$this->input->get("user");
	        $date=$this->input->get("date");
	        $data['json']=$this->ordersmodel->getmyordersbydate($user,$date);
		$this->load->view('json',$data);
	}
	public function getmyordersbyretailer()
	{
	        $this->load->model('ordersmodel');
	        $user=$this->input->get("user");
	        $retailer=$this->input->get("retailer");
	        $data['json']=$this->ordersmodel->getmyordersbyretailer($user,$retailer);
		$this->load->view('json',$data);
	}
}