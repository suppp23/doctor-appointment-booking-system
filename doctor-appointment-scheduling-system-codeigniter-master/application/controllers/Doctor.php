<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Doctor extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Doctor_model');
        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    public function registration() {
        $data['specialisations'] = $this->Doctor_model->get_specialisations();
        $this->load->view('register_doctor', $data);
    }
    public function submit_registration() {
        $this->form_validation->set_rules('name', 'Name', 'required|regex_match[/^[A-Za-z\s]+$/]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('phone', 'Phone', 'required|regex_match[/^[6-9][0-9]{9}$/]');
        $this->form_validation->set_rules('specialisation', 'Specialisation', 'required');
        $this->form_validation->set_rules('start_time', 'Start Time', 'required');
        $this->form_validation->set_rules('end_time', 'End Time', 'required|callback_check_time');
    
        if ($this->form_validation->run() === FALSE) {
            $data['specialisations'] = $this->Doctor_model->get_specialisations();
            $data['errors'] = validation_errors(); 
            $this->load->view('register_doctor', $data);
        } else {
            $doctor_data = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'mobile' => $this->input->post('phone'),
                'specialisation_id' => $this->input->post('specialisation'),
                'start_time' => $this->input->post('start_time'),
                'end_time' => $this->input->post('end_time')
            ];
    
            if ($this->Doctor_model->register_doctor($doctor_data)) {
                $response = [
                    'success' => true,
                    'message' => 'New doctor registered successfully!'
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Error registering the doctor. Please try again.'
                ];
            }
            echo json_encode($response);
        }
    }
    
    public function check_time($end_time) {
        $start_time = $this->input->post('start_time');
        if ($start_time >= $end_time) {
            $this->form_validation->set_message('check_time', 'End time must be after start time.');
            return FALSE;
        }
        return TRUE;
    }
    
    public function list() {
        $data['doctors'] = $this->Doctor_model->get_all_doctors(); 
        $this->load->view('doctors_list', $data);
    }

    public function update() {
        $doctorId = $this->input->post('id');
        $data = [
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'mobile' => $this->input->post('mobile'),
            'specialisation_id' => $this->input->post('specialisation'), 
            'start_time' => $this->input->post('start_time'),
            'end_time' => $this->input->post('end_time'),
        ];

        if ($this->Doctor_model->update($doctorId, $data)) {
            echo 'success';
        } else {
            echo 'error';
        }
    }

    public function delete() {
        $doctorId = $this->input->post('id');

        if ($this->Doctor_model->delete($doctorId)) {
            echo 'success';
        } else {
            echo 'error';
        }
    }
    
    public function dashboard() {
        $this->load->library('session');
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'doctor') {
            redirect('auth/login');
        }
        $this->load->view('doctor_dashboard');
    }

    public function profile() {
        $this->load->library('session');
        $user_id = $this->session->userdata('user_id');
        $this->load->model('User_model');
        $data['user'] = $this->User_model->get_user_by_id($user_id);
        $this->load->view('doctor_profile', $data);
    }

    public function update_profile() {
        $this->load->library('session');
        $user_id = $this->session->userdata('user_id');
        $this->load->model('User_model');
        if ($this->input->method() === 'post') {
            $update_data = [
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email')
            ];
            if ($this->input->post('password')) {
                $update_data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            }
            $this->User_model->update_user($user_id, $update_data);
            redirect('doctor/profile');
        }
        $data['user'] = $this->User_model->get_user_by_id($user_id);
        $this->load->view('doctor_update_profile', $data);
    }
}
