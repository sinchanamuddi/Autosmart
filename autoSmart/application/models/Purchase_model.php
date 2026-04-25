<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_model extends CI_Model {

    public function get_all_with_details() {
        return $this->db->select('pi.*, s.firm_name AS supplier_name, u.user_name AS entered_by_name')
            ->from('purchase_invoice pi')
            ->join('supplier_details s', 's.id = pi.supplier_id', 'left')
            ->join('user_details u', 'u.id = pi.entered_by', 'left')
            ->where('pi.purchase_status', 'active')
            ->order_by('pi.date_of_purchase', 'DESC')
            ->get()->result();
    }

    public function get_invoice($id) {
        return $this->db->select('pi.*, s.firm_name AS supplier_name, s.GSTIN AS supplier_gstin, s.address AS supplier_address')
            ->from('purchase_invoice pi')
            ->join('supplier_details s', 's.id = pi.supplier_id', 'left')
            ->where('pi.purchase_id', $id)
            ->get()->row();
    }

    public function get_details($purchase_id) {
        return $this->db->select('pd.*, p.product_name, p.HSN_code, p.SGST, p.CGST')
            ->from('purchase_details pd')
            ->join('product p', 'p.id = pd.product_id', 'left')
            ->where('pd.purchase_id', $purchase_id)
            ->get()->result();
    }

    public function get_recent($limit = 5) {
        return $this->db->select('pi.purchase_id, pi.date_of_purchase, pi.total_amount, s.firm_name AS supplier_name')
            ->from('purchase_invoice pi')
            ->join('supplier_details s', 's.id = pi.supplier_id', 'left')
            ->where('pi.purchase_status', 'active')
            ->order_by('pi.date_of_entry', 'DESC')
            ->limit($limit)->get()->result();
    }

    public function count_all() {
        return $this->db->where('purchase_status', 'active')->count_all_results('purchase_invoice');
    }

    public function create_invoice($data) {
        $this->db->insert('purchase_invoice', $data);
        return $this->db->insert_id();
    }

    public function create_detail($data) {
        $this->db->insert('purchase_details', $data);
    }
}
