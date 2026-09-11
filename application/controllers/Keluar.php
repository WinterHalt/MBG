<?php
// Controller : Barang Keluar
defined('BASEPATH') or exit('No direct script access allowed');

class Keluar extends Admin_Controller {
  // Define Role & Builder & Model
  public function __construct(){
    parent::__construct();
    $this->load->model(array('keluar_model', 'barang_model'));
  }

  public function index(){
    // Controller Tabel History Barang Keluar
    if (!get_permission('keluar', 'is_view')){
      access_denied();
    }
    // File
    $this->data['title'] = 'Tabel History Pengeluaran';
    $this->data['sub_page'] = 'keluar/index';
    $this->data['main_menu'] = 'keluar';
    $this->load->view('layout/index', $this->data);
  }

  public function historia(){
    // Tabel Historia on Keluar Gas Medis
    if (!get_permission('keluar', 'is_view')) {
      access_denied();
    }
    // Variable Awal
    $start = date('Y-m-d 00:00:00', strtotime($this->input->get('start')));
    // Variable Akhir
    $final = date('Y-m-d 23:59:59', strtotime($this->input->get('final')));
    // Table Content
    $results = $this->keluar_model->tabelKeluar($start, $final);
    // Return Result on Tabel
    echo json_encode($results);
  }

  public function insert(){
    // Controller u Melakukan Input Barang Keluar
    if (!get_permission('keluar', 'is_add')){
      access_denied();
    }
    // File
    $this->data['title'] = 'Input Pengeluaran Gas Medis';
    $this->data['sub_page'] = 'keluar/insert';
    $this->data['main_menu'] = 'keluar';
    $this->load->view('layout/index', $this->data);
  }

  public function publish(){
    // Controller u Melakukan Publish Dari Modal Input
    if (!get_permission('keluar', 'is_add')) {
      access_denied();
    }
    // Variable Input
    $inputs = $this->input->post();
    // Wrap Publish Dengan Transaction (Primary, Detail, Master Barang)
    $this->db->trans_begin();

    // Publish Data Primary
    $keluarKey = $this->keluar_model->publishKeluar($inputs['tanggal'], $inputs['user']);

    // Publish Data Detail Variable
    $detailKeluar = [$inputs['gases'], $inputs['pagi'], $inputs['sore'], $inputs['malam'], $inputs['total'], $keluarKey];
    // ?
    $this->keluar_model->publishDetail(...$detailKeluar);

    // Update Master Barang (Kurangi Stok)
    // $jumlahVariable = array_map(
      // fn($gases, $total) => ['id' => $gases, 'stock' => $total],
      // $inputs['gases'], $inputs['total']
    // );
    // ?
    // $this->kelmdl->PublishMasterBarang($jumlahVariable);
    // Cek Status Transaction
    if ($this->db->trans_status() === false) {
      // Hasil 0
      $this->db->trans_rollback();
      // Pengeluaran Data Fail !
      set_alert('error', 'Data Pengeluaran Gagal Disimpan !');
    } else {
      // Hasil 1
      $this->db->trans_commit();
      // Pengeluaran Data Berhasil !
      set_alert('success', 'Data Pengeluaran Berhasil Disimpan !');
    }
    // Kembali ke Halaman Keluar
    redirect(base_url('keluar'));
  }

  public function detail($id){
    // Controller u Melakukann Edit Data Keluar
    if (!get_permission('keluar', 'is_view')){
      access_denied();
    }
    // File Model Primary
    $this->data['primary'] = $this->keluar_model->detailPrimary($id);
    // Detail Keluar
    $this->data['content'] = $this->keluar_model->detailKeluar($id);
    // File
    $this->data['title'] = 'Detail Pengeluaran Barang';
    $this->data['sub_page'] = 'keluar/detail';
    $this->data['main_menu'] = 'keluar';
    $this->load->view('layout/index', $this->data);
  }
}

?>