<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class State extends CI_Controller {

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
        $this->load->model('statemodel');
        $data['json']=$this->statemodel->insertstate();
		$this->load->view('json',$data);
	}
    public function update()
	{
        $this->load->model('statemodel');
        $data['json']=$this->statemodel->updatestate();
		$this->load->view('json',$data);
	}
	public function find()
	{
		$this->load->model('statemodel');
        $data['json']=$this->statemodel->viewall();
		$this->load->view('json',$data);
	}
    public function findone()
	{
        //$id=$this->input->get('id');
        $this->load->model('statemodel');
        $data['json']=$this->statemodel->viewone();
		$this->load->view('json',$data);
	}
    public function delete()
	{
        $this->load->model('statemodel');
        $data['json']=$this->statemodel->deleteone();
		$this->load->view('json',$data);
	}
	public function findbyzone()
	{
        $this->load->model('statemodel');
        $zone=$this->input->get("zone");
        $data['json']=$this->statemodel->viewallwithzone($zone);
		$this->load->view('json',$data);
	}
}