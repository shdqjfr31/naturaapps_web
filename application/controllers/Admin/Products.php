<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Products extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    if (!$this->session->userdata('username') || !$this->session->userdata('role_id') == '1') {
      redirect('auth');
    }
    date_default_timezone_set('Asia/Jakarta');
    $this->load->model('M_Crud', 'Model');
    $this->load->model('M_Products', 'Products');
    // $this->load->library([
    //   'form_validation'
    // ]);
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
  function get_ajax()
  {
    base_url();
    $list = $this->Products->get_datatables();
    if ($this->input->is_ajax_request() == true) {

      $data = array();
      $no = @$_POST['start'];
      foreach ($list as $item) {
        $no++;
        // $cbhps = "<input type=\"checkbox\" name=\"KODE[]\" class=\"centangKode\"value=\"$item->KODE\">";
        $url_barcode = base_url('admin/products/barcode/' . $item->product_id);
        // $tombolEdit = '<button type="button" title="Edit Data" onclick="edit("' . $item->KODE . '")" class="btn btn-outline-info btn-sm"><i class="bi bi-pencil"></i> Edit</button>';
        $tombolEdit = "<button type=\"button\" title=\"Edit Data\" onclick=\"edit('" . $item->product_name . "')\" class=\"btn btn-outline-info btn-sm\"><i class=\"bi bi-pencil\"></i> </button>";
        $tombolDelete = "<button type=\"button\" title=\"Edit Data\" onclick=\"hapus('" . $item->product_name . "')\" class=\"btn btn-outline-danger btn-sm\"><i class=\"bi bi-trash\"></i> </button>";

        $btnBarcode = "<a class=\"btn-xs btn btn-secondary\" href=\"$url_barcode\"><i class=\"bi bi-qr-code\"></i> Generate</a>";

        // $aktif = $item->AKTIF == 1 ?  "<label class=\"btn btn-primary btn-sm\">Aktif</label>" : "<label class=\"btn btn-danger btn-sm\">Nonaktif</label>";

        $row = array();
        // $row[] = $cbhps;
        // $row[] = $item->FOTO;
        $row[] = $no . ".";
        $row[] = $item->product_kode . "&nbsp;" . $btnBarcode;
        $row[] = $item->product_name;
        $row[] = $item->harga_beli;
        // $row[] = $item->AKTIF;
        // $row[] =  $aktif;
        // $row[] = $item->FOTO != null ? '<img src="' . base_url('uploads/product/' . $item->FOTO) . '" class="img" style="width:100px">' : null;
        // add html for action
        // $row[] = '<a href="' . site_url('item/edit/' . $item->KODE) . '" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Update</a>
        // <a href="' . site_url('item/del/' . $item->KODE) . '" onclick="return confirm(\'Yakin hapus data?\')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</a>';
        $row[] = $tombolEdit . ' ' . $tombolDelete;
        $data[] = $row;
      }

      // $count_all = $this->Products->count_all();
      $output = array(
        "draw" => @$_POST['draw'],
        "recordsTotal" => $this->Products->count_all(),
        "recordsFiltered" => $this->Products->count_filtered(),
        "data" => $data,
      );
      // output to json format
      echo json_encode($output);
    } else {
      exit('Maaf Data Tidak Bisa Ditampilkan');
    }
  }
  public function index()
  {
    // $datacontent['url'] = '';
    // $tes = $this->inisial();
    // var_dump($tes);
    // die();
    $data['inisial'] = $this->inisial();
    // $data['nm_poli'] = $this->Model->get_poli();
    $data['title'] = 'Master Data Products - Admin';
    $this->load->view('admin/products/index', $data);
  }
  public function tambahDokter()
  {
    $data['nm_poli'] = $this->Model->get_poli();
    if ($this->input->is_ajax_request() == true) {
      $msg = [
        'sukses' => $this->load->view('admin/dokter/modalTambah', $data, true)
      ];
      echo json_encode($msg);
    }
  }
  public function simpan()
  {
    // $data['nm_poli'] = $this->Model->get_poli();
    if ($this->input->is_ajax_request() == true) {
      $KODE = $this->input->post('KODE', true);
      $NAMA = $this->input->post('NAMA', true);
      $SPESIALIS = $this->input->post('SPESIALIS', true);
      $AKTIF = $this->input->post('AKTIF', true);
      // $FOTO = $this->input->post('FOTO', true);
      $this->form_validation->set_rules(
        'KODE',
        'Kode',
        'trim|required|is_unique[tbl_dokter.KODE]',
        [
          'required' => '%s Tidak boleh kosong!',
          'is_unique' => '%s Kode sudah terdaftar!',
        ]
      );
      $this->form_validation->set_rules(
        'NAMA',
        'Nama',
        'trim|required',
        [
          'required' => '%s Tidak boleh kosong!',
        ]
      );
      if ($this->form_validation->run() == TRUE) {
        // $this->Model->simpan();
        $tampung  =
          array(
            'KODE' => $KODE,
            'NAMA' => $NAMA,
            'SPESIALIS' => $SPESIALIS,
            'AKTIF' => $AKTIF,
            'TGL_BUAT' => date('Y-m-d H:i:s'),
            'DIBUAT_OLEH' => $this->session->userdata('username')
          );

        $this->db->insert('tbl_dokter', $tampung);
        $msg = [
          'sukses' => 'Data Dokter Berhasil Ditambahkan'
        ];
      } else {
        // $msg = [
        //   'error' => '<br><div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
        //   ' . validation_errors() . '
        //   <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        // </div><br>'
        // ];
        $msg = [
          'error' => '<div class="alert alert-danger alert-dismissible fade show" role="alert">
         ' . validation_errors() . '
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>'
        ];
      }
      echo json_encode($msg);
    }

    // $this->form_validation->set_rules('KODE');


  }
  public function edit()
  {
    if ($this->input->is_ajax_request() == true) {


      $kode = $this->input->post('KODE', true);
      $ambildata = $this->Model->ambildata($kode);

      if ($ambildata->num_rows() > 0) {
        $row = $ambildata->row_array();
        // $data['nm_poli'] = $this->Model->get_poli();
        $data = [
          'KODE' => $kode,
          'NAMA' => $row['NAMA'],
          'SPESIALIS' => $row['SPESIALIS'],
          'AKTIF' => $row['AKTIF'],
          'nm_poli' => $this->Model->get_poli()
        ];
      }

      $msg = [
        'sukses' => $this->load->view('admin/dokter/modalEdit', $data, true)
      ];
      echo json_encode($msg);
    }
  }
  public function update()
  {
    if ($this->input->is_ajax_request() == true) {
      $KODE = $this->input->post('KODE', true);
      $NAMA = $this->input->post('NAMA', true);
      $SPESIALIS = $this->input->post('SPESIALIS', true);
      $AKTIF = $this->input->post('AKTIF', true);
      // $FOTO = $this->input->post('FOTO', true);

      $tampung  =
        array(
          // 'KODE' => $KODE,
          'NAMA' => $NAMA,
          'SPESIALIS' => $SPESIALIS,
          'AKTIF' => $AKTIF,
          'TGL_UBAH' => date('Y-m-d H:i:s'),
          'DIUBAH_OLEH' => $this->session->userdata('username')
        );
      $this->db->where('KODE', $KODE);
      $this->db->update('tbl_dokter', $tampung);
      $msg = [
        'sukses' => 'Data Dokter Berhasil Diupdate'
      ];
      echo json_encode($msg);
    }
  }
  public function delete()
  {
    if ($this->input->is_ajax_request() == true) {
      $kode = $this->input->post('KODE', true);

      $hapus = $this->db->delete('tbl_dokter', ['KODE' => $kode]);

      if ($hapus) {
        $msg = [
          'sukses' => 'Data Dokter Berhasil Dihapus'
        ];
      }
      echo json_encode($msg);
    }
  }
  public function deletemultiple()
  {
    if ($this->input->is_ajax_request() == true) {
      $kode = $this->input->post('KODE', true);
      $jmldata = count($kode);
      $hapusdata = $this->Model->hapusBanyak($kode, $jmldata);

      if ($hapusdata == true) {
        $msg = [
          'sukses' => "$jmldata Data Dokter Berhasil Dihapus"
        ];
      }
      echo json_encode($msg);
    } else {
      exit('Maaf tidak bisa dilanjutkan');
    }
  }

  function barcode($id)
  {
    $data['inisial'] = $this->inisial();
    $data['products'] = $this->db->get_where('products', array('product_id' => $id))->row();
    $data['title'] = 'Products Barcode - Admin';
    // var_dump($data['products']);
    // die();

    $this->load->view('products/barcode', $data);
  }
  function bar_qrcode($id)
  {
    $data['inisial'] = $this->inisial();
    $data['products'] = $this->db->get_where('products', array('product_id' => $id))->row();
    $data['title'] = 'Products Barcode & QR code - Admin';
    // var_dump($data['products']);
    // die();

    $this->load->view('products/barcode', $data);
  }

  function qrcode()
  {

    $result = new Endroid\QrCode\QrCode('ahaay deuh');

    // Directly output the QR code
    // header('Content-Type: ' . $result->getMimeType());
    header('Content-Type: ' . $result->getContentType());
    // echo $result->getString();
    echo $result->writeString();
  }

  function qrcode2()
  {
    // use Endroid\QrCode\ErrorCorrectionLevel;
    // use Endroid\QrCode\LabelAlignment;
    // use Endroid\QrCode\QrCode;
    // use Endroid\QrCode\Response\QrCodeResponse;

    // Create a basic QR code
    $qrCode2 = new Endroid\QrCode\QrCode('Lorem ipsum dolor sit amet consectetur, adipisicing elit. 
    
    Aut doloremque reprehenderit autem in! Unde, voluptas! Laboriosam totam alias quia exercitationem! 
    
    Reprehenderit veniam culpa eaque numquam.');
    $qrCode2->setSize(300);
    $qrCode2->setMargin(10);
    var_dump(base_url('assets/fonts/noto_sans.otf'));

    // Set advanced options
    $qrCode2->setWriterByName('png');
    $qrCode2->setEncoding('UTF-8');
    $qrCode2->setErrorCorrectionLevel(Endroid\QrCode\ErrorCorrectionLevel::HIGH());
    $qrCode2->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0]);
    $qrCode2->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0]);
    $qrCode2->setLabel('Scan the code', 16, 'assets/fonts/noto_sans.otf', Endroid\QrCode\LabelAlignment::CENTER());
    $qrCode2->setLogoPath('assets/images/j.png');
    $qrCode2->setLogoSize(150, 200);
    $qrCode2->setValidateResult(false);

    // Round block sizes to improve readability and make the blocks sharper in pixel based outputs (like png).
    // There are three approaches:
    $qrCode2->setRoundBlockSize(true, Endroid\QrCode\QrCode::ROUND_BLOCK_SIZE_MODE_MARGIN); // The size of the qr code is shrinked, if necessary, but the size of the final image remains unchanged due to additional margin being added (default)
    $qrCode2->setRoundBlockSize(true, Endroid\QrCode\QrCode::ROUND_BLOCK_SIZE_MODE_ENLARGE); // The size of the qr code and the final image is enlarged, if necessary
    $qrCode2->setRoundBlockSize(true, Endroid\QrCode\QrCode::ROUND_BLOCK_SIZE_MODE_SHRINK); // The size of the qr code and the final image is shrinked, if necessary

    // Set additional writer options (SvgWriter example)
    $qrCode2->setWriterOptions(['exclude_xml_declaration' => true]);

    // Directly output the QR code
    header('Content-Type: ' . $qrCode2->getContentType());
    echo $qrCode2->writeString();

    // Save it to a file
    $qrCode2->writeFile('assets/upload/qr-code2/product-test.png');

    // Generate a data URI to include image data inline (i.e. inside an <img> tag)
    $dataUri = $qrCode2->writeDataUri();
  }
}
