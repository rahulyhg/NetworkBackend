<?php
class DistributorModel extends CI_model
{
    function viewall()
      {
         $query= $this->db->get('distributor');
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
         $query= $this->db->get('distributor');
        if($query->num_rows > 0)
        {
            return $query->row();
        }
        else 
        {
            return false;
        }
      }
    
    function insertdistributor()
    {
        $name=$this->input->get('name');
        $code=$this->input->get('code');
        $componyname=$this->input->get('componyname');
        $email=$this->input->get('email');
        $contactno=$this->input->get('contactno');
        $dob=$this->input->get('dob');
        $query=$this->db->query("INSERT INTO `distributor` (`name`, `code`, `componyname`, `email`, `contactno`, `dob`) VALUES ('{$name}', '{$code}', '{$componyname}', '{$email}', '{$contactno}', '{$dob}')");
        //$query=$this
        return $query;
    }
    
    function updatedistributor()
    {
        $id=$this->input->get('id');
        $name=$this->input->get('name');
        $code=$this->input->get('code');
        $componyname=$this->input->get('componyname');
        $email=$this->input->get('email');
        $contactno=$this->input->get('contactno');
        $dob=$this->input->get('dob');
        $query=$this->db->query("UPDATE distributor SET `name`='{$name}',`code`='{$code}',`componyname`='{$componyname}',`email`='{$email}',`contactno`='{$contactno}',`dob`='{$dob}' WHERE `id`=$id");
        //$query=$this
        return $query;
    }
    function deleteone()
    {
        $id=$this->input->get('id');
        $this->db->where('id', $id);
        $query= $this->db->delete('distributor');
        return $query;
    }
}
?>