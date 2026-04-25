<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Supplier_model');
    }

    public function index() {
        $this->require_login();
        $data['suppliers'] = $this->Supplier_model->get_all();
        $this->render('supplier/index', $data, 'Suppliers');
    }

    public function add() {
        $this->require_login();
        if ($this->input->post()) {
            $this->form_validation->set_rules('firm_name',            'Firm Name',          'required|trim|max_length[30]');
            $this->form_validation->set_rules('contact_person_name',  'Contact Person',     'required|trim|max_length[30]');
            $this->form_validation->set_rules('contact_no',           'Contact No',         'required|trim|is_natural');
            $this->form_validation->set_rules('email_id',             'Email',              'permit_empty|valid_email|trim');

            if ($this->form_validation->run()) {
                $this->Supplier_model->create(array(
                    'firm_name'           => $this->input->post('firm_name', TRUE),
                    'contact_person_name' => $this->input->post('contact_person_name', TRUE),
                    'address'             => $this->input->post('address', TRUE),
                    'contact_no'          => $this->input->post('contact_no', TRUE),
                    'alt_contact_no'      => $this->input->post('alt_contact_no', TRUE),
                    'email_id'            => $this->input->post('email_id', TRUE),
                    'zipcode'             => $this->input->post('zipcode', TRUE),
                    'GSTIN'               => $this->input->post('GSTIN', TRUE),
                    'bank_name'           => $this->input->post('bank_name', TRUE),
                    'branch_name'         => $this->input->post('branch_name', TRUE),
                    'bank_act_name'       => $this->input->post('bank_act_name', TRUE),
                    'bank_act_no'         => $this->input->post('bank_act_no', TRUE),
                    'IFSC_code'           => $this->input->post('IFSC_code', TRUE),
                    'supplier_status'     => $this->input->post('supplier_status', TRUE),
                    'entered_by'          => $this->user_data['user_id'],
                ));
                $this->session->set_flashdata('success', 'Supplier added successfully.');
                redirect('supplier');
            }
        }
        $this->render('supplier/form', array('supplier' => NULL), 'Add Supplier');
    }

    public function edit($id) {
        $this->require_login();
        $supplier = $this->Supplier_model->get($id);
        if (!$supplier) show_404();
        if ($this->input->post()) {
            $this->form_validation->set_rules('firm_name',           'Firm Name',      'required|trim|max_length[30]');
            $this->form_validation->set_rules('contact_person_name', 'Contact Person', 'required|trim|max_length[30]');
            $this->form_validation->set_rules('contact_no',          'Contact No',     'required|trim|is_natural');
            if ($this->form_validation->run()) {
                $this->Supplier_model->update($id, array(
                    'firm_name'           => $this->input->post('firm_name', TRUE),
                    'contact_person_name' => $this->input->post('contact_person_name', TRUE),
                    'address'             => $this->input->post('address', TRUE),
                    'contact_no'          => $this->input->post('contact_no', TRUE),
                    'alt_contact_no'      => $this->input->post('alt_contact_no', TRUE),
                    'email_id'            => $this->input->post('email_id', TRUE),
                    'zipcode'             => $this->input->post('zipcode', TRUE),
                    'GSTIN'               => $this->input->post('GSTIN', TRUE),
                    'bank_name'           => $this->input->post('bank_name', TRUE),
                    'branch_name'         => $this->input->post('branch_name', TRUE),
                    'bank_act_name'       => $this->input->post('bank_act_name', TRUE),
                    'bank_act_no'         => $this->input->post('bank_act_no', TRUE),
                    'IFSC_code'           => $this->input->post('IFSC_code', TRUE),
                    'supplier_status'     => $this->input->post('supplier_status', TRUE),
                ));
                $this->session->set_flashdata('success', 'Supplier updated successfully.');
                redirect('supplier');
            }
        }
        $this->render('supplier/form', array('supplier' => $supplier), 'Edit Supplier');
    }

    public function delete($id) {
        $this->require_login('master');
        $this->Supplier_model->soft_delete($id);
        $this->session->set_flashdata('success', 'Supplier deleted.');
        redirect('supplier');
    }
}
