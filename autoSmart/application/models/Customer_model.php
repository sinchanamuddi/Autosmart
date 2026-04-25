<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model {

    protected $table = 'customer_details';

    public function get_all() {
        return $this->db->where('is_deleted', 0)->order_by('customer_name')->get($this->table)->result();
    }

    public function get($id) {
        return $this->db->get_where($this->table, array('id' => $id, 'is_deleted' => 0))->row();
    }

    public function get_active_dropdown() {
        return $this->db->select('id, customer_name, firm_name')
            ->where('is_deleted', 0)->where('customer_status', 'active')
            ->order_by('customer_name')->get($this->table)->result();
    }

    public function create($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where('id', $id)->update($this->table, $data);
    }

    public function soft_delete($id) {
        $this->db->where('id', $id)->update($this->table, array('is_deleted' => 1, 'customer_status' => 'inactive'));
    }
}
