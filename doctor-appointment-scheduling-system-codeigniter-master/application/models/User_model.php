<?php
class User_model extends CI_Model {
    private $table = 'users';

    public function __construct() {
        parent::__construct();
    }

    public function get_user_by_username($username) {
        return $this->db->get_where($this->table, ['username' => $username])->row_array();
    }

    public function get_user_by_email($email) {
        return $this->db->get_where($this->table, ['email' => $email])->row_array();
    }

    public function verify_password($username, $password) {
        $user = $this->get_user_by_username($username);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function get_role($user_id) {
        $user = $this->db->get_where($this->table, ['id' => $user_id])->row_array();
        return $user ? $user['role'] : null;
    }

    public function create_user($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->db->insert($this->table, $data);
    }

    public function get_user_by_id($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }

    public function update_user($id, $data) {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function get_all_users() {
        return $this->db->get($this->table)->result_array();
    }
} 