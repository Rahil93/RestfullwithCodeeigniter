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
    $this->load->library('form_validation');
    if ( $this->form_validation->run('register_form_rules') )
    {
      $data = $this->input->post();
      unset($data['confirm_password']);
      $data['password'] = md5($data['password']);
      $data = json_encode($data);
      echo '<pre>';
      print_r($data);
      $token = $this->ObjImpJWT->GenerateToken($data);
      echo '<pre>';
      print_r(json_encode($token));
      $deToken = $this->ObjImpJWT->DecodeToken($token);
      echo "<pre>";
      print_r($deToken);

      $subject = "Please verify email for login";
                $message = "Hi ".$this->input->post('user_name')." This is email verification mail from Codeigniter Login Register system.";
                $config['protocol']     = 'smtp';
                $config['smtp_host']    = 'ssl://smtp.gmail.com';
                $config['smtp_port']    = '465';
                $config['smtp_timeout'] = '7';
                $config['smtp_user']    = '******@gmail.com';
                $config['smtp_pass']    = '*********';
                $config['charset']      = 'utf-8';
                $config['newline']      = "\r\n";
                $config['mailtype']     = 'text'; 
                $config['validation']   = TRUE; 

                $this->email->initialize($config);
               
                $this->email->from('*******@gmail.com');
                $this->email->to($this->input->post('email_id'));
                $this->email->subject($subject);
                $this->email->message($message);
                $this->email->send();
      // $this->load->model('RegisterModel','regmodel');
      // $this->regmodel->postRegisterData($data);
      // echo "Successfull Register";
    }
    else
    {
      $this->index();
    }
  }
}

?>
