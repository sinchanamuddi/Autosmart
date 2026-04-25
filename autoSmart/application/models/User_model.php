<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    protected $table = 'user_details';

    public function authenticate($email, $password_sha1) {
        return $this->db->get_where($this->table, array(
            'user_email'    => $email,
            'user_password' => $password_sha1,
            'user_status'   => 'Active',
            'is_deleted'    => 0,
        ))->row();
    }

    public function get_all() {
        return $this->db->where('is_deleted', 0)->get($this->table)->result();
    }

    public function get($id) {
        return $this->db->get_where($this->table, array('id' => $id, 'is_deleted' => 0))->row();
    }

    public function create($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where('id', $id)->update($this->table, $data);
    }

    public function soft_delete($id) {
        $this->db->where('id', $id)->update($this->table, array('is_deleted' => 1, 'user_status' => 'Inactive'));
    }
}
