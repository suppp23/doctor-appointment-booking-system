<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Specialisation_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function insert_specialisation($data) {
        return $this->db->insert('specialisation', $data);
    }

    public function get_all_specialisations() {
        $query = $this->db->get('specialisation');
        return $query->result();
    }

    public function update_specialisation($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('specialisation', $data);
    }

    public function delete_specialisation($id) {
        $this->db->where('id', $id);
        return $this->db->delete('specialisation');
    }
}
