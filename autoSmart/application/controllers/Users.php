<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index() {
        $this->require_login('master');
        $data['users'] = $this->User_model->get_all();
        $this->render('users/index', $data, 'Users');
    }

    public function add() {
        $this->require_login('master');
        if ($this->input->post()) {
            $this->form_validation->set_rules('user_name',  'Name',     'required|trim|max_length[200]');
            $this->form_validation->set_rules('user_email', 'Email',    'required|valid_email|trim|is_unique[user_details.user_email]');
            $this->form_validation->set_rules('password',   'Password', 'required|trim|min_length[6]');
            $this->form_validation->set_rules('user_type',  'Role',     'required|trim');

            if ($this->form_validation->run()) {
                $this->User_model->create(array(
                    'user_name'     => $this->input->post('user_name', TRUE),
                    'user_email'    => $this->input->post('user_email', TRUE),
                    'user_password' => sha1($this->input->post('password', TRUE)),
                    'user_type'     => $this->input->post('user_type', TRUE),
                    'user_status'   => 'Active',
                    'entered_by'    => $this->user_data['user_id'],
                ));
                $this->session->set_flashdata('success', 'User created successfully.');
                redirect('users');
            }
        }
        $this->render('users/form', array('user' => NULL), 'Add User');
    }

    public function edit($id) {
        $this->require_login('master');
        $user = $this->User_model->get($id);
        if (!$user) show_404();
        if ($this->input->post()) {
            $this->form_validation->set_rules('user_name',  'Name',  'required|trim|max_length[200]');
            $this->form_validation->set_rules('user_type',  'Role',  'required|trim');
            $this->form_validation->set_rules('user_status','Status','required|trim');
            if ($this->form_validation->run()) {
                $update = array(
                    'user_name'   => $this->input->post('user_name', TRUE),
                    'user_type'   => $this->input->post('user_type', TRUE),
                    'user_status' => $this->input->post('user_status', TRUE),
                );
                if ($this->input->post('password')) {
                    $update['user_password'] = sha1($this->input->post('password', TRUE));
                }
                $this->User_model->update($id, $update);
                $this->session->set_flashdata('success', 'User updated successfully.');
                redirect('users');
            }
        }
        $this->render('users/form', array('user' => $user), 'Edit User');
    }

    public function delete($id) {
        $this->require_login('master');
        if ($id == $this->user_data['user_id']) {
            $this->session->set_flashdata('error', 'You cannot delete your own account.');
            redirect('users');
        }
        $this->User_model->soft_delete($id);
        $this->session->set_flashdata('success', 'User deleted.');
        redirect('users');
    }
}
