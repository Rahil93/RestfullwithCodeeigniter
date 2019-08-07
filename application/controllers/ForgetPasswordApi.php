<?php

class ForgetPasswordApi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->ObjImpJWT = new ImplementJwt();
        $this->load->driver('cache');
    }

    public function index()
    {
        $this->load->view('EmailVerificationForm');
    }

    public function getFrgtPassword()
    {
        if ($this->form_validation->run('emailverify_form_rules')) 
        {
            $data = $this->input->post();
            $this->load->model('ForgetPasswordModel','frgtmodel');
            if ($this->frgtmodel->verifyEmail($data)) 
            {
                $data = json_encode($data);
                $token = $this->ObjImpJWT->GenerateToken($data);
                $this->sendEmailVerificaton($token);
            }
            else {
                echo "It is Not an Registered Email Id";
            }   
        }
        else 
        {
            $this->index();   
        }
    }

    public function sendEmailVerificaton($verification_token)
  {
    $subject = "Please verify email for login";
                $message = "Hi , \nThis is email verification mail from Codeigniter Login Register system.\nFor complete forget password process and login into system you have to verify you email by click this link.\n".base_url()."ForgetPasswordApi/getEmailToken/".$verification_token."\nOnce you click this link your email will be verified and you can reset your password into system.\nThanks.";
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

  public function displayResetPassword()
  {
      $this->load->view('ForgetPasswordForm');
      
  }

  public function getEmailToken()
  {
    $emailToken = $this->uri->segment(3);
    $this->load->library('redis');
    $redis = $this->redis->config();

    $set = $redis->set('eToken', $emailToken);

    redirect("ForgetPasswordApi/resetPassword");
  }

  public function resetPassword()
  {
    $this->load->library('redis');
    $redis = $this->redis->config();

    $eToken = $redis->get('eToken');
    
    if ($this->form_validation->run('frgtpassword_form_rules')) 
    {      
          $data = md5($this->input->post('password'));
          $data = json_encode($data);
          $token = $this->ObjImpJWT->GenerateToken($data);
          $this->load->model('ForgetPasswordModel','frgtmodel');
          if ($this->frgtmodel->resetPassword($token,$eToken)) 
          {
            echo "Password has been Reset";
            header("Refresh: 5; url=".base_url()."/LoginApi");
          }
          else {

              echo "Reset Your Password Again";
          }  
    } 
    else 
    {
        $this->displayResetPassword();
    }

  }

}

?>