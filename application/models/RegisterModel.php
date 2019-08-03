<?php

class RegisterModel extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function postRegisterData($array)
  {
    $array = json_decode($array,true);

    $this->db->insert('user_details', $array);
  }
}

?>
