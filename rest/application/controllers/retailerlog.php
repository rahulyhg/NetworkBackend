<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Retailerlog extends CI_Controller {

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
        $this->load->model('retailerlogmodel');
        $data['json']=$this->retailerlogmodel->insertretailerlog();
		$this->load->view('json',$data);
	}
    public function update()
	{
        $this->load->model('retailerlogmodel');
        $data['json']=$this->retailerlogmodel->updateretailerlog();
		$this->load->view('json',$data);
	}
	public function find()
	{
		$this->load->model('retailerlogmodel');
        $data['json']=$this->retailerlogmodel->viewall();
		$this->load->view('json',$data);
	}
    public function findone()
	{
        //$id=$this->input->get('id');
        $this->load->model('retailerlogmodel');
        $data['json']=$this->retailerlogmodel->viewone();
		$this->load->view('json',$data);
	}
    public function delete()
	{
        $this->load->model('retailerlogmodel');
        $data['json']=$this->retailerlogmodel->deleteone();
		$this->load->view('json',$data);
	}
}