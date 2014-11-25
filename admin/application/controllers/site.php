<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Site extends CI_Controller 
{
	public function __construct( )
	{
		parent::__construct();
		
		$this->is_logged_in();
	}
	function is_logged_in( )
	{
		$is_logged_in = $this->session->userdata( 'logged_in' );
		if ( $is_logged_in !== 'true' || !isset( $is_logged_in ) ) {
			redirect( base_url() . 'index.php/login', 'refresh' );
		} //$is_logged_in !== 'true' || !isset( $is_logged_in )
	}
	function checkaccess($access)
	{
		$accesslevel=$this->session->userdata('accesslevel');
		if(!in_array($accesslevel,$access))
			redirect( base_url() . 'index.php/site?alerterror=You do not have access to this page. ', 'refresh' );
	}

	public function index()
	{
		//$access = array("1","2");
		$access = array("1","2");
		$this->checkaccess($access);
//        $currentdate=date('Y-m-d',strtotime("-1 days"));
//        echo $currentdate;
        $query=$this->db->query("SELECT `users`.`name`,SUM(`orders`.`quantity`) as `y` FROM `orders` RIGHT OUTER JOIN `users` ON `users`.`id`=`orders`.`salesid` WHERE DATE(`orders`.`timestamp`)=DATE(NOW()) GROUP BY `users`.`id`")->result();
        foreach($query as $row)
        {
            $row->y=intval($row->y);
        }
        $data["values"]=json_encode($query);
        $data['retailer']=$this->retailer_model->getretailersinceyesterday();
        $data['topproducts']=$this->retailer_model->gettopproducts();
        $data['userdetailswithlastlogin']=$this->user_model->getuserlastlogin();
//        $data['users']=$this->user_model->getuserlastlogin();
        $data['noofretailers']=sizeof($data['retailer']);
		$data[ 'page' ] = 'dashboard';
		$data[ 'title' ] = 'Welcome';
		$this->load->view( 'template', $data );	
	}
	public function dashboardzonewise()
	{
		//$access = array("1","2");
		$access = array("1","2");
		$this->checkaccess($access);
//        $currentdate=date('Y-m-d',strtotime("-1 days"));
//        echo $currentdate;
        $data['retailer']=$this->retailer_model->getretailersinceyesterdaywithzone();
        $data['noofretailers']=sizeof($data['retailer']);
		$data[ 'page' ] = 'dashboardzonewise';
		$data[ 'title' ] = 'Welcome';
		$this->load->view( 'template', $data );	
	}
	public function dashboardstatewise()
	{
		//$access = array("1","2");
		$access = array("1","2");
		$this->checkaccess($access);
//        $currentdate=date('Y-m-d',strtotime("-1 days"));
//        echo $currentdate;
        $data['retailer']=$this->retailer_model->getretailersinceyesterdaywithstate($this->input->get('zoneid'));
        $data['noofretailers']=sizeof($data['retailer']);
		$data[ 'page' ] = 'dashboardstatewise';
		$data[ 'title' ] = 'Welcome';
		$this->load->view( 'template', $data );	
	}
	public function dashboardcitywise()
	{
		//$access = array("1","2");
		$access = array("1","2");
		$this->checkaccess($access);
//        $currentdate=date('Y-m-d',strtotime("-1 days"));
//        echo $currentdate;
        $data['retailer']=$this->retailer_model->getretailersinceyesterdaywithcity($this->input->get('stateid'));
        $data['noofretailers']=sizeof($data['retailer']);
		$data[ 'page' ] = 'dashboardcitywise';
		$data[ 'title' ] = 'Welcome';
		$this->load->view( 'template', $data );	
	}
	public function dashboardareawise()
	{
		//$access = array("1","2");
		$access = array("1","2");
		$this->checkaccess($access);
//        $currentdate=date('Y-m-d',strtotime("-1 days"));
//        echo $currentdate;
        $data['retailer']=$this->retailer_model->getretailersinceyesterdaywitharea($this->input->get('cityid'));
        $data['noofretailers']=sizeof($data['retailer']);
		$data[ 'page' ] = 'dashboardareawise';
		$data[ 'title' ] = 'Welcome';
		$this->load->view( 'template', $data );	
	}
	public function dashboardretailersareawise()
	{
		//$access = array("1","2");
		$access = array("1","2");
		$this->checkaccess($access);
//        $currentdate=date('Y-m-d',strtotime("-1 days"));
//        echo $currentdate;
        $data['retailer']=$this->retailer_model->dashboardretailersareawise($this->input->get('areaid'));
        $data['noofretailers']=sizeof($data['retailer']);
		$data[ 'page' ] = 'dashboardretailersareawise';
		$data[ 'title' ] = 'Welcome';
		$this->load->view( 'template', $data );	
	}
	public function createuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data['zone']=$this->user_model->getzonedropdown();
		$data[ 'page' ] = 'createuser';
		$data[ 'title' ] = 'Create User';
		$this->load->view( 'template', $data );	
	}
	function createusersubmit()
	{
       
		$access = array("1","2");
		$this->checkaccess($access);
       
		$this->form_validation->set_rules('firstname','First Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('username','UserName','trim|required|max_length[30]');
		$this->form_validation->set_rules('password','Password','trim|required|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|required|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('contact','contact','trim');
		$this->form_validation->set_rules('zone','zone','trim');
		
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data['zone']=$this->user_model->getzonedropdown();
			$data['page']='createuser';
			$data['title']='Create New User';
			$this->load->view('template',$data);
		}
		else
		{
             
			$password=$this->input->post('password');
			
			$accesslevel=$this->input->post('accesslevel');
			$username=$this->input->post('username');
			$email=$this->input->post('email');
			$contact=$this->input->post('contact');
			//$facebookuserid=$this->input->post('facebookuserid');
			$name=$this->input->post('firstname');
			$zone=$this->input->post('zone');
			if($this->user_model->create($name,$password,$accesslevel,$email,$contact,$zone,$username)==0)
			$data['alerterror']="New user could not be created.";
			else
			$data['alertsuccess']="User created Successfully.";
			
			$data['table']=$this->user_model->viewusers();
			$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
	function viewusers()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewusers';
		
        $bothval=$this->user_model->viewusers();
        $data['table']=$bothval->query;
        
        $this->load->library('pagination');
        $config['base_url'] = site_url("site/viewusers");
        $config['total_rows']=$bothval->totalcount;
        $this->pagination->initialize($config); 
        
        $data['title']='View Users';
		$this->load->view('template',$data);
	}
    
    function viewsponsor()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->sponsor_model->viewall();
		$data['page']='viewsponsor';
		$data['title']='View Sponsor';
		$this->load->view('template',$data);
	}
	function viewuserinterestevents()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->user_model->beforeedit($this->input->get('id'));
		$data['table']=$this->user_model->userinterestevents($this->input->get('id'));
		$data['page']='viewuserinterestevents';
		$data['page2']='block/userblock';
		$data['title']='View User Interest Events';
		$this->load->view('template',$data);
	}
	function edituser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data['zone']=$this->user_model->getzonedropdown();
		$data['before']=$this->user_model->beforeedit($this->input->get('id'));
		$data['page']='edituser';
		//$data['page2']='block/userblock';
		$data['title']='Edit User';
		$this->load->view('template',$data);
	}
	function editusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('password','Password','trim|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|matches[password]');
		
		$this->form_validation->set_rules('firstname','First Name','trim|max_length[30]');
		$this->form_validation->set_rules('username','UserName','trim|max_length[30]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
		
		$this->form_validation->set_rules('zone','zone','trim|max_length[20]');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data['zone']=$this->user_model->getzonedropdown();
            $data['before']=$this->user_model->beforeedit($this->input->get('id'));
			$data['page']='edituser';
			$data['page2']='block/userblock';
			$data['title']='Edit User';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
           
            $zone=$this->input->post('zone');
            $username=$this->input->post('username');
			$password=$this->input->post('password');
			
			$accesslevel=$this->input->post('accesslevel');
			$email=$this->input->post('email');
			$contact=$this->input->post('contact');
			//$facebookuserid=$this->input->post('facebookuserid');
			$name=$this->input->post('firstname');
			
			if($this->user_model->edit($id,$name,$password,$accesslevel,$email,$contact,$zone,$username)==0)
			$data['alerterror']="User Editing was unsuccesful";
			else
			$data['alertsuccess']="User edited Successfully.";
			
			$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	function editaddress()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data['before']=$this->user_model->beforeedit($this->input->get('id'));
		$data['page']='editaddress';
		$data['page2']='block/userblock';
		$data['title']='Edit User';
		$this->load->view('template',$data);
	}
	function editaddresssubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('address','address','trim');
		$this->form_validation->set_rules('facebookuserid','facebookuserid','trim');
		$this->form_validation->set_rules('city','city','trim');
		$this->form_validation->set_rules('pincode','pincode','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->user_model->getstatusdropdown();
			$data['accesslevel']=$this->user_model->getaccesslevels();
			$data['before']=$this->user_model->beforeedit($this->input->post('id'));
			$data['page']='editaddress';
			$data['page2']='block/userblock';
			$data['title']='Edit User';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			$address=$this->input->post('address');
			$city=$this->input->post('city');
			$pincode=$this->input->post('pincode');
			if($this->user_model->editaddress($id,$address,$city,$pincode)==0)
			$data['alerterror']="User Editing was unsuccesful";
			else
			$data['alertsuccess']="User edited Successfully.";
			$data['table']=$this->user_model->viewusers();
			$data['redirect']="site/editaddress?id=".$id;
			//$data['other']="template=$template";
			$this->load->view("redirect2",$data);
			
		}
	}
	function deleteuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->deleteuser($this->input->get('id'));
		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="User Deleted Successfully";
		$data['page']='viewusers';
		$data['title']='View Users';
		$this->load->view('template',$data);
	}
	function changeuserstatus()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->changestatus($this->input->get('id'));
		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="Status Changed Successfully";
		$data['redirect']="site/viewusers";
        //$data['other']="template=$template";
        $this->load->view("redirect",$data);
	}
    
    function changesponsorstatus()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->sponsor_model->changestatus($this->input->get('user'),$this->input->get('event'));
		$data['table']=$this->sponsor_model->viewall();
		$data['alertsuccess']="Status Changed Successfully";
        
		$data['redirect']="site/viewsponsor";
        
        $this->load->view("redirect",$data);
	}
    
    
    /*-----------------User/Organizer Finctions added by avinash for frontend APIs---------------*/
    public function update()
	{
        $id=$this->input->get('id');
        $firstname=$this->input->get('firstname');
        $lastname=$this->input->get('lastname');
        $password=$this->input->get('password');
        $password=md5($password);
        $email=$this->input->get('email');
        $website=$this->input->get('website');
        $description=$this->input->get('description');
        $eventinfo=$this->input->get('eventinfo');
        $contact=$this->input->get('contact');
        $address=$this->input->get('address');
        $city=$this->input->get('city');
        $pincode=$this->input->get('pincode');
        $dob=$this->input->get('dob');
       // $accesslevel=$this->input->get('accesslevel');
        $accesslevel=2;
        $timestamp=$this->input->get('timestamp');
        $facebookuserid=$this->input->get('facebookuserid');
        $newsletterstatus=$this->input->get('newsletterstatus');
        $status=$this->input->get('status');
        $logo=$this->input->get('logo');
        $showwebsite=$this->input->get('showwebsite');
        $eventsheld=$this->input->get('eventsheld');
        $topeventlocation=$this->input->get('topeventlocation');
        $data['json']=$this->user_model->update($id,$firstname,$lastname,$password,$email,$website,$description,$eventinfo,$contact,$address,$city,$pincode,$dob,$accesslevel,$timestamp,$facebookuserid,$newsletterstatus,$status,$logo,$showwebsite,$eventsheld,$topeventlocation);
        print_r($data);
		//$this->load->view('json',$data);
	}
	public function finduser()
	{
        $data['json']=$this->user_model->viewall();
        print_r($data);
		//$this->load->view('json',$data);
	}
    public function findoneuser()
	{
        $id=$this->input->get('id');
        $data['json']=$this->user_model->viewone($id);
        print_r($data);
		//$this->load->view('json',$data);
	}
    public function deleteoneuser()
	{
        $id=$this->input->get('id');
        $data['json']=$this->user_model->deleteone($id);
		//$this->load->view('json',$data);
	}
    public function login()
    {
        $email=$this->input->get("email");
        $password=$this->input->get("password");
        $data['json']=$this->user_model->login($email,$password);
        //$this->load->view('json',$data);
    }
    public function authenticate()
    {
        $data['json']=$this->user_model->authenticate();
        //$this->load->view('json',$data);
    }
    public function signup()
    {
        $email=$this->input->get_post("email");
        $password=$this->input->get_post("password");
        $data['json']=$this->user_model->signup($email,$password);
        //$this->load->view('json',$data);
        
    }
    public function logout()
    {
        $this->session->sess_destroy();
        $data['json']=true;
        //$this->load->view('json',$data);
    }
    
    
    
    /*-----------------End of User/Organizer functions----------------------------------*/
    
    
    
	//category
    
    
    function viewcategory()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewcategory';
        
        
        $data['base_url'] = site_url("site/viewcategoryjson");
        
        
		$data['title']='View Category';
		$this->load->view('template',$data);
	} 
    
    function viewcategoryjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
