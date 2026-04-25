<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Purchase_model');
        $this->load->model('Supplier_model');
        $this->load->model('Product_model');
        $this->load->model('Stock_model');
    }

    public function index() {
        $this->require_login();
        $data['purchases'] = $this->Purchase_model->get_all_with_details();
        $this->render('purchase/index', $data, 'Purchase Invoices');
    }

    public function add() {
        $this->require_login();
        if ($this->input->post()) {
            $this->form_validation->set_rules('supplier_id',          'Supplier',         'required|is_natural_no_zero');
            $this->form_validation->set_rules('date_of_purchase',     'Date of Purchase', 'required|trim');
            $this->form_validation->set_rules('invoice_cash_bill_no', 'Invoice No',       'permit_empty|is_natural');
            $this->form_validation->set_rules('bill_amount',          'Bill Amount',      'required|numeric');
            $this->form_validation->set_rules('product_id[]',         'Product',          'required');
            $this->form_validation->set_rules('quantity[]',           'Quantity',         'required');

            if ($this->form_validation->run()) {
                $bill_amount = $this->input->post('bill_amount', TRUE);
                $SGST        = $this->input->post('SGST', TRUE) ?: 0;
                $CGST        = $this->input->post('CGST', TRUE) ?: 0;
                $total       = $bill_amount + ($bill_amount * $SGST / 100) + ($bill_amount * $CGST / 100);

                // Insert purchase invoice
                $purchase_id = $this->Purchase_model->create_invoice(array(
                    'supplier_id'          => $this->input->post('supplier_id', TRUE),
                    'date_of_purchase'     => $this->input->post('date_of_purchase', TRUE),
                    'invoice_cash_bill_no' => $this->input->post('invoice_cash_bill_no', TRUE) ?: 0,
                    'bill_amount'          => $bill_amount,
                    'SGST'                 => $SGST,
                    'CGST'                 => $CGST,
                    'total_amount'         => $total,
                    'purchase_status'      => 'active',
                    'entered_by'           => $this->user_data['user_id'],
                    'date_of_entry'        => date('Y-m-d'),
                ));

                // Insert purchase details & update stock
                $products  = $this->input->post('product_id');
                $quantities= $this->input->post('quantity');
                $uoms      = $this->input->post('purchase_uom');
                $unit_costs= $this->input->post('unit_cost');

                foreach ($products as $k => $pid) {
                    if (!$pid) continue;
                    $qty = $quantities[$k];
                    $this->Purchase_model->create_detail(array(
                        'purchase_id'  => $purchase_id,
                        'product_id'   => $pid,
                        'unit_cost'    => $unit_costs[$k] ?: 0,
                        'quantity'     => $qty,
                        'purchase_uom' => $uoms[$k],
                    ));
                    // Update stock
                    $this->Stock_model->add_stock($pid, $qty);
                }

                $this->session->set_flashdata('success', 'Purchase invoice saved successfully.');
                redirect('purchase');
            }
        }
        $data['suppliers'] = $this->Supplier_model->get_active_dropdown();
        $data['products']  = $this->Product_model->get_active_dropdown();
        $this->render('purchase/form', $data, 'New Purchase Invoice');
    }

    public function view($id) {
        $this->require_login();
        $data['invoice']  = $this->Purchase_model->get_invoice($id);
        $data['items']    = $this->Purchase_model->get_details($id);
        if (!$data['invoice']) show_404();
        $this->render('purchase/view', $data, 'Purchase Invoice #' . $id);
    }
}
