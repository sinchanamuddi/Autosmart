<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Customer_model');
    }

    public function index() {
        $this->require_login();
        $data['customers'] = $this->Customer_model->get_all();
        $this->render('customers/index', $data, 'Customers');
    }

    public function add() {
        $this->require_login();
        if ($this->input->post()) {
            $this->form_validation->set_rules('customer_name', 'Customer Name', 'required|trim|max_length[100]');
            $this->form_validation->set_rules('customer_type', 'Customer Type', 'required|trim');
            $this->form_validation->set_rules('email_id',      'Email',         'permit_empty|valid_email|trim');
            $this->form_validation->set_rules('contact_no',    'Contact No',    'permit_empty|is_natural');

            if ($this->form_validation->run()) {
                $this->Customer_model->create(array(
                    'customer_name'   => $this->input->post('customer_name', TRUE),
                    'firm_name'       => $this->input->post('firm_name', TRUE),
                    'address'         => $this->input->post('address', TRUE),
                    'place'           => $this->input->post('place', TRUE),
                    'customer_type'   => $this->input->post('customer_type', TRUE),
                    'GSTIN'           => $this->input->post('GSTIN', TRUE),
                    'contact_no'      => $this->input->post('contact_no', TRUE),
                    'email_id'        => $this->input->post('email_id', TRUE),
                    'zipcode'         => $this->input->post('zipcode', TRUE),
                    'customer_status' => 'active',
                    'entered_by'      => $this->user_data['user_id'],
                ));
                $this->session->set_flashdata('success', 'Customer added successfully.');
                redirect('customers');
            }
        }
        $this->render('customers/form', array('customer' => NULL), 'Add Customer');
    }

    public function edit($id) {
        $this->require_login();
        $customer = $this->Customer_model->get($id);
        if (!$customer) show_404();
        if ($this->input->post()) {
            $this->form_validation->set_rules('customer_name', 'Customer Name', 'required|trim|max_length[100]');
            $this->form_validation->set_rules('customer_type', 'Customer Type', 'required|trim');
            if ($this->form_validation->run()) {
                $this->Customer_model->update($id, array(
                    'customer_name'   => $this->input->post('customer_name', TRUE),
                    'firm_name'       => $this->input->post('firm_name', TRUE),
                    'address'         => $this->input->post('address', TRUE),
                    'place'           => $this->input->post('place', TRUE),
                    'customer_type'   => $this->input->post('customer_type', TRUE),
                    'GSTIN'           => $this->input->post('GSTIN', TRUE),
                    'contact_no'      => $this->input->post('contact_no', TRUE),
                    'email_id'        => $this->input->post('email_id', TRUE),
                    'zipcode'         => $this->input->post('zipcode', TRUE),
                    'customer_status' => $this->input->post('customer_status', TRUE),
                ));
                $this->session->set_flashdata('success', 'Customer updated successfully.');
                redirect('customers');
            }
        }
        $this->render('customers/form', array('customer' => $customer), 'Edit Customer');
    }

    public function delete($id) {
        $this->require_login('master');
        $this->Customer_model->soft_delete($id);
        $this->session->set_flashdata('success', 'Customer deleted.');
        redirect('customers');
    }
}