//        SELECT `catelog`.`id`,`catelog`.`name`,`tab2`.`name` as `parent`,`catelog`.`order` FROM `catelog` LEFT JOIN `catelog` as `tab2` ON `tab2`.`id`=`catelog`.`parent`
            
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`catelog`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]->field="`catelog`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Category";
        $elements[1]->alias="categoryname";
        
        $elements[2]->field="`tab2`.`name`";
        $elements[2]->sort="1";
        $elements[2]->header="Parent";
        $elements[2]->alias="parent";
        
        $elements[3]->field="`catelog`.`order`";
        $elements[3]->sort="1";
        $elements[3]->header="Order";
        $elements[3]->alias="order";
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `catelog` LEFT JOIN `catelog` as `tab2` ON `tab2`.`id`=`catelog`.`parent`");
        
		$this->load->view("json",$data);
	} 
	function viewsubcategory()
	{
		$access = array("1");
		$this->checkaccess($access);
		//$data['table']=$this->category_model->viewsubcategory();
        $brandid=$this->input->get('brandid');
        $categoryid=$this->input->get('id');
        $data['check']=$this->category_model->selectedcategory($brandid,$categoryid);
        $data['brandcategoryid']=$this->category_model->getbrandcategoryid($brandid,$categoryid);
		$data['page']='viewsubcategory';
		$data['title']='View Sub-category';
		$this->load->view('template',$data);
	}
     function editsubcategorysubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('brandcategoryid','brandcategoryid','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$brandid=$this->input->get('brandid');
        $categoryid=$this->input->get('id');
        $data['check']=$this->category_model->selectedcategory($brandid,$categoryid);
        $data['brandcategoryid']=$this->category_model->getbrandcategoryid($brandid,$categoryid);
		$data['page']='viewsubcategory';
		$data['title']='View Sub-category';
		$this->load->view('template',$data);
		}
		else
		{
			$brandcategoryid=$this->input->post('brandcategoryid');
			$men=$this->input->post('men');
			$women=$this->input->post('women');
			$kids=$this->input->post('kids');
            echo "men=".$men;
            if($men=="1")
               {
                $this->category_model->editsubcategorysubmit($brandcategoryid,$men);
                
               }
               else
               {
                   echo "else";
               $this->category_model->deletesubcategorysubmit($brandcategoryid,1);
               }
               
            if($women=="2")
               {
                $this->category_model->editsubcategorysubmit($brandcategoryid,$women);
               }
               else
               {
               $this->category_model->deletesubcategorysubmit($brandcategoryid,2);
               }
            if($kids=="3")
               {
                $this->category_model->editsubcategorysubmit($brandcategoryid,$kids);
               }
               else
               {
               $this->category_model->deletesubcategorysubmit($brandcategoryid,3);
               }
			$brandid=$this->input->get('brandid');
        $categoryid=$this->input->get('id');
        $data['check']=$this->category_model->selectedcategory($brandid,$categoryid);
        $data['brandcategoryid']=$this->category_model->getbrandcategoryid($brandid,$categoryid);
		$data['page']='viewsubcategory';
		$data['title']='View Sub-category';
		$this->load->view('template',$data);
			//$data['other']="template=$template";
			//$this->load->view("redirect",$data);
			/*$data['page']='viewusers';
			$data['title']='View Users';
			$this->load->view('template',$data);*/
		}
	}
	public function createcategory()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'status' ] =$this->category_model->getstatusdropdown();
		$data['category']=$this->category_model->getcategorydropdown();
		$data[ 'page' ] = 'createcategory';
		$data[ 'title' ] = 'Create category';
		$this->load->view( 'template', $data );	
	}
    public function createbrandcategory()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'status' ] =$this->category_model->getstatusdropdown();
		$data['category']=$this->category_model->getcategorydropdown();
		$data[ 'page' ] = 'createbrandcategory';
		$data[ 'title' ] = 'Create Brand category';
		$this->load->view( 'template', $data );	
	}
	function createcategorysubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('parent','parent','trim|');
		$this->form_validation->set_rules('status','status','trim|');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->category_model->getstatusdropdown();
			$data['category']=$this->category_model->getcategorydropdown();
			$data[ 'page' ] = 'createcategory';
			$data[ 'title' ] = 'Create category';
			$this->load->view('template',$data);
		}
		else
		{
			$name=$this->input->post('name');
			$parent=$this->input->post('parent');
			$status=$this->input->post('status');
			if($this->category_model->createcategory($name,$parent,$status)==0)
			$data['alerterror']="New category could not be created.";
			else
			$data['alertsuccess']="category  created Successfully.";
			$data['table']=$this->category_model->viewcategory();
			$data['redirect']="site/viewcategory";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
    function createbrandcategorysubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		//$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('brandid','Brandid','trim|');
		$this->form_validation->set_rules('category','Category','trim|');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->category_model->getstatusdropdown();
			$data['category']=$this->category_model->getcategorydropdown();
			$data[ 'page' ] = 'createcategory';
			$data[ 'title' ] = 'Create category';
			$this->load->view('template',$data);
		}
		else
		{
			$brandid=$this->input->get_post('brandid');
			$categoryid=$this->input->post('category');
			$parent=$this->input->post('parent');
			$status=$this->input->post('status');
			if($this->category_model->createbrandcategory($brandid,$categoryid)==0)
			$data['alerterror']="New Brand category could not be created.";
			else
			$data['alertsuccess']="Brand category  created Successfully.";
			$data['table']=$this->category_model->viewonebrandcategories($brandid);
			$data['redirect']="site/viewonebrandcategories?brandid=".$brandid;
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
	function viewonebrandcategories()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->category_model->viewonebrandcategories($this->input->get('brandid'));
		$data['tablemain']=$this->category_model->viewmaincategory();
		$data['hastypes']=$this->category_model->viewcategorytypes();
		$data['subcategory']=$this->category_model->viewallsubcategory();
        $data['category']=$this->brand_model->getcategory();
		$data['page']='viewonebrandcategories';
		$data['title']='View category';
		$this->load->view('template',$data);
	}
	function editcategory()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->category_model->beforeeditcategory($this->input->get('id'));
		$data['category']=$this->category_model->getcategorydropdown();
		$data[ 'status' ] =$this->category_model->getstatusdropdown();
		$data['page']='editcategory';
		$data['title']='Edit category';
		$this->load->view('template',$data);
	}
	function editcategorysubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('parent','parent','trim|');
		$this->form_validation->set_rules('status','status','trim|');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->category_model->getstatusdropdown();
			$data['category']=$this->category_model->getcategorydropdown();
			$data['before']=$this->category_model->beforeeditcategory($this->input->post('id'));
			$data['page']='editcategory';
			$data['title']='Edit category';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			$name=$this->input->post('name');
			$parent=$this->input->post('parent');
			$status=$this->input->post('status');
			
			if($this->category_model->editcategory($id,$name,$parent,$status)==0)
			$data['alerterror']="category Editing was unsuccesful";
			else
			$data['alertsuccess']="category edited Successfully.";
			$data['table']=$this->category_model->viewcategory();
			$data['redirect']="site/viewcategory";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			/*$data['page']='viewusers';
			$data['title']='View Users';
			$this->load->view('template',$data);*/
		}
	}
   
	function deletecategory()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->category_model->deletecategory($this->input->get('id'));
		$data['table']=$this->category_model->viewcategory();
		$data['alertsuccess']="category Deleted Successfully";
		$data['page']='viewcategory';
		$data['title']='View category';
		$this->load->view('template',$data);
	}
	
	//topic
    //Offer
	public function createoffer()
	{
		$access = array("1");
		$this->checkaccess($access);
		//$data[ 'status' ] =$this->user_model->getstatusdropdown();
		//$data['topic']=$this->topic_model->gettopicdropdown();
        $data['brand']=$this->brand_model->getbranddropdown();
		$data[ 'page' ] = 'createoffer';
		$data[ 'title' ] = 'Create offer';
		$this->load->view( 'template', $data );	
	}
	function createoffersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
        print_r($_POST);
		$this->form_validation->set_rules('header','header','trim|required');
		$this->form_validation->set_rules('description','description','trim|');
		$this->form_validation->set_rules('from','From','trim');
		$this->form_validation->set_rules('to','To','trim');
		$this->form_validation->set_rules('brand','Brand','trim');
		$this->form_validation->set_rules('storeid','storeid','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
//			$data[ 'status' ] =$this->user_model->getstatusdropdown();
//			$data['offer']=$this->offer_model->getofferdropdown();
			$data[ 'page' ] = 'createoffer';
			$data[ 'title' ] = 'Create offer';
			$this->load->view('template',$data);
		}
		else
		{
			$header=$this->input->post('header');
			$description=$this->input->post('description');
			$from=$this->input->post('from');
			$to=$this->input->post('to');
			$brand=$this->input->post('brand');
			$storeid=$this->input->post('storeid');
            if($from != "")
			{
				$from = date("Y-m-d",strtotime($from));
			}
            if($to != "")
			{
				$to = date("Y-m-d",strtotime($to));
			}
			if($this->offer_model->createoffer($header,$description,$from,$to,$brand,$storeid)==0)
			$data['alerterror']="New offer could not be created.";
			else
			$data['alertsuccess']="offer  created Successfully.";
			$data['table']=$this->offer_model->viewoffer();
			$data['redirect']="site/viewoffer";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
    
    //image gallery
     function viewgallery()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->imagegallery_model->viewgallery();
		$data['page']='viewgallery';
		$data['title']='View gallery';
		$this->load->view('template',$data);
	}     
    
	public function creategallery()
	{
		$access = array("1");
		$this->checkaccess($access);
		//$data[ 'status' ] =$this->user_model->getstatusdropdown();
		//$data['topic']=$this->topic_model->gettopicdropdown();
        $data['brand']=$this->brand_model->getbranddropdown();
		$data[ 'page' ] = 'creategallery';
		$data[ 'title' ] = 'Create Gallery';
		$this->load->view( 'template', $data );	
	}
	
    function creategallerysubmit()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		//$this->form_validation->set_rules('image','Image','trim|required');
		$this->form_validation->set_rules('description','Description','trim|required');
		$this->form_validation->set_rules('brand','brand','trim');
		$this->form_validation->set_rules('storeid','storeid','trim');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			
            $data['brand']=$this->brand_model->getbranddropdown();
            $data[ 'page' ] = 'creategallery';
            $data[ 'title' ] = 'Create Gallery';
            $this->load->view( 'template', $data );	
		}
		else
		{
			//$image=$this->input->post('image');
			$brand=$this->input->post('brand');
			$description=$this->input->post('description');
			$storeid=$this->input->post('storeid');
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$logo="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
			}
			if($this->imagegallery_model->create($image,$description,$brand,$storeid)==0)
			$data['alerterror']="New Image in gallery could not be created.";
			else
			$data['alertsuccess']="Image in gallery created Successfully.";
			
			$data['table']=$this->imagegallery_model->viewgallery();
			$data['redirect']="site/viewgallery";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}

    
	function editgallery()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->imagegallery_model->beforeedit($this->input->get('id'));
        $data['store']=$this->store_model->getstorebybrand($data['before']->brandid);
        $data['brand']=$this->brand_model->getbranddropdown();
		$data['page']='editgallery';
		$data['title']='Edit Gallery';
		$this->load->view('template',$data);
	}
    
    function editgallerysubmit()
	{
		$access = array("1","2");
		$this->checkaccess($access);
        
		$this->form_validation->set_rules('description','Description','trim|required');
		$this->form_validation->set_rules('brand','brand','trim');
		$this->form_validation->set_rules('storeid','storeid','trim');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
//			$data['organizer']=$this->organizer_model->getorganizer();
//			$data['listingtype']=$this->event_model->getlistingtype();
//			$data['remainingticket']=$this->event_model->getremainingticket();
            $data['alerterror'] = validation_errors();
			
            $data['brand']=$this->brand_model->getbranddropdown();
			$data['before']=$this->imagegallery_model->beforeedit($this->input->post('id'));
//			$data['page2']='block/eventblock';
			$data['page']='editgallery';
			$data['title']='Edit Gallery';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			$brand=$this->input->post('brand');
			$description=$this->input->post('description');
			$storeid=$this->input->post('storeid');
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
			}
            if($image=="")
            {
            $image=$this->imagegallery_model->getimagebyid($id);
               // print_r($image);
                $image=$image->image;
            }
			if($this->imagegallery_model->edit($id,$image,$description,$brand,$storeid)==0)
			$data['alerterror']="Image Gallery Editing was unsuccesful";
			else
			$data['alertsuccess']="Image Gallery edited Successfully.";
			
			$data['redirect']="site/viewgallery";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deletegallery()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->imagegallery_model->deletegallery($this->input->get('id'));
		$data['table']=$this->imagegallery_model->viewgallery();
		$data['alertsuccess']="Image Deleted Successfully";
		$data['page']='viewgallery';
		$data['title']='View Image Gallery';
		$this->load->view('template',$data);
	}
    
    
    
    //new in
    
     function viewnewin()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->imagegallery_model->viewnewin();
		$data['page']='viewnewin';
		$data['title']='View New In';
		$this->load->view('template',$data);
	}  
    
     
	public function createnewin()
	{
		$access = array("1");
		$this->checkaccess($access);
        $data['brand']=$this->brand_model->getbranddropdown();
		$data[ 'page' ] = 'createnewin';
		$data[ 'title' ] = 'Create New In';
		$this->load->view( 'template', $data );	
	}
    function createnewinsubmit()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		//$this->form_validation->set_rules('image','Image','trim|required');
		$this->form_validation->set_rules('description','Description','trim|required');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			
            $data['brand']=$this->brand_model->getbranddropdown();
            $data[ 'page' ] = 'createnewin';
            $data[ 'title' ] = 'Create New In';
            $this->load->view( 'template', $data );	
		}
		else
		{
			//$image=$this->input->post('image');
			$description=$this->input->post('description');
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$logo="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
			}
			if($this->imagegallery_model->createnewin($image,$description)==0)
			$data['alerterror']="New In could not be created.";
			else
			$data['alertsuccess']="New In created Successfully.";
			
			$data['table']=$this->imagegallery_model->viewnewin();
			$data['redirect']="site/viewnewin";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}

    
	function editnewin()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->imagegallery_model->beforeeditnewin($this->input->get('id'));
        $data['brand']=$this->brand_model->getbranddropdown();
		$data['page']='editnewin';
		$data['title']='Edit New in';
		$this->load->view('template',$data);
	}
    
    function editnewinsubmit()
	{
		$access = array("1","2");
		$this->checkaccess($access);
        
		$this->form_validation->set_rules('description','Description','trim|required');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
//			$data['organizer']=$this->organizer_model->getorganizer();
//			$data['listingtype']=$this->event_model->getlistingtype();
//			$data['remainingticket']=$this->event_model->getremainingticket();
            $data['alerterror'] = validation_errors();
			
            $data['brand']=$this->brand_model->getbranddropdown();
			$data['before']=$this->imagegallery_model->beforeeditnewin($this->input->post('id'));
//			$data['page2']='block/eventblock';
			$data['page']='editnewin';
			$data['title']='Edit New in';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			$description=$this->input->post('description');
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
			}
            
            if($image=="")
            {
            $image=$this->imagegallery_model->getnewinimagebyid($id);
               // print_r($image);
                $image=$image->image;
            }
			if($this->imagegallery_model->editnewin($id,$image,$description)==0)
			$data['alerterror']="New In Editing was unsuccesful";
			else
			$data['alertsuccess']="New In edited Successfully.";
			
			$data['redirect']="site/viewnewin";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deletenewin()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->imagegallery_model->deletenewin($this->input->get('id'));
		$data['table']=$this->imagegallery_model->viewnewin();
		$data['alertsuccess']="New In Deleted Successfully";
		$data['page']='viewnewin';
		$data['title']='View New In';
		$this->load->view('template',$data);
	}
    
    
    
    
    
	function viewoffer()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->offer_model->viewoffer();
		$data['page']='viewoffer';
		$data['title']='View offer';
		$this->load->view('template',$data);
	}
	function editoffer()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->offer_model->beforeeditoffer($this->input->get('id'));
//        print_r($data);
//        echo $data['before']->brandid;
        $data['store']=$this->store_model->getstorebybrand($data['before']->brandid);
//		$data['offer']=$this->offer_model->getofferdropdown();
//		$data[ 'status' ] =$this->user_model->getstatusdropdown();
        $data['brand']=$this->brand_model->getbranddropdown();
		$data['page']='editoffer';
		$data['title']='Edit offer';
		$this->load->view('template',$data);
	}
	function editoffersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('header','header','trim|required');
		$this->form_validation->set_rules('description','description','trim|');
		$this->form_validation->set_rules('from','From','trim');
		$this->form_validation->set_rules('to','To','trim');
		$this->form_validation->set_rules('brand','Brand','trim');
		$this->form_validation->set_rules('storeid','storeid','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
//			$data[ 'status' ] =$this->user_model->getstatusdropdown();
//			$data['topic']=$this->topic_model->gettopicdropdown();
			$data['before']=$this->offer_model->beforeeditoffer($this->input->post('id'));
			$data['page']='editoffer';
			$data['title']='Edit offer';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			$header=$this->input->post('header');
			$description=$this->input->post('description');
			$from=$this->input->post('from');
			$to=$this->input->post('to');
			$brand=$this->input->post('brand');
			$storeid=$this->input->post('storeid');
            if($from != "")
			{
				$from = date("Y-m-d",strtotime($from));
			}
            if($to != "")
			{
				$to = date("Y-m-d",strtotime($to));
			}
			if($this->offer_model->editoffer($id,$header,$description,$from,$to,$brand,$storeid)==0)
			$data['alerterror']="offer Editing was unsuccesful";
			else
			$data['alertsuccess']="offer edited Successfully.";
			$data['table']=$this->offer_model->viewoffer();
			$data['redirect']="site/viewoffer";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
	function deleteoffer()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->offer_model->deleteoffer($this->input->get('id'));
		$data['table']=$this->offer_model->viewoffer();
		$data['alertsuccess']="offer Deleted Successfully";
		$data['page']='viewoffer';
		$data['title']='View offer';
		$this->load->view('template',$data);
	}
	//discountcoupon
	public function creatediscountcoupon()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'ticketevent' ] =$this->ticketevent_model->getticketevent();
		$data[ 'page' ] = 'creatediscountcoupon';
		$data[ 'title' ] = 'Create discountcoupon';
		$this->load->view( 'template', $data );	
	}
	function creatediscountcouponsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','name','trim|');
		$this->form_validation->set_rules('couponcode','couponcode','trim|');
		$this->form_validation->set_rules('percent','percent','trim|');
		$this->form_validation->set_rules('amount','amount','trim|');
		$this->form_validation->set_rules('minimumticket','minimumticket','trim|');
		$this->form_validation->set_rules('maximumticket','maximumticket','trim|');
		$this->form_validation->set_rules('ticketevent','ticketevent','trim|');
		$this->form_validation->set_rules('userperuser','userperuser','trim|');
		$this->form_validation->set_rules('starttime','Start Time','trim|required');
		$this->form_validation->set_rules('endtime','End Time','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'ticketevent' ] =$this->ticketevent_model->getticketevent();
			$data[ 'page' ] = 'creatediscountcoupon';
			$data[ 'title' ] = 'Create discountcoupon';
			$this->load->view('template',$data);
		}
		else
		{
			$name=$this->input->post('name');
			$percent=$this->input->post('percent');
			$amount=$this->input->post('amount');
			$couponcode=$this->input->post('couponcode');
			$minimumticket=$this->input->post('minimumticket');
			$maximumticket=$this->input->post('maximumticket');
			$ticketevent=$this->input->post('ticketevent');
			$userperuser=$this->input->post('userperuser');
			$starttime=date("H:i",strtotime($this->input->post('starttime')));
			$starttime = $starttime.":00";
			$starttime = date("H:i:s",strtotime($starttime));
			$endtime=date("H:i",strtotime($this->input->post('endtime')));
			$endtime = $endtime.":00";
			$endtime = date("H:i:s",strtotime($endtime));
			if($this->discountcoupon_model->creatediscountcoupon($name,$percent,$amount,$minimumticket,$maximumticket,$ticketevent,$couponcode,$userperuser,$starttime,$endtime)==0)
			$data['alerterror']="New discountcoupon could not be created.";
			else
			$data['alertsuccess']="discountcoupon  created Successfully.";
			$data['table']=$this->discountcoupon_model->viewdiscountcoupon();
			$data['redirect']="site/viewdiscountcoupon";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
	function viewdiscountcoupon()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->discountcoupon_model->viewdiscountcoupon();
		$data['page']='viewdiscountcoupon';
		$data['title']='View discountcoupon';
		$this->load->view('template',$data);
	}
	function editdiscountcoupon()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->discountcoupon_model->beforeeditdiscountcoupon($this->input->get('id'));
		$data[ 'ticketevent' ] =$this->ticketevent_model->getticketevent();
		$data['page']='editdiscountcoupon';
		$data['title']='Edit discountcoupon';
		$this->load->view('template',$data);
	}
	function editdiscountcouponsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','name','trim|');
		$this->form_validation->set_rules('couponcode','couponcode','trim|');
		$this->form_validation->set_rules('percent','percent','trim|');
		$this->form_validation->set_rules('amount','amount','trim|');
		$this->form_validation->set_rules('minimumticket','minimumticket','trim|');
		$this->form_validation->set_rules('maximumticket','maximumticket','trim|');
		$this->form_validation->set_rules('ticketevent','ticketevent','trim|');
		$this->form_validation->set_rules('userperuser','userperuser','trim|');
		$this->form_validation->set_rules('starttime','Start Time','trim|required');
		$this->form_validation->set_rules('endtime','End Time','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['before']=$this->discountcoupon_model->beforeeditdiscountcoupon($this->input->post('id'));
			$data[ 'ticketevent' ] =$this->ticketevent_model->getticketevent();
			$data['page']='editdiscountcoupon';
			$data['title']='Edit discountcoupon';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			$name=$this->input->post('name');
			$percent=$this->input->post('percent');
			$amount=$this->input->post('amount');
			$couponcode=$this->input->post('couponcode');
			$minimumticket=$this->input->post('minimumticket');
			$maximumticket=$this->input->post('maximumticket');
			$ticketevent=$this->input->post('ticketevent');
			$userperuser=$this->input->post('userperuser');
			$starttime=date("H:i",strtotime($this->input->post('starttime')));
			$starttime = $starttime.":00";
			$starttime = date("H:i:s",strtotime($starttime));
			$endtime=date("H:i",strtotime($this->input->post('endtime')));
			$endtime = $endtime.":00";
			$endtime = date("H:i:s",strtotime($endtime));
			if($this->discountcoupon_model->editdiscountcoupon($id,$name,$percent,$amount,$minimumticket,$maximumticket,$ticketevent,$couponcode,$userperuser,$starttime,$endtime)==0)
			$data['alerterror']="discountcoupon Editing was unsuccesful";
			else
			$data['alertsuccess']="discountcoupon edited Successfully.";
			$data['table']=$this->discountcoupon_model->viewdiscountcoupon();
			$data['redirect']="site/viewdiscountcoupon";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			/*$data['discountcoupon']='viewusers';
			$data['title']='View Users';
			$this->load->view('template',$data);*/
		}
	}
	function deletediscountcoupon()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->discountcoupon_model->deletediscountcoupon($this->input->get('id'));
		$data['table']=$this->discountcoupon_model->viewdiscountcoupon();
		$data['alertsuccess']="discountcoupon Deleted Successfully";
		$data['page']='viewdiscountcoupon';
		$data['title']='View discountcoupon';
		$this->load->view('template',$data);
	}
	public function createorganizer()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createorganizer';
		$data[ 'title' ] = 'Create organizer';
		$data['user']=$this->user_model->getorganizeruser();
		$this->load->view( 'template', $data );	
	}
	function createorganizersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|');
		$this->form_validation->set_rules('contact','contactno','trim');
		
		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('description','description','trim');
		$this->form_validation->set_rules('info','info','trim');
		$this->form_validation->set_rules('website','website','trim');
		$this->form_validation->set_rules('user','user','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='createorganizer';
			$data['title']='Create New organizer';
			$data['user']=$this->user_model->getorganizeruser();
			$this->load->view('template',$data);
		}
		else
		{
			$info=$this->input->post('info');
			$email=$this->input->post('email');
			$website=$this->input->post('website');
			$contact=$this->input->post('contact');
			$name=$this->input->post('name');
			$description=$this->input->post('description');
			$user=$this->input->post('user');
			if($this->organizer_model->create($name,$description,$email,$contact,$info,$website,$user)==0)
			$data['alerterror']="New organizer could not be created.";
			else
			$data['alertsuccess']="organizer created Successfully.";
			
			$data['table']=$this->organizer_model->vieworganizers();
			$data['redirect']="site/vieworganizers";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
	
	function editorganizer()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->organizer_model->beforeedit($this->input->get('id'));
		$data['user']=$this->user_model->getorganizeruser();
		$data['page']='editorganizer';
		$data['title']='Edit organizer';
		$this->load->view('template',$data);
	}
	function editorganizersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|');
		$this->form_validation->set_rules('contact','contactno','trim');
		
		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('description','description','trim');
		$this->form_validation->set_rules('info','info','trim');
		$this->form_validation->set_rules('website','website','trim');
		$this->form_validation->set_rules('user','user','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['user']=$this->user_model->getorganizeruser();
			$data['before']=$this->organizer_model->beforeedit($this->input->post('id'));
			$data['page']='editorganizer';
			$data['title']='Edit organizer';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			$info=$this->input->post('info');
			$email=$this->input->post('email');
			$website=$this->input->post('website');
			$contact=$this->input->post('contact');
			$name=$this->input->post('name');
			$description=$this->input->post('description');
			$user=$this->input->post('user');
			if($this->organizer_model->edit($id,$name,$description,$email,$contact,$info,$website,$user)==0)
			$data['alerterror']="organizer Editing was unsuccesful";
			else
			$data['alertsuccess']="organizer edited Successfully.";
			
			$data['redirect']="site/vieworganizers";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deleteorganizer()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->organizer_model->deleteorganizer($this->input->get('id'));
		$data['table']=$this->organizer_model->vieworganizers();
		$data['alertsuccess']="organizer Deleted Successfully";
		$data['page']='vieworganizers';
		$data['title']='View organizers';
		$this->load->view('template',$data);
	}
    
	//City
    
    function viewcity()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewcity';
        
        
        $data['base_url'] = site_url("site/viewcityjson");
        
        
		$data['title']='View City';
		$this->load->view('template',$data);
	} 
    
    function viewcityjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
