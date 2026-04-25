<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uom extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Uom_model');
    }

    public function index() {
        $this->require_login();
        $data['uoms'] = $this->Uom_model->get_all();
        $this->render('uom/index', $data, 'Units of Measure');
    }

    public function add() {
        $this->require_login();
        if ($this->input->post()) {
            $this->form_validation->set_rules('uom_name', 'UOM Name', 'required|trim|max_length[100]');
            if ($this->form_validation->run()) {
                $this->Uom_model->create(array(
                    'uom_name'   => $this->input->post('uom_name', TRUE),
                    'uom_code'   => $this->input->post('uom_code', TRUE),
                    'uom_status' => $this->input->post('uom_status', TRUE),
                    'entered_by' => $this->user_data['user_id'],
                ));
                $this->session->set_flashdata('success', 'UOM added successfully.');
                redirect('uom');
            }
        }
        $this->render('uom/form', array('uom' => NULL), 'Add UOM');
    }

    public function edit($id) {
        $this->require_login();
        $uom = $this->Uom_model->get($id);
        if (!$uom) show_404();
        if ($this->input->post()) {
            $this->form_validation->set_rules('uom_name', 'UOM Name', 'required|trim|max_length[100]');
            if ($this->form_validation->run()) {
                $this->Uom_model->update($id, array(
                    'uom_name'   => $this->input->post('uom_name', TRUE),
                    'uom_code'   => $this->input->post('uom_code', TRUE),
                    'uom_status' => $this->input->post('uom_status', TRUE),
                ));
                $this->session->set_flashdata('success', 'UOM updated successfully.');
                redirect('uom');
            }
        }
        $this->render('uom/form', array('uom' => $uom), 'Edit UOM');
    }

    public function delete($id) {
        $this->require_login('master');
        $this->Uom_model->soft_delete($id);
        $this->session->set_flashdata('success', 'UOM deleted.');
        redirect('uom');
    }
}
