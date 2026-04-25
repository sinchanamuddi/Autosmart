<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    public function count_suppliers() {
        return $this->db->where('is_deleted', 0)->where('supplier_status', 'active')->count_all_results('supplier_details');
    }

    public function count_customers() {
        return $this->db->where('is_deleted', 0)->where('customer_status', 'active')->count_all_results('customer_details');
    }

    public function total_purchase_value() {
        $row = $this->db->select_sum('total_amount')->where('purchase_status', 'active')->get('purchase_invoice')->row();
        return $row ? (float)$row->total_amount : 0;
    }

    public function total_sales_value() {
        $row = $this->db->select_sum('inventory_order_total')->where('inventory_order_status', 'active')->get('inventory_order')->row();
        return $row ? (float)$row->inventory_order_total : 0;
    }

    public function get_recent_orders($limit = 5) {
        return $this->db->select('io.inventory_order_id, io.inventory_order_date, io.inventory_order_total, io.payment_status, c.customer_name')
            ->from('inventory_order io')
            ->join('customer_details c', 'c.id = io.customer_id', 'left')
            ->where('io.inventory_order_status', 'active')
            ->order_by('io.inventory_order_created_date', 'DESC')
            ->limit($limit)
            ->get()->result();
    }

    /**
     * Returns last N months of purchase totals: [{month:'Jan 25', total:1050}, ...]
     */
    public function monthly_purchases($months = 6) {
        $result = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $y = date('Y', strtotime("-$i months"));
            $m = date('m', strtotime("-$i months"));
            $label = date('M y', strtotime("-$i months"));

            $row = $this->db
                ->select_sum('total_amount', 'total')
                ->where('purchase_status', 'active')
                ->where("YEAR(date_of_purchase)", $y)
                ->where("MONTH(date_of_purchase)", $m)
                ->get('purchase_invoice')->row();

            $result[] = ['month' => $label, 'total' => $row ? (float)$row->total : 0];
        }
        return $result;
    }

    /**
     * Returns last N months of sales order totals
     */
    public function monthly_sales($months = 6) {
        $result = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $y = date('Y', strtotime("-$i months"));
            $m = date('m', strtotime("-$i months"));
            $label = date('M y', strtotime("-$i months"));

            $row = $this->db
                ->select_sum('inventory_order_total', 'total')
                ->where('inventory_order_status', 'active')
                ->where("YEAR(inventory_order_date)", $y)
                ->where("MONTH(inventory_order_date)", $m)
                ->get('inventory_order')->row();

            $result[] = ['month' => $label, 'total' => $row ? (float)$row->total : 0];
        }
        return $result;
    }

    /**
     * Stock available grouped by category (for doughnut chart)
     */
    public function stock_by_category() {
        return $this->db
            ->select('c.category_name, SUM(sd.stock_available) AS total_stock')
            ->from('stock_details sd')
            ->join('product p', 'p.id = sd.product_id', 'left')
            ->join('category c', 'c.id = p.category_id', 'left')
            ->where('p.is_deleted', 0)
            ->where('p.product_status', 'active')
            ->group_by('c.id')
            ->order_by('total_stock', 'DESC')
            ->get()->result();
    }

    /**
     * Top N products by available stock (horizontal bar chart)
     */
    public function top_stock_products($limit = 5) {
        return $this->db
            ->select('p.product_name, sd.stock_available, p.min_stock_quantity, u.uom_name')
            ->from('stock_details sd')
            ->join('product p', 'p.id = sd.product_id', 'left')
            ->join('uom u', 'u.id = p.uom_id', 'left')
            ->where('p.is_deleted', 0)
            ->where('p.product_status', 'active')
            ->order_by('sd.stock_available', 'DESC')
            ->limit($limit)
            ->get()->result();
    }
}
