<?php

class RegisterModel extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->ObjImpJWT = new ImplementJwt();
  }

  public function postRegisterData($data)
  {
    $array = json_decode($data,true);
    $this->db->insert('user_details', $array);
  }

  public function getUserId($firstname,$lastname)
  {
    $query = $this->db->query("SELECT id FROM user_details WHERE firstname = '$firstname' AND lastname = '$lastname'");
    
    foreach ($query->result() as $row) {
      return $row->id;
    }
  }

  public function verifyEmail($token)
  {
    $id = $this->ObjImpJWT->DecodeToken($token);
    $id = (int) json_decode($id[0],true);

    $query = $this->db->where('id',$id)
             ->where('email_verified','false')
             ->get('user_details');  

    if ($query->num_rows() > 0) {
      $data = ['email_verified' => 'true'];
      $this->db->where('id',$id)
               ->update('user_details',$data);
      return true;
    }
    else 
    {
      return false;
    }

  }
}

?>
