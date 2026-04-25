<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory_model extends CI_Model {

    public function get_all_with_details() {
        return $this->db->select('io.*, c.customer_name, u.user_name AS entered_by_name')
            ->from('inventory_order io')
            ->join('customer_details c', 'c.id = io.customer_id', 'left')
            ->join('user_details u', 'u.id = io.user_id', 'left')
            ->where('io.inventory_order_status', 'active')
            ->order_by('io.inventory_order_date', 'DESC')
            ->get()->result();
    }

    public function get_order($id) {
        return $this->db->select('io.*, c.customer_name, c.GSTIN AS customer_gstin, c.address AS customer_address, c.contact_no')
            ->from('inventory_order io')
            ->join('customer_details c', 'c.id = io.customer_id', 'left')
            ->where('io.inventory_order_id', $id)
            ->get()->row();
    }

    public function get_order_items($order_id) {
        return $this->db->select('iop.*, p.product_name, p.HSN_code, p.SGST, p.CGST')
            ->from('inventory_order_product iop')
            ->join('product p', 'p.id = iop.product_id', 'left')
            ->where('iop.inventory_order_id', $order_id)
            ->get()->result();
    }

    public function count_all() {
        return $this->db->where('inventory_order_status', 'active')->count_all_results('inventory_order');
    }

    public function create_order($data) {
        $this->db->insert('inventory_order', $data);
        return $this->db->insert_id();
    }

    public function create_order_item($data) {
        $this->db->insert('inventory_order_product', $data);
    }
}
