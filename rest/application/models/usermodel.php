<?php
class UserModel extends CI_model
{
    function viewall()
      {
         $query= $this->db->get('users');
        if($query->num_rows > 0)
        {
            foreach($query->result() as $row)
            {
            $data[]=$row;
            }
        
        }
        else 
        {
            return false;
        }
        return $data;
         
      }
    
     function viewone()
      {
         $id=$this->input->get('id');
         $this->db->where('id', $id);
         $query= $this->db->get('users');
        if($query->num_rows > 0)
        {
            return $query->row();
        
        }
        else 
        {
            return false;
        }
       
         
      }
    
    function insertuser()
    {
        $name=$this->input->get('name');
        $username=$this->input->get('username');
        $password=$this->input->get('password');
        $email=$this->input->get('email');
        $mobile=$this->input->get('mobile');
        $accessleve=$this->input->get('accessleve');
        $query=$this->db->query("INSERT INTO users (`name`, `username`, `password`, `email`, `mobile`, `accessleve`) VALUES ('{$name}','{$username}','{$password}','{$email}',{$mobile},{$accessleve})");
        //$query=$this
        return $query;
    }
    
    function updateuser()
    {
        $id=$this->input->get('id');
        $name=$this->input->get('name');
        $username=$this->input->get('username');
        $password=$this->input->get('password');
        $email=$this->input->get('email');
        $mobile=$this->input->get('mobile');
        $accessleve=$this->input->get('accessleve');
        $query=$this->db->query("UPDATE users SET name='{$name}',username='{$username}',password='{$password}',email='{$email}',mobile='{$mobile}',accessleve='{$accessleve}' WHERE id=$id");
        //$query=$this
        return $query;
    }
    function deleteone()
    {
        $id=$this->input->get('id');
        $this->db->where('id', $id);
        $query= $this->db->delete('users');
        return $query;
    }
    
    function authenticate($username,$password)
    {
       
        $query=$this->db->query("SELECT * FROM `users` WHERE `username` LIKE '$username' AND `password`='$password' LIMIT 0,1");
        if ($query->num_rows() > 0)
        {
        	$query=$query->row();
        	$this->db->query("UPDATE `users` SET `lastlogin` = CURRENT_TIMESTAMP WHERE `id`='$query->id'");
        	return $query;
        }
        else 
        {
        	return false;
        }
    }
}
?>