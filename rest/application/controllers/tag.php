<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tag extends CI_Controller {

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
        $this->load->model('tagmodel');
        $data['json']=$this->tagmodel->inserttag();
		$this->load->view('json',$data);
	}
    public function update()
	{
        $this->load->model('tagmodel');
        $data['json']=$this->tagmodel->updatetag();
		$this->load->view('json',$data);
	}
	public function find()
	{
		$this->load->model('tagmodel');
        $data['json']=$this->tagmodel->viewall();
		$this->load->view('json',$data);
	}
    public function findone()
	{
        //$id=$this->input->get('id');
        $this->load->model('tagmodel');
        $data['json']=$this->tagmodel->viewone();
		$this->load->view('json',$data);
	}
    public function delete()
	{
        $this->load->model('tagmodel');
        $data['json']=$this->tagmodel->deleteone();
		$this->load->view('json',$data);
	}
}