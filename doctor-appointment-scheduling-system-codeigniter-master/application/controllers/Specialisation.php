<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Specialisation extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Specialisation_model');
        $this->load->library('form_validation');
        $this->load->helper('url'); 
    }
    
    public function register_specialisation() {
        $this->load->view('register_specialisation');
    }

    public function register() {
        $this->form_validation->set_rules('specialisation_name', 'Specialisation Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required|min_length[5]');

        if ($this->form_validation->run() === FALSE) {
            $response = [
                'success' => false,
                'message' => validation_errors()
            ];
            echo json_encode($response);
            return;
        }

        $data = [
            'name' => $this->input->post('specialisation_name'),
            'description' => $this->input->post('description')
        ];

        if ($this->Specialisation_model->insert_specialisation($data)) {
            $response = [
                'success' => true,
                'message' => 'Specialisation registered successfully!'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Failed to register specialisation. Please try again.'
            ];
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($response)); 
    }

    public function list() {
        $data['specialisations'] = $this->Specialisation_model->get_all_specialisations();
        $this->load->view('specialisation_list', $data);
    }

    public function update() {
        $this->form_validation->set_rules('id', 'ID', 'required|integer');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required|min_length[5]');
    
        if ($this->form_validation->run() === FALSE) {
            $response = [
                'success' => false,
                'message' => validation_errors()
            ];
            echo json_encode($response);
            return;
        }
    
        $id = $this->input->post('id');
        $data = [
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description')
        ];
    
        if ($this->Specialisation_model->update_specialisation($id, $data)) {
            $response = [
                'success' => true,
                'message' => 'Specialisation updated successfully!'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Failed to update specialisation. Please try again.'
            ];
        }
    
        echo json_encode($response);
    }
    
    public function delete() {
        $id = $this->input->post('id');

        if (empty($id) || !is_numeric($id)) {
            echo json_encode(['success' => false, 'message' => 'Invalid ID provided.']);
            return;
        }

        if ($this->Specialisation_model->delete_specialisation($id)) {
            $response = [
                'success' => true,
                'message' => 'Specialisation deleted successfully!'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Failed to delete specialisation. Please try again.'
            ];
        }
    
        echo json_encode($response);
    }
}
