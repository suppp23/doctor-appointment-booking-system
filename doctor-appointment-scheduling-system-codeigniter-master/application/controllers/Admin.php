<?php
class Admin extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'admin') {
            redirect('auth/login');
        }
    }

    public function dashboard() {
        $this->load->view('admin_dashboard');
    }

    public function users() {
        $this->load->model('User_model');
        $data['users'] = $this->User_model->get_all_users();
        $this->load->view('admin_users', $data);
    }

    public function appointments() {
        $this->load->model('Appointment_model');
        $data['appointments'] = $this->Appointment_model->get_all_appointments();
        $this->load->view('admin_appointments', $data);
    }

    public function report() {
        $this->load->model('Appointment_model');
        $data['stats'] = $this->Appointment_model->get_appointment_stats();
        $this->load->view('admin_report', $data);
    }
} 