<?php // start datatables
  defined('BASEPATH') or exit('No direct script access allowed');

  class dt2 extends CI_Controller
  {
    public function ambildata()
    {
        if ($this->input->is_ajax_request() == true) {
            $this->load->model('admin/member/Modelmember', 'member');
            $list = $this->member->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $field) {
                
                $no++;
                $row = array();
               
                $row[] = $no;
                $row[] ='';
                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->member->count_all(),
                "recordsFiltered" => $this->member->count_filtered(),
                "data" => $data,
            );
            //output dalam format JSON
            echo json_encode($output);
        } else {
            exit('Maaf data tidak bisa ditampilkan');
        }
    }
  }
