<?php

class ForgetPasswordModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->ObjImpJWT = new ImplementJwt();
    }

    public function verifyEmail($email)
    {
        $query = $this->db->where($email)
                          ->get('user_details');
        if ($query->num_rows() > 0) 
        {
            return true;
        }
        else 
        {
            return false;
        }
    }

    public function resetPassword($token,$emailToken)
    {
        $password = $this->ObjImpJWT->DecodeToken($token);
        $password = json_decode($password[0],true);

        $email = $this->ObjImpJWT->DecodeToken($emailToken);
        $email = json_decode($email[0],true);

        $query = $this->db->where($email)
                          ->get('user_details');

        if ($query->num_rows() > 0) 
        {
            $data = ['password' => $password];
            $this->db->where($email)
                     ->update('user_details',$data);
            return true;
        }
        else 
        {
            return false;
        }
    }

}

?>