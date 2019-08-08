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
    $this->ObjImpJWT = new ImplementJwt();
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
        $data['password'] = md5($data['password']);
        $data = json_encode($data);
        // $token = $this->ObjImpJWT->GenerateToken($data);
        $this->load->model('LoginModel','logmodel');
        if ($this->logmodel->getLoginData($data))
        {
          echo "Successfully Login";
        }
        else {
          echo "Invalid User";
        }
      }
      else
      {
        $this->index();
      }
  }
}

?>
