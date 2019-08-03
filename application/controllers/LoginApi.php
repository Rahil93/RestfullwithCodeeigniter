<?php

/**
 *
 */
class LoginApi extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
  }

  public function index()
  {
    $this->load->view('LoginForm');
  }

  public function getLoginData()
  {
      if ($this->form_validation->run('login_form_rules'))
      {
        $data = $this->input->post();
        $data = json_encode($data);
        // $this->load->model('LoginModel','logmodel');
        // $this->logmodel->getLoginData($data);
        // if ()
        // {
        //   echo "Successfully Login";
        // }
        // else {
        //   echo "Invalid User";
        // }
        // echo "<pre>";
        // print_r($data);
      }
      else
      {
        $this->index();
        echo "Not Validate";
      }
  }
}


?>
