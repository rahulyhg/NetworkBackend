<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Retailer extends CI_Controller {

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
        $this->load->model('retailermodel');
        $data['json']=$this->retailermodel->insertretailer();
		$this->load->view('json',$data);
	}
    public function update()
	{
        $this->load->model('retailermodel');
        $data['json']=$this->retailermodel->updateretailer();
		$this->load->view('json',$data);
	}
	public function find()
	{
		$this->load->model('retailermodel');
        $data['json']=$this->retailermodel->viewall();
		$this->load->view('json',$data);
	}
    public function findone()
	{
        //$id=$this->input->get('id');
        $this->load->model('retailermodel');
        $data['json']=$this->retailermodel->viewone();
		$this->load->view('json',$data);
	}
	
	public function updatecontact()
	{
        //$id=$this->input->get('id');
        $this->load->model('retailermodel');
        $data['json']=$this->retailermodel->contactedit();
		$this->load->view('json',$data);
	}
	
    public function delete()
	{
        $this->load->model('retailermodel');
        $data['json']=$this->retailermodel->deleteone();
		$this->load->view('json',$data);
	}
	public function findbyarea()
	{
        $this->load->model('retailermodel');
        $area=$this->input->get("area");
        $data['json']=$this->retailermodel->viewallwitharea($area);
		$this->load->view('json',$data);
	}
}