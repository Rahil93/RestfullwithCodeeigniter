<?php

require_once APPPATH."/rabbitmq/sender.php";

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
            $toEmail = $data['email_id'];
            $this->load->model('ForgetPasswordModel','frgtmodel');
            if ($this->frgtmodel->verifyEmail($data)) 
            {
                $data = json_encode($data);
                $token = $this->ObjImpJWT->GenerateToken($data);
                $subject = "Please verify email to reset your password";
                $message = "Hi , \nThis is email verification mail from Codeigniter Login Register system.\nFor complete forget password process and login into system you have to verify you email by click this link.\n".base_url()."ForgetPasswordApi/getEmailToken/".$token."\nOnce you click this link your email will be verified and you can reset your password into system.\nThanks.";
                          
                $rabbitmq = new RBMQMail(); 

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
            else {
                echo "It is Not an Registered Email Id";
            }   
        }
        else 
        {
            $this->index();   
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

        $redis->set('eToken', $emailToken);

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
            $this->load->model('ForgetPasswordModel','frgtmodel');
            if ($this->frgtmodel->resetPassword($data,$eToken)) 
            {
                echo "Password has been Reset";
                header("Refresh: 3; url=".base_url()."/LoginApi");
            }
            else 
            {
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