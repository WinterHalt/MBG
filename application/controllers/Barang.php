<?php
// Barang Controller to Handle Master
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends Admin_Controller {
  // Define Role & Builder & Model
  protected $role;
  public function __construct(){
    parent::__construct();
    $this->role = 'gases';
    $this->load->model('barang_model');
  }

  public function index(){
    // Main File to Barang Tabel
    if (!get_permission($this->role, 'is_view')){
      access_denied();
    }
    // Hasil Model
    $this->data['results'] = $this->barang_model->getAllBarang();
    // File
    $this->data['title'] = "Data Master Gas Medis";
    $this->data['sub_page'] = "barang/index";
    $this->data['main_menu'] = 'barang';
    $this->load->view('layout/index', $this->data);
  }

  public function insert(){
    // Main File to Barang Tabel
    if (!get_permission($this->role, 'is_view')){
      access_denied();
    }
    // File
    $this->data['title'] = "Input Data Gas Medis";
    $this->data['sub_page'] = "barang/insert";
    $this->data['main_menu'] = 'barang';
    $this->load->view('layout/index', $this->data);
  }

  public function publish(){
    // Controller u Melakukan Publish Dari Modal Input
    if (!get_permission($this->role, 'is_add') && !get_permission($this->role, 'is_edit')) {
      access_denied();
    }
    // Variable Input
    $inputs = $this->input->post();
    // Model Publish
    $result = $this->barang_model->publishBarang($inputs);
    // Hasil
    if ($result) {
      // Hasil 1
      set_alert('success', 'Data Barang Berhasil Disimpan !');
    } else {
      // Hasil 0
      set_alert('error', 'Data Barang Gagal Disimpan !');
    }
    // Kembali ke Halaman Barang
    redirect(base_url('barang'));
  }

  public function detail($id){
    // Controller u Melakukann Edit Data Barang
    if (!get_permission($this->role, 'is_view')) {
      access_denied();
    }
    // File Model
    $this->data['result'] = $this->barang_model->getBarangById($id);
    // File
    $this->data['title'] = "Panel Detail Gas Medis";
    $this->data['sub_page'] = "barang/detail";
    $this->data['main_menu'] = 'barang';
    $this->load->view('layout/index', $this->data);
  }

  public function delete($id){
    // Controller u Melakukan Delete Pada Data Barang
    if (!get_permission($this->role, 'is_delete')) {
      access_denied();
    }
    // Delete the Data on Model
    $this->barang_model->deleteBarang($id);
  }

  public function barangOnly(){
    // Controller Barang u Melakukan Kegiatan Terkait Barang
    if (!get_permission($this->role, 'is_view')){
      access_denied();
    }
    // Hasil Model
    $result = $this->barang_model->barangOnly();
    // Hasil
    echo json_encode($result);
  }
}

?>