//        SELECT  `retailer`.`id`, `retailer`.`area`, `retailer`.`dob`,`retailer`.`name`, `retailer`.`number`, `retailer`.`email`, `retailer`.`address`,`retailer`. `ownername`, `retailer`.`ownernumber`, `retailer`.`contactname`,`retailer`. `contactnumber`,`area`.`name` AS `areaname` FROM `retailer` LEFT OUTER JOIN `area` ON `area`.`id`=`retailer`.`area`
        
//        SELECT `city`.`id`,`city`.`name` AS `cityname`,`state`.`name` AS `statename` FROM `city` LEFT OUTER JOIN `state` ON `state`.`id`=`city`.`state`
            
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`city`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]->field="`city`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="City Name";
        $elements[1]->alias="cityname";
        
        $elements[2]->field="`state`.`name`";
        $elements[2]->sort="1";
        $elements[2]->header="State";
        $elements[2]->alias="statename";
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `city` LEFT OUTER JOIN `state` ON `state`.`id`=`city`.`state`");
        
		$this->load->view("json",$data);
	} 
    
    function viewonecitylocations()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->city_model->viewonecitylocations($this->input->get('cityid'));
		$data['page']='viewonecitylocations';
		$data['title']='View Locations';
		$this->load->view('template',$data);
	}
	public function createcity()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createcity';
		$data[ 'title' ] = 'Create city';
		$data['state']=$this->city_model->getstatedropdown();
//		$data['location']=$this->location_model->getlocation();
//        $data['category']=$this->category_model->getcategory();
//        $data['topic']=$this->topic_model->gettopic();
//		$data['listingtype']=$this->event_model->getlistingtype();
//		$data['remainingticket']=$this->event_model->getremainingticket();
		$this->load->view( 'template', $data );	
	}
    function createcitysubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('state','state','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='createcity';
			$data['title']='Create New City';
            $data['state']=$this->city_model->getstatedropdown();
//			$data['organizer']=$this->organizer_model->getorganizer();
//			$data['listingtype']=$this->event_model->getlistingtype();
//			$data['remainingticket']=$this->event_model->getremainingticket();
			$this->load->view('template',$data);
		}
		else
		{
			$name=$this->input->post('name');
			$state=$this->input->post('state');
			if($this->city_model->create($name,$state)==0)
			$data['alerterror']="New City could not be created.";
			else
			$data['alertsuccess']="City created Successfully.";
			
			$data['table']=$this->city_model->viewcity();
			$data['redirect']="site/viewcity";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
    public function createlocation()
	{
		$access = array("1");
		$this->checkaccess($access);
        $data['cityid']=$this->input->get('cityid');
		$data[ 'page' ] = 'createlocation';
		$data[ 'title' ] = 'Create Location';
//		$data['location']=$this->location_model->getlocation();
//        $data['category']=$this->category_model->getcategory();
//        $data['topic']=$this->topic_model->gettopic();
//		$data['listingtype']=$this->event_model->getlistingtype();
//		$data['remainingticket']=$this->event_model->getremainingticket();
		$this->load->view( 'template', $data );	
	}
    function createlocationsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('pincode','Pincode','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='createlocation';
			$data['title']='Create New Location';
//			$data['organizer']=$this->organizer_model->getorganizer();
//			$data['listingtype']=$this->event_model->getlistingtype();
//			$data['remainingticket']=$this->event_model->getremainingticket();
			$this->load->view('template',$data);
		}
		else
		{
			$name=$this->input->post('name');
			$pincode=$this->input->post('pincode');
			$cityid=$this->input->get_post('cityid');
			if($this->city_model->createlocation($name,$cityid,$pincode)==0)
			$data['alerterror']="New Location could not be created.";
			else
			$data['alertsuccess']="Location created Successfully.";
			
			$data['table']=$this->city_model->viewonecitylocations($cityid);
			$data['redirect']="site/viewonecitylocations?cityid=".$cityid;
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
    
    function editcity()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->city_model->beforeedit($this->input->get('id'));
        $data['state']=$this->city_model->getstatedropdown();
//		$data['organizer']=$this->organizer_model->getorganizer();
//		$data['listingtype']=$this->event_model->getlistingtype();
//		$data['remainingticket']=$this->event_model->getremainingticket();
//		$data['page2']='block/eventblock';
		$data['page']='editcity';
		$data['title']='Edit City';
		$this->load->view('template',$data);
	}
	function editcitysubmit()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('state','state','trim|required');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
//			$data['organizer']=$this->organizer_model->getorganizer();
//			$data['listingtype']=$this->event_model->getlistingtype();
//			$data['remainingticket']=$this->event_model->getremainingticket();
			$data['before']=$this->city_model->beforeedit($this->input->post('id'));
            $data['state']=$this->city_model->getstatedropdown();
//			$data['page2']='block/eventblock';
			$data['page']='editcity';
			$data['title']='Edit City';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			$name=$this->input->post('name');
			$state=$this->input->post('state');
			if($this->city_model->edit($id,$name,$state)==0)
			$data['alerterror']="City Editing was unsuccesful";
			else
			$data['alertsuccess']="City edited Successfully.";
			
			$data['redirect']="site/viewcity";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	function editlocation()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->city_model->beforeeditlocation($this->input->get('id'));
//		$data['organizer']=$this->organizer_model->getorganizer();
//		$data['listingtype']=$this->event_model->getlistingtype();
//		$data['remainingticket']=$this->event_model->getremainingticket();
//		$data['page2']='block/eventblock';
		$data['page']='editlocation';
		$data['title']='Edit Location';
		$this->load->view('template',$data);
	}
	function editlocationsubmit()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('pincode','Pincode','trim|required');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
//			$data['organizer']=$this->organizer_model->getorganizer();
//			$data['listingtype']=$this->event_model->getlistingtype();
//			$data['remainingticket']=$this->event_model->getremainingticket();
			$data['before']=$this->city_model->beforeedit($this->input->post('id'));
//			$data['page2']='block/eventblock';
			$data['page']='editcity';
			$data['title']='Edit City';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->get_post('id');
			$cityid=$this->input->get_post('cityid');
			$name=$this->input->post('name');
			$pincode=$this->input->post('pincode');
			if($this->city_model->editlocation($id,$cityid,$name,$pincode)==0)
			$data['alerterror']="Location Editing was unsuccesful";
			else
			$data['alertsuccess']="Location edited Successfully.";
			
			$data['redirect']="site/viewonecitylocations?cityid=".$cityid;
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
    
	function deletecity()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->city_model->deletecity($this->input->get('id'));
		$data['table']=$this->city_model->viewcity();
		$data['alertsuccess']="City Deleted Successfully";
		$data['page']='viewcity';
		$data['title']='View City';
		$this->load->view('template',$data);
	}
     
	function deletelocation()
	{
		$access = array("1");
		$this->checkaccess($access);
        $cityid=$this->input->get('cityid');
		$this->city_model->deletelocation($this->input->get('id'));
		$data['table']=$this->city_model->viewonecitylocations($cityid);
		$data['alertsuccess']="City Deleted Successfully";
		$data['page']='viewonecitylocations';
		$data['title']='View Location';
		$this->load->view('template',$data);
	}
    
    //Brand
    
    function viewbrand()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->brand_model->viewbrand();
		$data['page']='viewbrand';
		$data['title']='View Brand';
		$this->load->view('template',$data);
	} 
    
    public function createbrand()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createbrand';
		$data[ 'title' ] = 'Create Brand';
        $data['category']=$this->brand_model->getcategory();
//		$data['location']=$this->location_model->getlocation();
//        $data['category']=$this->category_model->getcategory();
//        $data['topic']=$this->topic_model->gettopic();
//		$data['listingtype']=$this->event_model->getlistingtype();
//		$data['remainingticket']=$this->event_model->getremainingticket();
		$this->load->view( 'template', $data );	
	}
    function createbrandsubmit()
	{
        $access = array("1");
		$this->checkaccess($access);
        $this->form_validation->set_rules('name','Name','trim|required');
        $this->form_validation->set_rules('website','website','trim');
        $this->form_validation->set_rules('twitter','twitter','trim');
        $this->form_validation->set_rules('pininterest','pininterest','trim');
        $this->form_validation->set_rules('googleplus','googleplus','trim');
        $this->form_validation->set_rules('instagram','instagram','trim');
        $this->form_validation->set_rules('blog','blog','trim');
        $this->form_validation->set_rules('description','description','trim');
		
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='createbrand';
			$data['title']='Create New Brand';
        $data['category']=$this->brand_model->getcategory();
			$this->load->view('template',$data);
		}
		else
		{
           //$id=$this->input->get_post('id');
			$name=$this->input->post('name');
			$website=$this->input->post('website');
			$facebook=$this->input->post('facebook');
			$twitter=$this->input->post('twitter');
			$pininterest=$this->input->post('pininterest');
			$googleplus=$this->input->post('googleplus');
			$instagram=$this->input->post('instagram');
			$blog=$this->input->post('blog');
			$description=$this->input->post('description');
            $id=$this->brand_model->create($name,$website,$facebook,$twitter,$pininterest,$googleplus,$instagram,$blog,$description);
            if($id==0)
			$data['alerterror']="New brand could not be created.";
			else
			$data['alertsuccess']="brand created Successfully.";
            
            foreach ($_POST as $key => $value) {
             if(is_array($value)){
//                 echo "hi";
             foreach ($_POST[$key] as $key => $value) {
        //        echo "<tr>";
        //        echo "<td>";
//                echo $key;
        //        echo "</td>";
        //        echo "<td>";
               // echo $value;
                 $this->brand_model->createsubcategory($id,$value);
        //        echo "</td>";
        //        echo "</tr>";
                     }


                     }
                     else{
        //        echo "<tr>";
        //        echo "<td>";
//                echo $key;
        //        echo "</td>";
        //        echo "<td>";
                //echo $value;
                         if($key!="name")
                $this->brand_model->createsubcategory($id,$value);
                         
        //        echo "</td>";
        //        echo "</tr>";
                     }
             
                }
			
//			
			$data['table']=$this->brand_model->viewbrand();
			$data['redirect']="site/viewbrand";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
    
    
    function editbrand()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->brand_model->beforeedit($this->input->get('id'));
        $data['category']=$this->brand_model->getcategory();
        $data['brandcategory']=$this->brand_model->getbrandcategory($this->input->get('id'));
//		$data['organizer']=$this->organizer_model->getorganizer();
//		$data['listingtype']=$this->event_model->getlistingtype();
//		$data['remainingticket']=$this->event_model->getremainingticket();
//		$data['page2']='block/eventblock';
		$data['page']='editbrand';
		$data['title']='Edit brand';
		$this->load->view('template',$data);
	}
	function editbrandsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
        $this->form_validation->set_rules('website','website','trim');
        $this->form_validation->set_rules('twitter','twitter','trim');
        $this->form_validation->set_rules('pininterest','pininterest','trim');
        $this->form_validation->set_rules('googleplus','googleplus','trim');
        $this->form_validation->set_rules('instagram','instagram','trim');
        $this->form_validation->set_rules('blog','blog','trim');
        $this->form_validation->set_rules('description','description','trim');
		
        print_r($_POST);
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='createbrand';
			$data['title']='Create New Brand';
        $data['category']=$this->brand_model->getcategory();
			$this->load->view('template',$data);
		}
		else
		{
           $id=$this->input->get_post('id');
			$name=$this->input->post('name');
            $website=$this->input->post('website');
			$facebook=$this->input->post('facebook');
			$twitter=$this->input->post('twitter');
			$pininterest=$this->input->post('pininterest');
			$googleplus=$this->input->post('googleplus');
			$instagram=$this->input->post('instagram');
			$blog=$this->input->post('blog');
			$description=$this->input->post('description');
            $id1=$this->brand_model->editbrand($id,$name,$website,$facebook,$twitter,$pininterest,$googleplus,$instagram,$blog,$description);
            $this->brand_model->deletesubcategory($id);
            if($id1==0)
			$data['alerterror']="New brand could not be Updated.";
			else
			$data['alertsuccess']="brand Updated Successfully.";
            
            foreach ($_POST as $key => $value) {
             if(is_array($value)){
//                 echo "hi";
             foreach ($_POST[$key] as $key => $value) {
                 echo $value;
                 $this->brand_model->createsubcategory($id,$value);
                     }

                     }
                     else{
                         if($key!="name")
                $this->brand_model->createsubcategory($id,$value);
               
                     }
             
                }
			
//			
			$data['table']=$this->brand_model->viewbrand();
			$data['redirect']="site/viewbrand";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
    
	function deletebrand()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->brand_model->deletebrand($this->input->get('id'));
		$data['table']=$this->brand_model->viewbrand();
		$data['alertsuccess']="brand Deleted Successfully";
		$data['page']='viewbrand';
		$data['title']='View brand';
		$this->load->view('template',$data);
	}
    
    function deletebrandcategory()
	{
		$access = array("1");
		$this->checkaccess($access);
        $id=$this->input->get('id');
        $brandid=$this->input->get('brandid');
		$this->category_model->deletebrandcategory($this->input->get('id'),$this->input->get('brandid'));
		$data['table']=$this->category_model->viewonebrandcategories($this->input->get('brandid'));
		$data['page']='viewonebrandcategories';
		$data['title']='View Brand category';
		$this->load->view('template',$data);
	}
    
    
    
    
    //Mall
    public function createmall()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createmall';
		$data[ 'title' ] = 'Create mall';
        $data['location']=$this->city_model->getlocationdropdown();
//		$data['location']=$this->location_model->getlocation();
//        $data['category']=$this->category_model->getcategory();
//        $data['topic']=$this->topic_model->gettopic();
//		$data['listingtype']=$this->event_model->getlistingtype();
//		$data['remainingticket']=$this->event_model->getremainingticket();
		$this->load->view( 'template', $data );	
	}
	function createmallsubmit()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('address','Address','trim|required');
		$this->form_validation->set_rules('description','Description','trim|required');
		$this->form_validation->set_rules('specialoffers','specialoffers','trim');
		$this->form_validation->set_rules('events','events','trim');
		$this->form_validation->set_rules('cinemaoffer','Cinemaoffer','trim');
		$this->form_validation->set_rules('facebookpage','Facebookpage','trim');
		$this->form_validation->set_rules('pininterest','pininterest','trim');
		$this->form_validation->set_rules('instagram','instagram','trim');
		$this->form_validation->set_rules('twitterpage','twitterpage','trim');
		$this->form_validation->set_rules('location','location','trim|required');
		$this->form_validation->set_rules('latitude','Latitude','trim');
		$this->form_validation->set_rules('longitude','Longitude','trim|');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[mall.email]');
		$this->form_validation->set_rules('contactno','contactno','trim');
		$this->form_validation->set_rules('website','Website','trim|max_length[50]');
		$this->form_validation->set_rules('parkingfacility','Parkingfacility','trim');
		$this->form_validation->set_rules('cinema','Cinema','trim');
		$this->form_validation->set_rules('restaurant','Restaurant','trim');
		$this->form_validation->set_rules('entertainment','Entertainment','trim');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='createmall';
			$data['title']='Create New Mall';
//			$data['organizer']=$this->organizer_model->getorganizer();
//			$data['listingtype']=$this->event_model->getlistingtype();
//			$data['remainingticket']=$this->event_model->getremainingticket();
			$this->load->view('template',$data);
		}
		else
		{
			$name=$this->input->post('name');
			$address=$this->input->post('address');
			$description=$this->input->post('description');
			$specialoffers=$this->input->post('specialoffers');
			$events=$this->input->post('events');
			$cinemaoffer=$this->input->post('cinemaoffer');
			$pininterest=$this->input->post('pininterest');
			$instagram=$this->input->post('instagram');
			$twitterpage=$this->input->post('twitterpage');
			$facebookpage=$this->input->post('facebookpage');
			$location=$this->input->post('location');
			$latitude=$this->input->post('latitude');
			$longitude=$this->input->post('longitude');
			$contactno=$this->input->post('contactno');
			$parkingfacility=$this->input->post('parkingfacility');
			$cinema=$this->input->post('cinema');
			$restaurant=$this->input->post('restaurant');
			$entertainment=$this->input->post('entertainment');
			$website=$this->input->post('website');
			$email=$this->input->post('email');
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="logo";
			$logo="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$logo=$uploaddata['file_name'];
			}
			if($this->mall_model->create($name,$address,$location,$latitude,$longitude,$contactno,$parkingfacility,$cinema,$restaurant,$entertainment,$website,$email,$logo,$description,$specialoffers,$events,$cinemaoffer,$facebookpage,$pininterest,$instagram,$twitterpage)==0)
			$data['alerterror']="New Mall could not be created.";
			else
			$data['alertsuccess']="Mall created Successfully.";
			
			$data['table']=$this->mall_model->viewmall();
			$data['redirect']="site/viewmall";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
	function viewmall()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->mall_model->viewmall();
		$data['page']='viewmall';
		$data['title']='View Malls';
		$this->load->view('template',$data);
	}
	function editmall()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->mall_model->beforeedit($this->input->get('id'));
        $data['location']=$this->city_model->getlocationdropdown();
