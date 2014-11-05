<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class City extends CI_Controller {

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
        $this->load->model('citymodel');
        $data['json']=$this->citymodel->insertcity();
		$this->load->view('json',$data);
	}
    public function update()
	{
        $this->load->model('citymodel');
        $data['json']=$this->citymodel->updatecity();
		$this->load->view('json',$data);
	}
	public function find()
	{
		$this->load->model('citymodel');
        $data['json']=$this->citymodel->viewall();
		$this->load->view('json',$data);
	}
    public function findone()
	{
        //$id=$this->input->get('id');
        $this->load->model('citymodel');
        $data['json']=$this->citymodel->viewone();
		$this->load->view('json',$data);
	}
    public function delete()
	{
        $this->load->model('citymodel');
        $data['json']=$this->citymodel->deleteone();
		$this->load->view('json',$data);
	}
	
	public function findbystate()
	{
        $this->load->model('citymodel');
        $state=$this->input->get("state");
        $data['json']=$this->citymodel->viewallwithstate($state);
		$this->load->view('json',$data);
	}
}