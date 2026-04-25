<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_model extends CI_Model {

    public function get_all_with_product() {
        return $this->db->select('sd.*, p.product_name, p.min_stock_quantity, u.uom_name, c.category_name')
            ->from('stock_details sd')
            ->join('product p', 'p.id = sd.product_id', 'left')
            ->join('uom u', 'u.id = p.uom_id', 'left')
            ->join('category c', 'c.id = p.category_id', 'left')
            ->where('p.is_deleted', 0)
            ->order_by('p.product_name')
            ->get()->result();
    }

    public function get_product_info($product_id) {
        return $this->db->select('sd.*, p.product_name, p.min_stock_quantity, u.uom_name')
            ->from('stock_details sd')
            ->join('product p', 'p.id = sd.product_id', 'left')
            ->join('uom u', 'u.id = p.uom_id', 'left')
            ->where('sd.product_id', $product_id)
            ->get()->row();
    }

    public function get_stock_in($product_id) {
        return $this->db->get_where('product_wise_stock_in_details', array('product_id' => $product_id))->result();
    }

    public function get_stock_out($product_id) {
        return $this->db->get_where('product_wise_stock_out_details', array('product_id' => $product_id))->result();
    }

    public function get_stock_total($product_id) {
        return $this->db->get_where('stock_details', array('product_id' => $product_id))->row();
    }

    public function add_stock($product_id, $qty) {
        $existing = $this->db->get_where('stock_details', array('product_id' => $product_id))->row();
        if ($existing) {
            $this->db->where('product_id', $product_id)->update('stock_details', array(
                'total_purchase_quantity' => $existing->total_purchase_quantity + $qty,
                'stock_available'         => $existing->stock_available + $qty,
            ));
        } else {
            $this->db->insert('stock_details', array(
                'product_id'              => $product_id,
                'total_purchase_quantity' => $qty,
                'total_sales_quantity'    => 0,
                'stock_available'         => $qty,
            ));
        }
    }

    public function deduct_stock($product_id, $qty) {
        $existing = $this->db->get_where('stock_details', array('product_id' => $product_id))->row();
        if ($existing) {
            $new_available = max(0, $existing->stock_available - $qty);
            $this->db->where('product_id', $product_id)->update('stock_details', array(
                'total_sales_quantity' => $existing->total_sales_quantity + $qty,
                'stock_available'      => $new_available,
            ));
        }
    }

    public function count_low_stock() {
        return $this->db->select('sd.product_id')
            ->from('stock_details sd')
            ->join('product p', 'p.id = sd.product_id', 'left')
            ->where('p.is_deleted', 0)
            ->where('sd.stock_available <= p.min_stock_quantity')
            ->count_all_results();
    }

    public function get_low_stock_items() {
        return $this->db->select('sd.*, p.product_name, p.min_stock_quantity, u.uom_name')
            ->from('stock_details sd')
            ->join('product p', 'p.id = sd.product_id', 'left')
            ->join('uom u', 'u.id = p.uom_id', 'left')
            ->where('p.is_deleted', 0)
            ->where('sd.stock_available <= p.min_stock_quantity')
            ->order_by('sd.stock_available', 'ASC')
            ->get()->result();
    }
}
