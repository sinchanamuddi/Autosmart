<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Inventory_model');
        $this->load->model('Customer_model');
        $this->load->model('Product_model');
        $this->load->model('Stock_model');
    }

    public function index() {
        $this->require_login();
        $data['orders'] = $this->Inventory_model->get_all_with_details();
        $this->render('inventory/index', $data, 'Sales Orders');
    }

    public function add() {
        $this->require_login();
        if ($this->input->post()) {
            $this->form_validation->set_rules('customer_id',            'Customer',     'required|is_natural_no_zero');
            $this->form_validation->set_rules('inventory_order_date',   'Order Date',   'required|trim');
            $this->form_validation->set_rules('product_id[]',           'Product',      'required');
            $this->form_validation->set_rules('quantity[]',             'Quantity',     'required|numeric');

            if ($this->form_validation->run()) {
                $products   = $this->input->post('product_id');
                $quantities = $this->input->post('quantity');
                $prices     = $this->input->post('price');
                $taxes      = $this->input->post('tax');
                $uoms       = $this->input->post('sale_uom');

                $total = 0;
                foreach ($products as $k => $pid) {
                    if (!$pid) continue;
                    $total += ($prices[$k] * $quantities[$k]) + ($taxes[$k] ?: 0);
                }

                $order_id = $this->Inventory_model->create_order(array(
                    'user_id'                    => $this->user_data['user_id'],
                    'customer_id'                => $this->input->post('customer_id', TRUE),
                    'inventory_order_date'       => $this->input->post('inventory_order_date', TRUE),
                    'inventory_order_total'      => $total,
                    'pdiscount'                  => $this->input->post('pdiscount', TRUE) ?: 0,
                    'pcess'                      => $this->input->post('pcess', TRUE) ?: 0,
                    'bill_type'                  => $this->input->post('bill_type', TRUE),
                    'payment_status'             => $this->input->post('payment_status', TRUE),
                    'inventory_order_status'     => 'active',
                    'inventory_order_created_date' => date('Y-m-d'),
                ));

                foreach ($products as $k => $pid) {
                    if (!$pid) continue;
                    $qty = $quantities[$k];
                    $this->Inventory_model->create_order_item(array(
                        'inventory_order_id' => $order_id,
                        'product_id'         => $pid,
                        'quantity'           => $qty,
                        'price'              => $prices[$k] ?: 0,
                        'tax'                => $taxes[$k] ?: 0,
                        'sale_uom'           => $uoms[$k],
                    ));
                    // Deduct stock
                    $this->Stock_model->deduct_stock($pid, $qty);
                }

                $this->session->set_flashdata('success', 'Sales order created successfully.');
                redirect('inventory');
            }
        }
        $data['customers'] = $this->Customer_model->get_active_dropdown();
        $data['products']  = $this->Product_model->get_active_with_stock();
        $this->render('inventory/form', $data, 'New Sales Order');
    }

    public function view($id) {
        $this->require_login();
        $data['order'] = $this->Inventory_model->get_order($id);
        $data['items'] = $this->Inventory_model->get_order_items($id);
        if (!$data['order']) show_404();
        $this->render('inventory/view', $data, 'Sales Order #' . $id);
    }
}
