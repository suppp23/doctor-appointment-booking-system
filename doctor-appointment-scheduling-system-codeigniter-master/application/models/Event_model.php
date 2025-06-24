<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_doctors() {
        $query = $this->db->select('id, name')
                          ->from('doctorlogin')
                          ->get();
        return $query->result_array();
    }
    public function is_event_time_valid($doctor_id, $start_time, $end_time) {
        $this->db->select('start_time, end_time')
                 ->from('doctorlogin')
                 ->where('id', $doctor_id);
        $query = $this->db->get();
        $doctor = $query->row();

        if ($doctor) {
            return (strtotime($start_time) >= strtotime($doctor->start_time) &&
                    strtotime($end_time) <= strtotime($doctor->end_time));
        }

        return FALSE;
    }

    public function check_conflict($doctor_id, $appointment_date, $start_time, $end_time) {
        $this->db->from('appointments')
                 ->where('doctor_id', $doctor_id)
                 ->where('slot_date', $appointment_date)
                 ->group_start()
                     ->where('event_start_time <', $end_time)
                     ->where('event_end_time >', $start_time)
                 ->group_end();
        $query = $this->db->get();
        return $query->result_array();
    }

    
    public function create_event() {
        $this->form_validation->set_rules('doctor', 'Doctor', 'required');
        $this->form_validation->set_rules('event_date', 'Event Date', 'required');
        $this->form_validation->set_rules('event_type', 'Event Type', 'required');
        $this->form_validation->set_rules('event_start_time', 'Start Time', 'required');
        $this->form_validation->set_rules('event_end_time', 'End Time', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->create();
        } else {
            $doctor_id = $this->input->post('doctor');
            $appointment_date = $this->input->post('event_date');
            $event_type = $this->input->post('event_type');
            $start_time = $this->input->post('event_start_time');
            $end_time = $this->input->post('event_end_time');
    
            $conflicts = $this->Event_model->check_event_conflict($doctor_id, $appointment_date, $start_time, $end_time);
    
            if ($conflicts->num_rows() > 0) {
                $this->session->set_flashdata('error', 'Conflict with existing appointments!');
                redirect('events/create');
            } else {
                $event_data = [
                    'doctor_id' => $doctor_id,
                    'doctor_name' => $this->Event_model->get_doctor_name($doctor_id),
                    'slot_date' => $appointment_date,
                    'events' => $event_type,
                    'event_start_time' => $start_time,
                    'event_end_time' => $end_time,
                    'slot_status' => 'break' 
                ];
    
                if ($this->Event_model->create_event($event_data)) {
                    $this->session->set_flashdata('success', 'New event registered successfully!');
                    redirect('events/create'); 
                } else {
                    $this->session->set_flashdata('error', 'Failed to create event!');
                    redirect('events/create');
                }
            }
        }
    }
    
    public function get_doctor_name($doctor_id) {
        $this->db->select('name')
                 ->from('doctorlogin')
                 ->where('id', $doctor_id);
        $query = $this->db->get();
        return $query->row()->name;
    }

    public function get_events() {
        $this->db->select('id, doctor_name, slot_date, events, event_start_time, event_end_time');
        $this->db->from('appointments');
        $this->db->where('event_start_time !=', '00:00:00');
        $this->db->where('event_end_time !=', '00:00:00');
        $this->db->order_by('slot_date', 'ASC');
        $query = $this->db->get();
        return $query->result_array(); 
    }

    public function delete_event($event_id) {
        $this->db->where('id', $event_id);
        return $this->db->delete('appointments');
    }

}
