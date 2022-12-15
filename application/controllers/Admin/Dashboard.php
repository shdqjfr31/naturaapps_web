<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    if (!$this->session->userdata('username') || !$this->session->userdata('role_id') == '1') {
      redirect('auth');
    }
    date_default_timezone_set('Asia/Jakarta');
    // $this->Dokter = new Dokter();
    // $this->load->library('../controllers/Admin/Dokter');
    // $this->load->model('M_Antri', 'Model');
  }
  function inisial()
  {
    $nama = $this->session->userdata('nama');
    $bongkar = explode(' ', $nama);
    $singkatan = '';

    // if(){

    // }

    foreach ($bongkar as $row) {
      // if ($nama === ) {
      //   $singkatan .= substr($row, 0, 1);
      // } else {
      //   $singkatan = $row;
      // }
      $singkatan .= substr($row, 0, 1);

      // var_dump($singkatan);
      // die();
    }
    return $singkatan;
  }
  public function index()
  {
    // $datacontent['url'] = '';

    $inisial = $this->inisial();
    $data['inisial'] = $inisial;
    $data['title'] = 'Dashboard - Admin';
    $this->load->view('admin/index', $data);
  }


  public function users()
  {
    $this->load->Model();
    $data['title'] = 'Master Data User - Admin';
    $this->load->view('admin/users', $data);
  }
}