//		$data['organizer']=$this->organizer_model->getorganizer();
//		$data['listingtype']=$this->event_model->getlistingtype();
//		$data['remainingticket']=$this->event_model->getremainingticket();
//		$data['page2']='block/eventblock';
		$data['page']='editmall';
		$data['title']='Edit Mall';
		$this->load->view('template',$data);
	}
	function editmallsubmit()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('address','Address','trim|required');
		$this->form_validation->set_rules('description','Description','trim|required');
		$this->form_validation->set_rules('specialoffers','specialoffers','trim');
		$this->form_validation->set_rules('events','events','trim');
		$this->form_validation->set_rules('cinemaoffer','Cinemaoffer','trim');
		$this->form_validation->set_rules('facebookpage','Facebookpage','trim');
		$this->form_validation->set_rules('pininterest','pininterest','trim');
		$this->form_validation->set_rules('instagram','instagram','trim');
		$this->form_validation->set_rules('twitterpage','twitterpage','trim');
		$this->form_validation->set_rules('location','location','trim|required');
		$this->form_validation->set_rules('latitude','Latitude','trim');
		$this->form_validation->set_rules('longitude','Longitude','trim|');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('contactno','contactno','trim');
		$this->form_validation->set_rules('website','Website','trim|max_length[50]');
		$this->form_validation->set_rules('parkingfacility','Parkingfacility','trim');
		$this->form_validation->set_rules('cinema','Cinema','trim');
		$this->form_validation->set_rules('restaurant','Restaurant','trim');
		$this->form_validation->set_rules('entertainment','Entertainment','trim');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
//			$data['organizer']=$this->organizer_model->getorganizer();
//			$data['listingtype']=$this->event_model->getlistingtype();
//			$data['remainingticket']=$this->event_model->getremainingticket();
			$data['before']=$this->mall_model->beforeedit($this->input->post('id'));
//			$data['page2']='block/eventblock';
			$data['page']='editmall';
			$data['title']='Edit Mall';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			$name=$this->input->post('name');
			$address=$this->input->post('address');
			$description=$this->input->post('description');
			$specialoffers=$this->input->post('specialoffers');
			$events=$this->input->post('events');
			$facebookpage=$this->input->post('facebookpage');
			$cinemaoffer=$this->input->post('cinemaoffer');
			$pininterest=$this->input->post('pininterest');
			$instagram=$this->input->post('instagram');
			$twitterpage=$this->input->post('twitterpage');
			$location=$this->input->post('location');
			$latitude=$this->input->post('latitude');
			$longitude=$this->input->post('longitude');
			$contactno=$this->input->post('contactno');
			$parkingfacility=$this->input->post('parkingfacility');
			$cinema=$this->input->post('cinema');
			$restaurant=$this->input->post('restaurant');
			$entertainment=$this->input->post('entertainment');
			$website=$this->input->post('website');
			$email=$this->input->post('email');
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="logo";
			$logo="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$logo=$uploaddata['file_name'];
			}
			if($this->mall_model->edit($id,$name,$address,$location,$latitude,$longitude,$contactno,$parkingfacility,$cinema,$restaurant,$entertainment,$website,$email,$logo,$description,$specialoffers,$events,$cinemaoffer,$facebookpage,$pininterest,$instagram,$twitterpage)==0)
			$data['alerterror']="Mall Editing was unsuccesful";
			else
			$data['alertsuccess']="Mall edited Successfully.";
			
			$data['redirect']="site/viewmall";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deletemall()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->mall_model->deletemall($this->input->get('id'));
		$data['table']=$this->mall_model->viewmall();
		$data['alertsuccess']="Mall Deleted Successfully";
		$data['page']='viewmall';
		$data['title']='View Malls';
		$this->load->view('template',$data);
	}
    
    /*-----------------Event functions Addes by Avinash------------------------*/
    public function showalleventsbyuserid()
    {
        $id=$this->input->get('id');
        $data['json']=$this->event_model->showalleventsbyuserid($id);
        print_r ($data);
		//$this->load->view('json',$data);
    }
    public function findone()
	{
        $id=$this->input->get('id');
        $data['json']=$this->event_model->viewone($id);
        print_r($data);
		//$this->load->view('json',$data);
	}
    
    /*-----------------End of event functions----------------------------------*/
    
	function editeventcategorytopic()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->event_model->beforeedit($this->input->get('id'));
		$data['category']=$this->category_model->getcategory();
		$data['topic']=$this->topic_model->gettopic();
		$data['page2']='block/eventblock';
		$data['page']='eventcategorytopic';
		$data['title']='Edit event category';
		$this->load->view('template',$data);
	}
	function editeventcategorytopicsubmit()
	{
		$this->form_validation->set_rules('id','id','trim|');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['before']=$this->event_model->beforeeditevent($this->input->post('id'));
			$data['category']=$this->category_model->getcategory();
			$data['topic']=$this->topic_model->gettopic();
			$data['page2']='block/eventblock';
			$data['page']='eventcategorytopic';
			$data['title']='Edit Related events';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			
			$category=$this->input->post('category');
			$topic=$this->input->post('topic');
			if($this->event_model->editeventcategorytopic($id,$category,$topic)==0)
			$data['alerterror']=" Event category-topic Editing was unsuccesful";
			else
			$data['alertsuccess']=" Event category-topic edited Successfully.";
			
			$data['redirect']="site/editeventcategorytopic?id=".$id;
			//$data['other']="template=$template";
			$this->load->view("redirect2",$data);
		}
	}
	//ticketevent
	public function createticketevent()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createticketevent';
		$data[ 'title' ] = 'Create ticketevent';
		$data['event']=$this->event_model->getevent();
		$data['tickettype']=$this->ticketevent_model->gettickettype();
		$this->load->view( 'template', $data );	
	}
	function createticketeventsubmit()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$this->form_validation->set_rules('event','event','trim|');
		$this->form_validation->set_rules('tickettype','tickettype','trim');
		$this->form_validation->set_rules('ticket','ticket','trim|');
		$this->form_validation->set_rules('ticketname','ticketname','trim');
		$this->form_validation->set_rules('amount','amount','trim');
		$this->form_validation->set_rules('starttime','Start Time','trim|required');
		$this->form_validation->set_rules('endtime','End Time','trim|required');
		$this->form_validation->set_rules('quantity','quantity','trim');
		$this->form_validation->set_rules('description','description','trim');
		$this->form_validation->set_rules('ticketmaxallowed','ticketmaxallowed','trim');
		$this->form_validation->set_rules('ticketminallowed','ticketminallowed','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='createticketevent';
			$data['title']='Create New ticketevent';
			$data['event']=$this->event_model->getevent();
			$data['tickettype']=$this->ticketevent_model->gettickettype();
			$this->load->view('template',$data);
		}
		else
		{
			$event=$this->input->post('event');
			$ticket=$this->input->post('ticket');
			$tickettype=$this->input->post('tickettype');
			$amount=$this->input->post('amount');
			$ticketname=$this->input->post('ticketname');
			$quantity=$this->input->post('quantity');
			$description=$this->input->post('description');
			$ticketmaxallowed=$this->input->post('ticketmaxallowed');
			$ticketminallowed=$this->input->post('ticketminallowed');
			$starttime=date("H:i",strtotime($this->input->post('starttime')));
			$starttime = $starttime.":00";
			$starttime = date("H:i:s",strtotime($starttime));
			$endtime=date("H:i",strtotime($this->input->post('endtime')));
			$endtime = $endtime.":00";
			$endtime = date("H:i:s",strtotime($endtime));
			if($this->ticketevent_model->create($event,$ticket,$tickettype,$amount,$ticketname,$quantity,$description,$ticketmaxallowed,$ticketminallowed,$starttime,$endtime)==0)
			$data['alerterror']="New ticketevent could not be created.";
			else
			$data['alertsuccess']="ticketevent created Successfully.";
			
			$data['table']=$this->ticketevent_model->viewticketevent();
			$data['redirect']="site/viewticketevent";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
	function viewticketevent()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->ticketevent_model->viewticketevent();
		$data['page']='viewticketevent';
		$data['title']='View ticketevent';
		$this->load->view('template',$data);
	}
	function editticketevent()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->ticketevent_model->beforeedit($this->input->get('id'));
		$data['event']=$this->event_model->getevent();
		$data['tickettype']=$this->ticketevent_model->gettickettype();
		$data['page']='editticketevent';
		$data['title']='Edit ticketevent';
		$this->load->view('template',$data);
	}
	function editticketeventsubmit()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$this->form_validation->set_rules('event','event','trim|');
		$this->form_validation->set_rules('tickettype','tickettype','trim');
		$this->form_validation->set_rules('ticket','ticket','trim|');
		$this->form_validation->set_rules('ticketname','ticketname','trim');
		$this->form_validation->set_rules('amount','amount','trim');
		$this->form_validation->set_rules('starttime','Start Time','trim|required');
		$this->form_validation->set_rules('endtime','End Time','trim|required');
		$this->form_validation->set_rules('quantity','quantity','trim');
		$this->form_validation->set_rules('description','description','trim');
		$this->form_validation->set_rules('ticketmaxallowed','ticketmaxallowed','trim');
		$this->form_validation->set_rules('ticketminallowed','ticketminallowed','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['event']=$this->event_model->getevent();
			$data['tickettype']=$this->ticketevent_model->gettickettype();
			$data['before']=$this->ticketevent_model->beforeedit($this->input->post('id'));
			$data['page']='editticketevent';
			$data['title']='Edit ticketevent';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			$event=$this->input->post('event');
			$ticket=$this->input->post('ticket');
			$tickettype=$this->input->post('tickettype');
			$amount=$this->input->post('amount');
			$ticketname=$this->input->post('ticketname');
			$quantity=$this->input->post('quantity');
			$description=$this->input->post('description');
			$ticketmaxallowed=$this->input->post('ticketmaxallowed');
			$ticketminallowed=$this->input->post('ticketminallowed');
			$starttime=date("H:i",strtotime($this->input->post('starttime')));
			$starttime = $starttime.":00";
			$starttime = date("H:i:s",strtotime($starttime));
			$endtime=date("H:i",strtotime($this->input->post('endtime')));
			$endtime = $endtime.":00";
			$endtime = date("H:i:s",strtotime($endtime));
			if($this->ticketevent_model->edit($id,$event,$ticket,$tickettype,$amount,$ticketname,$quantity,$description,$ticketmaxallowed,$ticketminallowed,$starttime,$endtime)==0)
			$data['alerterror']="ticketevent Editing was unsuccesful";
			else
			$data['alertsuccess']="ticketevent edited Successfully.";
			
			$data['redirect']="site/viewticketevent";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deleteticketevent()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->ticketevent_model->deleteticketevent($this->input->get('id'));
		$data['table']=$this->ticketevent_model->viewticketevent();
		$data['alertsuccess']="ticketevent Deleted Successfully";
		$data['page']='viewticketevent';
		$data['title']='View ticketevent';
		$this->load->view('template',$data);
	}
	//Newsletter
	public function createnewsletter()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createnewsletter';
		$data[ 'title' ] = 'Create newsletter';
		$this->load->view( 'template', $data );	
	}
	public function createnewslettersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('title','title','trim|');
		$this->form_validation->set_rules('subject','subject','trim|');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'page' ] = 'createnewsletter';
			$data[ 'title' ] = 'Create newsletter';
			$this->load->view('template',$data);
		}
		else
		{
			$title=$this->input->post('title');
			$subject=$this->input->post('subject');
			if($this->newsletter_model->createnewsletter($title,$subject)==0)
			$data['alerterror']="New newsletter could not be created.";
			else
			$data['alertsuccess']="newsletter  created Successfully.";
			$data['redirect']="site/viewnewsletter";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
	public function editnewsletter()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->newsletter_model->beforeeditnewsletter($this->input->get('id'));
		$data[ 'page' ] = 'editnewsletter';
		$data[ 'title' ] = 'Edit newsletter';
		$this->load->view( 'template', $data );	
	}
	function editnewslettersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('title','title','trim|');
		$this->form_validation->set_rules('subject','subject','trim|');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['before']=$this->newsletter_model->beforeeditnewsletter($this->input->post('id'));
			$data['page']='editnewsletter';
			$data['title']='Edit newsletter';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			$title=$this->input->post('title');
			$subject=$this->input->post('subject');
			
			if($this->newsletter_model->editnewsletter($id,$title,$subject)==0)
			$data['alerterror']="newsletter Editing was unsuccesful";
			else
			$data['alertsuccess']="newsletter edited Successfully.";
			$data['table']=$this->newsletter_model->viewnewsletter();
			$data['redirect']="site/viewnewsletter";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			/*$data['page']='viewusers';
			$data['title']='View Users';
			$this->load->view('template',$data);*/
		}
	}
	function deletenewsletter()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->newsletter_model->deletenewsletter($this->input->get('id'));
		$data['table']=$this->newsletter_model->viewnewsletter();
		$data['alertsuccess']="newsletter Deleted Successfully";
		$data['page']='viewnewsletter';
		$data['title']='View newsletter';
		$this->load->view('template',$data);
	}
	function viewnewsletter()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->newsletter_model->viewnewsletter();
		$data['page']='viewnewsletter';
		$data['title']='View newsletter';
		$this->load->view('template',$data);
	}
    
    
    //store
    
    function viewindividualstore()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->store_model->viewindividualstore();
		$data['page']='viewindividualstore';
		$data['title']='View Individualstore';
		$this->load->view('template',$data);
	}
    function viewstoreinmall()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->store_model->viewstoreinmall();
		$data['page']='viewstoreinmall';
		$data['title']='View Stores in mall';
		$this->load->view('template',$data);
	}
    
     public function createstoreinmall()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createstoreinmall';
		$data[ 'title' ] = 'Create Store in mall';
		$data['city']=$this->city_model->getcitydropdown();
        $data['brand']=$this->brand_model->getbranddropdown();
        $data['shopclosedon']=$this->store_model->getshopclosedondropdown();
        $data['mall']=$this->mall_model->getmalldropdown();
        $data['floor']=$this->mall_model->getfloordropdown();
        $data['offer']=$this->offer_model->getofferdropdown();
//        $data['topic']=$this->topic_model->gettopic();
//		$data['listingtype']=$this->event_model->getlistingtype();
//		$data['remainingticket']=$this->event_model->getremainingticket();
		$this->load->view( 'template', $data );	
	}
	function editstoreinmall()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->store_model->beforeeditstoreinmall($this->input->get('id'));
		$data['city']=$this->city_model->getcitydropdown();
        $data['brand']=$this->brand_model->getbranddropdown();
        $data['mall']=$this->mall_model->getmalldropdown();
        $data['floor']=$this->mall_model->getfloordropdown();
        $data['shopclosedon']=$this->store_model->getshopclosedondropdown();
        $data['offer']=$this->offer_model->getofferdropdown();
		$data['page']='editstoreinmall';
		$data['title']='Edit store in mall';
		$this->load->view('template',$data);
	}
	function editstoreinmallsubmit()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('city','city','trim|required');
		$this->form_validation->set_rules('brand','brand','trim|required');
		$this->form_validation->set_rules('mall','mall','trim|required');
		$this->form_validation->set_rules('floor','floor','trim|required');
		$this->form_validation->set_rules('offer','offer','trim|');
		$this->form_validation->set_rules('description','Description','trim|');
		$this->form_validation->set_rules('shopclosedon','Shopclosedon','trim|');
		$this->form_validation->set_rules('workinghoursfrom','Workinghoursfrom','trim|');
		$this->form_validation->set_rules('workinghoursto','Workinghoursto','trim|');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[mall.email]');
		$this->form_validation->set_rules('contactno','contactno','trim');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='editstoreinmall';
			$data['title']='Edit Store in Mall';
            $data['before']=$this->store_model->beforeeditstoreinmall($this->input->get('id'));
            $data['city']=$this->city_model->getcitydropdown();
            $data['brand']=$this->brand_model->getbranddropdown();
            $data['shopclosedon']=$this->store_model->getshopclosedondropdown();
            $data['mall']=$this->mall_model->getmalldropdown();
            $data['floor']=$this->mall_model->getfloordropdown();
			$this->load->view('template',$data);
		}
		else
		{
            $id=$this->input->post('id');
			$name=$this->input->post('name');
			$city=$this->input->post('city');
			$brand=$this->input->post('brand');
			$mall=$this->input->post('mall');
			$floor=$this->input->post('floor');
			$offer=$this->input->post('offer');
			$contactno=$this->input->post('contactno');
			$description=$this->input->post('description');
			$email=$this->input->post('email');
			$format=$this->input->post('format');
			$shopclosedon=$this->input->post('shopclosedon');
			$workinghoursfrom=$this->input->post('workinghoursfrom');
			$workinghoursto=$this->input->post('workinghoursto');
			$email=$this->input->post('email');
			$format=$this->input->post('format');
			if($this->store_model->editstoreinmall($id,$name,$city,$brand,$mall,$floor,$contactno,$email,$format,$offer,$shopclosedon,$workinghoursfrom,$workinghoursto,$description)==0)
			$data['alerterror']="Store in Mall could not be edited.";
			else
			$data['alertsuccess']="Store in Mall Updated Successfully.";
			
			$data['table']=$this->store_model->viewstoreinmall();
			$data['redirect']="site/viewstoreinmall";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
	function createstoreinmallsubmit()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('city','city','trim|required');
		$this->form_validation->set_rules('brand','brand','trim|required');
		$this->form_validation->set_rules('mall','mall','trim|required');
		$this->form_validation->set_rules('floor','floor','trim|required');
		$this->form_validation->set_rules('offer','offer','trim|');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[mall.email]');
		$this->form_validation->set_rules('contactno','contactno','trim');
		$this->form_validation->set_rules('workinghoursfrom','workinghoursFrom','trim');
		$this->form_validation->set_rules('workinghoursto','workinghoursTo','trim');
		$this->form_validation->set_rules('description','Description','trim');
		$this->form_validation->set_rules('shopclosedon','shopclosedon','trim');
        
//		$this->form_validation->set_rules('website','Website','trim|max_length[50]');
//		$this->form_validation->set_rules('facebookpage','facebookpage','trim');
//		$this->form_validation->set_rules('twitterpage','twitterpage','trim');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='createstoreinmall';
			$data['title']='Create New Store in Mall';
            $data['city']=$this->city_model->getcitydropdown();
            $data['brand']=$this->brand_model->getbranddropdown();
        $data['shopclosedon']=$this->store_model->getshopclosedondropdown();
            $data['mall']=$this->mall_model->getmalldropdown();
            $data['floor']=$this->mall_model->getfloordropdown();
			$this->load->view('template',$data);
		}
		else
		{
			$name=$this->input->post('name');
			$city=$this->input->post('city');
			$brand=$this->input->post('brand');
			$mall=$this->input->post('mall');
			$floor=$this->input->post('floor');
			$offer=$this->input->post('offer');
			$contactno=$this->input->post('contactno');
			$description=$this->input->post('description');
//			$facebookpage=$this->input->post('facebookpage');
//			$twitterpage=$this->input->post('twitterpage');
//			$website=$this->input->post('website');
			$email=$this->input->post('email');
			$format=$this->input->post('format');
			$shopclosedon=$this->input->post('shopclosedon');
			$workinghoursfrom=$this->input->post('workinghoursfrom');
			$workinghoursto=$this->input->post('workinghoursto');
//			$config['upload_path'] = './uploads/';
//			$config['allowed_types'] = 'gif|jpg|png|jpeg';
//			$this->load->library('upload', $config);
//			$filename="logo";
//			$logo="";
//			if (  $this->upload->do_upload($filename))
//			{
//				$uploaddata = $this->upload->data();
//				$logo=$uploaddata['file_name'];
//			}
			if($this->store_model->createstoreinmall($name,$city,$brand,$mall,$floor,$contactno,$email,$format,$offer,$shopclosedon,$workinghoursfrom,$workinghoursto,$description)==0)
			$data['alerterror']="New Store in Mall could not be created.";
			else
			$data['alertsuccess']="Store in Mall created Successfully.";
			
			$data['table']=$this->store_model->viewstoreinmall();
			$data['redirect']="site/viewstoreinmall";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
     public function createindividualstore()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createindividualstore';
		$data[ 'title' ] = 'Create Individual Store';
		$data['city']=$this->city_model->getcitydropdown();
        $data['brand']=$this->brand_model->getbranddropdown();
        $data['shopclosedon']=$this->store_model->getshopclosedondropdown();
//        $data['mall']=$this->mall_model->getmalldropdown();
//        $data['floor']=$this->mall_model->getfloordropdown();
        $data['location']=$this->city_model->getlocationdropdown();
        $data['offer']=$this->offer_model->getofferdropdown();
//        $data['topic']=$this->topic_model->gettopic();
//		$data['listingtype']=$this->event_model->getlistingtype();
//		$data['remainingticket']=$this->event_model->getremainingticket();
		$this->load->view( 'template', $data );	
	}
     public function editindividualstore()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'editindividualstore';
		$data[ 'title' ] = 'Edit Individual Store';
		$data['before']=$this->store_model->beforeeditindividualstore($this->input->get('id'));
		$data['city']=$this->city_model->getcitydropdown();
        $data['brand']=$this->brand_model->getbranddropdown();
        $data['offer']=$this->offer_model->getofferdropdown();
        $data['shopclosedon']=$this->store_model->getshopclosedondropdown();
