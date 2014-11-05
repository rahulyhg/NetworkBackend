<?php
class LoguserModel extends CI_model
{
    function viewall()
      {
         $query= $this->db->get('loguser');
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
         $query= $this->db->get('loguser');
        if($query->num_rows > 0)
        {
            return $query->row();
        }
        else 
        {
            return false;
        }
      }
    
    function insertloguser()
    {
        $state=$this->input->get('state');
        $ip=$this->input->get('ip');
        $lat=$this->input->get('lat');
        $long=$this->input->get('long');
        $timestamp=$this->input->get('timestamp');
        $action=$this->input->get('action');
        $user=$this->input->get('user');
        $query=$this->db->query("INSERT INTO `loguser` (`state`, `ip`, `lat`, `long`, `timestamp`, `action`, `user`) VALUES ('{$state}', '{$ip}', '{$lat}', '{$long}', '{$timestamp}', '{$action}', '{$user}')");
        //$query=$this
        return $query;
    }
    
    function updateloguser()
    {
        $id=$this->input->get('id');
        $state=$this->input->get('state');
        $ip=$this->input->get('ip');
        $lat=$this->input->get('lat');
        $long=$this->input->get('long');
        $timestamp=$this->input->get('timestamp');
        $action=$this->input->get('action');
        $user=$this->input->get('user');
       // $query=$this->db->query("UPDATE `loguser` SET state='{$state}',ip='{$ip}',lat={$lat},long={$long},timestamp='{$timestamp}',action='{$action}',user={$user} WHERE id=$id");
        $query=$this->db->query("UPDATE loguser SET `state`='{$state}',`ip`='{$ip}',`lat`='{$lat}',`long`='{$long}',`timestamp`='{$timestamp}',`action`='{$action}',`user`='{$user}' WHERE `id`=$id");
        //$query=$this
        return $query;
    }
    function deleteone()
    {
        $id=$this->input->get('id');
        $this->db->where('id', $id);
        $query= $this->db->delete('loguser');
        return $query;
    }
}
?>