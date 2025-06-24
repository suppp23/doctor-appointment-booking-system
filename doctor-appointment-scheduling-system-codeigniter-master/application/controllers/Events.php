<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Event_model');
        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    public function index() {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
          
            $this->form_validation->set_rules('doctor', 'Doctor', 'required|numeric');
            $this->form_validation->set_rules('event_date', 'Event Date', 'required');
            $this->form_validation->set_rules('event_type', 'Event Type', 'required');
            $this->form_validation->set_rules('event_start_time', 'Start Time', 'required');
            $this->form_validation->set_rules('event_end_time', 'End Time', 'required|callback_check_end_time');

            if ($this->form_validation->run() === TRUE) {
                $doctor_id = $this->input->post('doctor');
                $appointment_date = $this->input->post('event_date');
                $appointment_type = $this->input->post('event_type');
                $event_start_time = $this->input->post('event_start_time');
                $event_end_time = $this->input->post('event_end_time');
                
                if ($this->Event_model->is_event_time_valid($doctor_id, $event_start_time, $event_end_time)) {
                    $conflicts = $this->Event_model->check_conflict($doctor_id, $appointment_date, $event_start_time, $event_end_time);
                    if (empty($conflicts)) {
                        if ($this->Event_model->create_event($doctor_id, $appointment_date, $appointment_type, $event_start_time, $event_end_time)) {
                            $this->session->set_flashdata('success', 'New event scheduled successfully!');
                            redirect('events');
                        } else {
                            $this->session->set_flashdata('error', 'Error registering the event.');
                        }
                    } else {
                        // Conflict found
                        $this->session->set_flashdata('error', 'There are conflicting appointments.');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Event time must be within doctor\'s available time.');
                }
            }
        }
        $data['doctors'] = $this->Event_model->get_doctors();
        $this->load->view('event_view', $data);
    }
  public function check_end_time($end_time) {
        $start_time = $this->input->post('event_start_time');
        if ($start_time && $end_time && $end_time <= $start_time) {
            $this->form_validation->set_message('check_end_time', 'End time must be after the start time.');
            return FALSE;
        }
        return TRUE;
    }

    public function view() {
        $data['appointments'] = $this->Event_model->get_events();
        $this->load->view('events_view', $data);  
    }

    // Delete event
    public function delete_event($event_id) {
        $deleted = $this->Event_model->delete_event($event_id);

        if ($deleted) {
            $this->session->set_flashdata('message', 'Event deleted successfully');
            redirect('events/view');  
        } else {
            $this->session->set_flashdata('message', 'Failed to delete event');
            redirect('events/view');
        }
    }
}
