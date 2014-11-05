<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Sponsor_model extends CI_Model
{
	
    public function viewall()
      {
         $query= $this->db->query("SELECT * FROM  `eventsponsor`");
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
    
    function changestatus($user,$event)
	{
        //echo $user;
		$query=$this->db->query("SELECT `status` FROM `eventsponsor` WHERE `user`='$user' and `event`='$event'")->row();
		$status=$query->status;
		if($status=='1')
		{
			$status='0';
            $userstatus='0';
            $queryuserupdate=$this->db->query( "UPDATE `user` SET `status`='$userstatus' WHERE `user`.`id`='$user'" );
            $newdata = array(
                'id'=> $user,
                'accesslevel'=>'4'
            );

            $this->session->set_userdata($newdata);
		}
		else 
		{
			$status='1';
            $userstatus='1';
            $queryuserupdate=$this->db->query( "UPDATE `user` SET `status`='$userstatus' WHERE `user`.`id`='$user'" );
            $newdata = array(
                'id'=> $user,
                'accesslevel'=>'4'
            );

            $this->session->set_userdata($newdata);
		}
		$data  = array(
			'status' => $status,
		);
		
		$query=$this->db->query( "UPDATE `eventsponsor` SET `status`='$status' WHERE `user`='$user' AND `event`='$event'" );
		if(!$query)
			return  0;
		else
			return  1;
	}
    
    
}
?>