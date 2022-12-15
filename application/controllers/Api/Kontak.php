<?php

defined('BASEPATH') or exit('No direct script access allowed');


use chriskacerguis\RestServer\RestController;

class Kontak extends RestController
{

  function __construct($config = 'rest')
  {
    parent::__construct($config);
    $this->load->database();
  }

  //Menampilkan data kontak
  function index_get()
  {
    $id = $this->get('id');
    if ($id == '') {
      $kontak = $this->db->get('telepon')->result();
    } else {
      $this->db->where('id', $id);
      $kontak = $this->db->get('telepon')->result();
    }
    // $this->response($kontak, 200);
    $this->response($kontak, RestController::HTTP_OK);
  }
  public function users_get()
  {
    // Users from a data store e.g. database
    $users = [
      ['id' => 0, 'name' => 'John', 'email' => 'john@example.com'],
      ['id' => 1, 'name' => 'Jim', 'email' => 'jim@example.com'],
    ];

    $id = $this->get('id');

    if ($id === null) {
      // Check if the users data store contains users
      if ($users) {
        // Set the response and exit
        $this->response($users, 200);
      } else {
        // Set the response and exit
        $this->response([
          'status' => false,
          'message' => 'No users were found'
        ], 404);
      }
    } else {
      if (array_key_exists($id, $users)) {
        $this->response($users[$id], 200);
      } else {
        $this->response([
          'status' => false,
          'message' => 'No such user found'
        ], 404);
      }
    }
  }

  //Masukan function selanjutnya disini
  function index_post()
  {
    $data = array(
      // 'id'           => $this->post('id'),
      'nama'          => $this->post('nama'),
      'nomor'    => $this->post('nomor')
    );
    $insert = $this->db->insert('telepon', $data);
    if ($insert) {
      $this->response($data, RestController::HTTP_OK);
    }
  } //Memperbarui data kontak yang telah ada
  function index_put()
  {
    // * Metode PUT digunakan untuk memperbarui data yang telah ada di server REST API. Sebagai contohnya digunakan untuk memperbarui data dengan id 88 pada tabel telepon database kontak.


    $id = $this->put('id');
    $data = array(
      'id'       => $this->put('id'),
      'nama'          => $this->put('nama'),
      'nomor'    => $this->put('nomor')
    );
    $this->db->where('id', $id);
    $update = $this->db->update('telepon', $data);


    if ($update) {
      $this->response($data, 200);
    } else {
      $this->response(array('status' => 'fail', 502));
    }
  }
  //Menghapus salah satu data kontak
  function index_delete()
  {
    $id = $this->delete('id');
    $this->db->where('id', $id);
    $delete = $this->db->delete('telepon');
    if ($delete) {
      $this->response(array('status' => 'success'), 201);
    } else {
      $this->response(array('status' => 'fail', 502));
    }
  }
}
