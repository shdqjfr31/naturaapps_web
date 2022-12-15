<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
  }
  public function index()
  {
    $this->form_validation->set_rules('username', 'Username', 'trim|required');
    $this->form_validation->set_rules('password', 'Password', 'trim|required');

    if ($this->form_validation->run() == false) {
      # code...
      $this->load->view('auth/index');
    } else {
      //validasi succes
      $this->login();
    }
  }
  private function login()
  {
    $username = $this->input->post('username');
    $password = $this->input->post('password');

    $user = $this->db->get_where('tbl_user', ['username' => $username])->row_array();

    //var_dump($user); 
    //die;
    # usernya ada..
    if ($user) {
      # jisa user aktif..
      if ($user['aktif'] == 1) {
        # cek password
        if (password_verify($password, $user['password'])) {
          # jika benar
          $data = [
            'username' => $user['username'],
            'role_id' => $user['role_id'],
            'email' => $user['email'],
            'nama' => $user['nama']
          ];
          $this->session->set_userdata($data);
          // var_dump($data);
          // return;
          if ($user['role_id'] == 1) {
            redirect('Admin/Dashboard');
          } elseif ($user['role_id'] == 2) {
            redirect('User/Dashboard');
          } else {
            redirect('Auth');
          }
        } else {
          $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="bi bi-exclamation-octagon me-1"></i>
          Sorry, wrong password!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
          redirect('auth');
        }
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-octagon me-1"></i>
        This username has not been activated
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>');
        redirect('auth');
      }
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-octagon me-1"></i>
      A username is not registered!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>');
      redirect('auth');
    }
  }
  public function logout()
  {
    $this->session->sess_destroy();
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
          you have been logged out</div>');
    redirect('auth');
  }
}