//        $data['mall']=$this->mall_model->getmalldropdown();
//        $data['floor']=$this->mall_model->getfloordropdown();
        $data['location']=$this->city_model->getlocationdropdown();
//        $data['topic']=$this->topic_model->gettopic();
//		$data['listingtype']=$this->event_model->getlistingtype();
//		$data['remainingticket']=$this->event_model->getremainingticket();
		$this->load->view( 'template', $data );	
	}
	function createindividualstoresubmit()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('city','city','trim|required');
		$this->form_validation->set_rules('brand','brand','trim|required');
		$this->form_validation->set_rules('offer','offer','trim|');
		$this->form_validation->set_rules('workinghoursfrom','Workinghoursfrom','trim|');
		$this->form_validation->set_rules('workinghoursto','Workinghoursto','trim|');
		$this->form_validation->set_rules('shopclosedon','shopclosedon','trim|');
		$this->form_validation->set_rules('address','Address','trim|required');
		$this->form_validation->set_rules('description','Description','trim');
		$this->form_validation->set_rules('location','Location','trim|required');
		$this->form_validation->set_rules('latitude','Latitude','trim|required');
		$this->form_validation->set_rules('longitude','Longitude','trim|required');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[mall.email]');
		$this->form_validation->set_rules('contactno','contactno','trim');
//		$this->form_validation->set_rules('website','Website','trim|max_length[50]');
//		$this->form_validation->set_rules('facebookpage','facebookpage','trim');
//		$this->form_validation->set_rules('twitterpage','twitterpage','trim');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'page' ] = 'createindividualstore';
		$data[ 'title' ] = 'Create Individual Store';
		$data['city']=$this->city_model->getcitydropdown();
        $data['brand']=$this->brand_model->getbranddropdown();
        $data['shopclosedon']=$this->store_model->getshopclosedondropdown();
        $data['mall']=$this->mall_model->getmalldropdown();
        $data['floor']=$this->mall_model->getfloordropdown();
        $data['offer']=$this->offer_model->getofferdropdown();
        $data['location']=$this->city_model->getlocationdropdown();
		$this->load->view( 'template', $data );
		}
		else
		{
			$name=$this->input->post('name');
			$city=$this->input->post('city');
			$brand=$this->input->post('brand');
			$offer=$this->input->post('offer');
			$workinghoursfrom=$this->input->post('workinghoursfrom');
			$workinghoursto=$this->input->post('workinghoursto');
			$shopclosedon=$this->input->post('shopclosedon');
			$address=$this->input->post('address');
			$description=$this->input->post('description');
			$location=$this->input->post('location');
			$latitude=$this->input->post('latitude');
			$longitude=$this->input->post('longitude');
			$contactno=$this->input->post('contactno');
            
//			$facebookpage=$this->input->post('facebookpage');
//			$twitterpage=$this->input->post('twitterpage');
//			$website=$this->input->post('website');
			$email=$this->input->post('email');
			$format=$this->input->post('format');
//			$config['upload_path'] = './uploads/';
//			$config['allowed_types'] = 'gif|jpg|png|jpeg';
//			$this->load->library('upload', $config);
//			$filename="logo";
//			$logo="";
//			if (  $this->upload->do_upload($filename))
//			{
//				$uploaddata = $this->upload->data();
//				$logo=$uploaddata['file_name'];
//			}
			if($this->store_model->createindividualstore($name,$city,$brand,$address,$location,$latitude,$longitude,$contactno,$email,$format,$offer,$workinghoursfrom,$workinhhoursto,$shopclosedon,$description)==0)
			$data['alerterror']="New Individual Store could not be created.";
			else
			$data['alertsuccess']="Individual Store created Successfully.";
			
			$data['table']=$this->store_model->viewindividualstore();
			$data['redirect']="site/viewindividualstore";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
	function editindividualstoresubmit()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('city','city','trim|required');
		$this->form_validation->set_rules('brand','brand','trim|required');
		$this->form_validation->set_rules('offer','offer','trim|required');
		$this->form_validation->set_rules('workinghoursfrom','Workinghoursfrom','trim|');
		$this->form_validation->set_rules('workinghoursto','Workinghoursto','trim|');
		$this->form_validation->set_rules('address','Address','trim|required');
		$this->form_validation->set_rules('description','Description','trim');
		$this->form_validation->set_rules('location','Location','trim|required');
		$this->form_validation->set_rules('latitude','Latitude','trim|required');
		$this->form_validation->set_rules('longitude','Longitude','trim|required');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[mall.email]');
		$this->form_validation->set_rules('contactno','contactno','trim');
//		$this->form_validation->set_rules('website','Website','trim|max_length[50]');
//		$this->form_validation->set_rules('facebookpage','facebookpage','trim');
//		$this->form_validation->set_rules('twitterpage','twitterpage','trim');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'page' ] = 'editindividualstore';
		$data[ 'title' ] = 'Edit Individual Store';
		$data['before']=$this->store_model->beforeeditindividualstore($this->input->get('id'));
		$data['city']=$this->city_model->getcitydropdown();
        $data['brand']=$this->brand_model->getbranddropdown();
        $data['shopclosedon']=$this->store_model->getshopclosedondropdown();
        $data['offer']=$this->offer_model->getofferdropdown();
//        $data['mall']=$this->mall_model->getmalldropdown();
//        $data['floor']=$this->mall_model->getfloordropdown();
        $data['location']=$this->city_model->getlocationdropdown();
		$this->load->view( 'template', $data );
		}
		else
		{
			$id=$this->input->get_post('id');
			$name=$this->input->post('name');
			$city=$this->input->post('city');
			$brand=$this->input->post('brand');
			$offer=$this->input->post('offer');
			$workinghoursfrom=$this->input->post('workinghoursfrom');
			$workinghoursto=$this->input->post('workinghoursto');
			$shopclosedon=$this->input->post('shopclosedon');
			$address=$this->input->post('address');
			$description=$this->input->post('description');
			$location=$this->input->post('location');
			$latitude=$this->input->post('latitude');
			$longitude=$this->input->post('longitude');
			$contactno=$this->input->post('contactno');
			$facebookpage=$this->input->post('facebookpage');
			$twitterpage=$this->input->post('twitterpage');
			$website=$this->input->post('website');
			$email=$this->input->post('email');
			$format=$this->input->post('format');
			if($this->store_model->editindividualstore($id,$name,$city,$brand,$address,$location,$latitude,$longitude,$contactno,$email,$format,$offer,$workinghoursfrom,$workinhhoursto,$shopclosedon,$description)==0)
			$data['alerterror']=" Individual Store could not be Updated.";
			else
			$data['alertsuccess']="Individual Store Updated Successfully.";
			
			$data['table']=$this->store_model->viewindividualstore();
			$data['redirect']="site/viewindividualstore";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
    
	function deletestoreinmall()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->store_model->deletestoreinmall($this->input->get('id'));
		$data['table']=$this->store_model->viewstoreinmall();
		$data['page']='viewstoreinmall';
		$data['title']='View Stores in mall';
		$this->load->view('template',$data);
	}
	function deleteindividualstore()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->store_model->deleteindividualstore($this->input->get('id'));
		$data['table']=$this->store_model->viewindividualstore();
		$data['page']='viewindividualstore';
		$data['title']='View Individual Stores';
		$this->load->view('template',$data);
	}
    
    //filters
    function filterstorebyofferid()
    {
		$id=$this->input->get_post('id');
        $this->store_model->filterstorebyofferid($this->input->get_post('id'));
        
    
    }
    function filterbrandbycategoryid()
    {
		$id=$this->input->get_post('id');
        $this->brand_model->filterbrandbycategoryid($this->input->get_post('id'));
        
    
    }
    
    
    public function getstore($id)
    {
   $data=$this->store_model->getstore($id);
        
        if($data!="No Store"){
         $options = array("Please Select");
        foreach ( $data as $data1 ) {
        $options[$data1->id] = $data1->name;
        }
          //  print_r($options);
//       echo "hdoiwhdawISAHDSHA";
    
            
             echo "<div class='form-group'>
                <label class='col-sm-2 control-label'>Store Name</label>
                <div class='col-sm-4'>";
              
                  
                echo form_dropdown('storeid',$options,'id="select1"  class="form-control populate placeholder select2-                      offscreen"');
                    
              
                    

               // echo form_dropdown('data',$options,set_value('id'),"id='select1' onChange='changechapter()' class='form-control populate placeholder select2-offscreen'");

              
               echo "</div>
                </div>";
        }
        else{
        echo "<div class='form-group'>
                <label class='col-sm-2 control-label'>Store Name</label>
                <div class='col-sm-4'>No Store for This Brand";

              
               echo "</div>
                </div>";
        
        
        
        }
    }
    
    //Shop 
    
	function viewshop()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->shop_model->viewshop();
		$data['page']='viewshop';
		$data['title']='View Shop';
		$this->load->view('template',$data);
	}
        
     public function createshop()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createshop';
		$data[ 'title' ] = 'Create Shop';
        $data['user']=$this->user_model->getuserdropdown();
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$this->load->view( 'template', $data );	
	}
	function createshopsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('alias','Alias','trim');
		$this->form_validation->set_rules('status','status','trim');
		$this->form_validation->set_rules('metatitle','metatitle','trim');
		$this->form_validation->set_rules('metadescription','metadescription','trim');
		$this->form_validation->set_rules('banner','banner','trim');
		$this->form_validation->set_rules('bannerdescription','bannerdescription','trim');
		$this->form_validation->set_rules('defaulttax','defaulttax','trim');
		$this->form_validation->set_rules('user','user','trim');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='createshop';
			$data['title']='Create New Shop';
            $data['user']=$this->user_model->getuserdropdown();
            $data[ 'status' ] =$this->user_model->getstatusdropdown();
			$this->load->view('template',$data);
		}
		else
		{
			$name=$this->input->post('name');
			$alias=$this->input->post('alias');
			$status=$this->input->post('status');
			$metatitle=$this->input->post('metatitle');
			$metadescription=$this->input->post('metadescription');
			$bannerdescription=$this->input->post('bannerdescription');
			$defaulttax=$this->input->post('defaulttax');
			$user=$this->input->post('user');
			
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="banner";
			$banner="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$banner=$uploaddata['file_name'];
			}
			if($this->shop_model->create($name,$alias,$status,$metatitle,$metadescription,$banner,$bannerdescription,$defaulttax,$user)==0)
			$data['alerterror']="New Shop could not be created.";
			else
			$data['alertsuccess']="Shop created Successfully.";
			
			$data['table']=$this->shop_model->viewshop();
			$data['redirect']="site/viewshop";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
    
    function editshop()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->shop_model->beforeedit($this->input->get('id'));
        $data[ 'status' ] =$this->user_model->getstatusdropdown();
        $data['user']=$this->user_model->getuserdropdown();
		$data['page']='editshop';
		$data['title']='Edit Shop';
		$this->load->view('template',$data);
	}
	function editshopsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('alias','Alias','trim');
		$this->form_validation->set_rules('status','status','trim');
		$this->form_validation->set_rules('metatitle','metatitle','trim');
		$this->form_validation->set_rules('metadescription','metadescription','trim');
		$this->form_validation->set_rules('banner','banner','trim');
		$this->form_validation->set_rules('bannerdescription','bannerdescription','trim');
		$this->form_validation->set_rules('defaulttax','defaulttax','trim');
		$this->form_validation->set_rules('user','user','trim');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['before']=$this->store_model->beforeedit($this->input->post('id'));
            $data[ 'status' ] =$this->user_model->getstatusdropdown();
//			$data['page2']='block/eventblock';
			$data['page']='editshop';
			$data['title']='Edit Shop';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			$name=$this->input->post('name');
			$alias=$this->input->post('alias');
			$status=$this->input->post('status');
			$metatitle=$this->input->post('metatitle');
			$metadescription=$this->input->post('metadescription');
			$bannerdescription=$this->input->post('bannerdescription');
			$defaulttax=$this->input->post('defaulttax');
			$user=$this->input->post('user');
            
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="banner";
			$banner="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$banner=$uploaddata['file_name'];
			}
            
            if($banner=="")
            {
            $banner=$this->shop_model->getbannerbyid($id);
               // print_r($image);
                $banner=$banner->bannername;
            }
			if($this->shop_model->edit($id,$name,$alias,$status,$metatitle,$metadescription,$banner,$bannerdescription,$defaulttax,$user)==0)
			$data['alerterror']="shop Editing was unsuccesful";
			else
			$data['alertsuccess']="shop edited Successfully.";
			
			$data['redirect']="site/viewshop";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
    
    
	function changeshopstatus()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->shop_model->changeshopstatus($this->input->get('id'));
		$data['table']=$this->shop_model->viewshop();
		$data['alertsuccess']="Status Changed Successfully";
		$data['redirect']="site/viewshop";
        $this->load->view("redirect",$data);
	}
    
	function deleteshop()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->shop_model->deleteshop($this->input->get('id'));
		$data['table']=$this->shop_model->viewshop();
		$data['alertsuccess']="shop Deleted Successfully";
		$data['page']='viewshop';
		$data['title']='View shops';
		$this->load->view('template',$data);
	}
    
    
    //shop navigation
    
    function viewshopnavigation()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->shopnavigation_model->viewshopnavigation();
		$data['page']='viewshopnavigation';
		$data['title']='View shopnavigation';
		$this->load->view('template',$data);
	} 
       
     public function createshopnavigation()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createshopnavigation';
		$data[ 'title' ] = 'Create Shopnavigation';
        $data['user']=$this->shop_model->getshopdropdown();
        $data['filtergroup']=$this->filtergroup_model->getfiltergroupdropdown();
//        $data['user']=$this->user_model->getuserdropdown();
		$data[ 'status' ] =$this->shopnavigation_model->getstatusdropdown();
		$data[ 'isdefault' ] =$this->shopnavigation_model->getisdefaultdropdown();
		$data[ 'type' ] =$this->shopnavigation_model->gettypedropdown();
		$this->load->view( 'template', $data );	
	}
    function createshopnavigationsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('alias','Alias','trim');
		$this->form_validation->set_rules('shop','shop','trim');
		$this->form_validation->set_rules('order','order','trim');
		$this->form_validation->set_rules('metatitle','metatitle','trim');
		$this->form_validation->set_rules('metadescription','metadescription','trim');
		$this->form_validation->set_rules('bannerdescription','bannerdescription','trim');
		$this->form_validation->set_rules('positiononwebsite','positiononwebsite','trim');
//		$this->form_validation->set_rules('filtergroup','filtergroup');
		$this->form_validation->set_rules('sizes','sizes','trim');
		$this->form_validation->set_rules('status','status','trim');
		$this->form_validation->set_rules('isdefault','isdefault','trim');
		$this->form_validation->set_rules('type','type','trim');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='createshopnavigation';
			$data['title']='Create New Shopnavigation';
            $data['user']=$this->shop_model->getshopdropdown();
            $data['filtergroup']=$this->filtergroup_model->getfiltergroupdropdown();
            $data[ 'status' ] =$this->shopnavigation_model->getstatusdropdown();
            $data[ 'isdefault' ] =$this->shopnavigation_model->getisdefaultdropdown();
            $data[ 'type' ] =$this->shopnavigation_model->gettypedropdown();
			$this->load->view('template',$data);
		}
		else
		{
			$name=$this->input->post('name');
			$alias=$this->input->post('alias');
			$shop=$this->input->post('shop');
			$order=$this->input->post('order');
			$status=$this->input->post('status');
			$sizes=$this->input->post('sizes');
			$positiononwebsite=$this->input->post('positiononwebsite');
			$metatitle=$this->input->post('metatitle');
			$metadescription=$this->input->post('metadescription');
			$filtergroup=$this->input->post('filtergroup');
			$bannerdescription=$this->input->post('bannerdescription');
			$isdefault=$this->input->post('isdefault');
			$type=$this->input->post('type');
			print_r($filtergroup);
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="banner";
			$banner="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$banner=$uploaddata['file_name'];
			}
			if($this->shopnavigation_model->create($name,$alias,$shop,$order,$status,$metatitle,$metadescription,$banner,$bannerdescription,$isdefault,$type,$sizes,$positiononwebsite,$filtergroup)==0)
			$data['alerterror']="New Shop Navigation could not be created.";
			//else
			$data['alertsuccess']="Shop Navigation created Successfully.";
			
			$data['table']=$this->shopnavigation_model->viewshopnavigation();
			$data['redirect']="site/viewshopnavigation";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
    
    function editshopnavigation()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->shopnavigation_model->beforeedit($this->input->get('id'));
        $data['user']=$this->shop_model->getshopdropdown();
        $data['filtergroup']=$this->filtergroup_model->getfiltergroupdropdown();
        $data['selectedfiltergroup']=$this->filtergroup_model->getshopnavbyfiltergroup($this->input->get('id'));
