<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->model('Category_model');
        $this->load->model('Supplier_model');
        $this->load->model('Uom_model');
    }

    public function index() {
        $this->require_login();
        $data['products'] = $this->Product_model->get_all_with_details();
        $this->render('product/index', $data, 'Products');
    }

    public function add() {
        $this->require_login();
        if ($this->input->post()) {
            $this->form_validation->set_rules('product_name',       'Product Name',    'required|trim|max_length[300]');
            $this->form_validation->set_rules('category_id',        'Category',        'required|is_natural_no_zero');
            $this->form_validation->set_rules('supplier_id',        'Supplier',        'required|is_natural_no_zero');
            $this->form_validation->set_rules('uom_id',             'UOM',             'required|is_natural_no_zero');
            $this->form_validation->set_rules('min_stock_quantity', 'Min Stock Qty',   'required|is_natural');
            $this->form_validation->set_rules('init_stock_quantity','Opening Stock',   'required|numeric');
            $this->form_validation->set_rules('as_on_date',         'As On Date',      'required|trim');
            $this->form_validation->set_rules('HSN_code',           'HSN Code',        'required|trim');

            if ($this->form_validation->run()) {
                $this->Product_model->create(array(
                    'product_name'       => $this->input->post('product_name', TRUE),
                    'category_id'        => $this->input->post('category_id', TRUE),
                    'supplier_id'        => $this->input->post('supplier_id', TRUE),
                    'uom_id'             => $this->input->post('uom_id', TRUE),
                    'unit_conversion'    => $this->input->post('unit_conversion', TRUE) ?: 1,
                    'tax_status'         => $this->input->post('tax_status', TRUE),
                    'SGST'               => $this->input->post('SGST', TRUE) ?: 0,
                    'CGST'               => $this->input->post('CGST', TRUE) ?: 0,
                    'min_stock_quantity' => $this->input->post('min_stock_quantity', TRUE),
                    'init_stock_quantity'=> $this->input->post('init_stock_quantity', TRUE),
                    'as_on_date'         => $this->input->post('as_on_date', TRUE),
                    'HSN_code'           => $this->input->post('HSN_code', TRUE),
                    'size'               => $this->input->post('size', TRUE),
                    'grade'              => $this->input->post('grade', TRUE),
                    'product_status'     => $this->input->post('product_status', TRUE),
                    'entered_by'         => $this->user_data['user_id'],
                ));
                $this->session->set_flashdata('success', 'Product added successfully.');
                redirect('product');
            }
        }
        $data['categories'] = $this->Category_model->get_active_dropdown();
        $data['suppliers']  = $this->Supplier_model->get_active_dropdown();
        $data['uoms']       = $this->Uom_model->get_active_dropdown();
        $data['product']    = NULL;
        $this->render('product/form', $data, 'Add Product');
    }

    public function edit($id) {
        $this->require_login();
        $product = $this->Product_model->get($id);
        if (!$product) show_404();

        if ($this->input->post()) {
            $this->form_validation->set_rules('product_name', 'Product Name', 'required|trim|max_length[300]');
            $this->form_validation->set_rules('category_id',  'Category',     'required|is_natural_no_zero');
            $this->form_validation->set_rules('supplier_id',  'Supplier',     'required|is_natural_no_zero');
            $this->form_validation->set_rules('uom_id',       'UOM',          'required|is_natural_no_zero');

            if ($this->form_validation->run()) {
                $this->Product_model->update($id, array(
                    'product_name'       => $this->input->post('product_name', TRUE),
                    'category_id'        => $this->input->post('category_id', TRUE),
                    'supplier_id'        => $this->input->post('supplier_id', TRUE),
                    'uom_id'             => $this->input->post('uom_id', TRUE),
                    'unit_conversion'    => $this->input->post('unit_conversion', TRUE) ?: 1,
                    'tax_status'         => $this->input->post('tax_status', TRUE),
                    'SGST'               => $this->input->post('SGST', TRUE) ?: 0,
                    'CGST'               => $this->input->post('CGST', TRUE) ?: 0,
                    'min_stock_quantity' => $this->input->post('min_stock_quantity', TRUE),
                    'HSN_code'           => $this->input->post('HSN_code', TRUE),
                    'size'               => $this->input->post('size', TRUE),
                    'grade'              => $this->input->post('grade', TRUE),
                    'product_status'     => $this->input->post('product_status', TRUE),
                ));
                $this->session->set_flashdata('success', 'Product updated successfully.');
                redirect('product');
            }
        }
        $data['categories'] = $this->Category_model->get_active_dropdown();
        $data['suppliers']  = $this->Supplier_model->get_active_dropdown();
        $data['uoms']       = $this->Uom_model->get_active_dropdown();
        $data['product']    = $product;
        $this->render('product/form', $data, 'Edit Product');
    }

    public function delete($id) {
        $this->require_login('master');
        $this->Product_model->soft_delete($id);
        $this->session->set_flashdata('success', 'Product deleted.');
        redirect('product');
    }
}
