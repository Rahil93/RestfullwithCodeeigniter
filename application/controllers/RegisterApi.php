<?php

require_once APPPATH."/rabbitmq/sender.php";

class RegisterApi extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
    $this->load->library('email');
    $this->ObjImpJWT = new ImplementJwt();
  }

  public function index()
  {
    $this->load->view('RegisterForm');
  }

  public function getRegisterData()
  {
      if ( $this->form_validation->run('register_form_rules') )
      {
          $data = $this->input->post();

          unset($data['confirm_password']);
          $data['password'] = md5($data['password']);
          $data['email_verified'] = 'false';
          $toEmail = $data['email_id'];

          $data = json_encode($data);

          $this->load->model('RegisterModel','regmodel');
          $this->regmodel->postRegisterData($data);

          $this->load->model('RegisterModel','regmodel');
          $key = $this->regmodel->getUserId($this->input->post('firstname'),$this->input->post('lastname')); 
          $verification_token = $this->ObjImpJWT->GenerateToken($key);

          $rabbitmq = new RBMQMAIL();

          $subject = "Please verify email for login";
          $message = "Hi ".$this->input->post('firstname')." ".$this->input->post('lastname').", \nThis is email verification mail from Codeigniter Login Register system.\nFor complete registration process and login into system you have to verify you email by click this link.\n".base_url()."RegisterApi/verifyEmail/".$verification_token."\nOnce you click this link your email will be verified and you can login into system.\nThanks.";

          if($rabbitmq->sendRabQueue($toEmail,$subject,$message))
          {
            echo "Please check email for verification";
            $rabbitmq->sendMail();
          }
          else 
          {
            echo "Error While Sending Mail";
          }
      }
      else
      {
        $this->index();
      }
  }

  public function verifyEmail()
  {
    $token = $this->uri->segment(3);
    $this->load->model('RegisterModel','regmodel');
    if ($this->regmodel->verifyEmail($token)) 
    {
      echo "Verification of email has done Successfully";
      header("Refresh: 3; url=".base_url()."/LoginApi");
    }
    else 
    {
      echo "Not Valid User";
    }
  }
}

?>
