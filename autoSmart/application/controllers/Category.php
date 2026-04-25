<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Category_model');
    }

    public function index() {
        $this->require_login();
        $data['categories'] = $this->Category_model->get_all();
        $this->render('category/index', $data, 'Categories');
    }

    public function add() {
        $this->require_login();

        if ($this->input->post()) {
            $this->form_validation->set_rules('category_name', 'Category Name', 'required|trim|max_length[250]');

            if ($this->form_validation->run()) {
                $this->Category_model->create(array(
                    'category_name'   => $this->input->post('category_name', TRUE),
                    'category_status' => $this->input->post('category_status', TRUE),
                    'entered_by'      => $this->user_data['user_id'],
                ));
                $this->session->set_flashdata('success', 'Category added successfully.');
                redirect('category');
            }
        }
        $this->render('category/form', array('category' => NULL), 'Add Category');
    }

    public function edit($id) {
        $this->require_login();
        $category = $this->Category_model->get($id);
        if (!$category) show_404();

        if ($this->input->post()) {
            $this->form_validation->set_rules('category_name', 'Category Name', 'required|trim|max_length[250]');
            if ($this->form_validation->run()) {
                $this->Category_model->update($id, array(
                    'category_name'   => $this->input->post('category_name', TRUE),
                    'category_status' => $this->input->post('category_status', TRUE),
                ));
                $this->session->set_flashdata('success', 'Category updated successfully.');
                redirect('category');
            }
        }
        $this->render('category/form', array('category' => $category), 'Edit Category');
    }

    public function delete($id) {
        $this->require_login('master');
        $this->Category_model->soft_delete($id);
        $this->session->set_flashdata('success', 'Category deleted.');
        redirect('category');
    }
}
