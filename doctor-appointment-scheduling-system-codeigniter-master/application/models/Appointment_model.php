<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Appointment_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    public function get_specialisations() {
        $query = $this->db->get('specialisation');
        return $query->result_array();
    }

    public function get_patients() {
        $query = $this->db->get('patientlogin');
        return $query->result_array();
    }
    public function get_doctors_by_specialisation($specialisation_id) {
        $this->db->select('id, name');
        $this->db->from('doctorlogin');
        $this->db->where('specialisation_id', $specialisation_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_doctor_availability($doctor_id) {
        $this->db->select('start_time, end_time');
        $this->db->from('doctorlogin');
        $this->db->where('id', $doctor_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return null; 
    }
    public function get_doctor_breaks($doctor_id, $slot_date) {
        $this->db->select('event_start_time, event_end_time');
        $this->db->from('appointments');
        $this->db->where('doctor_id', $doctor_id);
        $this->db->where('slot_date', $slot_date);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_booked_slots($doctor_id, $slot_date) {
        $this->db->select('slot_start_time, slot_end_time');
        $this->db->from('appointments');
        $this->db->where('doctor_id', $doctor_id);
        $this->db->where('slot_date', $slot_date);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_available_slots($doctor_id, $slot_date) {
        
        $doctor = $this->get_doctor_availability($doctor_id);
        if (!$doctor) {
            return null;
        }

        $doctor_start_time = strtotime($doctor['start_time']);
        $doctor_end_time = strtotime($doctor['end_time']);
        $breaks = $this->get_doctor_breaks($doctor_id, $slot_date);
        foreach ($breaks as &$break) {
            $break['event_start_time'] = strtotime($break['event_start_time']);
            $break['event_end_time'] = strtotime($break['event_end_time']);
        }
        unset($break); 

        if ($doctor_start_time <= strtotime('13:00:00') && $doctor_end_time >= strtotime('14:00:00')) {
            $breaks[] = [
                'event_start_time' => strtotime('13:00:00'),
                'event_end_time' => strtotime('14:00:00'),
            ];
        }
        $bookedSlots = $this->get_booked_slots($doctor_id, $slot_date);
        foreach ($bookedSlots as &$booked) {
            $booked['slot_start_time'] = strtotime($booked['slot_start_time']);
            $booked['slot_end_time'] = strtotime($booked['slot_end_time']);
        }
        unset($booked); 

        $slot_interval = 20 * 60;
        $current_time = $doctor_start_time;
        $available_slots = [];
        $now = time(); 

       
        while ($current_time < $doctor_end_time) {
            $slot_start_time = $current_time;
            $slot_end_time = $current_time + $slot_interval;

            if ($slot_date == date('Y-m-d') && $slot_start_time <= $now) {
                $current_time = $slot_end_time;
                continue;
            }
            if ($slot_end_time > $doctor_end_time) {
                break;
            }
            $is_during_break = false;
            foreach ($breaks as $break) {
                if ($slot_start_time < $break['event_start_time'] && $slot_end_time > $break['event_start_time'] && $slot_end_time <= $break['event_end_time']) {
                    $slot_end_time = $break['event_start_time']; 
                }
                if ($slot_start_time >= $break['event_start_time'] && $slot_start_time < $break['event_end_time'] && $slot_end_time > $break['event_end_time']) {
                    $slot_start_time = $break['event_end_time']; 
                }
                if ($slot_start_time >= $break['event_start_time'] && $slot_end_time <= $break['event_end_time']) {
                    $is_during_break = true; 
                    break;
                }
            }

            $is_booked = false;
            foreach ($bookedSlots as $booked) {
                if (($slot_start_time >= $booked['slot_start_time'] && $slot_start_time < $booked['slot_end_time']) || 
                    ($slot_end_time > $booked['slot_start_time'] && $slot_end_time <= $booked['slot_end_time'])) {
                    $is_booked = true; 
                    break;
                }
            }

            if (!$is_during_break && !$is_booked) {
                $available_slots[] = [
                    'slot_start_time' => date('H:i', $slot_start_time),
                    'slot_end_time' => date('H:i', $slot_end_time),
                ];
            }
            $current_time += $slot_interval;
        }

        return $available_slots; 
    }
    
    public function get_doctor_name($doctor_id) {
        $this->db->select('name');
        $this->db->from('doctorlogin');
        $this->db->where('id', $doctor_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->name;  
        }
        return null;  
    }
    public function get_patient_name($patient_id) {
        $this->db->select('name');
        $this->db->from('patientlogin');
        $this->db->where('id', $patient_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->name;  
        }
        return null;  
    }
    public function save_appointment($data) {
        if (empty($data['doctor_id']) || empty($data['patient_id']) || empty($data['slot_date']) || empty($data['slot_start_time']) || empty($data['slot_end_time'])) {
            log_message('error', 'Missing required fields for appointment.');
            return false; 
        }
        $insert = $this->db->insert('appointments', $data);

        if (!$insert) {
            log_message('error', 'Error inserting appointment: ' . json_encode($this->db->error()));
            return false;
        }
        return true; 
    }

    public function get_appointments() {
        $this->db->select('id, patient_name, doctor_name, slot_date, slot_start_time, slot_end_time');
        $this->db->from('appointments');
        $this->db->where('slot_start_time !=', '00:00:00');
        $this->db->where('slot_end_time !=', '00:00:00');
        $this->db->order_by('slot_date');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_ava_slots($doctor_id, $slot_date) {
        $this->db->select('slot_start_time, slot_end_time');
        $this->db->from('doctor_slots');
        $this->db->where('doctor_id', $doctor_id);
        $this->db->where('slot_date', $slot_date);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function update_appointment($appointment_id, $data) {
        $this->db->where('id', $appointment_id);
        return $this->db->update('appointments', $data);
    }

    public function delete_appointment($appointment_id) {
        $this->db->where('id', $appointment_id);
        return $this->db->delete('appointments');
    }
    public function get_appointments_count_per_doctor() {
        // Get the count of appointments for each doctor
        $this->db->select('doctor_id, COUNT(*) as appointment_count');
        $this->db->from('appointments');
        $this->db->group_by('doctor_id');  // Group by doctor ID to get the count per doctor
        $query = $this->db->get();
    
        // Check if query was successful and return the result
        if ($query->num_rows() > 0) {
            return $query->result();  // Return all results (doctor_id and appointment_count)
        }
    
        // If no appointments found, return an empty array
        return array();
    }
    
    public function get_all_appointments() {
        return $this->db->get('appointments')->result_array();
    }

    public function get_appointment_stats() {
        $this->db->select('role, COUNT(*) as count');
        $this->db->from('users');
        $this->db->join('appointments', 'users.id = appointments.patient_id', 'left');
        $this->db->group_by('role');
        return $this->db->get()->result_array();
    }
}
