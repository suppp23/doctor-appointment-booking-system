<?php
class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper(array('form', 'url'));
    }

    public function login() {
        if ($this->input->method() === 'post') {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $user = $this->User_model->verify_password($username, $password);
            if ($user) {
                $this->session->set_userdata([
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'logged_in' => true
                ]);
                // Redirect based on role
                if ($user['role'] === 'admin') {
                    redirect('admin/dashboard');
                } elseif ($user['role'] === 'doctor') {
                    redirect('doctor/dashboard');
                } else {
                    redirect('patient/dashboard');
                }
            } else {
                $data['error'] = 'Invalid username or password';
                $this->load->view('login_view', $data);
                return;
            }
        }
        $this->load->view('login_view');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }

    public function register_admin() {
        if ($this->input->method() === 'post') {
            $data = [
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'role' => 'admin'
            ];
            $this->User_model->create_user($data);
            redirect('auth/login');
        }
        $this->load->view('register_admin_view');
    }

    public function register_doctor() {
        if ($this->input->method() === 'post') {
            $data = [
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'role' => 'doctor'
            ];
            $this->User_model->create_user($data);
            redirect('auth/login');
        }
        $this->load->view('register_doctor_view');
    }

    public function register_patient() {
        if ($this->input->method() === 'post') {
            $data = [
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'role' => 'patient'
            ];
            $this->User_model->create_user($data);
            redirect('auth/login');
        }
        $this->load->view('register_patient_view');
    }
} 