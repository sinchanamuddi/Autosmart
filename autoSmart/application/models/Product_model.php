<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

    protected $table = 'product';

    public function get_all_with_details() {
        return $this->db->select('p.*, c.category_name, s.firm_name AS supplier_name, u.uom_name')
            ->from('product p')
            ->join('category c', 'c.id = p.category_id', 'left')
            ->join('supplier_details s', 's.id = p.supplier_id', 'left')
            ->join('uom u', 'u.id = p.uom_id', 'left')
            ->where('p.is_deleted', 0)
            ->order_by('p.product_name')
            ->get()->result();
    }

    public function get($id) {
        return $this->db->get_where($this->table, array('id' => $id, 'is_deleted' => 0))->row();
    }

    public function get_active_dropdown() {
        return $this->db->select('id, product_name, SGST, CGST, tax_status')
            ->where('is_deleted', 0)->where('product_status', 'active')
            ->order_by('product_name')->get($this->table)->result();
    }

    public function get_active_with_stock() {
        return $this->db->select('p.id, p.product_name, p.SGST, p.CGST, p.tax_status, u.uom_name, COALESCE(sd.stock_available,0) AS stock_available')
            ->from('product p')
            ->join('uom u', 'u.id = p.uom_id', 'left')
            ->join('stock_details sd', 'sd.product_id = p.id', 'left')
            ->where('p.is_deleted', 0)->where('p.product_status', 'active')
            ->order_by('p.product_name')->get()->result();
    }

    public function count_active() {
        return $this->db->where('is_deleted', 0)->where('product_status', 'active')->count_all_results($this->table);
    }

    public function create($data) {
        $this->db->insert($this->table, $data);
        $id = $this->db->insert_id();
        // Create initial stock record
        $this->db->insert('stock_details', array(
            'product_id'             => $id,
            'total_purchase_quantity'=> $data['init_stock_quantity'],
            'total_sales_quantity'   => 0,
            'stock_available'        => $data['init_stock_quantity'],
        ));
        return $id;
    }

    public function update($id, $data) {
        $this->db->where('id', $id)->update($this->table, $data);
    }

    public function soft_delete($id) {
        $this->db->where('id', $id)->update($this->table, array('is_deleted' => 1, 'product_status' => 'inactive'));
    }
}
