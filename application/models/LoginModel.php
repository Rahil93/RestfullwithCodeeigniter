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
  }

  public function getLoginData($array)
  {
    $array = json_decode($array,true);
    $q = $this->db->where($array)->get('user_details');
    // return print_r($q);
    // if ()
    // {
    //   return true;
    // }
    // else
    // {
    //   return false;
    // }
  }
}


?>
