<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Stock_model');
    }

    public function index() {
        $this->require_login();
        $data['stocks'] = $this->Stock_model->get_all_with_product();
        $this->render('stock/index', $data, 'Stock Overview');
    }

    public function view($product_id) {
        $this->require_login();
        $data['product']     = $this->Stock_model->get_product_info($product_id);
        $data['stock_in']    = $this->Stock_model->get_stock_in($product_id);
        $data['stock_out']   = $this->Stock_model->get_stock_out($product_id);
        $data['stock_total'] = $this->Stock_model->get_stock_total($product_id);
        if (!$data['product']) show_404();
        $this->render('stock/view', $data, 'Stock Detail');
    }
}
