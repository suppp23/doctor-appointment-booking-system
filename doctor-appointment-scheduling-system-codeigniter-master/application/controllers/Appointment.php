<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Appointment extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Appointment_model');
        $this->load->helper('url');
        
    }

    public function index() {
        $data['specialisations'] = $this->Appointment_model->get_specialisations();
        $data['patients'] = $this->Appointment_model->get_patients();

        $this->load->view('appointment_view', $data);
    }

    public function fetch_doctors() {
        $specialisation_id = $this->input->post('specialisation_id');
        $doctors = $this->Appointment_model->get_doctors_by_specialisation($specialisation_id);
        echo json_encode($doctors);
    }

    public function fetch_slots() {
        $doctor_id = $this->input->post('doctor_id');
        $slot_date = $this->input->post('slot_date');
        
        $slots = $this->Appointment_model->get_available_slots($doctor_id, $slot_date);
        echo json_encode($slots);
    }

    public function book_appointment() {
    $this->load->library('form_validation');

    $this->form_validation->set_rules('specialisation', 'Specialisation', 'required');
    $this->form_validation->set_rules('doctor', 'Doctor', 'required');
    $this->form_validation->set_rules('patient', 'Patient', 'required');
    $this->form_validation->set_rules('slot_date', 'Appointment Date', 'required');
    $this->form_validation->set_rules('slot_time', 'Slot Time', 'required');

    
    if ($this->form_validation->run() === FALSE) {
        log_message('debug', 'Form validation failed, reloading index page');
        $this->index();
    } else {

        $doctor_id = $this->input->post('doctor');
        $patient_id = $this->input->post('patient');
        $doctor_name = $this->Appointment_model->get_doctor_name($doctor_id);  
        $patient_name = $this->Appointment_model->get_patient_name($patient_id);

        $appointment_data = array(
            'doctor_id' => $doctor_id,
            'doctor_name' => $doctor_name,
            'patient_id' => $patient_id,
            'patient_name' => $patient_name,
            'slot_date' => $this->input->post('slot_date'),
            'events' => 4
             
        );
        $slot_time = $this->input->post('slot_time'); 
        list($slot_start_time, $slot_end_time) = explode('-', $slot_time);
        $appointment_data['slot_start_time'] = $slot_start_time;
        $appointment_data['slot_end_time'] = $slot_end_time;

      
        $result = $this->Appointment_model->save_appointment($appointment_data);
        if ($result) {
            $this->session->set_flashdata('success', 'Appointment booked successfully!');
             $this->load->view('appointment_view', ['success' => true]);
        } else {
            $this->session->set_flashdata('error', 'Failed to book appointment. Please try again.');
             $this->load->view('appointment_view', ['error' => true]);
        }
    }
}

    public function list() {
        $data['appointments'] = $this->Appointment_model->get_appointments();
        $data['appointment_counts'] = $this->Appointment_model->get_appointments_count_per_doctor();
        
        $this->load->view('appointments_list', $data);
    }
   
   
}
