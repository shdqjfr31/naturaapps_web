<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Crud extends CI_Model
{
  public function show($table, $order)
  {
    $this->db->order_by($order);
    $sql = $this->db->get($table);
    return $sql;
  }
  public function show_where($table, $where)
  {
    $this->db->where($where);
    $sql = $this->db->get($table);
    return $sql;
  }
  public function show2($table)
  {
    $sql = $this->db->get($table);
    return $sql;
  }
  public function show_limit($table, $limit)
  {
    $sql = $this->db->get($table);
    $this->db->limit($limit);
    return $sql;
  }
  public function get_max_id($table, $field, $where)
  {
    // $this->db->select_max($field);
    // $this->db->where('LEFT(NO_ANTRIAN,1)', 'D');
    $this->db->select_max('cast(substr(' . $field . ',2) as unsigned)', 'MAX_ANTRIAN');
    $this->db->where($where);
    $sql = $this->db->get($table);
    return $sql;
  }
  public function get_group_id($table, $group_by)
  {
    $this->db->group_by($group_by);
    $this->db->order_by($group_by . " DESC");
    $sql = $this->db->get($table);
    return $sql;
  }
  public function add($table, $data)
  {
    $this->db->insert($table, $data);
  }
  public function del($table, $where)
  {
    $this->db->where($where);
    $this->db->delete($table);
  }
  public function edit($table, $data, $where)
  {
    $this->db->where($where);
    $this->db->update($table, $data);
  }
  public function join($table, $join, $on, $order, $az)
  {
    $this->db->select('*');
    $this->db->from($table);
    $this->db->join($join, $on);
    $this->db->order_by($order, $az);
    $sql = $this->db->get();
    return $sql;
  }
  public function join_multiple($table, $join, $pq, $join1, $pq1, $order, $az)
  {
    $this->db->select('*');
    $this->db->from($table);
    $this->db->join($join, $pq);
    $this->db->join($join1, $pq1);
    $this->db->order_by($order, $az);
    $sql = $this->db->get();
    return $sql;
  }
  public function get_id($table, $where)
  {

    // $this->db->where('LEFT(NO_ANTRIAN,1)', 'D');
    $this->db->where($where);
    $sql = $this->db->get($table);
    return $sql;
  }
  public function fetch_data($table, $field, $num, $offset)
  {
    empty($offset) ? $offset = 0 : $offset;

    $this->db->query("SET @no=" . $offset);
    $this->db->select('*,(@no:=@no+1) AS nomor');
    $this->db->group_by($field);
    $this->db->order_by($field, 'DESC');

    $data = $this->db->get($table, $num, $offset);

    return $data->result();
  }
  function get_user()
  {
    $data = $this->db->select('*')
      ->from('t_user a')
      ->join('tbl_antrian_counter b', 'a.id_konter=b.COUNTER', 'LEFT')
      ->get();
    return $data;
  }
  function get_loket()
  {
    $data = $this->db->get('t_loket');
    return $data;
  }

  function get_antrian()
  {
    $data = $this->db->select('*')
      ->from('t_antrian a')
      ->join('t_loket b', 'a.id_loket=b.id_loket', 'LEFT')
      ->join('t_user c', 'a.username=c.username', 'LEFT')
      ->get();
    return $data;
  }
  function get_poli_1()
  {
    $data = $this->db->select('*')
      ->from('tbl_poli_gambar a')
      ->get();
    return $data;
  }
  function get_jadwal_poli()
  {
    $data = $this->db->select('*')
      ->from('tbl_jadwal_poli a')
      ->get();
    return $data;
  }
  function get_jp_dok($dok)
  {
    $data = $this->db->select('*')
      ->from('tbl_dokter')
      ->where('NAMA', $dok)
      ->get();
    return $data;
  }
  public function get_id_jadwal($kode)
  {
    $data = $this->db->query("SELECT * FROM tbl_jadwal_poli WHERE tbl_jadwal_poli.KODE = '$kode' ");
    return $data;
  }
  function get_dokter_1()
  {
    $data = $this->db->select('*')
      ->from('tbl_dokter a')
      ->get();
    return $data;
  }
  function get_dokter_asc()
  {
    $data = $this->db->select('KODE, NAMA');
    $data = $this->db->where('AKTIF', '1');
    $data = $this->db->order_by('NAMA ASC');
    $data = $this->db->get('tbl_dokter');
    return $data;
  }
  function get_poli_asc()
  {
    $data = $this->db->order_by('NM_POLI ASC');
    $data = $this->db->get('tbl-poli-gambar');
    return $data;
  }
  function get_dokter()
  {
    $data = $this->db->select('*')
      ->from('t_dokter a')
      ->join('t_poli b', 'a.id_poli=b.id_poli', 'LEFT')
      ->get();
    return $data;
  }
  function get_antrian2()
  {
    $data = $this->db->select('*')
      ->from('t_antrian a')
      ->join('t_poli b', 'a.id_poli=b.id_poli', 'LEFT')
      ->join('t_konter c', 'a.id_konter=c.id_konter', 'LEFT')
      ->join('t_dokter d', 'a.id_dok=d.id_dok', 'LEFT')
      ->get();
    return $data;
  }
  function get_konter()
  {
    $data = $this->db->select('*')
      ->from('tbl_antrian_counter')
      ->get();
    return $data;
  }
  function get_maxpasien($dokter, $praktek)
  {
    $nowDate = date('Y-m-d');
    $data = $this->db->select('*')
      ->from('tbl_antrian_registrasi')
      ->where('DATE(TGL_REGISTRASI)', $nowDate)
      ->where('DOKTER', $dokter)
      ->where('PRAKTEK', $praktek)
      ->get();
    return $data;
  }
  function get_btn_antrian()
  {
    $data = $this->db->select('*')
      ->from('tbl_btn_antrian')
      ->get();
    return $data;
  }
  function get_counter_plasma()
  {
    $data = $this->db->select('*')
      ->from('tbl_plasma_counter')
      ->get();
    return $data;
  }
  function get_media_antrian()
  {
    $data = $this->db->select('*')
      ->from('tbl_media_antrian')
      ->where('DIGUNAKAN', '1')
      ->where('LOKASI', 'Plasma')
      ->limit(1)
      ->get();
    return $data;
  }
  function get_media()
  {
    $data = $this->db->select('*')
      ->from('tbl_media_antrian')
      ->get();
    return $data;
  }
  function get_btn_next()
  {
    $data = $this->db->select('*')
      ->from('tbl_btn_next')
      ->get();
    return $data;
  }
  function get_poli()
  {
    $sql = $this->db->query("SELECT NM_POLI FROM tbl_poli_gambar order by NM_POLI ASC");
    return $sql->result();
  }
  function get_produtcs()
  {
    $sql = $this->db->query("SELECT NM_POLI FROM tbl_poli_gambar order by NM_POLI ASC");
    return $sql->result();
  }
  function get_btn_master()
  {
    $data = $this->db->order_by('NAMA_BTN ASC');
    $data = $this->db->get('tbl_btn_master');
    // $data = $this->db->order_by('nm_poli', 'DESC');
    return $data;
  }
  function get_konter2()
  {
    $data = $this->db->order_by('COUNTER ASC');
    $data = $this->db->get('tbl_antrian_counter');
    // $data = $this->db->order_by('nm_poli', 'DESC');
    return $data;
  }
  // public function slide($limit)
  // {
  //     $sql = $this->db->query("SELECT * FROM agenda ORDER BY id_agenda DESC LIMIT $limit");
  //     return $sql;
  // }
  // public function data_dokter($where)
  // {
  //     $this->db->select('t_dokter.*,t_poli.id_poli,t_poli.nm_poli');
  //     $this->db->from($this->table);
  //     $this->db->join('t_poli', 't_poli.id_poli = t_dokter.id_poli', 'left');
  //     $this->db->where($where);
  //     return $this->db->get();
  // }
  public function data_dokter($where)
  {
    $this->db->select('t_dokter.*');
    $this->db->from('t_dokter');
    // $this->db->join('t_poli', 't_poli.id_poli = t_dokter.id_poli', 'LEFT');
    $this->db->where($where);
    return $this->db->get();
  }
  public function data_dokter2()
  {
    $data = $this->db->select('*')
      ->from('t_antrian a')
      ->join('t_dokter b', 'a.id_dok=b.id_dok', 'LEFT')
      ->join('t_poli c', 'a.id_poli=c.id_poli', 'LEFT')
      ->get();
    return $data;
  }
  function insert($data = array())
  {
    $this->db->insert('t_antrian', $data);
  }
  function insert_dokter($data = array())
  {
    $this->db->insert('tbl_dokter', $data);
    $info = '<div class="alert alert-success alert-dismissible">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	            <h4><i class="icon fa fa-check"></i> Sukses!</h4> Data Sukses Ditambah </div>';
    $this->session->set_flashdata('info', $info);
  }
  function insert_konter($data = array())
  {
    $this->db->insert('tbl_antrian_counter', $data);
    $info = '<div class="alert alert-success alert-dismissible">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	            <h4><i class="icon fa fa-check"></i> Sukses!</h4> Data Sukses Ditambah </div>';
    $this->session->set_flashdata('info', $info);
  }
  function GetDataPoli($kdpoli)
  {
    $sql = "SELECT KODE, ID_DOKTER, DOKTER, HARI, POLIKLINIK, JAM , MAX_PASIEN, SUDAH_DATANG, STATUS_CUTI, KETERANGAN, POLI, MAPPING From TBL_JADWAL_POLI WHERE KODE = '" . $kdpoli . "' LIMIT 1";

    $query = $this->db->query($sql);
    return $query->row();
  }
  function ListNamaRuangan($namahari)
  {
    $sql = "SELECT DISTINCT POLIKLINIK From TBL_JADWAL_POLI WHERE HARI = '" . $namahari . "' ORDER BY POLIKLINIK";
    $query = $this->db->query($sql);
    return $query->result();
  }
  function ListNamaRuangan2($namahari, $statusdatang)
  {
    $sql = "SELECT DISTINCT POLIKLINIK From TBL_JADWAL_POLI WHERE HARI = '" . $namahari . "' AND SUDAH_DATANG = '" . $statusdatang . "' ORDER BY POLIKLINIK";
    $query = $this->db->query($sql);
    return $query->result();
  }
  function ListNamaRuangan3($namahari, $statusdatang)
  {
    $query = $this->db->distinct()
      ->select('a.POLIKLINIK')
      ->from('tbl_jadwal_poli a')
      ->join('tbl_poli_gambar b', 'a.POLIKLINIK=b.NM_POLI')
      ->where('a.HARI', $namahari)
      ->where('a.SUDAH_DATANG', $statusdatang)
      ->order_by('a.POLIKLINIK')
      ->get();
    return $query->result();
  }
  function ListNamaRuangan3sql($namahari, $statusdatang)
  {
    $sql = "SELECT DISTINCT a.POLIKLINIK, b.GAMBAR  From TBL_JADWAL_POLI a 
        join tbl_poli_gambar b on a.POLIKLINIK=b.NM_POLI 
        WHERE a.HARI = '" . $namahari . "' AND a.SUDAH_DATANG = '" . $statusdatang . "' ORDER BY a.POLIKLINIK";
    $query = $this->db->query($sql);
    return $query->result();
  }
  function ListNamaDokter($namahari, $namapoli)
  {
    $kdpoli = str_replace("_", " ", $namapoli);
    $sql = "SELECT KODE,ID_DOKTER, DOKTER, HARI, POLIKLINIK, JAM , MAX_PASIEN, SUDAH_DATANG, STATUS_CUTI, KETERANGAN, POLI, MAPPING From TBL_JADWAL_POLI 
        WHERE HARI = '" . $namahari . "' AND POLIKLINIK = '" . $kdpoli . "' ORDER BY POLIKLINIK, DOKTER, JAM";

    $query = $this->db->query($sql);
    return $query->result();
  }
  function ListNamaDokter2($namahari, $namapoli)
  {
    $kdpoli = str_replace("_", " ", $namapoli);
    $data = $this->db->select('a.KODE')
      ->select('a.ID_DOKTER')
      ->select('a.DOKTER')
      ->select('a.HARI')
      ->select('a.POLIKLINIK')
      ->select('a.JAM')
      ->select('a.MAX_PASIEN')
      ->select('a.SUDAH_DATANG')
      ->select('a.STATUS_CUTI')
      ->select('a.KETERANGAN')
      ->select('a.POLI')
      ->select('a.MAPPING')
      ->select('b.FOTO')
      ->from('tbl_jadwal_poli a')
      ->join('tbl_dokter b', 'a.ID_DOKTER=b.KODE')
      ->where('a.HARI', $namahari)
      ->where('a.POLIKLINIK', $kdpoli)
      ->order_by('a.POLIKLINIK')
      ->order_by('a.DOKTER')
      ->order_by('a.JAM')
      ->get();
    return $data->result();
  }
  function getKodePoli($kodedaftar)
  {
    $nowDate = date('Y-m-d');

    $this->db->select('RIGHT(NO_ANTRIAN,3) as kode', FALSE);
    $this->db->where('DATE(TGL_REGISTRASI)', $nowDate);
    $this->db->where('LEFT(NO_ANTRIAN,1)', $kodedaftar);
    $this->db->order_by('NO_ANTRIAN', 'DESC');
    $query = $this->db->get('tbl_antrian_registrasi');
    if ($query->num_rows() <> 0) {
      $data = $query->row();
      $kode = intval($data->kode) + 1;
    } else {
      $kode = 1;
    }
    $kodemax = str_pad($kode, 3, "0", STR_PAD_LEFT);
    $kodejadi = "$kodedaftar" . $kodemax;
    return $kodejadi;
  }
  function getNoUrut($kodedaftar, $poliklinik, $dokter, $praktek)
  {
    $nowDate = date('Y-m-d');

    $this->db->select('RIGHT(NO_URUT,3) as kode', FALSE);
    $this->db->where('DATE(TGL_REGISTRASI)', $nowDate);
    $this->db->where('JENIS_PELAYANAN', $kodedaftar);
    $this->db->where('POLIKLINIK', $poliklinik);
    $this->db->where('DOKTER', $dokter);
    $this->db->where('PRAKTEK', $praktek);
    $this->db->order_by('NO_ANTRIAN', 'DESC');
    $query = $this->db->get('tbl_antrian_registrasi');
    if ($query->num_rows() <> 0) {
      $data = $query->row();
      $kode = intval($data->kode) + 1;
    } else {
      $kode = 1;
    }
    $kodemax = str_pad($kode, 3);
    $kodejadi = $kodemax;
    return $kodejadi;
  }
  function get_data_antrian()
  {
    $nowDate = date('Y-m-d');
    $this->db->select('*');
    $this->db->from('tbl_antrian_registrasi');
    $this->db->where('DATE(TGL_REGISTRASI)', $nowDate);
    $this->db->where('DILAYANI_OLEH', null);
    $this->db->where('DATE(TGL_PELAYANAN)', NULL);
    return $this->db->get();
    // $this->db->limit(15);     

  }
  function get_data_antrian_ag()
  {
    $nowDate = date('Y-m-d');
    $this->db->select('*');
    $this->db->from('tbl_antrian_registrasi');
    $this->db->where('DATE(TGL_REGISTRASI)', $nowDate);
    $this->db->where('DILAYANI_OLEH', null);
    $this->db->where('DATE(TGL_PELAYANAN)', NULL);
    $this->db->where('JENIS_PELAYANAN BETWEEN "A" AND "E"');
    $this->db->order_by('cast(substr(TGL_REGISTRASI, 10) AS INT)');
    return $this->db->get();
    // $this->db->limit(15);     
  }
  function get_data_antrian_ae_select()
  {
    $nowDate = date('Y-m-d');
    $this->db->select('NO_ANTRIAN, TGL_REGISTRASI, DOKTER,PRAKTEK,POLIKLINIK');
    $this->db->from('tbl_antrian_registrasi');
    $this->db->where('DATE(TGL_REGISTRASI)', $nowDate);
    $this->db->where('DILAYANI_OLEH', null);
    $this->db->where('DATE(TGL_PELAYANAN)', NULL);
    $this->db->where('JENIS_PELAYANAN BETWEEN "A" AND "E"');
    return $this->db->get();
    // $this->db->limit(15);     
  }
  function get_data_antrian_cs()
  {
    $nowDate = date('Y-m-d');
    $this->db->select('*');
    $this->db->from('tbl_antrian_registrasi');
    $this->db->where('DATE(TGL_REGISTRASI)', $nowDate);
    $this->db->where('DILAYANI_OLEH', null);
    $this->db->where('DATE(TGL_PELAYANAN)', NULL);
    $this->db->where('JENIS_PELAYANAN', 'G');
    return $this->db->get();
    // $this->db->limit(15);     
  }
  function get_data_antrian_kasir()
  {
    $nowDate = date('Y-m-d');
    $this->db->select('*');
    $this->db->from('tbl_antrian_registrasi');
    $this->db->where('DATE(TGL_REGISTRASI)', $nowDate);
    $this->db->where('DILAYANI_OLEH', null);
    $this->db->where('DATE(TGL_PELAYANAN)', NULL);
    $this->db->where('JENIS_PELAYANAN', 'F');
    return $this->db->get();
    // $this->db->limit(15);     
  }
  function get_data_antrian_belum_ag()
  {
    $nowDate = date('Y-m-d');
    $this->db->select('*');
    $this->db->from('tbl_antrian_registrasi');
    $this->db->where('DATE(TGL_REGISTRASI)', $nowDate);
    $this->db->where('DILAYANI_OLEH', null);
    $this->db->where('DATE(TGL_PELAYANAN)', NULL);
    $this->db->where('JENIS_PELAYANAN BETWEEN "A" AND "E"');
    return $this->db->get();
    // $this->db->limit(15);     
  }
  function get_data_antrian_belum_cs()
  {
    $nowDate = date('Y-m-d');
    $this->db->select('*');
    $this->db->from('tbl_antrian_registrasi');
    $this->db->where('DATE(TGL_REGISTRASI)', $nowDate);
    $this->db->where('DILAYANI_OLEH', null);
    $this->db->where('DATE(TGL_PELAYANAN)', NULL);
    $this->db->where('JENIS_PELAYANAN', 'G');
    return $this->db->get();
    // $this->db->limit(15);     
  }
  function get_data_antrian_belum_kasir()
  {
    $nowDate = date('Y-m-d');
    $this->db->select('*');
    $this->db->from('tbl_antrian_registrasi');
    $this->db->where('DATE(TGL_REGISTRASI)', $nowDate);
    $this->db->where('DILAYANI_OLEH', null);
    $this->db->where('DATE(TGL_PELAYANAN)', NULL);
    $this->db->where('JENIS_PELAYANAN', 'F');
    return $this->db->get();
    // $this->db->limit(15);     
  }
  function get_data_antrian_sudah_ag()
  {
    $nowDate = date('Y-m-d');
    $this->db->select('*');
    $this->db->from('tbl_antrian_registrasi');
    $this->db->where('DATE(TGL_REGISTRASI)', $nowDate);
    $this->db->where('DILAYANI_OLEH is  NOT NULL');
    $this->db->where('DATE(TGL_PELAYANAN) is  NOT NULL');
    $this->db->where('JENIS_PELAYANAN BETWEEN "A" AND "E"');
    return $this->db->get();
    // $this->db->limit(15);     

  }
  function get_data_antrian_sudah_cs()
  {
    $nowDate = date('Y-m-d');
    $this->db->select('*');
    $this->db->from('tbl_antrian_registrasi');
    $this->db->where('DATE(TGL_REGISTRASI)', $nowDate);
    $this->db->where('DILAYANI_OLEH is  NOT NULL');
    $this->db->where('DATE(TGL_PELAYANAN) is  NOT NULL');
    $this->db->where('JENIS_PELAYANAN', 'G');
    return $this->db->get();
    // $this->db->limit(15);     

  }
  function get_data_antrian_sudah_kasir()
  {
    $nowDate = date('Y-m-d');
    $this->db->select('*');
    $this->db->from('tbl_antrian_registrasi');
    $this->db->where('DATE(TGL_REGISTRASI)', $nowDate);
    $this->db->where('DILAYANI_OLEH is  NOT NULL');
    $this->db->where('DATE(TGL_PELAYANAN) is  NOT NULL');
    $this->db->where('JENIS_PELAYANAN', 'F');
    return $this->db->get();
    // $this->db->limit(15);     

  }
  function get_igd()
  {
    $KODE = "D";
    $nowDate = date('Y-m-d');
    $this->db->select('NO_ANTRIAN');
    $this->db->from('tbl_antrian_registrasi');
    $this->db->where('DATE(TGL_REGISTRASI)', $nowDate);
    $this->db->where('JENIS_PELAYANAN', $KODE);
    $this->db->where('DILAYANI_OLEH', null);
    $this->db->order_by('NO_ANTRIAN ASC');
    $this->db->limit(1);
    return $this->db->get();
  }
  function get_coba()
  {

    // $this->db->select_max('cast(substr(`column_name`,3) as unsigned)','max_id');
    // $this->db->get('table_name');

    // $this->db->select_max($field);
    // $this->db->where($where);
    // $sql = $this->db->get($table);
    // return $sql;

    // $KODE = "D";
    $nowDate = date('Y-m-d');
    $this->db->select_max('cast(substr(NO_ANTRIAN, 2, length(NO_ANTRIAN) - 1');
    $this->db->from('tbl_antrian_registrasi');
    $this->db->where('DATE(TGL_REGISTRASI)', $nowDate);
    $this->db->where('DILAYANI_OLEH', null);
  }
  function get_antrian_coba($KODE)
  {
    // $KODE = "D";
    $nowDate = date('Y-m-d');
    $this->db->select('*');
    $this->db->from('tbl_antrian_registrasi');
    $this->db->where('DATE(TGL_REGISTRASI)', $nowDate);
    $this->db->where('DILAYANI_OLEH', null);
    $this->db->where('JENIS_PELAYANAN', $KODE);
    $this->db->where('TGL_PELAYANAN', null);
    $this->db->order_by('NO_ANTRIAN ASC');
    $this->db->limit(1);
    return $this->db->get();
  }
  function get_antrian_coba_new($KODE, $COUNTER)
  {
    // $KODE = "D";
    $nowDate = date('Y-m-d');
    $this->db->select('*');
    $this->db->select('str_to_date(TGL_PELAYANAN, "%Y-%m-%d %H:%i:%s") day', false);
    $this->db->from('tbl_antrian_registrasi');
    $this->db->where('DATE(TGL_REGISTRASI)', $nowDate);
    $this->db->where('DILAYANI_OLEH', $COUNTER);
    $this->db->where('JENIS_PELAYANAN', $KODE);
    $this->db->where('TGL_PELAYANAN is  NOT NULL');
    $this->db->order_by('day', 'DESC');
    $this->db->limit(1);
    return $this->db->get();
  }
  function get_antrian_recall($COUNTER)
  {
    // $KODE = "D";
    $nowDate = date('Y-m-d');
    $this->db->select('*');
    $this->db->select('str_to_date(TGL_PELAYANAN, "%Y-%m-%d %H:%i:%s") day', false);
    $this->db->from('tbl_antrian_registrasi');
    $this->db->where('DATE(TGL_REGISTRASI)', $nowDate);
    $this->db->where('DILAYANI_OLEH', $COUNTER);
    $this->db->where('TGL_PELAYANAN is  NOT NULL');
    $this->db->order_by('day', 'DESC');
    $this->db->limit(1);
    return $this->db->get();
  }
  function get_antrian_nonkode_new($COUNTER)
  {
    // $KODE = "D";
    $nowDate = date('Y-m-d');
    $this->db->select('*');
    $this->db->select('str_to_date(TGL_PELAYANAN, "%Y-%m-%d %H:%i:%s") day', false);
    $this->db->from('tbl_antrian_registrasi');
    $this->db->where('DATE(TGL_REGISTRASI)', $nowDate);
    $this->db->where('DILAYANI_OLEH', $COUNTER);
    $this->db->where('TGL_PELAYANAN is  NOT NULL');
    $this->db->order_by('day', 'DESC');
    $this->db->limit(1);
    return $this->db->get();
  }
  function get_akhir_new($COUNTER)
  {
    // $KODE = "D";
    $limit1 = 1;
    $limit2 = 1;
    $nowDate = date('Y-m-d');
    $this->db->select('*');
    $this->db->select('str_to_date(TGL_PELAYANAN, "%Y-%m-%d %H:%i:%s") day', false);
    $this->db->from('tbl_antrian_registrasi');
    $this->db->where('DATE(TGL_REGISTRASI)', $nowDate);
    $this->db->where('DILAYANI_OLEH', $COUNTER);
    $this->db->where('TGL_PELAYANAN is  NOT NULL');
    $this->db->order_by('day', 'DESC');
    $this->db->limit(1, 1);
    return $this->db->get();
  }
  function get_antrian_coba2($table, $field, $KODE, $nowDate)
  {
    // $KODE = "D";
    // $nowDate = date('Y-m-d');
    $this->db->select($field);
    $this->db->where('DATE(TGL_REGISTRASI)', $nowDate);
    $this->db->where('DILAYANI_OLEH', null);
    $this->db->where('JENIS_PELAYANAN', $KODE);
    $this->db->where('TGL_PELAYANAN', null);
    $this->db->order_by('NO_ANTRIAN ASC');
    $this->db->limit(1);
    $sql = $this->db->get($table);
    return $sql;
  }
  function get_antrian_coba2_1($table, $field,  $nowDate)
  {
    // $KODE = "D";
    // $nowDate = date('Y-m-d');
    $this->db->select($field);
    $this->db->where('DATE(TGL_REGISTRASI)', $nowDate);
    $this->db->where('DILAYANI_OLEH', null);
    $this->db->where('TGL_PELAYANAN', null);
    $this->db->order_by('NO_ANTRIAN ASC');
    $this->db->limit(1);
    $sql = $this->db->get($table);
    return $sql;
  }
  function get_antrian_coba3()
  {
    // $KODE = "D";
    $nowDate = date('Y-m-d');
    $this->db->select('*');
    $this->db->from('tbl_antrian_registrasi');
    $this->db->where('DATE(TGL_REGISTRASI)', $nowDate);
    $this->db->where('DILAYANI_OLEH', null);
    $this->db->where('TGL_PELAYANAN', null);
    $this->db->order_by('NO_ANTRIAN ASC');
    $this->db->limit(1);
    return $this->db->get();
  }
  function get_btn_umum($table, $field, $nowDate)
  {
    // $KODE = "D";
    // $nowDate = date('Y-m-d');
    $this->db->select($field);
    $this->db->where('DATE(TGL_REGISTRASI)', $nowDate);
    $this->db->where('DILAYANI_OLEH', null);
    $this->db->where('JENIS_PELAYANAN', 'A');
    $this->db->where('TGL_PELAYANAN', null);
    $this->db->order_by('NO_ANTRIAN ASC');
    $this->db->limit(1);
    $sql = $this->db->get($table);
    return $sql;
  }
  function get_nomor($table)
  {
    // $KODE = "D";
    // $nowDate = date('Y-m-d');
    $this->db->select('*');
    $this->db->where('STATUS_COUNTER', 1);
    $sql = $this->db->get($table);
    return $sql;
  }
  function get_last_call($table, $field)
  {
    // $KODE = "D";
    $nowDate = date('Y-m-d');
    $this->db->select($field);
    $this->db->where('DATE(TGL_PELAYANAN)', $nowDate);
    $this->db->order_by('TGL_PELAYANAN DESC');
    $this->db->limit(1);
    $sql = $this->db->get($table);
    return $sql;
  }
  function get_antrian3($id_antrian)
  {

    $data = $this->db->query("SELECT * FROM tbl_antrian_registrasi, 
        tbl_antrian_counter
								WHERE tbl_antrian_registrasi.DILAYANI_OLEH = tbl_antrian_counter.COUNTER
								AND tbl_antrian_registrasi.KODE = '$id_antrian' ");
    return $data;
  }
  function get_antrian3v2($id_antrian)
  {

    $data = $this->db->query("SELECT * FROM tbl_antrian_registrasi, 
        tbl_antrian_counter
								WHERE tbl_antrian_registrasi.DILAYANI_OLEH = tbl_antrian_counter.COUNTER
								AND tbl_antrian_registrasi.KODE = '$id_antrian' ");
    return $data;
  }
  function get_antrian4($id_antrian)
  {

    $data = $this->db->query("SELECT * FROM tbl_antrian_registrasi, 
        tbl_antrian_counter
								WHERE tbl_antrian_registrasi.DILAYANI_OLEH = NULL or 0
								AND tbl_antrian_registrasi.KODE = '$id_antrian' ");
    return $data;
  }
  function get_no_antrian($id_noantrian)
  {

    $data = $this->db->query("SELECT * FROM tbl_antrian_registrasi 
        WHERE tbl_antrian_registrasi.KODE = '$id_noantrian' ");
    return $data;
  }
  function get_counter($id_counter)
  {

    $data = $this->db->query("SELECT * FROM tbl_antrian_counter, t_user
								WHERE tbl_antrian_counter.NO_COUNTER = t_user.id_konter
								AND tbl_antrian_counter.ID_COUNTER = '$id_counter' ");
    return $data;
  }
  function get_table($id_antrian)
  {

    // $this->db->select('t_kegiatan.*,t_user.nm_user,t_user.nama_lengkap');
    // $this->db->from($this->table);
    // $this->db->join('t_user', 't_user.nik = t_kegiatan.nik', 'inner');
    // $this->db->where('t_kegiatan.nik', $nik);
    // // $this->db->join('t_pengduan', 't_pengduan.id_pengaduan = t_kegiatan.id_pengaduan', 'inner');
    // return $this->db->get();
  }
  function get_antrian_nonkode()
  {
    // $KODE = "D";
    $nowDate = date('Y-m-d');
    $this->db->select('*');
    $this->db->from('tbl_antrian_registrasi');
    $this->db->where('DATE(TGL_REGISTRASI)', $nowDate);
    $this->db->where('DILAYANI_OLEH', null);
    $this->db->where('TGL_PELAYANAN', null);
    $this->db->order_by('NO_ANTRIAN ASC');
    $this->db->limit(1);
    return $this->db->get();
  }
  function get_antrian_kode($KODE)
  {
    // $KODE = "D";
    $nowDate = date('Y-m-d');
    $this->db->select('*');
    $this->db->from('tbl_antrian_registrasi');
    $this->db->where('DATE(TGL_REGISTRASI)', $nowDate);
    $this->db->where('DILAYANI_OLEH', null);
    $this->db->where('TGL_PELAYANAN', null);
    $this->db->where('JENIS_PELAYANAN', $KODE);
    $this->db->order_by('NO_ANTRIAN ASC');
    $this->db->limit(1);
    return $this->db->get();
  }
  function get_antrian_aja()
  {
    // $KODE = "D";
    $nowDate = date('Y-m-d');
    $this->db->select('*');
    $this->db->from('tbl_antrian_registrasi');
    $this->db->where('DATE(TGL_REGISTRASI)', $nowDate);
    $this->db->where('DILAYANI_OLEH', null);
    $this->db->where('TGL_PELAYANAN', null);
    $this->db->order_by('NO_ANTRIAN ASC');
    $this->db->limit(1);
    return $this->db->get();
  }
  function get_antrian_kode_nasc($KODE)
  {
    // $KODE = "D";
    $nowDate = date('Y-m-d');
    $this->db->select('*');
    $this->db->from('tbl_antrian_registrasi');
    $this->db->where('DATE(TGL_REGISTRASI)', $nowDate);
    $this->db->where('DILAYANI_OLEH', null);
    $this->db->where('TGL_PELAYANAN', null);
    $this->db->where('JENIS_PELAYANAN', $KODE);
    $this->db->order_by('NO_ANTRIAN');
    $this->db->limit(1);
    return $this->db->get();
  }
  function get_call_antri()
  {
    // $KODE = "D";
    // $nowDate = date('Y-m-d');
    $this->db->select('*');
    $this->db->from('tbl_antrian_counter');
    return $this->db->get();
  }
  function get_call_antri2($counter)
  {
    // $KODE = "D";
    // $nowDate = date('Y-m-d');
    $this->db->select('*');
    $this->db->from('tbl_antrian_counter');
    $this->db->where('NO_COUNTER', $counter);
    $this->db->where('STATUS', NULL);
    $this->db->order_by('NO_ANTRIAN ASC');
    $this->db->limit(1);
    return $this->db->get();
  }
  function get_js_antri($table, $field, $where)
  {
    // $KODE = "D";
    // $nowDate = date('Y-m-d');
    // $this->db->select('*');
    // $this->db->where($where);
    // $this->db->from('tbl_antrian_counter');
    // return $this->db->get();
    $this->db->select($field);
    $this->db->where($where);
    $sql = $this->db->get($table);
    return $sql;
  }
  function call_antri()
  {
    $sql = $this->db->query("SELECT JENIS_ANTRIAN, NO_ANTRIAN, NO_COUNTER FROM tbl_call_antrian order by NO_COUNTER  limit 1");
    return $sql;
  }
  function call_antri2()
  {
    $sql = $this->db->query("SELECT  NO_ANTRIAN, NO_COUNTER FROM tbl_antrian_temp order by TGL_PELAYANAN limit 1");
    return $sql;
  }
  function del_call_antri($row)
  {
    $sql = $this->db->query("DELETE  FROM tbl_antrian_temp WHERE NO_ANTRIAN = '" . $row["NO_ANTRIAN"] . "' AND NO_COUNTER = '" . $row["NO_COUNTER"] . "'");
    return $sql;
  }
  // function call_antri2()
  // {
  //     $query = $this->db->query("SELECT JENIS_ANTRIAN, NO_ANTRIAN, NO_COUNTER FROM tbl_call_antrian  limit 1");
  //     return $query->row_array();
  // }
  function get_next()
  {
    $nowDate = date('Y-m-d');
    $this->db->select('*');
    $this->db->from('tbl_antrian_registrasi');
    $this->db->where('DATE(TGL_REGISTRASI)', $nowDate);
    $this->db->where('DILAYANI_OLEH', null);
    $this->db->where('TGL_PELAYANAN', null);
    return $this->db->get();
  }
  function get_counters()
  {
    $data = $this->db->select('*')
      ->from('t_user')
      ->where('level', 'Penjaga')
      ->order_by('id_konter', 'ASC')
      ->get();
    return $data;
  }
  function ambildata($a)
  {
    return $this->db->get_where('tbl_dokter', ['KODE' => $a]);
  }
  // public function delete($kode)
  // {
  //   return $this->db->delete('tbl_dokter', ['KODE' => $a]);
  // }

  public function hapusBanyak($kode, $jmldata)
  {
    for ($i = 0; $i < $jmldata; $i++) {
      $this->db->delete('tbl_dokter', ['KODE' => $kode[$i]]);
      # code...
    }
    return true;
  }
}
