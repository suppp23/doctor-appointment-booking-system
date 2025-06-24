<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Doctor_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_specialisations() {
        $query = $this->db->select('id, name')->get('specialisation');
        return $query->result_array();
    }

    public function register_doctor($data) {
        return $this->db->insert('doctorlogin', $data);
    }

    public function get_all_doctors() {
        $this->db->select('d.id, d.name AS doctor_name, s.name AS specialisation_name, d.email, d.mobile, d.start_time, d.end_time');
        $this->db->from('doctorlogin d');
        $this->db->join('specialisation s', 'd.specialisation_id = s.id');
        return $this->db->get()->result_array();
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('doctorlogin', $data);
    }

    public function delete($id) {
        return $this->db->delete('doctorlogin', ['id' => $id]);
    }
}
