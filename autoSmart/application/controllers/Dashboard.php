<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->model('Stock_model');
        $this->load->model('Purchase_model');
        $this->load->model('Inventory_model');
        $this->load->model('Supplier_model');
        $this->load->model('Customer_model');
        $this->load->model('Dashboard_model');
    }

    public function index() {
        $this->require_login();

        // Stat cards
        $data['total_products']   = $this->Product_model->count_active();
        $data['low_stock']        = $this->Stock_model->count_low_stock();
        $data['total_purchases']  = $this->Purchase_model->count_all();
        $data['total_orders']     = $this->Inventory_model->count_all();
        $data['total_suppliers']  = $this->Dashboard_model->count_suppliers();
        $data['total_customers']  = $this->Dashboard_model->count_customers();
        $data['purchase_value']   = $this->Dashboard_model->total_purchase_value();
        $data['sales_value']      = $this->Dashboard_model->total_sales_value();

        // Tables
        $data['recent_purchases'] = $this->Purchase_model->get_recent(6);
        $data['recent_orders']    = $this->Dashboard_model->get_recent_orders(5);
        $data['low_stock_items']  = $this->Stock_model->get_low_stock_items();

        // Charts — monthly purchases & sales (last 6 months)
        $data['monthly_purchases'] = $this->Dashboard_model->monthly_purchases(6);
        $data['monthly_sales']     = $this->Dashboard_model->monthly_sales(6);

        // Stock by category (doughnut)
        $data['stock_by_category'] = $this->Dashboard_model->stock_by_category();

        // Top 5 products by stock
        $data['top_stock_products'] = $this->Dashboard_model->top_stock_products(5);

        $this->render('dashboard/index', $data, 'Dashboard');
    }
}
