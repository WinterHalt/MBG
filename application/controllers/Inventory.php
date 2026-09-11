<?php
// Controller Barang Inventory
defined('BASEPATH') or exit('No direct script access allowed');

class Inventory extends Admin_Controller {
  // Define Role & Builder & Model
  protected $role;
  public function __construct(){
    parent::__construct();
    $this->role = 'gases';
    $this->load->model(array('inventory_model', 'barang_model'));
  }

  public function index(){
    // Main File Controller
    if (!get_permission($this->role, 'is_view')){
      access_denied();
    }
    // Hasil Model
    $this->data['results'] = $this->inventory_model->tabelAllInventory();
    // File
    $this->data['title'] = 'Tabel Data Inventory Barang';
    $this->data['sub_page'] = 'inventory/index';
    $this->data['main_menu'] = 'inventory';
    $this->load->view('layout/index', $this->data);
  }

  public function insert(){
    // Controller u Menampilkan Form Input Inventory
    if (!get_permission($this->role, 'is_add')){
      access_denied();
    }
    $this->data['results'] = $this->barang_model->getAllBarang();
    // File
    $this->data['title'] = 'Tambah Data Inventory';
    $this->data['sub_page'] = 'inventory/insert';
    $this->data['main_menu'] = 'inventory';
    $this->load->view('layout/index', $this->data);
  }

  public function publish(){
    // Controller u Melakukan Publish Dari Modal Input
    if (!get_permission($this->role, 'is_add')) {
      access_denied();
    }
    // Variable Input
    $inputs = $this->input->post();
    // Wrap Publish Dengan Transaction (Primary, Detail, Master Barang)
    $this->db->trans_begin();
    // Publish Primary Variable
    $idVariable = $this->inventory_model->publishPrimary($inputs['tanggal'], userids());
    // Detail Variable
    $detailVariable = [];
    foreach ($inputs['gases'] as $i => $gasesKey) {
      $row = [];
      $row['loggingKey'] = $idVariable;
      $row['gases'] = $gasesKey;
      $row['sistem'] = $inputs['sistem'][$i];
      $row['fisik'] = $inputs['fisik'][$i];
      $row['selisih'] = $inputs['selisih'][$i];
      $row['price'] = $inputs['price'][$i];
      $detailVariable[] = $row;
    }
    // Publish Detail Inventory
    $this->inventory_model->publishDetail($detailVariable);
    // Update Master Barang
    $jumlahVariable = [];
    foreach ($inputs['gases'] as $i => $gasesKey) {
      $row = [];
      $row['id'] = $gasesKey;
      $row['stock'] = $inputs['fisik'][$i];
      $jumlahVariable[] = $row;
    }
    // ?
    $this->barang_model->jumlahBaru($jumlahVariable);
    // Cek Status Transaction
    if ($this->db->trans_status() === false) {
      // Hasil 0
      $this->db->trans_rollback();
      // Fail !
      set_alert('error', 'Data Inventory Gagal Disimpan !');
    } else {
      // Hasil 1
      $this->db->trans_commit();
      // Berhasil !
      set_alert('success', 'Data Inventory Berhasil Disimpan !');
    }
    // Kembali ke Halaman Inventory
    redirect(base_url('inventory'));
  }

  public function detail($id){
    // Controller u Melakukann Edit Data Inventory
    if (!get_permission($this->role, 'is_view')){
      access_denied();
    }
    // File Model Primary
    $this->data['primary'] = $this->inventory_model->detailPrimary($id);
    // File Model Detail
    $this->data['detail'] = $this->inventory_model->detailInventory($id);
    // File
    $this->data['title'] = 'Detail Kelola Jumlah Kuantitas Barang';
    $this->data['sub_page'] = 'inventory/detail';
    $this->data['main_menu'] = 'inventory';
    $this->load->view('layout/index', $this->data);
  }
}

?>