//        $data['user']=$this->user_model->getuserdropdown();
		$data[ 'status' ] =$this->shopnavigation_model->getstatusdropdown();
		$data[ 'isdefault' ] =$this->shopnavigation_model->getisdefaultdropdown();
		$data[ 'type' ] =$this->shopnavigation_model->gettypedropdown();
		$data['page']='editshopnavigation';
		$data['title']='Edit Shopnavigation';
		$this->load->view('template',$data);
	}
	function editshopnavigationsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('alias','Alias','trim');
		$this->form_validation->set_rules('shop','shop','trim');
		$this->form_validation->set_rules('order','order','trim');
		$this->form_validation->set_rules('metatitle','metatitle','trim');
		$this->form_validation->set_rules('metadescription','metadescription','trim');
		$this->form_validation->set_rules('bannerdescription','bannerdescription','trim');
		$this->form_validation->set_rules('positiononwebsite','positiononwebsite','trim');
		$this->form_validation->set_rules('sizes','sizes','trim');
		$this->form_validation->set_rules('status','status','trim');
		$this->form_validation->set_rules('isdefault','isdefault','trim');
		$this->form_validation->set_rules('type','type','trim');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['before']=$this->shopnavigation_model->beforeedit($this->input->get('id'));
            $data['user']=$this->shop_model->getshopdropdown();
    //        $data['user']=$this->user_model->getuserdropdown();
            $data[ 'status' ] =$this->shopnavigation_model->getstatusdropdown();
            $data[ 'isdefault' ] =$this->shopnavigation_model->getisdefaultdropdown();
            $data[ 'type' ] =$this->shopnavigation_model->gettypedropdown();
            $data['page']='editshopnavigation';
            $data['title']='Edit Shopnavigation';
            $this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			$name=$this->input->post('name');
			$alias=$this->input->post('alias');
			$shop=$this->input->post('shop');
			$order=$this->input->post('order');
			$status=$this->input->post('status');
			$sizes=$this->input->post('sizes');
			$positiononwebsite=$this->input->post('positiononwebsite');
			$metatitle=$this->input->post('metatitle');
			$metadescription=$this->input->post('metadescription');
			$filtergroup=$this->input->post('filtergroup');
			$bannerdescription=$this->input->post('bannerdescription');
			$isdefault=$this->input->post('isdefault');
			$type=$this->input->post('type');
			//print_r($filtergroup);
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="banner";
			$banner="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$banner=$uploaddata['file_name'];
			}
            if($banner=="")
            {
                $banner=$this->shopnavigation_model->getbannerbyid($id);
//                print_r($banner);
                $banner=$banner->banner;
            }
//            print_r($banner);
			if($this->shopnavigation_model->edit($id,$name,$alias,$shop,$order,$status,$metatitle,$metadescription,$banner,$bannerdescription,$isdefault,$type,$sizes,$positiononwebsite,$filtergroup)==0)
			$data['alerterror']="shop Navigation Editing was unsuccesful";
			else
			$data['alertsuccess']="shop Navigation edited Successfully.";
			
			$data['redirect']="site/viewshopnavigation";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
    
    
	function changeshopnavigationstatus()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->shopnavigation_model->changeshopnavigationstatus($this->input->get('id'));
		$data['table']=$this->shopnavigation_model->viewshopnavigation();
		$data['alertsuccess']="Status Changed Successfully";
		$data['redirect']="site/viewshopnavigation";
        $this->load->view("redirect",$data);
	}
    
	function deleteshopnavigation()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->shopnavigation_model->deleteshopnavigation($this->input->get('id'));
		$data['table']=$this->shopnavigation_model->viewshopnavigation();
		$data['alertsuccess']="Shop Navigation Deleted Successfully";
		$data['page']='viewshopnavigation';
		$data['title']='View Shop Navigations';
		$this->load->view('template',$data);
	}
    
    //Product
    
//    function viewproduct()
//	{
//		$access = array("1");
//		$this->checkaccess($access);
////		$data['table']=$this->product_model->viewproduct();
//		$data['page']='viewproduct';
//        
//        $bothval=$this->product_model->viewproduct();
//        $data['table']=$bothval->query;
//        
//        $this->load->library('pagination');
//        $config['base_url'] = site_url("site/viewproduct");
//        $config['total_rows']=$bothval->totalcount;
//        $this->pagination->initialize($config); 
//        
//		$data['title']='View product';
//		$this->load->view('template',$data);
//	} 
    
    function viewproduct()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewproduct';
        $data['base_url']=site_url("site/viewproductjson");
		$data['title']='View Product';
		$this->load->view('template',$data);
	}
    function viewproductjson() 
    {
        $access = array("1");
		$this->checkaccess($access);
        
//        SELECT `orders`.`id`, `orders`.`retail`, `orders`.`sales`, DATE_FORMAT(`orders`.`timestamp`,'%b %d %Y %H:%i') as `timestamp`, `orders`.`amount`, `orders`.`signature`, `orders`.`salesid`, `orders`.`quantity`,`retailer`.`name` AS `retailername`, `orders`.`remark`
            
//        SELECT `product`.`id`, `product`.`name` AS `productname`, `product`.`product`, `product`.`encode`, `product`.`name2`, `product`.`productcode`,`product`. `category`,`product`. `video`,`product`. `mrp`,`product`. `description`,`product`. `age`,`product`. `scheme`,`product`.`isnew`,`product`. `timestamp`,`catelog`.`name` AS `categoryname`,`scheme`.`name` AS `schemename`
//FROM `product`
//LEFT OUTER JOIN `catelog` ON `catelog`.`id`=`product`.`category`
//LEFT OUTER JOIN `scheme` ON `scheme`.`id`=`product`.`scheme`
            
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`product`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]->field="`product`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Product Name";
        $elements[1]->alias="productname";
        
        $elements[2]->field="`product`.`productcode`";
        $elements[2]->sort="1";
        $elements[2]->header="Product Code";
        $elements[2]->alias="productcode";
        
        $elements[3]->field="`catelog`.`name`";
        $elements[3]->sort="1";
        $elements[3]->header="Category";
        $elements[3]->alias="categoryname";
        
        $elements[4]->field="`product`.`mrp`";
        $elements[4]->sort="1";
        $elements[4]->header="MRP";
        $elements[4]->alias="mrp";
        
        $elements[5]->field="`product`.`description`";
        $elements[5]->sort="1";
        $elements[5]->header="Description";
        $elements[5]->alias="description";
        
        $elements[6]->field="`scheme`.`name`";
        $elements[6]->sort="1";
        $elements[6]->header="Scheme";
        $elements[6]->alias="schemename";
        
        $elements[7]->field="`product`.`isnew`";
        $elements[7]->sort="1";
        $elements[7]->header="Is New";
        $elements[7]->alias="isnew";
        
        $elements[8]->field="`product`.`timestamp`";
        $elements[8]->sort="1";
        $elements[8]->header="Timestamp";
        $elements[8]->alias="timestamp";
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="DESC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `product` LEFT OUTER JOIN `catelog` ON `catelog`.`id`=`product`.`category` LEFT OUTER JOIN `scheme` ON `scheme`.`id`=`product`.`scheme`");
        
		$this->load->view("json",$data);
            
        
    }
    
        
     public function createproduct()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createproduct';
		$data[ 'title' ] = 'Create product';
        $data['category']=$this->category_model->getcategorydropdown();
        $data['scheme']=$this->scheme_model->getschemedropdown();
        $data['isnew']=$this->product_model->getisnewdropdown();
		$this->load->view( 'template', $data );	
	}
    function createproductsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('productcode','productcode','trim|required');
		$this->form_validation->set_rules('category','category','trim');
		$this->form_validation->set_rules('mrp','mrp','trim');
		$this->form_validation->set_rules('description','description','trim');
		$this->form_validation->set_rules('scheme','scheme','trim');
		$this->form_validation->set_rules('isnew','isnew','trim');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data[ 'page' ] = 'createproduct';
            $data[ 'title' ] = 'Create product';
            $data['category']=$this->category_model->getcategorydropdown();
            $data['scheme']=$this->scheme_model->getschemedropdown();
            $data['isnew']=$this->product_model->getisnewdropdown();
            $this->load->view( 'template', $data );	
	
		}
		else
		{
			$name=$this->input->post('name');
			$productcode=$this->input->post('productcode');
			$category=$this->input->post('category');
			$mrp=$this->input->post('mrp');
			$description=$this->input->post('description');
			$scheme=$this->input->post('scheme');
			$isnew=$this->input->post('isnew');
			
			if($this->product_model->create($name,$productcode,$category,$mrp,$description,$scheme,$isnew)==0)
			$data['alerterror']="New Product could not be created.";
			else
			$data['alertsuccess']="Product created Successfully.";
			
			$data['table']=$this->product_model->viewproduct();
			$data['redirect']="site/viewproduct";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
    
    function editproduct()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->product_model->beforeedit($this->input->get('id'));
        $data['category']=$this->category_model->getcategorydropdown();
        $data['scheme']=$this->scheme_model->getschemedropdown();
        $data['isnew']=$this->product_model->getisnewdropdown();
		$data['page']='editproduct';
		$data['title']='Edit product';
		$this->load->view('template',$data);
	}
	function editproductsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('productcode','productcode','trim|required');
		$this->form_validation->set_rules('category','category','trim');
		$this->form_validation->set_rules('mrp','mrp','trim');
		$this->form_validation->set_rules('description','description','trim');
		$this->form_validation->set_rules('scheme','scheme','trim');
		$this->form_validation->set_rules('isnew','isnew','trim');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['before']=$this->product_model->beforeedit($this->input->get('id'));
            $data['category']=$this->category_model->getcategorydropdown();
            $data['scheme']=$this->scheme_model->getschemedropdown();
            $data['isnew']=$this->product_model->getisnewdropdown();
            $data['page']='editproduct';
            $data['title']='Edit product';
            $this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			$name=$this->input->post('name');
			$productcode=$this->input->post('productcode');
			$category=$this->input->post('category');
			$mrp=$this->input->post('mrp');
			$description=$this->input->post('description');
			$scheme=$this->input->post('scheme');
			$isnew=$this->input->post('isnew');
            
			if($this->product_model->edit($id,$name,$productcode,$category,$mrp,$description,$scheme,$isnew)==0)
			$data['alerterror']="product Editing was unsuccesful";
			else
			$data['alertsuccess']="product edited Successfully.";
			
			$data['redirect']="site/viewproduct";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
    
	function deleteproduct()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->product_model->deleteproduct($this->input->get('id'));
		$data['table']=$this->product_model->viewproduct();
		$data['alertsuccess']="product Deleted Successfully";
		$data['page']='viewproduct';
		$data['title']='View products';
		$this->load->view('template',$data);
	}
	
    //attribute
    
    function viewattribute()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->attribute_model->viewattribute();
		$data['page']='viewattribute';
		$data['title']='View attribute';
		$this->load->view('template',$data);
	} 
    
     public function createattribute()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createattribute';
		$data[ 'title' ] = 'Create attribute';
		$this->load->view( 'template', $data );	
	}
    function createattributesubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
		$data[ 'page' ] = 'createattribute';
		$data[ 'title' ] = 'Create attribute';
		$this->load->view( 'template', $data );
		}
		else
		{
			$name=$this->input->post('name');
			
			if($this->attribute_model->create($name)==0)
			$data['alerterror']="New Attribute could not be created.";
			else
			$data['alertsuccess']="Attribute created Successfully.";
			
			$data['table']=$this->attribute_model->viewattribute();
			$data['redirect']="site/viewattribute";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
    
     function editattribute()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->attribute_model->beforeedit($this->input->get('id'));
		$data['page']='editattribute';
		$data['title']='Edit Attribute';
		$this->load->view('template',$data);
	}
	function editattributesubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data['before']=$this->attribute_model->beforeedit($this->input->get('id'));
            $data['page']='editattribute';
            $data['title']='Edit Attribute';
            $this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->get_post('id');
			$name=$this->input->post('name');
			if($this->attribute_model->edit($id,$name)==0)
			$data['alerterror']="attribute Editing was unsuccesful";
			else
			$data['alertsuccess']="attribute edited Successfully.";
			
			$data['redirect']="site/viewattribute";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
    
	function deleteattribute()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->attribute_model->delete($this->input->get('id'));
		$data['table']=$this->attribute_model->viewattribute();
		$data['alertsuccess']="attribute Deleted Successfully";
		$data['page']='viewattribute';
		$data['title']='View attribute';
		$this->load->view('template',$data);
	}
    
    //Filtergroup
    
    function viewfiltergroup()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->filtergroup_model->viewfiltergroup();
		$data['page']='viewfiltergroup';
		$data['title']='View filtergroup';
		$this->load->view('template',$data);
	} 
     public function createfiltergroup()
	{
		$access = array("1");
		$this->checkaccess($access);
        $data['attribute']=$this->attribute_model->getattributedropdown();
		$data[ 'page' ] = 'createfiltergroup';
		$data[ 'title' ] = 'Create filtergroup';
		$this->load->view( 'template', $data );	
	}
    function createfiltergroupsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('attribute','attribute','required');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data['attribute']=$this->attribute_model->getattributedropdown();
            $data[ 'page' ] = 'createfiltergroup';
            $data[ 'title' ] = 'Create filtergroup';
            $this->load->view( 'template', $data );
		}
		else
		{
			$name=$this->input->post('name');
			$attribute=$this->input->post('attribute');
            print_r($attribute);
			
			if($this->filtergroup_model->create($name,$attribute)==0)
			$data['alerterror']="New filtergroup could not be created.";
			else
			$data['alertsuccess']="filtergroup created Successfully.";
			
			$data['table']=$this->filtergroup_model->viewfiltergroup();
			$data['redirect']="site/viewfiltergroup";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
    
     function editfiltergroup()
	{
		$access = array("1");
		$this->checkaccess($access);
        $data['attribute']=$this->attribute_model->getattributedropdown();
		$data['before']=$this->filtergroup_model->beforeedit($this->input->get('id'));
        $data['selectedattribute']=$this->attribute_model->getfiltergroupbyattribute($this->input->get('id'));
		$data['page']='editfiltergroup';
		$data['title']='Edit filtergroup';
		$this->load->view('template',$data);
	}
	function editfiltergroupsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('attribute','attribute','required');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data['before']=$this->filtergroup_model->beforeedit($this->input->get('id'));
            $data['attribute']=$this->attribute_model->getattributedropdown();
            $data['selectedattribute']=$this->attribute_model->getfiltergroupbyattribute($this->input->get('id'));
            $data['page']='editfiltergroup';
            $data['title']='Edit filtergroup';
            $this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->get_post('id');
			$name=$this->input->post('name');
			$attribute=$this->input->post('attribute');
			if($this->filtergroup_model->edit($id,$name,$attribute)==0)
			$data['alerterror']="filtergroup Editing was unsuccesful";
			else
			$data['alertsuccess']="filtergroup edited Successfully.";
			
			$data['redirect']="site/viewfiltergroup";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
    
	function deletefiltergroup()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->filtergroup_model->delete($this->input->get('id'));
		$data['table']=$this->filtergroup_model->viewfiltergroup();
		$data['alertsuccess']="filtergroup Deleted Successfully";
		$data['page']='viewfiltergroup';
		$data['title']='View filtergroup';
		$this->load->view('template',$data);
	}
    
    
    //Coupon
    
    function viewcoupon()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->coupon_model->viewcoupon();
		$data['page']='viewcoupon';
		$data['title']='View coupon';
		$this->load->view('template',$data);
	} 
     public function createcoupon()
	{
		$access = array("1");
		$this->checkaccess($access);
        $data['codes']=$this->coupon_model->getcodesdropdown();
		$data[ 'page' ] = 'createcoupon';
		$data[ 'title' ] = 'Create coupon';
		$this->load->view( 'template', $data );	
	}
    function createcouponsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('codes','codes','required');
		$this->form_validation->set_rules('rules','rules','trim|');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data['codes']=$this->coupon_model->getcodesdropdown();
            $data[ 'page' ] = 'createcoupon';
            $data[ 'title' ] = 'Create coupon';
            $this->load->view( 'template', $data );
		}
		else
		{
			$name=$this->input->post('name');
			$rules=$this->input->post('rules');
			$codes=$this->input->post('codes');
			
			if($this->coupon_model->create($name,$rules,$codes)==0)
			$data['alerterror']="New coupon could not be created.";
			else
			$data['alertsuccess']="coupon created Successfully.";
			
			$data['table']=$this->coupon_model->viewcoupon();
			$data['redirect']="site/viewcoupon";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
    
     function editcoupon()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->coupon_model->beforeedit($this->input->get('id'));
        $data['codes']=$this->coupon_model->getcodesdropdown();
        $data['selectedcodes']=$this->coupon_model->getcodesbycoupon($this->input->get('id'));
		$data['page']='editcoupon';
		$data['title']='Edit coupon';
		$this->load->view('template',$data);
	}
	function editcouponsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('codes','codes','required');
		$this->form_validation->set_rules('rules','rules','trim|');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data['before']=$this->coupon_model->beforeedit($this->input->get('id'));
            $data['codes']=$this->coupon_model->getcodesdropdown();
            $data['selectedcodes']=$this->coupon_model->getcodesbycoupon($this->input->get('id'));
            $data['page']='editcoupon';
            $data['title']='Edit coupon';
            $this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->get_post('id');
			$name=$this->input->post('name');
			$rules=$this->input->post('rules');
			$codes=$this->input->post('codes');
			if($this->coupon_model->edit($id,$name,$rules,$codes)==0)
			$data['alerterror']="coupon Editing was unsuccesful";
			else
			$data['alertsuccess']="coupon edited Successfully.";
			
			$data['redirect']="site/viewcoupon";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
    
	function deletecoupon()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->coupon_model->delete($this->input->get('id'));
		$data['table']=$this->coupon_model->viewcoupon();
		$data['alertsuccess']="coupon Deleted Successfully";
		$data['page']='viewcoupon';
		$data['title']='View coupon';
		$this->load->view('template',$data);
	}
    
    //vendor
    
    function viewvendor()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->vendor_model->viewvendor();
		$data['page']='viewvendor';
		$data['title']='View vendor';
		$this->load->view('template',$data);
	} 
     public function createvendor()
	{
		$access = array("1");
		$this->checkaccess($access);
        $data['shop']=$this->shop_model->getshopdropdown();
		$data[ 'page' ] = 'createvendor';
		$data[ 'title' ] = 'Create Vendor';
		$this->load->view( 'template', $data );	
	}
    function createvendorsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('shop','shop','trim|required');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('contact','contact','required');
		$this->form_validation->set_rules('vat','vat','required');
		$this->form_validation->set_rules('tin','tin','required');
		$this->form_validation->set_rules('address','address','required');
		$this->form_validation->set_rules('details','details','required');
		$this->form_validation->set_rules('pan','pan','required');
		$this->form_validation->set_rules('taxamount','taxamount','required');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data['shop']=$this->shop_model->getshopdropdown();
            $data[ 'page' ] = 'createvendor';
            $data[ 'title' ] = 'Create vendor';
            $this->load->view( 'template', $data );
		}
		else
		{
			$name=$this->input->post('name');
			$shop=$this->input->post('shop');
			$email=$this->input->post('email');
			$contact=$this->input->post('contact');
			$vat=$this->input->post('vat');
			$tin=$this->input->post('tin');
			$address=$this->input->post('address');
			$details=$this->input->post('details');
			$pan=$this->input->post('pan');
			$taxamount=$this->input->post('taxamount');
			
			if($this->vendor_model->create($name,$shop,$email,$contact,$vat,$tin,$address,$details,$pan,$taxamount)==0)
			$data['alerterror']="New vendor could not be created.";
			else
			$data['alertsuccess']="vendor created Successfully.";
			
			$data['table']=$this->vendor_model->viewvendor();
			$data['redirect']="site/viewvendor";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
    
     function editvendor()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->vendor_model->beforeedit($this->input->get('id'));
        $data['shop']=$this->shop_model->getshopdropdown();
		$data['page']='editvendor';
		$data['title']='Edit vendor';
		$this->load->view('template',$data);
	}
	function editvendorsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('shop','shop','trim|required');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('contact','contact','required');
		$this->form_validation->set_rules('vat','vat','required');
		$this->form_validation->set_rules('tin','tin','required');
		$this->form_validation->set_rules('address','address','required');
		$this->form_validation->set_rules('details','details','required');
		$this->form_validation->set_rules('pan','pan','required');
		$this->form_validation->set_rules('taxamount','taxamount','required');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data['before']=$this->vendor_model->beforeedit($this->input->get('id'));
            $data['shop']=$this->shop_model->getshopdropdown();
            $data['page']='editvendor';
            $data['title']='Edit vendor';
            $this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->get_post('id');
			$name=$this->input->post('name');
			$shop=$this->input->post('shop');
			$email=$this->input->post('email');
			$contact=$this->input->post('contact');
			$vat=$this->input->post('vat');
			$tin=$this->input->post('tin');
			$address=$this->input->post('address');
			$details=$this->input->post('details');
			$pan=$this->input->post('pan');
			$taxamount=$this->input->post('taxamount');
			if($this->vendor_model->edit($id,$name,$shop,$email,$contact,$vat,$tin,$address,$details,$pan,$taxamount)==0)
			$data['alerterror']="Vendor Editing was unsuccesful";
			else
			$data['alertsuccess']="Vendor edited Successfully.";
			
			$data['redirect']="site/viewvendor";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
    
	function deletevendor()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->vendor_model->deletevendor($this->input->get('id'));
		$data['table']=$this->vendor_model->viewvendor();
		$data['alertsuccess']="vendor Deleted Successfully";
		$data['page']='viewvendor';
		$data['title']='View vendor';
		$this->load->view('template',$data);
	}
    
    
    //area
    
    function viewarea()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewarea';
        
        
        $data['base_url'] = site_url("site/viewareajson");
        
        
		$data['title']='View Area';
		$this->load->view('template',$data);
	} 
    
    function viewareajson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
