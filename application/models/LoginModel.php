<?php

class LoginModel extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->ObjImpJWT = new ImplementJwt();
  }

  public function getLoginData($data)
  {
    // $token = $this->ObjImpJWT->DecodeToken($token);
    $array = json_decode($data,true);
    $q = $this->db->where($array)
                  ->where('email_verified','true')
                  ->get('user_details');
    if ($q->num_rows() > 0)
    {
      return true;
    }
    else
    {
      return false;
    }
  }
}

?>
