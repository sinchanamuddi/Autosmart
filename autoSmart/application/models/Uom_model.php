<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uom_model extends CI_Model {

    protected $table = 'uom';

    public function get_all() {
        return $this->db->where('is_deleted', 0)->order_by('uom_name')->get($this->table)->result();
    }

    public function get($id) {
        return $this->db->get_where($this->table, array('id' => $id, 'is_deleted' => 0))->row();
    }

    public function get_active_dropdown() {
        return $this->db->select('id, uom_name, uom_code')
            ->where('is_deleted', 0)->where('uom_status', 'active')
            ->order_by('uom_name')->get($this->table)->result();
    }

    public function create($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where('id', $id)->update($this->table, $data);
    }

    public function soft_delete($id) {
        $this->db->where('id', $id)->update($this->table, array('is_deleted' => 1, 'uom_status' => 'inactive'));
    }
}