//        SELECT  `retailer`.`id`, `retailer`.`area`, `retailer`.`dob`,`retailer`.`name`, `retailer`.`number`, `retailer`.`email`, `retailer`.`address`,`retailer`. `ownername`, `retailer`.`ownernumber`, `retailer`.`contactname`,`retailer`. `contactnumber`,`area`.`name` AS `areaname` FROM `retailer` LEFT OUTER JOIN `area` ON `area`.`id`=`retailer`.`area`
        
            
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`area`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]->field="`area`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Area Name";
        $elements[1]->alias="areaname";
        
        $elements[2]->field="`city`.`name`";
        $elements[2]->sort="1";
        $elements[2]->header="City";
        $elements[2]->alias="cityname";
        
        $elements[3]->field="`distributor`.`name`";
        $elements[3]->sort="1";
        $elements[3]->header="Distributor";
        $elements[3]->alias="distributorname";
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `area` LEFT OUTER JOIN `city` ON `area`.`city`=`city`.`id`  LEFT OUTER JOIN `distributor` ON `area`.`distributor`=`distributor`.`id`");
        
		$this->load->view("json",$data);
	} 
    
     public function createarea()
	{
		$access = array("1");
		$this->checkaccess($access);
        $data['distributor']=$this->area_model->getdistributordropdown();
        $data['city']=$this->area_model->getcitydropdown();
		$data[ 'page' ] = 'createarea';
		$data[ 'title' ] = 'Create area';
		$this->load->view( 'template', $data );	
	}
    function createareasubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('city','city','trim|required');
		$this->form_validation->set_rules('distributor','distributor','trim');
		
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data['distributor']=$this->area_model->getdistributordropdown();
            $data['city']=$this->area_model->getcitydropdown();
            $data[ 'page' ] = 'createarea';
            $data[ 'title' ] = 'Create area';
            $this->load->view( 'template', $data );
		}
		else
		{
			$name=$this->input->post('name');
			$city=$this->input->post('city');
			$distributor=$this->input->post('distributor');
			
			if($this->area_model->create($name,$city,$distributor)==0)
			$data['alerterror']="New area could not be created.";
			else
			$data['alertsuccess']="area created Successfully.";
			
			$data['table']=$this->area_model->viewarea();
			$data['redirect']="site/viewarea";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
    
     function editarea()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->area_model->beforeedit($this->input->get('id'));
        $data['distributor']=$this->area_model->getdistributordropdown();
        $data['city']=$this->area_model->getcitydropdown();
		$data['page']='editarea';
		$data['title']='Edit area';
		$this->load->view('template',$data);
	}
	function editareasubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('city','city','trim|required');
		$this->form_validation->set_rules('distributor','distributor','trim');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data['before']=$this->area_model->beforeedit($this->input->get('id'));
            $data['distributor']=$this->area_model->getdistributordropdown();
            $data['city']=$this->area_model->getcitydropdown();
            $data['page']='editarea';
            $data['title']='Edit area';
            $this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->get_post('id');
			$name=$this->input->post('name');
			$city=$this->input->post('city');
			$distributor=$this->input->post('distributor');
			
			if($this->area_model->edit($id,$name,$city,$distributor)==0)
			$data['alerterror']="area Editing was unsuccesful";
			else
			$data['alertsuccess']="area edited Successfully.";
			
			$data['redirect']="site/viewarea";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
    
	function deletearea()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->area_model->deletearea($this->input->get('id'));
		$data['table']=$this->area_model->viewarea();
		$data['alertsuccess']="area Deleted Successfully";
		$data['page']='viewarea';
		$data['title']='View area';
		$this->load->view('template',$data);
	}
    
    
    //state
    
    function viewstate()
	{
		$access = array("1");
		$this->checkaccess($access);
//		$data['table']=$this->state_model->viewstate();
		$data['page']='viewstate';
        
        
        $bothval=$this->state_model->viewstate();
        $data['table']=$bothval->query;
        
        $this->load->library('pagination');
        $config['base_url'] = site_url("site/viewstate");
        $config['total_rows']=$bothval->totalcount;
        $this->pagination->initialize($config); 
        
        
		$data['title']='View state';
		$this->load->view('template',$data);
	} 
    public function createstate()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createstate';
		$data[ 'title' ] = 'Create state';
		$data['zone']=$this->user_model->getzonedropdown();
		$this->load->view( 'template', $data );	
	}
    function createstatesubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('zone','zone','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='createstate';
			$data['title']='Create New state';
            $data['zone']=$this->user_model->getzonedropdown();
			$this->load->view('template',$data);
		}
		else
		{
			$name=$this->input->post('name');
			$zone=$this->input->post('zone');
			if($this->state_model->create($name,$zone)==0)
			$data['alerterror']="New state could not be created.";
			else
			$data['alertsuccess']="state created Successfully.";
			
			$data['table']=$this->state_model->viewstate();
			$data['redirect']="site/viewstate";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
    
    function editstate()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->state_model->beforeedit($this->input->get('id'));
        $data['zone']=$this->user_model->getzonedropdown();
//		$data['organizer']=$this->organizer_model->getorganizer();
//		$data['listingtype']=$this->event_model->getlistingtype();
//		$data['remainingticket']=$this->event_model->getremainingticket();
//		$data['page2']='block/eventblock';
		$data['page']='editstate';
		$data['title']='Edit state';
		$this->load->view('template',$data);
	}
	function editstatesubmit()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('zone','zone','trim|required');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
//			$data['organizer']=$this->organizer_model->getorganizer();
//			$data['listingtype']=$this->event_model->getlistingtype();
//			$data['remainingticket']=$this->event_model->getremainingticket();
			$data['before']=$this->state_model->beforeedit($this->input->post('id'));
            $data['zone']=$this->user_model->getzonedropdown();
//			$data['page2']='block/eventblock';
			$data['page']='editstate';
			$data['title']='Edit state';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			$name=$this->input->post('name');
			$zone=$this->input->post('zone');
			if($this->state_model->edit($id,$name,$zone)==0)
			$data['alerterror']="state Editing was unsuccesful";
			else
			$data['alertsuccess']="state edited Successfully.";
			
			$data['redirect']="site/viewstate";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
    
	function deletestate()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->state_model->deletestate($this->input->get('id'));
		$data['table']=$this->state_model->viewstate();
		$data['alertsuccess']="state Deleted Successfully";
		$data['page']='viewstate';
		$data['title']='View state';
		$this->load->view('template',$data);
	}
    
    //zone
    
    function viewzone()
	{
		$access = array("1");
		$this->checkaccess($access);
//		$data['table']=$this->zone_model->viewzone();
		$data['page']='viewzone';
        
        $bothval=$this->zone_model->viewzone();
        $data['table']=$bothval->query;
        
        $this->load->library('pagination');
        $config['base_url'] = site_url("site/viewzone");
        $config['total_rows']=$bothval->totalcount;
        $this->pagination->initialize($config); 
        
		$data['title']='View zone';
		$this->load->view('template',$data);
	} 
    public function createzone()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createzone';
		$data[ 'title' ] = 'Create zone';
		$this->load->view( 'template', $data );	
	}
    function createzonesubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('email','Email','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='createzone';
			$data['title']='Create New zone';
			$this->load->view('template',$data);
		}
		else
		{
			$name=$this->input->post('name');
			$email=$this->input->post('email');
			if($this->zone_model->create($name,$email)==0)
			$data['alerterror']="New zone could not be created.";
			else
			$data['alertsuccess']="zone created Successfully.";
			
			$data['table']=$this->zone_model->viewzone();
			$data['redirect']="site/viewzone";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
    
    function editzone()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->zone_model->beforeedit($this->input->get('id'));
		$data['page']='editzone';
		$data['title']='Edit zone';
		$this->load->view('template',$data);
	}
	function editzonesubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('email','Email','trim|required');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['before']=$this->zone_model->beforeedit($this->input->post('id'));
//			$data['page2']='block/eventblock';
			$data['page']='editzone';
			$data['title']='Edit zone';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			$name=$this->input->post('name');
			$email=$this->input->post('email');
			if($this->zone_model->edit($id,$name,$email)==0)
			$data['alerterror']="zone Editing was unsuccesful";
			else
			$data['alertsuccess']="zone edited Successfully.";
			
			$data['redirect']="site/viewzone";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
    
	function deletezone()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->zone_model->deletezone($this->input->get('id'));
		$data['table']=$this->zone_model->viewzone();
		$data['alertsuccess']="zone Deleted Successfully";
		$data['page']='viewzone';
		$data['title']='View zone';
		$this->load->view('template',$data);
	}
    
    //distributor
    
//    function viewdistributor()
//	{
//		$access = array("1");
//		$this->checkaccess($access);
////		$data['table']=$this->distributor_model->viewdistributor();
//		$data['page']='viewdistributor';
//        
//        
//        $bothval=$this->distributor_model->viewdistributor();
//        $data['table']=$bothval->query;
//        
//        $this->load->library('pagination');
//        $config['base_url'] = site_url("site/viewdistributor");
//        $config['total_rows']=$bothval->totalcount;
//        $this->pagination->initialize($config); 
//        
//		$data['title']='View distributor';
//		$this->load->view('template',$data);
//	} 
    function viewdistributor()
	{
		$access = array("1");
		$this->checkaccess($access);
//		$data['table']=$this->distributor_model->viewdistributor();
		$data['page']='viewdistributor';
        $data['base_url']=site_url("site/viewdistributorjson");
        
		$data['title']='View distributor';
		$this->load->view('template',$data);
	}
    function viewdistributorjson() 
    {
        $access = array("1");
		$this->checkaccess($access);
        
//        SELECT `orders`.`id`, `orders`.`retail`, `orders`.`sales`, DATE_FORMAT(`orders`.`timestamp`,'%b %d %Y %H:%i') as `timestamp`, `orders`.`amount`, `orders`.`signature`, `orders`.`salesid`, `orders`.`quantity`,`retailer`.`name` AS `retailername`, `orders`.`remark`
            
//        SELECT `distributor`.`id`, `distributor`.`name` AS `distributorname`, `distributor`.`code`,`distributor`. `componyname`, `distributor`.`email`, `distributor`.`contactno`, `distributor`.`dob`, `distributor`.`address1`, `distributor`.`address2`, `distributor`.`zipcode` FROM `distributor`
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`distributor`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]->field="`distributor`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="distributorname";
        
        $elements[2]->field="`distributor`.`code`";
        $elements[2]->sort="1";
        $elements[2]->header="Code";
        $elements[2]->alias="code";
        
        $elements[3]->field="`distributor`.`componyname`";
        $elements[3]->sort="1";
        $elements[3]->header="company";
        $elements[3]->alias="companyname";
        
        $elements[4]->field="`distributor`.`email`";
        $elements[4]->sort="1";
        $elements[4]->header="Email";
        $elements[4]->alias="email";
        
        $elements[5]->field="`distributor`.`contactno`";
        $elements[5]->sort="1";
        $elements[5]->header="Contact";
        $elements[5]->alias="contactno";
        
        $elements[6]->field="`distributor`.`dob`";
        $elements[6]->sort="1";
        $elements[6]->header="DOB";
        $elements[6]->alias="dob";
        
        $elements[7]->field="`distributor`.`address1`";
        $elements[7]->sort="1";
        $elements[7]->header="Address1";
        $elements[7]->alias="address1";
        
        $elements[8]->field="`distributor`.`address2`";
        $elements[8]->sort="1";
        $elements[8]->header="Address2";
        $elements[8]->alias="address2";
        
        $elements[9]->field="`distributor`.`zipcode`";
        $elements[9]->sort="1";
        $elements[9]->header="zipcode";
        $elements[9]->alias="zipcode";
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="DESC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `distributor`");
        
		$this->load->view("json",$data);
            
        
    }
    
    public function createdistributor()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createdistributor';
		$data[ 'title' ] = 'Create distributor';
		$this->load->view( 'template', $data );	
	}
    function createdistributorsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('code','code','trim|required');
		$this->form_validation->set_rules('componyname','componyname','trim|required');
        $this->form_validation->set_rules('email','Email','trim|required');
		$this->form_validation->set_rules('contactno','contactno','trim|required');
		$this->form_validation->set_rules('dob','dob','trim|required');
		$this->form_validation->set_rules('address1','address1','trim|required');
		$this->form_validation->set_rules('address2','address2','trim|required');
		$this->form_validation->set_rules('zipcode','zipcode','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='createdistributor';
			$data['title']='Create New distributor';
			$this->load->view('template',$data);
		}
		else
		{
			$name=$this->input->post('name');
			$code=$this->input->post('code');
			$componyname=$this->input->post('componyname');
			$email=$this->input->post('email');
			$contactno=$this->input->post('contactno');
			$dob=$this->input->post('dob');
            if($dob != "")
			{
				$dob = date("Y-m-d",strtotime($dob));
			}
			$address1=$this->input->post('address1');
			$address2=$this->input->post('address2');
			$zipcode=$this->input->post('zipcode');
//            echo $dob;
			if($this->distributor_model->create($name,$code,$componyname,$email,$contactno,$dob,$address1,$address2,$zipcode)==0)
			$data['alerterror']="New distributor could not be created.";
			else
			$data['alertsuccess']="distributor created Successfully.";
			
			$data['table']=$this->distributor_model->viewdistributor();
			$data['redirect']="site/viewdistributor";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
    
    function editdistributor()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->distributor_model->beforeedit($this->input->get('id'));
		$data['page']='editdistributor';
		$data['title']='Edit distributor';
		$this->load->view('template',$data);
	}
	function editdistributorsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('code','code','trim|required');
		$this->form_validation->set_rules('componyname','componyname','trim|required');
        $this->form_validation->set_rules('email','Email','trim|required');
		$this->form_validation->set_rules('contactno','contactno','trim|required');
		$this->form_validation->set_rules('dob','dob','trim|required');
		$this->form_validation->set_rules('address1','address1','trim|required');
		$this->form_validation->set_rules('address2','address2','trim|required');
		$this->form_validation->set_rules('zipcode','zipcode','trim|required');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['before']=$this->distributor_model->beforeedit($this->input->post('id'));
//			$data['page2']='block/eventblock';
			$data['page']='editdistributor';
			$data['title']='Edit distributor';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
            $name=$this->input->post('name');
			$code=$this->input->post('code');
			$componyname=$this->input->post('componyname');
			$email=$this->input->post('email');
			$contactno=$this->input->post('contactno');
			$dob=$this->input->post('dob');
            if($dob != "")
			{
				$dob = date("Y-m-d",strtotime($dob));
			}
			$address1=$this->input->post('address1');
			$address2=$this->input->post('address2');
			$zipcode=$this->input->post('zipcode');
			if($this->distributor_model->edit($id,$name,$code,$componyname,$email,$contactno,$dob,$address1,$address2,$zipcode)==0)
			$data['alerterror']="distributor Editing was unsuccesful";
			else
			$data['alertsuccess']="distributor edited Successfully.";
			
			$data['redirect']="site/viewdistributor";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
    
	function deletedistributor()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->distributor_model->deletedistributor($this->input->get('id'));
		$data['table']=$this->distributor_model->viewdistributor();
		$data['alertsuccess']="distributor Deleted Successfully";
		$data['page']='viewdistributor';
		$data['title']='View distributor';
		$this->load->view('template',$data);
	}
    
    //scheme
    
//    function viewscheme()
//	{
//		$access = array("1");
//		$this->checkaccess($access);
////		$data['table']=$this->scheme_model->viewscheme();
//		$data['page']='viewscheme';
//        
//        $bothval=$this->scheme_model->viewscheme();
//        $data['table']=$bothval->query;
//        
//        $this->load->library('pagination');
//        $config['base_url'] = site_url("site/viewscheme");
//        $config['total_rows']=$bothval->totalcount;
//        $this->pagination->initialize($config); 
//        
//		$data['title']='View scheme';
//		$this->load->view('template',$data);
//	} 
    function viewscheme()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewscheme';
        $data['base_url']=site_url("site/viewschemejson");
        
		$data['title']='View scheme';
		$this->load->view('template',$data);
	}
    function viewschemejson() 
    {
        $access = array("1");
		$this->checkaccess($access);
        
//        SELECT `distributor`.`id`, `distributor`.`name` AS `distributorname`, `distributor`.`code`,`distributor`. `componyname`, `distributor`.`email`, `distributor`.`contactno`, `distributor`.`dob`, `distributor`.`address1`, `distributor`.`address2`, `distributor`.`zipcode` FROM `distributor`
//        SELECT `scheme`.`id`, `scheme`.`name` AS `schemename`, `scheme`.`discount_percent`, `scheme`.`date_start`, `scheme`.`date_end`, `scheme`.`mrp` FROM `scheme`
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`scheme`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]->field="`scheme`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="schemename";
        
        $elements[2]->field="`scheme`.`discount_percent`";
        $elements[2]->sort="1";
        $elements[2]->header="Discount Percent";
        $elements[2]->alias="discount_percent";
        
        $elements[3]->field="`scheme`.`date_start`";
        $elements[3]->sort="1";
        $elements[3]->header="Start Date";
        $elements[3]->alias="date_start";
        
        $elements[4]->field="`scheme`.`date_end`";
        $elements[4]->sort="1";
        $elements[4]->header="Date End";
        $elements[4]->alias="date_end";
        
        $elements[5]->field="`scheme`.`mrp`";
        $elements[5]->sort="1";
        $elements[5]->header="MRP";
        $elements[5]->alias="mrp";
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="DESC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `scheme`");
        
		$this->load->view("json",$data);
            
        
    }
    public function createscheme()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createscheme';
		$data[ 'title' ] = 'Create scheme';
		$this->load->view( 'template', $data );	
	}
    function createschemesubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('discount_percent','discount_percent','trim|required');
		$this->form_validation->set_rules('date_start','date_start','required');
		$this->form_validation->set_rules('date_end','date_end','required');
		$this->form_validation->set_rules('mrp','mrp','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='createscheme';
			$data['title']='Create New scheme';
			$this->load->view('template',$data);
		}
		else
		{
			$name=$this->input->post('name');
			$discount_percent=$this->input->post('discount_percent');
			$date_start=$this->input->post('date_start');
			$date_end=$this->input->post('date_end');
			$mrp=$this->input->post('mrp');
            if($date_start != "")
			{
				$date_start = date("Y-m-d",strtotime($date_start));
			}
            if($date_end != "")
			{
				$date_end = date("Y-m-d",strtotime($date_end));
			}
            
//            echo $dob;
			if($this->scheme_model->create($name,$discount_percent,$date_start,$date_end,$mrp)==0)
			$data['alerterror']="New scheme could not be created.";
			else
			$data['alertsuccess']="scheme created Successfully.";
			
			$data['table']=$this->scheme_model->viewscheme();
			$data['redirect']="site/viewscheme";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
    
    function editscheme()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->scheme_model->beforeedit($this->input->get('id'));
		$data['page']='editscheme';
		$data['title']='Edit scheme';
		$this->load->view('template',$data);
	}
	function editschemesubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('discount_percent','discount_percent','trim|required');
		$this->form_validation->set_rules('date_start','date_start','required');
		$this->form_validation->set_rules('date_end','date_end','required');
		$this->form_validation->set_rules('mrp','mrp','trim|required');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['before']=$this->scheme_model->beforeedit($this->input->post('id'));
