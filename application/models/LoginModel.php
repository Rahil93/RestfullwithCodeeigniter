<?php

/**
 *
 */
class LoginModel extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->ObjImpJWT = new ImplementJwt();
  }

  public function getLoginData($token)
  {
    $token = $this->ObjImpJWT->DecodeToken($token);
    $array = json_decode($token[0],true);
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
