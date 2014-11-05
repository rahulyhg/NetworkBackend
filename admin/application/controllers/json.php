<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Json extends CI_Controller 
{
	
	function savequantity()
	{
		$product=$this->input->get_post('product');
		$quantity=$this->input->get_post('quantity');
		$data["message"]=$this->product_model->savequantity($product,$quantity);
		$this->load->view("json",$data);
	}
	function uploadfile() {
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = '*|gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="file";
			$logo="";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
			}
			$data[ 'message' ] = $uploaddata;
			$this->load->view( 'json', $data );
			
	}
}
?>