//			$data['page2']='block/eventblock';
			$data['page']='editscheme';
			$data['title']='Edit scheme';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
            $name=$this->input->post('name');
			$discount_percent=$this->input->post('discount_percent');
			$date_start=$this->input->post('date_start');
			$date_end=$this->input->post('date_end');
			$mrp=$this->input->post('mrp');
            if($date_start != "")
			{
				$date_start = date("Y-m-d",strtotime($date_start));
			}
            if($date_end != "")
			{
				$date_end = date("Y-m-d",strtotime($date_end));
			}
			if($this->scheme_model->edit($id,$name,$discount_percent,$date_start,$date_end,$mrp)==0)
			$data['alerterror']="scheme Editing was unsuccesful";
			else
			$data['alertsuccess']="scheme edited Successfully.";
			
			$data['redirect']="site/viewscheme";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
    
	function deletescheme()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->scheme_model->deletescheme($this->input->get('id'));
		$data['table']=$this->scheme_model->viewscheme();
		$data['alertsuccess']="scheme Deleted Successfully";
		$data['page']='viewscheme';
		$data['title']='View scheme';
		$this->load->view('template',$data);
	}
    
    //productimage
    
    function viewproductimage()
	{
		$access = array("1");
		$this->checkaccess($access);
//		$data['table']=$this->productimage_model->viewproductimage();
		$data['page']='viewproductimage';
        
        $bothval=$this->productimage_model->viewproductimage();
        $data['table']=$bothval->query;
        
        $this->load->library('pagination');
        $config['base_url'] = site_url("site/viewproductimage");
        $config['total_rows']=$bothval->totalcount;
        $this->pagination->initialize($config); 
        
		$data['title']='View productimage';
		$this->load->view('template',$data);
	} 
    public function createproductimage()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createproductimage';
		$data[ 'title' ] = 'Create productimage';
        $data['product']=$this->productimage_model->getproductdropdown();
		$this->load->view( 'template', $data );	
	}
    function createproductimagesubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('product','product','trim|required');
		$this->form_validation->set_rules('order','order','trim|required');
		
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='createproductimage';
			$data['title']='Create New productimage';
            $data['product']=$this->productimage_model->getproductdropdown();
			$this->load->view('template',$data);
		}
		else
		{
			$product=$this->input->post('product');
			$order=$this->input->post('order');
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
			}
            
			if($this->productimage_model->create($product,$image,$order)==0)
			$data['alerterror']="New productimage could not be created.";
			else
			$data['alertsuccess']="productimage created Successfully.";
			
			$data['table']=$this->productimage_model->viewproductimage();
			$data['redirect']="site/viewproductimage";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
    
    function editproductimage()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->productimage_model->beforeedit($this->input->get('id'));
        $data['product']=$this->productimage_model->getproductdropdown();
		$data['page']='editproductimage';
		$data['title']='Edit productimage';
		$this->load->view('template',$data);
	}
	function editproductimagesubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
        
		$this->form_validation->set_rules('product','product','trim|required');
		$this->form_validation->set_rules('order','order','trim|required');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['before']=$this->productimage_model->beforeedit($this->input->post('id'));
            $data['product']=$this->productimage_model->getproductdropdown();
//			$data['page2']='block/eventblock';
			$data['page']='editproductimage';
			$data['title']='Edit productimage';
			$this->load->view('template',$data);
		}
		else
		{
            
			$id=$this->input->post('id');
            $product=$this->input->post('product');
			$order=$this->input->post('order');
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
			}
            if($image=="")
            {
            $image=$this->productimage_model->getimagebyid($id);
               // print_r($image);
                $image=$image->image;
            }
			if($this->productimage_model->edit($id,$product,$image,$order)==0)
			$data['alerterror']="productimage Editing was unsuccesful";
			else
			$data['alertsuccess']="productimage edited Successfully.";
			
			$data['redirect']="site/viewproductimage";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
    
	function deleteproductimage()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->productimage_model->deleteproductimage($this->input->get('id'));
		$data['table']=$this->productimage_model->viewproductimage();
		$data['alertsuccess']="productimage Deleted Successfully";
		$data['page']='viewproductimage';
		$data['title']='View productimage';
		$this->load->view('template',$data);
	}
    
    
    function vieworderjson() 
    {
        $access = array("1");
		$this->checkaccess($access);
        
//        SELECT `orders`.`id`, `orders`.`retail`, `orders`.`sales`, DATE_FORMAT(`orders`.`timestamp`,'%b %d %Y %H:%i') as `timestamp`, `orders`.`amount`, `orders`.`signature`, `orders`.`salesid`, `orders`.`quantity`,`retailer`.`name` AS `retailername`, `orders`.`remark`
            
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`orders`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]->field="`orders`.`retail`";
        $elements[1]->sort="1";
        $elements[1]->header="Retail";
        $elements[1]->alias="retail";
        
        $elements[2]->field="`orders`.`sales`";
        $elements[2]->sort="1";
        $elements[2]->header="Sales";
        $elements[2]->alias="sales";
        
        $elements[3]->field="DATE_FORMAT(`orders`.`timestamp`,'%b %d %Y %H:%i')";
        $elements[3]->sort="1";
        $elements[3]->header="Timestamp";
        $elements[3]->alias="timestamp";
        
        $elements[4]->field="`orders`.`amount`";
        $elements[4]->sort="1";
        $elements[4]->header="Amount";
        $elements[4]->alias="amount";
        
        $elements[5]->field="`orders`.`signature`";
        $elements[5]->sort="1";
        $elements[5]->header="signature";
        $elements[5]->alias="signature";
        
        $elements[6]->field="`orders`.`salesid`";
        $elements[6]->sort="1";
        $elements[6]->header="Sales ID";
        $elements[6]->alias="salesid";
        
        $elements[7]->field="`orders`.`quantity`";
        $elements[7]->sort="1";
        $elements[7]->header="Quantity";
        $elements[7]->alias="quantity";
        
        $elements[8]->field="`retailer`.`name`";
        $elements[8]->sort="1";
        $elements[8]->header="Retailer";
        $elements[8]->alias="retailername";
        
        $elements[9]->field="`orders`.`remark`";
        $elements[9]->sort="0";
        $elements[9]->header="Remarks";
        $elements[9]->alias="remark";
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="DESC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `orders` LEFT OUTER JOIN `retailer` ON `retailer`.`id`=`orders`.`retail`");
        
		$this->load->view("json",$data);
            
        
    }
    
    
    //order
    function vieworder()
	{
		$access = array("1");
		$this->checkaccess($access);
//		$data['table']=$this->order_model->vieworder();
		$data['page']='vieworder';
        $data['base_url']=site_url("site/vieworderjson");
        
		$data['title']='View order';
		$this->load->view('template',$data);
	}
    function vieworderproduct()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->order_model->vieworderproduct($this->input->get('id'));
		$data['page']='vieworderproduct';
		$data['title']='View orderproduct';
		$this->load->view('template',$data);
	} 
    
//    function vieworderproduct()
//	{
//		$access = array("1");
//		$this->checkaccess($access);
////		$data['table']=$this->order_model->vieworderproduct($this->input->get('id'));
//		$data['page']='vieworderproduct';
//        
//        $bothval=$this->order_model->vieworderproduct($this->input->get('id'));
//        $data['table']=$bothval->query;
//        
//        $this->load->library('pagination');
//        $config['base_url'] = site_url("site/vieworderproduct?id=".$this->input->get('id'));
//        $config['total_rows']=$bothval->totalcount;
//        $this->pagination->initialize($config); 
//        
//		$data['title']='View orderproduct';
//		$this->load->view('template',$data);
//	} 
    
    
    //retailer
    
    function viewretailerjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
//        SELECT  `retailer`.`id`, `retailer`.`area`, `retailer`.`dob`,`retailer`.`name`, `retailer`.`number`, `retailer`.`email`, `retailer`.`address`,`retailer`. `ownername`, `retailer`.`ownernumber`, `retailer`.`contactname`,`retailer`. `contactnumber`,`area`.`name` AS `areaname` FROM `retailer` LEFT OUTER JOIN `area` ON `area`.`id`=`retailer`.`area`
            
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`retailer`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]->field="`retailer`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";
        
        $elements[2]->field="`retailer`.`number`";
        $elements[2]->sort="1";
        $elements[2]->header="Number";
        $elements[2]->alias="number";
        
        $elements[3]->field="`retailer`.`email`";
        $elements[3]->sort="1";
        $elements[3]->header="Email";
        $elements[3]->alias="email";
        
        $elements[4]->field="`retailer`.`address`";
        $elements[4]->sort="1";
        $elements[4]->header="Address";
        $elements[4]->alias="address";
        
        $elements[5]->field="`area`.`name`";
        $elements[5]->sort="1";
        $elements[5]->header="Area";
        $elements[5]->alias="areaname";
       
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `retailer` LEFT OUTER JOIN `area` ON `area`.`id`=`retailer`.`area`");
        
		$this->load->view("json",$data);
	} 
    
    function viewretailer()
	{
		$access = array("1");
		$this->checkaccess($access);
//		$data['table']=$this->retailer_model->viewretailer();
		$data['page']='viewretailer';
        
        
        $data['base_url'] = site_url("site/viewretailerjson");
        
        
		$data['title']='View retailer';
		$this->load->view('template',$data);
	} 
    public function createretailer()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createretailer';
		$data[ 'title' ] = 'Create retailer';
        $data['area']=$this->retailer_model->getareadropdown();
		$this->load->view( 'template', $data );	
	}
    function createretailersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('lat','lat','trim|required');
		$this->form_validation->set_rules('long','long','trim|required');
		$this->form_validation->set_rules('area','area','trim|required');
		$this->form_validation->set_rules('dob','dob','trim|required');
		$this->form_validation->set_rules('sq_feet','sq_feet','trim|required');
		$this->form_validation->set_rules('name','name','trim|required');
		$this->form_validation->set_rules('number','number','trim|required');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('address','address','trim|required');
		$this->form_validation->set_rules('ownername','ownername','trim|required');
		$this->form_validation->set_rules('ownernumber','ownernumber','trim|required');
		$this->form_validation->set_rules('contactname','contactname','trim|required');
		$this->form_validation->set_rules('contactnumber','contactnumber','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data[ 'page' ] = 'createretailer';
            $data[ 'title' ] = 'Create retailer';
            $data['area']=$this->retailer_model->getareadropdown();
            $this->load->view( 'template', $data );
		}
		else
		{
			$lat=$this->input->post('lat');
			$long=$this->input->post('long');
			$area=$this->input->post('area');
			$dob=$this->input->post('dob');
            if($dob != "")
			{
				$dob = date("Y-m-d",strtotime($dob));
			}
			$sq_feet=$this->input->post('sq_feet');
			$name=$this->input->post('name');
			$number=$this->input->post('number');
			$email=$this->input->post('email');
			$address=$this->input->post('address');
			$ownername=$this->input->post('ownername');
			$ownernumber=$this->input->post('ownernumber');
			$contactname=$this->input->post('contactname');
			$contactnumber=$this->input->post('contactnumber');
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="store_image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
			}
            
			if($this->retailer_model->create($lat,$long,$area,$dob,$sq_feet,$name,$number,$email,$address,$ownername,$ownernumber,$contactname,$contactnumber,$image)==0)
			$data['alerterror']="New retailer could not be created.";
			else
			$data['alertsuccess']="retailer created Successfully.";
			
			$data['table']=$this->retailer_model->viewretailer();
			$data['redirect']="site/viewretailer";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
    
    function editretailer()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->retailer_model->beforeedit($this->input->get('id'));
        $data['area']=$this->retailer_model->getareadropdown();
		$data['page']='editretailer';
		$data['title']='Edit retailer';
		$this->load->view('template',$data);
	}
	function editretailersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('lat','lat','trim|required');
		$this->form_validation->set_rules('long','long','trim|required');
		$this->form_validation->set_rules('area','area','trim|required');
		$this->form_validation->set_rules('dob','dob','trim|required');
		$this->form_validation->set_rules('sq_feet','sq_feet','trim|required');
		$this->form_validation->set_rules('name','name','trim|required');
		$this->form_validation->set_rules('number','number','trim|required');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('address','address','trim|required');
		$this->form_validation->set_rules('ownername','ownername','trim|required');
		$this->form_validation->set_rules('ownernumber','ownernumber','trim|required');
		$this->form_validation->set_rules('contactname','contactname','trim|required');
		$this->form_validation->set_rules('contactnumber','contactnumber','trim|required');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['before']=$this->retailer_model->beforeedit($this->input->post('id'));
            $data['product']=$this->retailer_model->getproductdropdown();
//			$data['page2']='block/eventblock';
			$data['page']='editretailer';
			$data['title']='Edit retailer';
			$this->load->view('template',$data);
		}
		else
		{
            
			$id=$this->input->post('id');
            $lat=$this->input->post('lat');
			$long=$this->input->post('long');
			$area=$this->input->post('area');
			$dob=$this->input->post('dob');
            if($dob != "")
			{
				$dob = date("Y-m-d",strtotime($dob));
			}
			$sq_feet=$this->input->post('sq_feet');
			$name=$this->input->post('name');
			$number=$this->input->post('number');
			$email=$this->input->post('email');
			$address=$this->input->post('address');
			$ownername=$this->input->post('ownername');
			$ownernumber=$this->input->post('ownernumber');
			$contactname=$this->input->post('contactname');
			$contactnumber=$this->input->post('contactnumber');
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="store_image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
			}
            if($image=="")
            {
            $image=$this->retailer_model->getimagebyid($id);
               // print_r($image);
                $image=$image->store_image;
            }
			if($this->retailer_model->edit($id,$lat,$long,$area,$dob,$sq_feet,$name,$number,$email,$address,$ownername,$ownernumber,$contactname,$contactnumber,$image)==0)
			$data['alerterror']="retailer Editing was unsuccesful";
			else
			$data['alertsuccess']="retailer edited Successfully.";
			
			$data['redirect']="site/viewretailer";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
    
	function deleteretailer()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->retailer_model->deleteretailer($this->input->get('id'));
		$data['table']=$this->retailer_model->viewretailer();
		$data['alertsuccess']="retailer Deleted Successfully";
		$data['page']='viewretailer';
		$data['title']='View retailer';
		$this->load->view('template',$data);
	}
    
    /*export*/
    	public function exportretailer()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->retailer_model->exportretailer();
		$data['table']=$this->retailer_model->viewretailer();
		$data['page']='viewretailer';
		$data['title']='View retailer';
		$this->load->view('template',$data);
	}
    	public function exportretailerfromdashboard()
	{
		$access = array("1");
		$this->checkaccess($access);
        $currentdate=date('Y-m-d',strtotime("-1 days"));
		$this->retailer_model->exportretailerfromdashboard($currentdate);
            
        $data['retailer']=$this->retailer_model->getretailersinceyesterday($currentdate);
        $data['topproducts']=$this->retailer_model->gettopproducts();
        $data['noofretailers']=sizeof($data['retailer']);
		$data[ 'page' ] = 'dashboard';
		$data[ 'title' ] = 'Welcome';
		$this->load->view( 'template', $data );
            
//		$data['table']=$this->retailer_model->viewretailer($currentdate);
//		$data['page']='viewretailer';
//		$data['title']='View retailer';
//		$this->load->view('template',$data);
	}
    	public function exportdistributor()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->distributor_model->exportdistributor();
		$data['table']=$this->distributor_model->viewdistributor();
		$data['page']='viewdistributor';
		$data['title']='View distributor';
		$this->load->view('template',$data);
	}
    	public function exportproduct()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->product_model->exportproduct();
//		$data['table']=$this->product_model->viewproduct();
//		$data['page']='viewproduct';
//		$data['title']='View product';
//		$this->load->view('template',$data);
	}
    	public function exportorder()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->order_model->exportorder();
//		$data['table']=$this->order_model->vieworder();
//		$data['page']='vieworder';
//		$data['title']='View order';
//		$this->load->view('template',$data);
	}
    
    //email
    
    public function sendemail()
    {
        $email=$this->input->get('email');
        $this->load->library('email');
        //$email='patiljagruti181@gmail.com,jagruti@wohlig.com';
        $this->email->from('avinash@wohlig.com', 'Toykraft');
        $this->email->to($email);
        $this->email->subject('Email Test');
        $this->email->message('Email From ToyKraft');

        $this->email->send();

        echo $this->email->print_debugger();
    }
   public function blank()
	{
        $query=$this->db->query("SELECT `users`.`name`,SUM(`orders`.`quantity`) as `y` FROM `orders` RIGHT OUTER JOIN `users` ON `users`.`id`=`orders`.`salesid` WHERE DATE(`orders`.`timestamp`)=DATE(NOW()) GROUP BY `users`.`id`")->result();
        foreach($query as $row)
        {
            $row->y=intval($row->y);
        }
        $data["values"]=json_encode($query);
        $data["page"]="blank";
        $this->load->view('template',$data);
    }
    public function checkchartjson1()
    {
        $data["message"]=$this->chintantable->gethighstockjson("DATE(`timestamp`)","SUM(`quantity`)","FROM `orders`","","GROUP BY DATE(`timestamp`)","","","");
        $this->load->view('json',$data);
    }
    public function checkchartjson2()
    {
        $data["message"]=$this->chintantable->gethighstockjson("DATE(`timestamp`)","SUM(`amount`)","FROM `orders`","","GROUP BY DATE(`timestamp`)","","","");
        $this->load->view('json',$data);
    }
    
}
?>