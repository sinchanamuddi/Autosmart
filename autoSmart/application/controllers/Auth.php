<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Auth_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index() {
        redirect('auth/login');
    }

    public function login() {
        $data = array('error' => '');

        if ($this->input->post()) {
            $this->form_validation->set_rules('email',    'Email',    'required|valid_email|trim');
            $this->form_validation->set_rules('password', 'Password', 'required|trim');

            if ($this->form_validation->run()) {
                $email    = $this->input->post('email', TRUE);
                $password = sha1($this->input->post('password', TRUE)); // SHA1 to match existing DB hash

                $user = $this->User_model->authenticate($email, $password);

                if ($user) {
                    $this->session->set_userdata(array(
                        'logged_in' => TRUE,
                        'user_id'   => $user->id,
                        'user_name' => $user->user_name,
                        'user_type' => $user->user_type,
                        'user_email'=> $user->user_email,
                    ));
                    redirect('dashboard');
                } else {
                    $data['error'] = 'Invalid email or password.';
                }
            } else {
                $data['error'] = validation_errors();
            }
        }

        $this->load->view('auth/login', $data);
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
