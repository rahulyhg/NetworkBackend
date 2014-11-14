<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class User_model extends CI_Model
{
	protected $id,$username ,$password;
	public function validate($username,$password )
	{
		
		$password=md5($password);
		$query ="SELECT `users`.`id`,`users`.`name` as `name`,`users`.`email`,`users`.`accesslevel` as `accesslevel` ,`accesslevel`.`name` as `accesslevelname` FROM `users`
		INNER JOIN `accesslevel` ON `users`.`accesslevel` = `accesslevel`.`id` 
		WHERE `users`.`email` LIKE '$username' AND `users`.`password` LIKE '$password'  AND `users`.`accesslevel` IN (1,2) ";
		$row =$this->db->query( $query );
		if ( $row->num_rows() > 0 ) {
			$row=$row->row();
			$this->id       = $row->id;
			$this->name = $row->name;
			$this->email = $row->email;
			$newdata        = array(
				'id' => $this->id,
				'email' => $this->email,
				'name' => $this->name ,
				'accesslevel' => $row->accesslevel ,
				'logged_in' => 'true',
			);
			$this->session->set_userdata( $newdata );
			return true;
		} //count( $row_array ) == 1
		else
			return false;
	}
	
	
	public function create($name,$password,$accesslevel,$email,$contact,$zone)
	{
		$data  = array(
			'name' => $name,
			'username' => $name,
			'password' =>md5($password),
			'accesslevel' => $accesslevel,
			'email' => $email,
			'mobile' => $contact,
            'zone'=>$zone
		);
		$query=$this->db->insert( 'users', $data );
		$id=$this->db->insert_id();
        
//		if($query)
//		{
//			$this->saveuserlog($id,'User Created');
//		}
		if(!$query)
			return  0;
		else
			return  1;
	}
    
     public function getloginsbyuser($id)
	{
         $return=array();
		$query=$this->db->query("SELECT `id`,`otheruser`,`user` FROM `userlogin`  WHERE `user`='$id'");
        if($query->num_rows() > 0)
        {
            $query=$query->result();
            foreach($query as $row)
            {
                $return[]=$row->otheruser;
            }
        }
         return $return;
         
		
	}
    
     public function createloginuserbyuser($value,$id)
	{
		$data  = array(
			'otheruser' =>$value,
			'user' => $id
		);
       // print_r($data);
		$query=$this->db->insert( 'userlogin', $data );
		return  1;
	}
	function viewusers()
	{
		$user = $this->session->userdata('accesslevel');
		$query="SELECT DISTINCT `users`.`id` as `id`,`users`.`name` as `name`,`accesslevel`.`name` as `accesslevel`	,`users`.`mobile`,`users`.`email` as `email`,`users`.`accesslevel` as `access`,`zone`.`name` as `zonename`
		FROM `users`
	   INNER JOIN `accesslevel` ON `users`.`accesslevel`=`accesslevel`.`id`
	   INNER JOIN `zone` ON `users`.`zone`=`zone`.`id`  ";
	   $accesslevel=$this->session->userdata('accesslevel');
	   if($accesslevel==1)
		{
			$query .= " ";
		}
		else if($accesslevel==2)
		{
			$query .= " WHERE `users`.`accesslevel`> '$accesslevel' ";
		}
		
	   $query.=" ORDER BY `users`.`id` ASC";
		$query=$this->db->query($query)->result();
		return $query;
	}
	function getuserlastlogin()
	{
		$query="SELECT `tab1`.`totaldailyquantity` as `totaldailyquantity`,`tab1`.`totaldailyamount` as `totaldailyamount`,`tab2`.`totalmonthlyquantity` as `totalmonthlyquantity`, `tab2`.`totalmonthlyamount` as `totalmonthlyamount`, `tab3`.`username`,`tab3`.`lastlogin`
FROM
(
SELECT `users`.`name` as `username`,`users`.`lastlogin`,`id` FROM `users`
) as `tab3`
LEFT OUTER JOIN 
(
SELECT sum(`orders`.`quantity`) AS `totaldailyquantity`,sum(`orders`.`amount`) AS `totaldailyamount`,0 as `totalmonthlyquantity`,0 as `totalmonthlyamount`, DATE(`orders`.`timestamp`) as `date` ,`users`.`name` AS `username`,`users`.`lastlogin` AS `lastlogin`
FROM `orders`
INNER JOIN `users` ON `users`.`id`=`orders`.`salesid`
WHERE `orders`.`quantity`> 0  
GROUP BY `date` 
HAVING `date`=DATE(CURRENT_TIMESTAMP) 
) as `tab1`
ON
`tab3`.`username`=`tab1`.`username`

LEFT OUTER JOIN 
(
SELECT 0 as `totaldailyquantity`,0 as `totaldailyamount`,sum(`orders`.`quantity`) AS `totalmonthlyquantity`,sum(`orders`.`amount`) AS `totalmonthlyamount`, MONTH(`orders`.`timestamp`) as `month` ,`users`.`name` AS `username`,`users`.`lastlogin` AS `lastlogin`
FROM `orders`
INNER JOIN `users` ON `users`.`id`=`orders`.`salesid`
WHERE  `orders`.`quantity`> 0   
GROUP BY `month`
HAVING `month`=MONTH(CURRENT_TIMESTAMP)
) as `tab2`
ON 
`tab3`.`username`=`tab2`.`username`

GROUP BY `tab3`.`id`";
	   
		$query=$this->db->query($query)->result();
		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'users' )->row();
		return $query;
	}
	
	public function edit($id,$name,$password,$accesslevel,$email,$contact,$zone)
	{
		$data  = array(
            
			'name' => $name,
			'username' => $name,
			'accesslevel' => $accesslevel,
			'mobile' => $contact,
            'zone'=>$zone
			
		);
		if($password != "")
			$data['password'] =md5($password);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'users', $data );
        
