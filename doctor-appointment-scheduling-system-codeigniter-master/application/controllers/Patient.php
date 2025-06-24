<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patient extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database(); 
        $this->load->library('form_validation');
        $this->load->library('session'); 
        $this->load->model('Patient_model');
        $this->load->model('User_model');
        $this->load->helper('url');
    }

    public function registration() {
        $this->load->view('register_patient'); 
    }

    public function submit_patient() {
        // Set validation rules
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('phone', 'Phone', 'required|numeric|exact_length[10]');
        $this->form_validation->set_rules('age', 'Age', 'required|numeric|greater_than[0]|less_than[101]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('register_patient');
        } else {
            if ($this->Patient_model->validate_patient($this->input->post('email'), $this->input->post('phone'))) {
                $this->session->set_flashdata('error', 'Patient with this email or phone already exists.');
                redirect('patient/registration');
            }
            $data = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'mobile' => $this->input->post('phone'),
                'age' => $this->input->post('age')
            );

            $this->Patient_model->insert_patient($data);
            $this->session->set_flashdata('success', 'Patient registered successfully!');
            redirect('patient/registration');
        }
    }

    public function list() {
        $data['patients'] = $this->Patient_model->get_all_patients();
        $this->load->view('patient_list', $data);
    }
    public function update_patient() {
        $id = $this->input->post('id');
        $data = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'mobile' => $this->input->post('mobile'),
            'age' => $this->input->post('age')
        );

        if ($this->Patient_model->update_patient($id, $data)) {
            echo 'success';
        } else {
            echo 'failure';
        }
    }
    public function delete_patient() {
        $id = $this->input->post('id');
        if ($this->Patient_model->delete_patient($id)) {
            echo 'success';
        } else {
            echo 'failure';
        }
    }

    public function dashboard() {
        $this->load->library('session');
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'patient') {
            redirect('auth/login');
        }
        $this->load->view('patient_dashboard');
    }

    public function profile() {
        $this->load->library('session');
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->User_model->get_user_by_id($user_id);
        $this->load->view('patient_profile', $data);
    }

    public function update_profile() {
        $this->load->library('session');
        $user_id = $this->session->userdata('user_id');
        if ($this->input->method() === 'post') {
            $update_data = [
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email')
            ];
            if ($this->input->post('password')) {
                $update_data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            }
            $this->User_model->update_user($user_id, $update_data);
            redirect('patient/profile');
        }
        $data['user'] = $this->User_model->get_user_by_id($user_id);
        $this->load->view('patient_update_profile', $data);
    }
}
