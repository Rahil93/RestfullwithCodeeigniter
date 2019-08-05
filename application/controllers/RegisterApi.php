<?php

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
      $data = json_encode($data);
      $token = $this->ObjImpJWT->GenerateToken($data);
      $this->postRegisterData($token);
    }
    else
    {
      $this->index();
    }
  }

  public function postRegisterData($token)
  {
      $this->load->model('RegisterModel','regmodel');
      $this->regmodel->postRegisterData($token);
      $this->getVerificationKey();
  }

  public function getVerificationKey()
  {
    $this->load->model('RegisterModel','regmodel');
    $key = $this->regmodel->getUserId($this->input->post('firstname'),$this->input->post('lastname')); 
    $verification_token = $this->ObjImpJWT->GenerateToken( (int) $key);
    $this->sendEmailVerificaton($verification_token);
  }

  public function sendEmailVerificaton($verification_token)
  {
    $subject = "Please verify email for login";
                $message = "Hi ".$this->input->post('firstname')." ".$this->input->post('lastname').", \nThis is email verification mail from Codeigniter Login Register system.\nFor complete registration process and login into system you have to verify you email by click this link.\n".base_url()."RegisterApi/verifyEmail/".$verification_token."\nOnce you click this link your email will be verified and you can login into system.\nThanks.";
                $config['protocol']     = 'smtp';
                $config['smtp_host']    = 'ssl://smtp.gmail.com';
                $config['smtp_port']    = '465';
                $config['smtp_timeout'] = '7';
                $config['smtp_user']    = 'rahilstar11@gmail.com';
                $config['smtp_pass']    = '8454895228';
                $config['charset']      = 'utf-8';
                $config['newline']      = "\r\n";
                $config['mailtype']     = 'text'; 
                $config['validation']   = TRUE; 

                $this->email->initialize($config);
               
                $this->email->from('rahilstar11@gmail.com');
                $this->email->to($this->input->post('email_id'));
                $this->email->subject($subject);
                $this->email->message($message);
                if ($this->email->send()) 
                {
                  echo "Please check email for verification";
                }
                else 
                {
                  echo "Error While Sending Mail";
                }
  }

  public function verifyEmail()
  {
    $token = $this->uri->segment(3);
    $this->load->model('RegisterModel','regmodel');
    if ($this->regmodel->verifyEmail($token)) 
    {
      echo "Verification of email has done Successfully";
      header("Refresh: 5; url=".base_url()."/LoginApi");
    }
    else 
    {
      echo "Not Valid User";
    }
  }
}

?>
