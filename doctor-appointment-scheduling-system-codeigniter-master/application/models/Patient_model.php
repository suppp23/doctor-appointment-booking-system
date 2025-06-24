<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patient_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database(); 
    }

    public function get_all_patients() {
        $query = $this->db->get('patientlogin');  
        return $query->result_array(); 
    }

    public function get_patient_by_id($id) {
        $query = $this->db->get_where('patientlogin', array('id' => $id));
        return $query->row_array(); 
    }
    public function validate_patient($email, $mobile) {
        $this->db->where('email', $email);
        $this->db->or_where('mobile', $mobile);  
        $query = $this->db->get('patientlogin');
        return $query->num_rows() > 0;  

    public function insert_patient($data) {
        return $this->db->insert('patientlogin', $data);
    }

    public function update_patient($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('patientlogin', $data);  
    }

  
    public function delete_patient($id) {
        return $this->db->delete('patientlogin', array('id' => $id));  
    }
}