//		if($query)
//		{
//			$this->saveuserlog($id,'User Details Edited');
//		}
		return 1;
	}
	function deleteuser($id)
	{
		$query=$this->db->query("DELETE FROM `users` WHERE `id`='$id'");
	}
	function changepassword($id,$password)
	{
		$data  = array(
			'password' =>md5($password),
		);
		$this->db->where('id',$id);
		$query=$this->db->update( 'users', $data );
		if(!$query)
			return  0;
		else
			return  1;
	}
	public function getaccesslevels()
	{
		$return=array();
		$query=$this->db->query("SELECT * FROM `accesslevel` ORDER BY `id` ASC")->result();
		$accesslevel=$this->session->userdata('accesslevel');
			foreach($query as $row)
			{
				if($accesslevel==1)
				{
					$return[$row->id]=$row->name;
				}
				else if($accesslevel==2)
				{
					if($row->id > $accesslevel)
					{
						$return[$row->id]=$row->name;
					}
				}
				else if($accesslevel==3)
				{
					if($row->id > $accesslevel)
					{
						$return[$row->id]=$row->name;
					}
				}
				else if($accesslevel==4)
				{
					if($row->id == $accesslevel)
					{
						$return[$row->id]=$row->name;
					}
				}
			}
	
		return $return;
	}
    
	public function getzonedropdown()
	{
		$query=$this->db->query("SELECT * FROM `zone`  ORDER BY `id` ASC")->result();
		$return=array();
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
	function changestatus($id)
	{
		$query=$this->db->query("SELECT `status` FROM `users` WHERE `id`='$id'")->row();
		$status=$query->status;
		if($status==1)
		{
			$status=0;
		}
		else if($status==0)
		{
			$status=1;
		}
		$data  = array(
			'status' =>$status,
		);
		$this->db->where('id',$id);
		$query=$this->db->update( 'user', $data );
		if(!$query)
			return  0;
		else
			return  1;
	}
	public function getstatusdropdown()
	{
		$status= array(
			 "1" => "Enabled",
			 "0" => "Disabled",
			);
		return $status;
	}
    
     public function getuserdropdown()
	{
		$query=$this->db->query("SELECT * FROM `users`  ORDER BY `lastlogin` ASC")->result();
		$return=array();
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
	
	function editaddress($id,$address,$city,$pincode)
	{
		$data  = array(
			'address' => $address,
			'city' => $city,
			'pincode' => $pincode,
		);
		
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'user', $data );
		if($query)
		{
			$this->saveuserlog($id,'User Address Edited');
		}
		return 1;
	}
	
	function saveuserlog($id,$action)
	{
		$fromuser = $this->session->userdata('id');
		$data2  = array(
			'onuser' => $id,
			'fromuser' => $fromuser,
			'description' => $action,
		);
		$query2=$this->db->insert( 'userlog', $data2 );
	}
	function getorganizeruser()
	{
		$return=array();
		$query=$this->db->query("SELECT `id`,`firstname`,`lastname` FROM `user` WHERE `accesslevel`=2 ORDER BY `firstname` ASC")->result();
		
		foreach($query as $row)
		{
			$return[$row->id]=$row->firstname.' '.$row->lastname;
		}
		return $return;
	}
	function userinterestevents($user)
	{
		$query = $this->db->query("SELECT `event`.`title` as `event`,`userinterestevents`.`status`,`userinterestevents`.`timestamp` FROM `userinterestevents`
		INNER JOIN `event` ON `event`.`id`=`userinterestevents`.`event`
		WHERE `user`='$user'")->result();
		return $query;
	}
    
    //----------------------------Functions added by avinash--------------------
    
    
    function viewall()
      {
         $query= $this->db->query("SELECT `user`.`id` ,  `user`.`firstname` ,  `user`.`lastname` ,  `user`.`password` ,  `user`.`email` ,  `user`.`website` ,  `user`.`description` ,  `user`.`eventinfo` ,  `user`.`contact` , `user`.`address` ,  `user`.`city` ,  `user`.`pincode` ,  `user`.`dob` ,  `accesslevel`.`id` ,  `accesslevel`.`name` AS `Accesslevel` ,  `user`.`timestamp` ,  `user`.`facebookuserid` ,  `user`.`newsletterstatus` ,  `user`.`status`,`user`.`logo`,`user`.`showwebsite`,`user`.`eventsheld`,`user`.`topeventlocation`
FROM  `user` 
INNER JOIN  `accesslevel` ON  `user`.`accesslevel` =  `accesslevel`.`id`");
        if($query->num_rows > 0)
        {
            return $query->result();
        }
        else 
        {
            return false;
        }
        return $data;
        
      }
    
     function viewone($id)
      {
         //$this->db->where('id', $id);
         $query= $this->db->query("SELECT `user`.`id` ,  `user`.`firstname` ,  `user`.`lastname` ,  `user`.`password` ,  `user`.`email` ,  `user`.`website` ,  `user`.`description` ,  `user`.`eventinfo` ,  `user`.`contact` , `user`.`address` ,  `user`.`city` ,  `user`.`pincode` ,  `user`.`dob` ,  `accesslevel`.`id` ,  `accesslevel`.`name` AS `Accesslevel` ,  `user`.`timestamp` ,  `user`.`facebookuserid` ,  `user`.`newsletterstatus` ,  `user`.`status`,`user`.`logo`,`user`.`showwebsite`,`user`.`eventsheld`,`user`.`topeventlocation`
FROM  `user` 
INNER JOIN  `accesslevel` ON  `user`.`accesslevel` =  `accesslevel`.`id` WHERE `user`.`id`='$id'");
        if($query->num_rows > 0)
        {
            return $query->result();
        }
        else 
        {
            return false;
        }
        return $data;
         
      }
    
    function deleteone($id)
    {
        $this->db->where('id', $id);
        $query= $this->db->delete('user');
        //$this->db->where('user', $id);
        //$queryorganizer=$this->db->delete('organizer');
        return $query;
    }
    
    function update($id,$firstname,$lastname,$password,$email,$website,$description,$eventinfo,$contact,$address,$city,$pincode,$dob,$accesslevel,$timestamp,$facebookuserid,$newsletterstatus,$status,$logo,$showwebsite,$eventsheld,$topeventlocation)
    {
        $query=$this->db->query("UPDATE `user` SET `firstname`='$firstname',`lastname`='$lastname',`website`='$website',`description`='$description',`eventinfo`='$eventinfo',`contact`='$contact',`address`='$address',`city`='$city',`pincode`='$pincode',`dob`='$dob',`accesslevel`='$accesslevel',`timestamp`=null,`facebookuserid`='$facebookuserid',`newsletterstatus`='$newsletterstatus',`status`='$status',`logo`='$logo',`showwebsite`='$showwebsite',`eventsheld`='$eventsheld',`topeventlocation`='$topeventlocation' WHERE `id`=$id");
        
        return $query;
    }
    function signup($email,$password) 
    {
         $password=md5($password);   
        $query=$this->db->query("SELECT `id` FROM `user` WHERE `email`='$email' ");
        if($query->num_rows == 0)
        {
            $this->db->query("INSERT INTO `user` (`id`, `firstname`, `lastname`, `password`, `email`, `website`, `description`, `eventinfo`, `contact`, `address`, `city`, `pincode`, `dob`, `accesslevel`, `timestamp`, `facebookuserid`, `newsletterstatus`, `status`,`logo`,`showwebsite`,`eventsheld`,`topeventlocation`) VALUES (NULL, NULL, NULL, '$password', '$email', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, CURRENT_TIMESTAMP, NULL, NULL, NULL,NULL, NULL, NULL,NULL);");
            $user=$this->db->insert_id();
            $newdata = array(
                'email'     => $email,
                'password' => $password,
                'logged_in' => true,
                'id'=> $user
            );

            $this->session->set_userdata($newdata);
            
          //  $queryorganizer=$this->db->query("INSERT INTO `organizer`(`name`, `description`, `email`, `info`, `website`, `contact`, `user`) VALUES(NULL,NULL,NULL,NULL,NULL,NULL,'$user')");
            
            
           return $user;
        }
        else
         return false;
        
        
    }
    function login($email,$password) 
    {
        $password=md5($password);
        $query=$this->db->query("SELECT `id` FROM `users` WHERE `email`='$email' AND `password`= '$password'");
        if($query->num_rows > 0)
        {
            $user=$query->row();
            $user=$user->id;
            

            $newdata = array(
                'email'     => $email,
                'password' => $password,
                'logged_in' => true,
                'id'=> $user
            );

            $this->session->set_userdata($newdata);
            //print_r($newdata);
            return $user;
        }
        else
        return false;


    }
    function authenticate() {
        $is_logged_in = $this->session->userdata( 'logged_in' );
        //print_r($is_logged_in);
        if ( $is_logged_in !== 'true' || !isset( $is_logged_in ) ) {
            return false;
        } //$is_logged_in !== 'true' || !isset( $is_logged_in )
        else {
            $userid = $this->session->userdata( 'id' );
         return $userid;
        }
    }
}
?>